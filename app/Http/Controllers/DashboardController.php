<?php

namespace App\Http\Controllers;

use App\User;
use App\WhatsappMessage;
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
        if($is_json){
            return json_encode(['messages'=>$whatsapp_messages,'more'=>$has_more,
                'phone'=>$phone_number]);
        }
        dd('well');
    }
}