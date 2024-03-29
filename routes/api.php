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

Route::get('cities/{id}',function ($country_id){
    $countries=  \App\Models\City::where('country_id',$country_id)->get();
    return response()->json($countries, 200);
});

Route::post('cms-page','CMSController@getPages');

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
Route::post('sap-hybris/order', 'SAPHybrisController@receiveOrder');
Route::post('sap-hybris/fulfill-order', 'SAPHybrisController@fulfillOrder');

Route::post('driver-registration', 'doorder\DriversController@postDriverRegistration');
Route::post('driver-login', 'doorder\DriversController@driversLogin');
Route::post('driver-forgot-password', 'doorder\DriversController@sendForgotPasswordCode');
Route::post('contractor-forgot-password', 'doorder\DriversController@sendGHForgotPasswordCode');
Route::post('driver-check-code', 'doorder\DriversController@checkForgotPasswordCode');
Route::post('driver-change-password', 'doorder\DriversController@changeUserPassword');
Route::group(['middleware' => "auth:api"], function () {
    //DoOrder
    Route::get('orders-list', 'doorder\DriversController@ordersList');
    Route::get('new-orders-list', 'doorder\DriversController@newOrdersList');
    Route::get('time-end-shift', 'doorder\DriversController@timeEndShift');
    Route::get('cancel-reasons', 'doorder\DriversController@cancelReasons');
    Route::post('cancel-order', 'doorder\DriversController@cancelOrder');
    
    Route::post('driver-status-update', 'doorder\DriversController@updateOrderDriverStatus');
    Route::post('driver-duty-update', 'doorder\DriversController@updateDriverDutyStatus');
    Route::post('driver-rating', 'doorder\DriversController@AddDriverRating');
    Route::post('order-details', 'doorder\DriversController@orderDetails');
    Route::post('driver-location-update', 'doorder\DriversController@updateDriverLocation');
    Route::post('skip-delivery-confirmation', 'doorder\DriversController@skipDeliveryConfirmation');
    Route::post('update-driver-firebase-token', 'doorder\DriversController@updateDriverFirebaseToken');
    Route::post('update-driver-password', 'doorder\DriversController@changePassword');
    Route::get('get-driver-profile', 'doorder\DriversController@getProfile');
    Route::post('update-driver-profile', 'doorder\DriversController@updateProfile');
    Route::post('optimize-orders-route', 'doorder\DriversController@optimizeOrdersRoute');
    Route::post('check-order-qr-code', 'doorder\OrdersController@checkOrderQrCode');

    //GardenHelp
    Route::get('jobs-list', 'garden_help\ContractorsController@getJobsList');
    Route::post('job-details', 'garden_help\ContractorsController@getJobDetails');
    Route::post('contractor-status-update', 'garden_help\ContractorsController@updateJobDriverStatus');
    Route::post('change-password', 'garden_help\ContractorsController@changePassword');
    Route::get('get-profile', 'garden_help\ContractorsController@getProfile');
    Route::post('update-profile', 'garden_help\ContractorsController@updateProfile');
    Route::get('get-setting', 'garden_help\ContractorsController@editSetting');
    Route::post('update-setting', 'garden_help\ContractorsController@updateSetting');
    Route::post('skip-confirmation', 'garden_help\ContractorsController@skipJobConfirmation');
    Route::post('job-time-tracker', 'garden_help\ContractorsController@jobTimeTracker');
    Route::post('contractor-bidding', 'garden_help\ContractorsController@postContractorBid');

    //Unified
    Route::group(['prefix' => 'unified'], function () {
        Route::get('jobs', 'unified\EngineerController@getJobsList');
        Route::get('jobs/{id}', 'unified\EngineerController@getJobDetails');
        Route::post('jobs/{id}', 'unified\EngineerController@postJob');
        Route::get('jobs_types', 'unified\EngineerController@getJobsTypes');
        Route::get('services', 'unified\EngineerController@getServices');
        Route::post('update_location', 'unified\EngineerController@updateLocation');
        Route::post('checkout_jobs', 'unified\EngineerController@checkOutJobs');
    });

    //General
    Route::post('user/delete', 'UserController@deleteUserData');
});
//Stripe updates
Route::post('stripe-account-update', 'StripeController@accountUpdateWebhook');
Route::post('stripe-payment-intent-update', 'StripeController@PaymentIntentUpdateWebhook');

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
//GardenHelp
Route::get('garden-help/available_contractors', 'garden_help\CustomersController@getAvailableContractorsForBooking');
