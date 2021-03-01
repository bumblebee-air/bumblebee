<?php

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */
Route::get('register/{user_type?}', 'Auth\RegisterController@getRegister');
Route::post('register', 'Auth\RegisterController@postRegister');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout');

Route::get('/', function () {
    // return view('home');
    return redirect('login');
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
// Route::get('health-check/send/{id}', 'CompanyController@getSupportForHealthCheck');
Route::post('customer/request-recovery', 'CustomersController@postSendRecoveryRequest');
Route::get('test-sms', 'CustomersController@getSendTestSMS');
Route::post('test-whatsapp', 'CustomersController@postSendTestWhatsapp');

Route::get('insurance/dashboard', 'InsuranceController@getInsuranceDashboard');
Route::post('insurance/send-invitation', 'InsuranceController@sendCustomerInvitation');

Route::get('fleet/add', 'FleetController@getAddFleet');
Route::post('fleet/add', 'FleetController@postAddFleet');
Route::get('fleets/view', 'FleetController@viewFleets');
Route::get('fleet/view/{id}', 'FleetController@viewFleet');

Route::get('obd/add', 'AdminController@getAddObd');
Route::post('obd/add', 'AdminController@postAddObd');
Route::get('obd/edit/{id}', 'AdminController@getEditObd');
Route::post('obd/edit', 'AdminController@postEditObd');
Route::get('obd/list', 'AdminController@getListObd');
Route::get('vehicle/add', 'AdminController@getAddVehicle');
Route::post('vehicle/add', 'AdminController@postAddVehicle');
Route::get('vehicle/edit/{id}', 'AdminController@getEditVehicle');
Route::post('vehicle/edit', 'AdminController@postEditVehicle');
Route::get('vehicle/list', 'AdminController@getListVehicle');
Route::get('obd-to-vehicle/add', 'AdminController@getAddObdToVehicle');
Route::post('obd-to-vehicle/add', 'AdminController@postAddObdToVehicle');
Route::get('obd-to-vehicle/edit/{id}', 'AdminController@getEditObdToVehicle');
Route::post('obd-to-vehicle/edit', 'AdminController@postEditObdToVehicle');
Route::get('obd-to-vehicle/list', 'AdminController@getListObdToVehicle');
Route::get('admin/customer-register', 'AdminController@getCustomerRegister');
Route::post('admin/customer-register', 'AdminController@postCustomerRegister');
Route::get('whatsapp-conversations', 'DashboardController@getWhatsappConversations');
Route::get('whatsapp-conversation/{user_id}', 'DashboardController@getWhatsappConversation');
Route::post('whatsapp/customer/send', 'DashboardController@sendMessageToCustomer');

Route::get('keywords', 'KeywordsController@index')->name('keywords');
Route::post('keywords', 'KeywordsController@store');
Route::put('keywords/{keyword}', 'KeywordsController@update');
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
Route::put('support-type/{supportType}', 'SupportController@update');
Route::get('support-type/edit/{supportType}', 'SupportController@edit');
Route::get('support-type/delete/{supportType}', 'SupportController@destroy');

Route::get('clients', 'ConversationsController@getClientsIndex');
Route::get('client/add', 'ConversationsController@getClientAdd');
Route::post('client/add', 'ConversationsController@postClientAdd');
Route::get('client/edit/{id}', 'ConversationsController@getClientEdit');
Route::post('client/edit', 'ConversationsController@postClientEdit');
Route::any('client/delete/{id}', 'ConversationsController@anyClientDelete');

Route::get('users', 'UserController@usersIndex');

Route::get('dashboard', function () {
    return view('admin.dashboard');
});
// Route for record audio
Route::get('record-audio', 'AudioController@index');
Route::get('orderlist', 'OrdersController@index');
Route::post('upload-record-file', 'AudioController@save_recorded_audio');
Route::post('translate-audio-url', 'AudioController@saveAndTranslateAudioFile');

Route::get('support-customer', function () {
    return view('support');
});
Route::get('obd-admin', function () {
    return view('obd_general');
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

// Emergency settings for customer
Route::get('emergency-settings/pin', 'EmergencyController@getEmergencySettingsPin');
Route::post('emergency-settings/pin', 'EmergencyController@postEmergencySettingsPin');
Route::post('emergency-settings', 'EmergencyController@postEmergencySettings');
Route::get('emergency-settings', function () {
    $user_id = null;
    $contact_name = null;
    $contact_phone = null;
    $contact_email = null;
    $contact_method = null;
    $second_contact_name = null;
    $second_contact_phone = null;
    $second_contact_email = null;
    $second_contact_method = null;
    $other_contact = null;
    return view('emergency-settings.settings', compact('contact_name', 'contact_phone', 'contact_email', 'contact_method', 'second_contact_name', 'second_contact_phone', 'second_contact_email', 'second_contact_method', 'user_id', 'other_contact'));
});

Route::get('general-enquiry', 'EnquiryController@getGeneralEnquiryIndex');
Route::get('general-enquiry/add', 'EnquiryController@getAddGeneralEnquiry');
Route::post('general-enquiry', 'EnquiryController@postGeneralEnquiry');
Route::get('general-enquiry/edit/{id}', 'EnquiryController@getEditGeneralEnquiry');

Route::get('suppliers', 'SupplierController@getSuppliersIndex');
Route::get('suppliers/import', 'SupplierController@getSuppliersImport');
Route::post('suppliers/import', 'SupplierController@postSuppliersImport');
Route::post('suppliers/delete-all', 'SupplierController@deleteAllSuppliers');
Route::get('supplier/schedule-form/{code}', 'SupplierController@getSupplierScheduleForm');
Route::post('supplier/schedule-form', 'SupplierController@postSupplierScheduleForm');
Route::get('suppliers/map', 'SupplierController@getSuppliersMap');

Route::get('customer-payment', 'PaymentController@getCustomerPayment');
Route::post('custom-customer-payment-amount', 'PaymentController@setCustomCustomerPaymentAmount');
// Test routes
/*
 * Route::get('autodata-driver', function () {
 * return view('autodata-driver');
 * });
 */
Route::get('tyres-batteries', function () {
    return view('autodata-driver');
});
Route::get('test-soap', 'LookUpController@testSoap');
Route::get('socket-test', function () {
    return view('socket_test');
});
Route::get('test-call', 'TestController@getTestCall');
Route::post('test-call', 'TestController@postTestCall');
Route::get('test-crash-call', 'TestController@getTestCrashDetectionCall');
Route::post('test-crash-call', 'TestController@postTestCrashDetectionCall');

// Stripe
Route::get('stripe-account-create-test', 'StripeController@getAccountCreationTest');
Route::post('stripe-account-create-test', 'StripeController@postAccountCreationTest');
Route::get('stripe-onboard/{onboard_code}', 'StripeController@getOnboard');
Route::get('stripe-onboard/stripe/refresh', 'StripeController@getOnboardRefresh');
Route::get('stripe-onboard/stripe/success', 'StripeController@getOnboardSuccess');

// Clients Login
Route::group(['prefix' => '{client_name}'], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('clientLogin');
    Route::post('login', 'Auth\LoginController@login')->name('clientLogin');

    /*
     * GardenHelp Routes
     */

    Route::get('contractors/registration', 'garden_help\ContractorsController@index')->name('getContractorRegistration');
    Route::post('contractors/registration', 'garden_help\ContractorsController@save')->name('postContractorRegistration');
    Route::get('customers/registration', 'garden_help\CustomersController@getRegistrationForm')->name('getCustomerRegistration');
    Route::post('customers/registration', 'garden_help\CustomersController@postRegistrationForm')->name('postCustomerRegistration');

    Route::group(['middleware' => "auth:garden-help"], function () {

        Route::get('home', 'garden_help\DashboardController@index')->name('garden_help_getDashboard');
        Route::group(['prefix' => 'contractors'], function () {
            Route::get('requests', 'garden_help\ContractorsController@getContractorsRequests')->name('garden_help_getContractorsRequests');
            Route::get('requests/{id}', 'garden_help\ContractorsController@getSingleRequest')->name('garden_help_getContractorSingleRequest');
            Route::post('requests/{id}', 'garden_help\ContractorsController@postSingleRequest')->name('garden_help_postContractorSingleRequest');
        });
        Route::group(['prefix' => 'customers'], function () {
            Route::get('requests', 'garden_help\CustomersController@getCustomersRequests')->name('garden_help_getCustomerssRequests');
            Route::get('requests/{id}', 'garden_help\CustomersController@getSingleRequest')->name('garden_help_getcustomerSingleRequest');
            Route::post('requests/{id}', 'garden_help\CustomersController@postSingleRequest')->name('garden_help_postCustomerSingleRequest');
        });
        Route::group(['prefix' => 'jobs_table'], function () {
            Route::get('jobs', 'garden_help\JobsController@getJobsTable')->name('garden_help_getJobsTable');
            Route::get('job/{id}', 'garden_help\JobsController@getSingleJob')->name('garden_help_getSingleJob');
            Route::post('job/{id}', 'garden_help\JobsController@postSingleJob')->name('garden_help_postSingleJob');
        });

        Route::post('job/assign', 'garden_help\JobsController@assignContractorToJob')->name('garden_help_assignJob');

    });


    /*
     * DoOrder Routes
     */

    //Driver Registration
    Route::get('driver_registration', 'doorder\DriversController@getDriverRegistration')->name('getDriverRegistration');
    Route::post('driver_registration', 'doorder\DriversController@postDriverRegistration')->name('postDriverRegistration');

    // Retailer Registration
    Route::get('retailer/registration', 'doorder\RetailerController@getRetailerRegistrationForm')->name('getRetailerRegistration');
    Route::post('retailer/registration', 'doorder\RetailerController@postRetailerRegistrationForm')->name('postRetailerRegistration');

    Route::group(['middleware' => "auth:doorder"], function () {
        Route::get('dashboard', 'doorder\DashboardController@index')->name('doorder_dashboard');
        Route::get('orders', 'doorder\OrdersController@getOrdersTable')->name('doorder_ordersTable');
        Route::get('single-order/{id}', 'doorder\OrdersController@getSingleOrder')->name('doorder_singleOrder');

        Route::group(['middleware' => "client"], function () {
            Route::post('order/assign', 'doorder\OrdersController@assignDriverToOrder')->name('doorder_assignOrder');
            Route::get('admin-map', 'doorder\DashboardController@getAdminMap')->name('doorder_adminMap');
            // Drivers
            Route::get('drivers/requests', 'doorder\DriversController@getDriverRegistrationRequests')->name('doorder_drivers_requests');
            Route::get('drivers/requests/{id}', 'doorder\DriversController@getSingleRequest')->name('doorder_drivers_single_request');
            Route::post('drivers/requests/{id}', 'doorder\DriversController@postSingleRequest')->name('post_doorder_drivers_single_request');
            // Retailers
            Route::get('retailers/requests', 'doorder\RetailerController@getRetailerRequests')->name('doorder_retailers_requests');
            Route::get('retailers/requests/{id}', 'doorder\RetailerController@getSingleRequest')->name('doorder_retailers_single_request');
            Route::post('retailers/request/{id}', 'doorder\RetailerController@postSingleRequest')->name('post_doorder_retailers_single_request');
        });
        Route::group(['middleware' => "retailer"], function () {
            Route::get('orders/add', 'doorder\OrdersController@addNewOrder')->name('doorder_addNewOrder');
            Route::post('orders/save', 'doorder\OrdersController@saveNewOrder')->name('doorder_saveNewOrder');
        });
    });
});

// DoOrder Routes
Route::get('driver_app', function () {
    return view('templates/driver_app');
});
// GardenHelp App
Route::get('contractors_app', function () {
    return view('templates/garden_help_app');
});

Route::get('customer/order/{customer_confirmation_code}', 'doorder\CustomerController@getCustomerOrderPage');
Route::get('customer/tracking/{customer_confirmation_code}', 'doorder\CustomerController@getOrderTracking');
Route::get('customer/delivery_confirmation/{customer_confirmation_code}', 'doorder\CustomerController@getDeliveryConfirmationURL')->name('getDeliveryConfirmationURL');
Route::post('customer/delivery_confirmation', 'doorder\CustomerController@postDeliveryConfirmationURL')->name('postDeliveryConfirmationURL');
