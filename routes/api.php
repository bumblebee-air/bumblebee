<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('twilio-token', 'TwilioTokenController@generate');
Route::post('vehicle-by-obd', 'LookUpController@postGetVehicleByObd');
Route::post('check-obd-vehicle-connection', 'LookUpController@checkObdToVehicleConnection');
Route::post('get-tyres-info', 'LookUpController@getTyresInformation');
Route::post('get-batteries-info', 'LookUpController@getBatteriesInformation');
Route::post('get-battery-info', 'LookUpController@getBatteryInformation');
Route::post('whatsapp-message', 'TwilioController@whatsappMessage');
Route::post('whatsapp-status', 'TwilioController@whatsappStatus');

Route::post('generate-security-pin', 'SecurityController@generateCustomerPin');
Route::post('customer-identification', 'SecurityController@customerIdentification');
Route::post('dtc-info', 'LookUpController@submitHealthCheck');
Route::post('crash-report', 'EmergencyController@crashReport');
Route::post('emergency-call-twiml', 'TwilioController@emergencyCallTwiml');
Route::post('crash-detection-twiml', 'TwilioController@crashDetectionTwiml');
Route::post('twilio-record-hangup', 'TwilioController@twilioRecordHangup');
Route::post('process-crash-detection-recording', 'TwilioController@processCrashDetectionRecording');
Route::post('obd-connection', 'OBDController@saveAppOBDConnection');
Route::post('general-enquiry', 'EnquiryController@saveGeneralEnquiry');

Route::post('order', 'OrdersController@receiveOrder');
Route::post('fulfill-order', 'OrdersController@fulfillOrder');