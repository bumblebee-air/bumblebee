<?php

namespace App\Http\Controllers;

use App\WhatsappMessage;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use SimpleXMLElement;
use Response;

class TwilioController extends Controller
{
    public function whatsappMessage(Request $request){
        $message_sid = $request->get('MessageSid');
        $from = $request->get('From');
        $message_body = $request->get('Body');
        $customer_phone = explode(':',$from)[1];
        //\Log::debug('Sid: '.$message_sid.', From: '.$from.', Body: '.$message_body);
        $whats = new WhatsappMessage();
        $whats->message = $message_body;
        $whats->from = $customer_phone;
        $whats->to = 'Bumblebee ('.'+447445341335'.')';
        $whats->status = 'received';
        $whats->external_id = $message_sid;
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
            $whats->status = $message->status;
            $whats->external_id = $message->sid;
            $whats->save();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response><Message><Body>there was an error while processing the message</Body></Message></Response>');
            return Response::make($xml->asXML(),500,[]);
        }
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
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><Response/>');
        return Response::make($xml->asXML(),200,[]);
    }
}