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
Route::post('shopify/order', 'ShopifyController@receiveOrder');
Route::post('shopify/fulfill-order', 'ShopifyController@fulfillOrder');
Route::post('magento/order', 'MagentoController@receiveOrder');
Route::post('magento/fulfill-order', 'MagentoController@fulfillOrder');
Route::post('woocommerce/order', 'WooCommerceController@receiveOrder');
Route::post('woocommerce/fulfill-order', 'WooCommerceController@fulfillOrder');
Route::post('bigcommerce/webhook-order', 'BigCommerceController@receiveWebhookOrder');
Route::post('bigcommerce/order', 'BigCommerceController@receiveOrder');
Route::post('bigcommerce/fulfill-order', 'BigCommerceController@fulfillOrder');
Route::post('bigcommerce/create-webhook', 'BigCommerceController@createBigCommerceWebhook');
Route::post('bigcommerce/list-or-delete-webhook', 'BigCommerceController@listOrDeleteBigCommerceWebhook');

Route::post('driver-registration','doorder\DriversController@postDriverRegistration');
Route::post('driver-login','doorder\DriversController@driversLogin');
Route::post('driver-forgot-password','doorder\DriversController@sendForgotPasswordCode');
Route::post('contractor-forgot-password','doorder\DriversController@sendGHForgotPasswordCode');
Route::post('driver-check-code','doorder\DriversController@checkForgotPasswordCode');
Route::post('driver-change-password','doorder\DriversController@changeUserPassword');
Route::group(['middleware' => "auth:api"],function () {
    //DoOrder
    Route::get('orders-list','doorder\DriversController@ordersList');
    Route::post('driver-status-update','doorder\DriversController@updateOrderDriverStatus');
    Route::post('driver-duty-update','doorder\DriversController@updateDriverDutyStatus');
    Route::post('order-details','doorder\DriversController@orderDetails');
    Route::post('driver-location-update','doorder\DriversController@updateDriverLocation');
    Route::post('skip-delivery-confirmation','doorder\DriversController@skipDeliveryConfirmation');
    Route::post('update-driver-firebase-token','doorder\DriversController@updateDriverFirebaseToken');
    Route::post('update-driver-password','doorder\DriversController@changePassword');
    Route::get('get-driver-profile','doorder\DriversController@getProfile');
    Route::post('update-driver-profile','doorder\DriversController@updateProfile');
    Route::post('optimize-orders-route','doorder\DriversController@optimizeOrdersRoute');

    //GardenHelp
    Route::get('jobs-list','garden_help\ContractorsController@getJobsList');
    Route::post('job-details','garden_help\ContractorsController@getJobDetails');
    Route::post('contractor-status-update','garden_help\ContractorsController@updateJobDriverStatus');
    Route::post('change-password','garden_help\ContractorsController@changePassword');
    Route::post('update-profile','garden_help\ContractorsController@updateProfile');
    Route::get('get-profile','garden_help\ContractorsController@getProfile');


    //Unified
    Route::group(['prefix' => 'unified'], function() {
        Route::get('jobs', 'unified\EngineerController@getJobsList');
        Route::get('jobs/{id}', 'unified\EngineerController@getJobDetails');
        Route::post('jobs/{id}', 'unified\EngineerController@postJob');
        Route::get('jobs_types', 'unified\EngineerController@getJobsTypes');
        Route::get('services', 'unified\EngineerController@getServices');
        Route::post('update_location', 'unified\EngineerController@updateLocation');
        Route::post('checkout_jobs', 'unified\EngineerController@checkOutJobs');
    });
});


Route::post('stripe-account-update','StripeController@accountUpdateWebhook');

//App Details
Route::get('app-details', 'AppDetailsController@view');
Route::post('app-details', 'AppDetailsController@update');

//Auth API
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'Auth\ApiAuthController@login');
    Route::post('forgot_password', 'Auth\ApiAuthController@forgotPassword');
    Route::post('code_verification', 'Auth\ApiAuthController@checkVerificationCode');
    Route::post('update_password', 'Auth\ApiAuthController@updatePassword')->middleware('auth:api');
});
