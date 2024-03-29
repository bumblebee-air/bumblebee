<?php

namespace App\Http\Controllers;

use App\User;
use App\Keyword;
use App\WhatsappMessage;
use Carbon\Carbon;
use App\Client as BumblebeeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Twilio\Rest\Client;
use SimpleXMLElement;
use Response;

class DashboardController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
    }

    public function getWhatsappConversations(){
        $conversations = [];
        $grouped_conversations = WhatsappMessage::groupBy('user_id')
            ->select(\DB::raw('MAX(`id`) as id'))->get();
        foreach($grouped_conversations as $index=>$conv){
            $whatsapp_message = WhatsappMessage::find($conv->id);
            $unread_messages_count = WhatsappMessage::where('user_id','=',$whatsapp_message->user_id)
                ->where('status','=','received')
                ->where('read_status','=',0)->count();
            $the_user = User::find($whatsapp_message->user_id);
            if($the_user){
                $the_name = $the_user->name;
                $the_phone = $the_user->phone;
            } else {
                $the_name = 'N/A';
                $the_phone = 'N/A';
            }
            $whatsapp_message->name = $the_name;
            $whatsapp_message->phone = $the_phone;
            $whatsapp_message->time = Carbon::parse($whatsapp_message->created_at)->format('H:i');
            $conversations[] = ['message'=>$whatsapp_message,
                'unread_count'=>$unread_messages_count];
        }
        //dd($conversations);
        $the_clients = BumblebeeClient::all();
        return view('admin.whatsapp_conversation',['conversations'=>$conversations,
            'the_clients'=>$the_clients]);
    }

    public function getWhatsappConversation($user_id){
        $is_json = Input::get('is_json');
        $page = Input::get('page');
        $user = User::find($user_id);
        if(!$user){
            return redirect()->back()->withErrors('No user was found with this ID!');
        }
        $phone_number = $user->phone;

        $matchedKeywords = [];
        if($page == 1)
        {
            $keywords = Keyword::select('id', 'keyword', 'weight')->get();

            if(!empty($keywords))
            {
                $messages = WhatsappMessage::where('to','=',$phone_number)->orWhere('from','=',$phone_number)->select('id', 'message')->get();
                foreach($messages as $message)
                {
                    foreach($keywords as $key=> $keyword)
                    {
                        if (strpos($message, $keyword->keyword) !== false) {
                            $matchedKeywords[] = [
                                'id' => $keyword->id,
                                'keyword' => $keyword->keyword,
                                'weight' => $keyword->weight
                            ];
                            unset($keywords[$key]);
                            continue;
                        }
                    }
                }
            }
        }

        $whatsapp_messages = WhatsappMessage::with(['audio_transcript'=>function($q){
            $q->where('message_type','=','whatsapp');
        }])->where('user_id','=',$user_id)
            ->orderBy('id', 'desc')->simplePaginate(5);
        /*->where('to','=',$phone_number)
        ->orWhere('from','=',$phone_number)*/
        foreach($whatsapp_messages as $message){
            if($message->read_status!=1) {
                $message->read_status = 1;
                $message->save();
            }
        }
        $unread_messages_count = WhatsappMessage::where('user_id','=',$user_id)
            ->where('status','=','received')
            ->where('read_status','=',0)->count();

        $has_more = $whatsapp_messages->hasMorePages();
        $latest_customer_message = WhatsappMessage::where('from','=',$phone_number)->orderBy('id', 'desc')->limit(1)->first();
        $message_time_window = false;
        if($latest_customer_message != null){
            $latest_message_time = Carbon::parse($latest_customer_message->created_at);
            $current_time_min_day = Carbon::now()->subDay();
            $message_time_diff = $latest_message_time->gt($current_time_min_day);
            $message_time_window = $message_time_diff;
        }
        if($is_json){
            return json_encode([
                'messages'=>$whatsapp_messages,
                'more'=>$has_more,
                'phone'=>$phone_number,
                'time_window'=>$message_time_window,
                'unread_count'=>$unread_messages_count,
                'countMatchedKeywords' => count($matchedKeywords),
                'matchedKeywords' => $matchedKeywords
            ]);
        }
        dd('well');
    }

    public function sendMessageToCustomer(Request $request){
        $customer_id = $request->get('customer_id');
        $message_body = $request->get('message_body');
        //dd($request->all());
        $attachments = $request->file('attachment');
        $media_array = [];
        $media_types_array = [];
        $the_user = User::find($customer_id);
        if(!$the_user){
            return json_encode(['fault'=>1, 'message'=>'No user was found with this ID']);
        }
        $customer_phone = $the_user->phone;
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $twilio = new Client($sid, $token);
        if($attachments != null && (gettype($attachments)=='object' || (gettype($attachments)=='array' && sizeof($attachments) >= 1))) {
            if(gettype($attachments)=='object'){
                $attachment = $attachments;
                $imageName = $customer_id . '_' . time() . '.' . $attachment->getClientOriginalExtension();
                $media_types_array[] = $attachment->getMimeType();
                $attachment->move(base_path() . '/public/uploads/whatsapp-attachments/', $imageName);
                $media_array[] = asset('uploads/whatsapp-attachments/' . $imageName);
            } else {
                foreach ($attachments as $attachment) {
                    $imageName = $customer_id . '_' . time() . '.' . $attachment->getClientOriginalExtension();
                    $media_types_array[] = $attachment->getMimeType();
                    $attachment->move(base_path() . '/public/uploads/whatsapp-attachments/', $imageName);
                    $media_array[] = asset('uploads/whatsapp-attachments/' . $imageName);
                }
            }
        }
        if($message_body==null){
            $message_body = '';
        }
        $whatsapp_message_content = ["from" => "whatsapp:+447445341335",
            "body" => $message_body];
        $media_array_size = sizeof($media_array);
        if($media_array_size>0){
            $whatsapp_message_content["mediaUrl"] = $media_array;
        }
        $message = $twilio->messages->create('whatsapp:'.$customer_phone,
            $whatsapp_message_content
        );
        $whats = new WhatsappMessage();
        $whats->message = $message_body;
        $whats->from = 'Bumblebee ('.'+447445341335'.')';
        $whats->to = $customer_phone;
        $whats->user_id = $customer_id;
        $whats->status = $message->status;
        $whats->external_id = $message->sid;
        if($media_array_size>0){
            $whats->num_of_media = $media_array_size;
            $whats->media_urls = '';
            $whats->media_types = '';
            for($i=0; $i<$media_array_size; $i++){
                $whats->media_urls .= $media_array[$i];
                $whats->media_types .= $media_types_array[$i];
                if($i != $media_array_size-1){
                    $whats->media_urls .= ',';
                    $whats->media_types .= ',';
                }
            }
        }
        $whats->save();
        return json_encode(['fault'=>0, 'message'=>'Message enqueued for sending']);
    }
}
