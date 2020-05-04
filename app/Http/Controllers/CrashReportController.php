<?php

namespace App\Http\Controllers;

use App\User;
use App\WhatsappMessage;
use Illuminate\Http\Request;
use App\CrashReport;
use Twilio\Rest\Client;
use Validator;

class CrashReportController extends Controller
{
    public function crashReport(Request $request)
    {
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
}
