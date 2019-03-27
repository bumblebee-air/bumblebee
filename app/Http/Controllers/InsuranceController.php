<?php

namespace App\Http\Controllers;
use App\CustomerInvitation;
use App\SMS;
use Illuminate\Http\Request;
use Auth;
use Twilio\Rest\Client;

class InsuranceController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('insurance');
    }

    public function getInsuranceDashboard(){
        return view('insurance.dashboard');
    }

    public function sendCustomerInvitation(Request $request){
        $current_user = Auth::user();
        $name = $request->get('name');
        $phone = $request->get('phone');
        $sid = env('TWILIO_SID', '');
        $token = env('TWILIO_AUTH', '');
        try {
            $twilio = new Client($sid, $token);
            $body = 'Hi ';
            if($name!=null) {
                $body .= $name;
            }
            $code = $this->generateCode();
            $body.=', Register on Bumblebee to get your OBD device activated. '.
                url('customer/register/'.$code);
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
            $customer_invite = new CustomerInvitation();
            $customer_invite->phone = $phone;
            $customer_invite->name = $name;
            $customer_invite->code = $code;
            $customer_invite->sms_id = $sms->id;
            $customer_invite->user_id = $current_user->id;
            $customer_invite->save();

            return redirect()->back()->with('success','SMS Invitation initiated for '.$phone);
        } catch (\Exception $e) {
            //dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function generateCode($size = 6){
        $code = '';
        for ($i = 0; $i<$size; $i++) {
            $code .= mt_rand(0,9);
        }
        return $code;
    }
}