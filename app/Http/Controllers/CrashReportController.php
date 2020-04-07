<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CrashReport;
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

        $report = new CrashReport();
        $report->user_id = $request->customer_id;
        $report->location = $request->location_lat . ',' . $request->location_lon;
        $report->speed_readings = $request->last_speed_readings;
        $report->top_speed = $request->top_speed_reading;
        $report->report_time = $request->report_time;
        $report->save();

        return response()->json(['error' => 0])->setStatusCode(201);
    }
}
