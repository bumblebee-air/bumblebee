<?php

namespace App\Http\Controllers;

use App\Keyword;
use App\User;
use App\WhatsappMessage;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use Twilio\TwiML\VoiceResponse;
use SimpleXMLElement;
use Response;

class TwilioController extends Controller
{
    public function whatsappMessage(Request $request){
        $message_sid = $request->get('MessageSid');
        $from = $request->get('From');
        $message_body = $request->get('Body');
        $customer_phone = explode(':',$from)[1];
        $user_id = null;
        $the_user = User::where('phone','=',$customer_phone)->first();
        if($the_user){
            $user_id = $the_user->id;
        }
        $number_of_media = $request->get('NumMedia');
        $media_types = null;
        $media_urls = null;
        //\Log::debug('Sid: '.$message_sid.', From: '.$from.', Body: '.$message_body);
        if($message_body==null){
            $message_body = '';
        }

        // get matching keywords
        if(!empty($message_body))
        {
            $matchedKeywords = [];
            $keywords = Keyword::select('id', 'keyword', 'audio')->get();
            foreach($keywords as $key=> $keyword)
            {
                if ((strpos(strtolower($message_body), strtolower($keyword->keyword)) !== false) && !empty($keyword->audio)) {
                    $matchedKeywords[] = [
                        'id' => $keyword->id,
                        'keyword' => $keyword->keyword,
                        'audio' => $keyword->audio
                    ];
                }
            }
        }

        if(intval($number_of_media) > 0){
            $media_types = '';
            $media_urls = '';
            $number_of_media = intval($number_of_media);
            for($i=0;$i<$number_of_media;$i++){
                $content_type = $request->get('MediaContentType'.strval($i));
                $media_url = $request->get('MediaUrl'.strval($i));
                $media_types .= $content_type;
                $media_urls .= $media_url;
                if($i != $number_of_media-1){
                    $media_types .= ',';
                    $media_urls .= ',';
                }
            }
        }
        $whats = new WhatsappMessage();
        $whats->message = $message_body;
        $whats->from = $customer_phone;
        $whats->to = 'Bumblebee ('.'+447445341335'.')';
        $whats->status = 'received';
        $whats->user_id = $user_id;
        $whats->external_id = $message_sid;
        $whats->num_of_media = $number_of_media;
        $whats->media_types = $media_types;
        $whats->media_urls = $media_urls;
        //Check if it is a location message
        $lat = $request->get('Latitude');
        $lon = $request->get('Longitude');
        if($lat!=null && $lon!=null){
            $address = $request->get('Address');
            $address_label = $request->get('Label');
            $whats->lat = $lat;
            $whats->lon = $lon;
            $whats->address = $address.' ('.$address_label.')';
        }
        $whats->save();
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $body = "Hi there, your number is $customer_phone and you said: $message_body";
        if(str_contains(strtolower($message_body),'yes')){
            $code = '';
            for ($i = 0; $i<6; $i++) {
                $code .= mt_rand(0,9);
            }
            $health_check_url = url('health-check/'.$code);
            $body = "Super! Your authorization pin code is $code and you're using an encrypted secure socket layer to connect here $health_check_url";
        }
        try {
            $twilio = new Client($sid, $token);
            $message = $twilio->messages->create($from,
                ["from" => "whatsapp:+447445341335",
                    "body" => $body]
            );
            //dd($message);
            $whats = new WhatsappMessage();
            $whats->message = $body;
            $whats->from = 'Bumblebee ('.'+447445341335'.')';
            $whats->to = $customer_phone;
            $whats->user_id = $user_id;
            $whats->status = $message->status;
            $whats->external_id = $message->sid;
            $whats->save();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response><Message><Body>there was an error while processing the message</Body></Message></Response>');
            return Response::make($xml->asXML(),500,[]);
        }

        // send keyword's audio file to sender
        if(!empty($matchedKeywords))
        {
            foreach($matchedKeywords as $keyword)
            {
                $twilio = new Client($sid, $token);
                $message = $twilio->messages->create(
                    $from,
                    [
                        "from" => "whatsapp:+447445341335",
                        "body" => "Matched Keyword: " . $keyword['keyword'],
                        'mediaUrl' => url('') . '/' . $keyword['audio']
                    ]
                );

                $whats = new WhatsappMessage();
                $whats->message = "Matched Keyword: " . $keyword['keyword'];
                $whats->from = 'Bumblebee ('.'+447445341335'.')';
                $whats->to = $customer_phone;
                $whats->user_id = $user_id;
                $whats->num_of_media = 1;
                $whats->media_types = 'audio/ogg';
                $whats->media_urls = url('') . '/' . $keyword['audio'];
                $whats->status = $message->status;
                $whats->external_id = $message->sid;
                $whats->save();
            }
        }
        $this->checkForwardWhatsappData($request->all(),'message');
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');
        return Response::make($xml->asXML(),200,[]);
    }

