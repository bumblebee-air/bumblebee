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
        $conversations = WhatsappMessage::groupBy('user_id')
            ->select('user_id',\DB::raw('MAX(`message`) as message'),
                \DB::raw('MAX(`from`) as sender'))->get();
        foreach($conversations as $index=>$conv){
            $the_user = User::find($conv->user_id);
            if($the_user){
                $the_name = $the_user->name;
            } else {
                $the_name = 'N/A';
            }
            $conversations[$index]->name = $the_name;
        }
        dd($conversations);
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
            return $whatsapp_messages->toJson();
        }

    }
}