<?php

namespace App\Http\Controllers;

use App\User;
use App\WhatsappMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Twilio\Rest\Client;
use SimpleXMLElement;
use Response;

class DashboardController extends Controller
{
    public function getWhatsappConversations(){
        $conversations = [];
        $grouped_conversations = WhatsappMessage::groupBy('user_id')
            ->select(\DB::raw('MAX(`id`) as id'))->get();
        foreach($grouped_conversations as $index=>$conv){
            $whatsapp_message = WhatsappMessage::find($conv->id);
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
            $conversations[] = $whatsapp_message;
        }
        //dd($conversations);
        return view('admin.whatsapp_conversation',['conversations'=>$conversations]);
    }

    public function getWhatsappConversation($user_id){
        $is_json = Input::get('is_json');
        $user = User::find($user_id);
        if(!$user){
            return redirect()->back()->withErrors('No user was found with this ID!');
        }
        $phone_number = $user->phone;
        $whatsapp_messages = WhatsappMessage::where('to','=',$phone_number)
            ->orWhere('from','=',$phone_number)->orderBy('id', 'desc')->simplePaginate(5);
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
            return json_encode(['messages'=>$whatsapp_messages,'more'=>$has_more,
                'phone'=>$phone_number,'time_window'=>$message_time_window]);
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
            if(sizeof($attachments)==1){
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