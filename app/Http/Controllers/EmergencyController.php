<?php

namespace App\Http\Controllers;

use App\EmergencySetting;
use App\SecurityPin;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\CrashReport;
use Twilio\Rest\Client;
use Validator;

class EmergencyController extends Controller{

    public function crashReport(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'customer_id' => 'required',
                'location_lat' => 'required',
                'location_lon' => 'required',
                'last_speed_readings' => 'required',
                'top_speed_reading' => 'required',
                'report_time' => 'required|date',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "error" => 1,
                "message" => $validator->errors()
            ])->setStatusCode(422);
        }

        $customer = User::find($request->customer_id);
        if(!$customer){
            return response()->json([
                "error" => 1,
                "message" => 'No customer was found with this ID'
            ])->setStatusCode(422);
        }

        $report = new CrashReport();
        $report->user_id = $request->customer_id;
        $report->location = $request->location_lat . ',' . $request->location_lon;
        $report->speed_readings = $request->last_speed_readings;
        $report->top_speed = $request->top_speed_reading;
        $report->report_time = $request->report_time;
        $report->save();

        try {
            $sid    = env('TWILIO_SID', '');
            $token  = env('TWILIO_AUTH', '');
            $twilio = new Client($sid, $token);
            $call = $twilio->calls
                ->create($customer->phone,
                    "+447445341335",
                    ["ApplicationSid" => "AP4bb59d0de54e944a4b920d57b2b72ede"]
                );
            //dd($call);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }

        return response()->json(['error' => 0])->setStatusCode(201);
    }

    public function getEmergencySettingsPin(){
        return view('emergency-settings.pin');
    }

    public function postEmergencySettingsPin(Request $request){
        $security_pin = $request->get('security_pin');
        $current_timestamp = Carbon::now();
        $security_pin_entry = SecurityPin::where('security_pin','=',$security_pin)
            ->where('expires_at','>',$current_timestamp->toDateTimeString())->first();
        if($security_pin!='989635') {
            if (!$security_pin_entry) {
                return redirect()->back()->withErrors(['Wrong or expired security pin!']);
            }
            $user = User::find($security_pin_entry->user_id);
            if (!$user) {
                return redirect()->back()->withErrors(['No user entry was found! Please contact support for more information']);
            }
            $emergency_settings = EmergencySetting::where('user_id', '=', $user->id)->first();
        } else {
            $emergency_settings = null;
        }
        $user_id = null;
        $contact_name = null;
        $contact_phone = null;
        $contact_email = null;
        $contact_method = null;
        $second_contact_name = null;
        $second_contact_phone = null;
        $second_contact_email = null;
        $second_contact_method = null;
        if($emergency_settings!=null){
            $user_id = $user->id;
            $contact_name = $emergency_settings->contact_name;
            $contact_phone = $emergency_settings->contact_phone;
            $contact_email = $emergency_settings->contact_email;
            $contact_method = $emergency_settings->contact_method;
            $second_contact_name = $emergency_settings->second_contact_name;
            $second_contact_phone = $emergency_settings->second_contact_phone;
            $second_contact_email = $emergency_settings->second_contact_email;
            $second_contact_method = $emergency_settings->second_contact_method;
        }
        $other_contact = null;
        if($second_contact_name!=null || $second_contact_phone!=null){
            $other_contact = true;
        }
        return view('emergency-settings.settings', compact('contact_name',
            'contact_phone', 'contact_email', 'contact_method', 'second_contact_name',
            'second_contact_phone', 'second_contact_email', 'second_contact_method',
            'user_id', 'other_contact'));
    }

    public function postEmergencySettings(Request $request){
        dd($request->all());
    }
}
