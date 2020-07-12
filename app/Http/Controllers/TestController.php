<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\Rest\Client;
use SimpleXMLElement;
use Response;

class TestController extends Controller
{
    public function getTestCall(){
        return view('test_call');
    }

    public function postTestCall(Request $request){
        $phone = $request->phone;
        try {
            $sid    = env('TWILIO_SID', '');
            $token  = env('TWILIO_AUTH', '');
            $twilio = new Client($sid, $token);
            $call = $twilio->calls
                ->create($phone,
                    "+447445341335",
                    ["ApplicationSid" => "AP4bb59d0de54e944a4b920d57b2b72ede"]
                );
            //dd($call);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            dd($e->getMessage());
        }
        return redirect()->back();
    }

    public function getTestCrashDetectionCall(){
        return view('test_crash_detection_call');
    }

    public function postTestCrashDetectionCall(Request $request){
        $phone = $request->phone;
        try {
            $sid    = env('TWILIO_SID', '');
            $token  = env('TWILIO_AUTH', '');
            $twilio = new Client($sid, $token);
            $call = $twilio->calls
                ->create($phone,
                    "+447445341335",
                    ["ApplicationSid" => "AP610012487e2b9de5665d13e471663873"]
                );
            //dd($call);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return redirect()->back();
    }
}