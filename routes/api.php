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
Route::post('whatsapp-message', 'TwilioController@whatsappMessage');
Route::post('whatsapp-status', 'TwilioController@whatsappStatus');