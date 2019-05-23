<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Twilio\Rest\Client;
use App\User;
use App\SMS;

class CompanyController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function getSendHealthCheck($id){

    }

    public function sendSupportForHealthCheck(Request $request){
        $user_id = $request->get('user_id');
        $the_user = User::find($user_id);
        $room = rand(100000,999999);
        if(!$the_user){
            return redirect()->back()->with('error', 'This user was not found!');
        }
        $name = $the_user->name;
        $phone = $the_user->phone;
        $sid = env('TWILIO_SID', '');
        $token = env('TWILIO_AUTH', '');
        try {
            $twilio = new Client($sid, $token);
            $body = 'Hi ';
            if($name!=null) {
                $body .= $name;
            }
            $body.=', Click the following link to open the health check support session. '.
                url('health-check/'.$room);
            $message = $twilio->messages->create($phone,
                ["from" => "+447445341335",
                    "body" => $body]
            );
            $sms = new SMS();
            $sms->message = $body;
            $sms->from = 'Bumblebee ('.'+447445341335'.')';
            $sms->to = $phone;
            $sms->status = $message->status;
            $sms->external_id = $message->sid;
            $sms->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->to('support/health-check/'.$room);
    }

    public function getSupportForHealthCheck($room){
        return view('support_health_check', compact('room'));
    }
}