    public function whatsappStatus(Request $request){
        /*foreach($request->all() as $key=>$item){
            \Log::debug($key.':  '.$item);
        }*/
        $whats = WhatsappMessage::where('external_id','=',$request->get('MessageSid'))->first();
        if($whats!=null){
            $whats->status = $request->get('MessageStatus');
            $whats->save();
        }
        $this->checkForwardWhatsappData($request->all(),'status');
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');
        return Response::make($xml->asXML(),200,[]);
    }

    public function sendMessageToCustomer(Request $request){
        $customer_id = $request->get('customer_id');
        $message_body = $request->get('message_body');
        $the_user = User::find($customer_id);
        if(!$the_user){
            return json_encode(['error'=>1, 'message'=>'No user was found with this ID']);
        }
        $customer_phone = $the_user->phone;
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $twilio = new Client($sid, $token);
        $message = $twilio->messages->create($customer_phone,
            ["from" => "whatsapp:+447445341335",
                "body" => $message_body]
        );
        $whats = new WhatsappMessage();
        $whats->message = $message_body;
        $whats->from = 'Bumblebee ('.'+447445341335'.')';
        $whats->to = $customer_phone;
        $whats->user_id = $customer_id;
        $whats->status = $message->status;
        $whats->external_id = $message->sid;
        $whats->save();

    }

    public function checkForwardWhatsappData($data, $type){
        try{
            $whatsapp_forward_url = env('WHATSAPP_FORWARD_URL');
            if($whatsapp_forward_url!=null && $whatsapp_forward_url!=''){
                $route_uri = \Request::route()->uri();
                $whatsapp_forward_url .= '/'.$route_uri;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $whatsapp_forward_url);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
                curl_setopt($ch, CURLOPT_FAILONERROR, true);
                $response = curl_exec($ch);
                $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if($status !== 200) {
                    \Log::info('Whatsapp '.$type.' forwarding failed!');
                    \Log::error(curl_error($ch));
                } else {
                    \Log::info('Whatsapp '.$type.' forwarded successfully to the url: '.
                        $whatsapp_forward_url);
                }
                curl_close($ch);
            }
        } catch(\Exception $exception){
            \Log::error($exception->getMessage(), $exception->getTrace());
        }
    }

    public function checkForKeywords($string){
        $stopWords = array('i','a','about','an','and','are','as','at','be','by','com',
            'de','en','for','from','how','in','is','it','la','of','on','or','that','the',
            'this','to','was','what','when','where','who','will','with','und','the','www');
        $string = preg_replace('/ss+/i', '', $string);
        $string = trim($string); // trim the string
    }

    public function emergencyCallTwiml(Request $request){
        \Log::debug(implode(' || ',$request->all()));
        /*$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?>
<Response>
    <Say voice="woman" language="en-gb">This is Bumblebee AIR testing Twilio voice. This is a recorded message.</Say>
<Response/>');
        echo $xml->asXML();*/
        //return Response::make($xml->asXML(),200,[]);
        $response = new VoiceResponse();
        $response->say(
            "This is Bumblebee AIR testing Twilio voice. This is a recorded message.",
            array("voice" => "woman", "language"=>"en-gb")
        );
        header('Content-type: text/xml');
        echo $response;
    }

    public function crashDetectionTwiml(Request $request){
        $response = new VoiceResponse();
        $response->say(
            "Hi, This is the Bumblebee system checking on you since we received a possible crash report.".
                "Do you require help now? please reply with yes or no.",
            array("voice" => "woman", "language"=>"en-gb")
        );
        $response->record([
            'maxLength' => '5',
            'method' => 'POST',
            'action' => route('twilio-record-hangup', [], false),
            'transcribeCallback' => route(
                'process-crash-detection-recording', [], false
            )
        ]);
        $response->say(
            "Sorry, no recording received. Goodbye",
            array("voice" => "woman", "language"=>"en-gb")
        );
        $response->hangup();
        return $response;
    }

    public function processCrashDetectionRecording(Request $request){
        \Log::debug('ProcessCrashDetectionRecording:  '.implode(' || ',$request->all()));
        return ;
    }

    public function twilioRecordHangup(Request $request){
        $response = new VoiceResponse();
        $response->say(
            "We will process your recording and perform the required action. Goodbye",
            array("voice" => "woman", "language"=>"en-gb")
        );
        $response->hangup();
        return $response;
    }
}