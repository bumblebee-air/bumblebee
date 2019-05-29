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
Route::get('health-check/{room}', 'CustomersController@getHealthCheckWithSupport');
Route::post('send/health-check', 'CompanyController@sendSupportForHealthCheck');
Route::get('support/health-check/{room}', 'CompanyController@getSupportForHealthCheck');
//Route::get('health-check/send/{id}', 'CompanyController@getSupportForHealthCheck');
Route::get('test-sms', 'CustomersController@getSendTestSMS');

Route::get('insurance/dashboard', 'InsuranceController@getInsuranceDashboard');
Route::post('insurance/send-invitation', 'InsuranceController@sendCustomerInvitation');

Route::get('fleet/add', 'FleetController@getAddFleet');
Route::post('fleet/add', 'FleetController@postAddFleet');
Route::get('fleets/view', 'FleetController@viewFleets');
Route::get('fleet/view/{id}', 'FleetController@viewFleet');

Route::get('obd/add','AdminController@getAddObd');
Route::post('obd/add','AdminController@postAddObd');
Route::get('vehicle/add','AdminController@getAddVehicle');
Route::post('vehicle/add','AdminController@postAddVehicle');
Route::get('obd-to-vehicle/add','AdminController@getAddObdToVehicle');
Route::post('obd-to-vehicle/add','AdminController@postAddObdToVehicle');
Route::post('vehicle-by-obd', 'LookUpController@postGetVehicleByObd');

Route::get('support-customer', function () {
    return view('support');
});
Route::get('obd-admin', function () {
    return view('obd_general');
});
Route::get('test-soap','LookUpController@testSoap');
Route::get('socket-test', function () {
    return view('socket_test');
});
