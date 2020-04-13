<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('register/{user_type?}', 'Auth\RegisterController@getRegister');
Route::post('register', 'Auth\RegisterController@postRegister');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', function () {
    return view('home');
});

Route::get('customer/register/{code}', 'CustomersController@getCustomerRegister');
Route::post('customer/register', 'CustomersController@postCustomerRegister');
Route::get('customer/login', 'CustomersController@getCustomerLogin');
Route::post('customer/login', 'CustomersController@postCustomerLogin');
Route::get('customer/health-check', 'CustomersController@getHealthCheck');
Route::get('vehicle-lookup/{vehicle_reg}', 'LookUpController@getVehicleDetails');
Route::post('get-dtc-info', 'LookUpController@getDtcInformation');
Route::post('get-dtc-info-static-mid', 'LookUpController@getDtcInformationStaticMid');
Route::get('health-check/{room}', 'CustomersController@getHealthCheckWithSupport');
Route::post('send/health-check', 'CompanyController@sendSupportForHealthCheck');
Route::get('support/health-check/{room}', 'CompanyController@getSupportForHealthCheck');
//Route::get('health-check/send/{id}', 'CompanyController@getSupportForHealthCheck');
Route::post('customer/request-recovery', 'CustomersController@postSendRecoveryRequest');
Route::get('test-sms', 'CustomersController@getSendTestSMS');
Route::post('test-whatsapp', 'CustomersController@postSendTestWhatsapp');

Route::get('insurance/dashboard', 'InsuranceController@getInsuranceDashboard');
Route::post('insurance/send-invitation', 'InsuranceController@sendCustomerInvitation');

Route::get('fleet/add', 'FleetController@getAddFleet');
Route::post('fleet/add', 'FleetController@postAddFleet');
Route::get('fleets/view', 'FleetController@viewFleets');
Route::get('fleet/view/{id}', 'FleetController@viewFleet');

Route::get('obd/add','AdminController@getAddObd');
Route::post('obd/add','AdminController@postAddObd');
Route::get('obd/edit/{id}','AdminController@getEditObd');
Route::post('obd/edit','AdminController@postEditObd');
Route::get('obd/list','AdminController@getListObd');
Route::get('vehicle/add','AdminController@getAddVehicle');
Route::post('vehicle/add','AdminController@postAddVehicle');
Route::get('vehicle/edit/{id}','AdminController@getEditVehicle');
Route::post('vehicle/edit','AdminController@postEditVehicle');
Route::get('vehicle/list','AdminController@getListVehicle');
Route::get('obd-to-vehicle/add','AdminController@getAddObdToVehicle');
Route::post('obd-to-vehicle/add','AdminController@postAddObdToVehicle');
Route::get('obd-to-vehicle/edit/{id}','AdminController@getEditObdToVehicle');
Route::post('obd-to-vehicle/edit','AdminController@postEditObdToVehicle');
Route::get('obd-to-vehicle/list','AdminController@getListObdToVehicle');
Route::get('admin/customer-register','AdminController@getCustomerRegister');
Route::post('admin/customer-register','AdminController@postCustomerRegister');
Route::get('whatsapp-conversations','DashboardController@getWhatsappConversations');
Route::get('whatsapp-conversation/{user_id}','DashboardController@getWhatsappConversation');
Route::post('whatsapp/customer/send','DashboardController@sendMessageToCustomer');

Route::get('keywords', 'KeywordsController@index')->name('keywords');
Route::post('keywords', 'KeywordsController@store');
Route::put('keywords/{keyword}','KeywordsController@update');
Route::get('keywords/edit/{keyword}', 'KeywordsController@edit');
Route::get('keywords/add', 'KeywordsController@addKeyword');
Route::post('keywords/remove-audio', 'KeywordsController@removeAudio');
Route::get('keywords/delete/{keyword}', 'KeywordsController@destroy');

Route::get('responses', 'ResponseController@index')->name('responses');
Route::post('response', 'ResponseController@store');
Route::get('response/create', 'ResponseController@create');
Route::get('response/edit/{response}', 'ResponseController@edit');
Route::put('response/{response}', 'ResponseController@update');
Route::get('response/delete/{response}', 'ResponseController@destroy');

Route::get('service-types', 'ConversationsController@getServiceTypesIndex');
Route::get('service-type/add', 'ConversationsController@getServiceTypeAdd');
Route::post('service-type/add', 'ConversationsController@postServiceTypeAdd');
Route::get('service-type/edit/{id}', 'ConversationsController@getServiceTypeEdit');
Route::post('service-type/edit', 'ConversationsController@postServiceTypeEdit');
Route::any('service-type/delete/{id}', 'ConversationsController@anyServiceTypeDelete');

Route::get('support-types', 'SupportController@index');
Route::get('support-type/add', 'SupportController@addSupportType');
Route::post('support-type', 'SupportController@store');
Route::put('support-type/{supportType}','SupportController@update');
Route::get('support-type/edit/{supportType}', 'SupportController@edit');
Route::get('support-type/delete/{supportType}', 'SupportController@destroy');

Route::get('clients', 'ConversationsController@getClientsIndex');
Route::get('client/add', 'ConversationsController@getClientAdd');
Route::post('client/add', 'ConversationsController@postClientAdd');
Route::get('client/edit/{id}', 'ConversationsController@getClientEdit');
Route::post('client/edit', 'ConversationsController@postClientEdit');
Route::any('client/delete/{id}', 'ConversationsController@anyClientDelete');

Route::get('dashboard', function () {
    return view('admin.dashboard');
});
//Route for record audio
Route::get('record-audio','AudioController@index');
Route::post('upload-record-file', 'AudioController@save_recorded_audio');
Route::post('translate-audio-url', 'AudioController@saveAndTranslateAudioFile');

Route::get('support-customer', function () {
    return view('support');
});
Route::get('obd-admin', function () {
    return view('obd_general');
});
/*Route::get('autodata-driver', function () {
    return view('autodata-driver');
});*/
Route::get('tyres-batteries', function () {
    return view('autodata-driver');
});
Route::get('test-soap','LookUpController@testSoap');
Route::get('socket-test', function () {
    return view('socket_test');
});


// Customer
Route::get('create-customer', 'AdminController@createCustomer');
Route::post('customer', 'AdminController@storeCustomer');

Route::get('customer-register/{code}', 'CustomersController@customerRegister');
Route::post('complete-registration/{code}', 'CustomersController@completeRegistration');

Route::get('client/dashboard', 'ClientController@dashboard');

// whatsapp template
Route::get('whatsapp-templates', 'WhatsappTemplateController@index')->name('whatsapp-templates');
Route::get('whatsapp-template/create', 'WhatsappTemplateController@create');
Route::post('whatsapp-template', 'WhatsappTemplateController@store');
Route::get('whatsapp-template/edit/{template}', 'WhatsappTemplateController@edit');
Route::put('whatsapp-template/update/{template}', 'WhatsappTemplateController@update');
Route::get('whatsapp-template/delete/{template}', 'WhatsappTemplateController@delete');