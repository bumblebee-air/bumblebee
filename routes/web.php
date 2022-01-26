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

// open_insurance
Route::get('open_insurance/insurance_entity', 'OpenInsuranceController@getInsuranceEntity');
Route::post('open_insurance/save_insurance_entity', 'OpenInsuranceController@postInsuranceEntity');
Route::get('open_insurance/personal', 'OpenInsuranceController@getPersonal');
Route::post('open_insurance/save_personal', 'OpenInsuranceController@postPersonal');
Route::get('open_insurance/commercial', 'OpenInsuranceController@getCommercial');
Route::post('open_insurance/save_commercial', 'OpenInsuranceController@postCommercial');
Route::get('open_insurance/driver', 'OpenInsuranceController@getDriver');
Route::post('open_insurance/save_driver', 'OpenInsuranceController@postDriver');
Route::get('open_insurance/vehicle', 'OpenInsuranceController@getVehicle');
Route::post('open_insurance/save_vehicle', 'OpenInsuranceController@postVehicle');
Route::get('open_insurance/product', 'OpenInsuranceController@getProduct');
Route::post('open_insurance/save_product', 'OpenInsuranceController@postProduct');
Route::get('open_insurance/claim', 'OpenInsuranceController@getClaim');
Route::post('open_insurance/save_claim', 'OpenInsuranceController@postClaim');
Route::get('open_insurance/coverage', 'OpenInsuranceController@getCoverage');
Route::post('open_insurance/save_coverage', 'OpenInsuranceController@postCoverage');
Route::get('open_insurance/beneficiary', 'OpenInsuranceController@getBeneficiary');
Route::post('open_insurance/save_beneficiary', 'OpenInsuranceController@postBeneficiary');
Route::get('open_insurance/receipt', 'OpenInsuranceController@getReceipt');
Route::post('open_insurance/save_receipt', 'OpenInsuranceController@postReceipt');
Route::get('open_insurance/premium_bordereau', 'OpenInsuranceController@getPremiumBordereau');
Route::post('open_insurance/save_premium_bordereau', 'OpenInsuranceController@postPremiumBordereau');
Route::get('open_insurance/claims_bordereau', 'OpenInsuranceController@getClaimsBordereau');
Route::post('open_insurance/save_claims_bordereau', 'OpenInsuranceController@postClaimsBordereau');

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

Route::post('validate-email-phone', 'HelperController@postValidateEmailAndPhone');
// Clients Login
Route::group(
    [
        'prefix' => '{client_name}'
    ],
    function () {
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('clientLogin');
        Route::post('login', 'Auth\LoginController@login')->name('clientLogin');
        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('clientForgetPassword');

        Route::middleware("auth:garden-help,doorder,doom-yoga,unified")->group(function () {
            Route::get('profile', 'ProfileController@getProfile');
            Route::post('profile/password-reset', 'ProfileController@postPasswordReset');
        });
        /*
         * GardenHelp Routes
         */

        Route::get('contractors/registration', 'garden_help\ContractorsController@index')->name('getContractorRegistration');
        Route::post('contractors/registration', 'garden_help\ContractorsController@save')->name('postContractorRegistration');
        Route::get('customers/registration', 'garden_help\CustomersController@getRegistrationForm')->name('getCustomerRegistration');
        Route::post('customers/registration', 'garden_help\CustomersController@postRegistrationForm')->name('postCustomerRegistration');

        Route::group([
            'middleware' => "auth:garden-help"
        ], function () {
            Route::get('garden_help_dashboard', 'garden_help\DashboardController@index')->name('garden_help_getDashboard');
            Route::group([
                'prefix' => 'contractors'
            ], function () {
                Route::get('requests', 'garden_help\ContractorsController@getContractorsRequests')->name('garden_help_getContractorsRequests');
                Route::get('requests/view/{id}', 'garden_help\ContractorsController@getSingleRequest')->name('garden_help_getContractorSingleRequest');
                Route::post('requests/view/{id}', 'garden_help\ContractorsController@postSingleRequest')->name('garden_help_postContractorSingleRequest');
                Route::post('requests/delete', 'garden_help\ContractorsController@deleteContractorRequest')->name('garden_help_deleteContractorRequest');
                Route::get('contractors_list', 'garden_help\ContractorsController@getContractorsList')->name('garden_help_getContractorsList');
                Route::get('fee_list', 'garden_help\ContractorsController@getContractorsFee')->name('garden_help_getContractorsFee');
                Route::get('edit_fee', 'garden_help\ContractorsController@editContractorsFee')->name('garden_help_editContractorsFee');
                Route::post('update_fee', 'garden_help\ContractorsController@updateContractorsFee')->name('garden_help_updateContractorsFee');
                Route::get('view/{id}', 'garden_help\ContractorsController@getSingleContractor')->name('garden_help_getContractorSingleView');
                Route::get('edit/{id}', 'garden_help\ContractorsController@getSingleContractorEdit')->name('garden_help_getContractorSingleEdit');
                Route::post('edit/{id}', 'garden_help\ContractorsController@postEditContractor')->name('garden_help_postEditContractor');
                Route::post('delete', 'garden_help\ContractorsController@postDeleteContractor')->name('garden_help_postDeleteContractor');
                Route::get('roster', 'garden_help\ContractorsController@getContractorsRoster')->name('garden_help_getContractorsRoster');
                Route::get('roster-events', 'garden_help\ContractorsController@getContractorsRosterEvents')->name('garden_help_getContractorsRosterEvents');
                Route::get('roster-data', 'garden_help\ContractorsController@postContractorsRoster')->name('garden_help_postContractorsRoster');
                
            });
            Route::group([
                'prefix' => 'customers'
            ], function () {
                Route::get('requests', 'garden_help\CustomersController@getCustomersRequests')->name('garden_help_getCustomerssRequests');
                Route::get('requests/{id}', 'garden_help\CustomersController@getSingleRequest')->name('garden_help_getcustomerSingleRequest');
                Route::post('requests/{id}', 'garden_help\CustomersController@postSingleRequest')->name('garden_help_postCustomerSingleRequest');
                Route::post('requests/delete/{id}', 'garden_help\CustomersController@deleteCustomerRequest')->name('garden_help_deleteCustomerRequest');
            });
            Route::group([
                'prefix' => 'jobs_table'
            ], function () {
                Route::get('jobs', 'garden_help\JobsController@getJobsTable')->name('garden_help_getJobsTable');
                Route::get('job/{id}', 'garden_help\JobsController@getSingleJob')->name('garden_help_getSingleJob');
                Route::post('job/{id}', 'garden_help\JobsController@postSingleJob')->name('garden_help_postSingleJob');
                Route::get('reassign_job/{id}', 'garden_help\JobsController@getSingleJobReassign')->name('garden_help_getSingleJobReassign');
                Route::get('add_job', 'garden_help\JobsController@addNewJob')->name('garden_help_addNewJob');
                Route::post('add_job', 'garden_help\JobsController@postNewJob')->name('postAddJob');
            });
            Route::get('view_applied_contractor/{id}', 'garden_help\JobsController@getSingleAppliedContractor')->name('garden_help_getAppliedContractorSingleView');
            
            Route::group([
                'prefix' => 'service_types'
            ], function () {
                Route::get('list', 'garden_help\ServiceTypesController@getServiceTypesTable')->name('garden_help_getServiceTypes');
                Route::get('type/{id}', 'garden_help\ServiceTypesController@getSingleServiceType')->name('garden_help_getSingleServiceType');
                Route::get('edit_service_type/{id}', 'garden_help\ServiceTypesController@getSingleServiceTypeEdit')->name('garden_help_getSingleServiceTypeEdit');
                Route::get('add_service_type', 'garden_help\ServiceTypesController@addServiceType')->name('garden_help_addServiceType');
                Route::post('add_service_type', 'garden_help\ServiceTypesController@postAddServiceType')->name('garden_help_postAddServiceType');
                Route::post('edit_service_type/{id}', 'garden_help\ServiceTypesController@postEditServiceType')->name('garden_help_postEditServiceType');
                Route::post('delete_service_type', 'garden_help\ServiceTypesController@postDeleteServiceType')->name('garden_help_postDeleteServiceType');
            });
            Route::group([
                'prefix' => 'invoice'
            ], function () {
                Route::get('/list', 'garden_help\InvoiceController@getInvoiceJobs')->name('garden_help_getInvoiceList');
                Route::get('/view/{id}', 'garden_help\InvoiceController@viewInvoiceJob')->name('garden_help_viewInvoice');
            });
            Route::group([
                'prefix' => 'setting'
            ], function () {
                Route::get('/', 'doorder\SettingsController@getSettings')->name('garden_help_getSetting');
                Route::post('save_notification', 'doorder\SettingsController@postSaveNotification')->name('gardenhelp_postSaveNotification');
            });
            Route::group([
                'prefix' => 'properties'
            ], function () {
                Route::get('/', 'garden_help\PropertiesController@index')->name('garden_help_getProperties');
                Route::get('add', 'garden_help\PropertiesController@add')->name('gardenhelp_addProperties');
                Route::post('save', 'garden_help\PropertiesController@save')->name('gardenhelp_saveProperties');
                Route::get('edit/{id}', 'garden_help\PropertiesController@edit')->name('gardenhelp_editProperties');
                Route::post('update', 'garden_help\PropertiesController@update')->name('gardenhelp_updateProperties');
                Route::post('delete', 'garden_help\PropertiesController@delete')->name('gardenhelp_deleteProperties');
            });
            Route::post('send_notification_contractor', 'garden_help\InvoiceController@postSendNotification')->name('garden_help_sendNotificationDriver');
            Route::post('payout_contractor_invoice', 'garden_help\InvoiceController@postPayout')->name('garden_help_sendNotificationContractor');
            Route::post('update_contractor_last_payout_date', 'garden_help\InvoiceController@postUpdateLastPayoutDate')->name('garden_help_updateContractorLastPayout');

            Route::post('job/assign', 'garden_help\JobsController@assignContractorToJob')->name('garden_help_assignJob');

            Route::get('terms_privacy', 'garden_help\TermsController@index')->name('garden_help_getTermsPrivacy');
            Route::post('terms_privacy', 'garden_help\TermsController@save')->name('garden_help_postTermsPrivacy');
        });

        /*
         * DoOrder Routes
         */
        // Driver Registration
        Route::get('driver_registration', 'doorder\DriversController@getDriverRegistration')->name('getDriverRegistration');
        Route::post('driver_registration', 'doorder\DriversController@postDriverRegistration')->name('postDriverRegistration');
        // Retailer Registration
        Route::get('retailer/registration', 'doorder\RetailerController@getRetailerRegistrationForm')->name('getRetailerRegistration');
        Route::post('retailer/registration', 'doorder\RetailerController@postRetailerRegistrationForm')->name('postRetailerRegistration');
        // Order rating
        Route::get('order/rating/{user_type}/{order_id}', 'doorder\RatingController@getRating')->name('doorder_getRating');
        Route::post('order/save_rating', 'doorder\RatingController@saveRating')->name('doorder_saveRating');
        Route::get('order/rating_success', 'doorder\RatingController@getSuccess')->name('doorder_ratingSuccess');
        // order update address
        Route::get('order/update_address/{order_id}', 'doorder\OrdersController@getUpdateAddress')->name('doorder_getUpdateAddress');
        Route::post('order/save_update_address', 'doorder\OrdersController@saveUpdateAddress')->name('doorder_saveUpdateAddress');
        Route::get('order/save_address_success', 'doorder\OrdersController@getUpdateAddressSuccess')->name('doorder_saveAddressSuccess');


        Route::group([
            'middleware' => "auth:doorder"
        ], function () {
            Route::get('dashboard', 'doorder\DashboardController@index')->name('doorder_dashboard');
            Route::get('search_map', 'doorder\DashboardController@searchOrderMap')->name('doorder_searchMapOrder');
            Route::get('metrics_dashboard', 'doorder\DashboardController@metricsDashboard')->name('doorder_metrics_dashboard');
            Route::get('get_metrics_chart_label_data', 'doorder\DashboardController@getMetricsChartLabelData')->name('doorder_metrics_chart_label_data');
            Route::get('get_metrics_average_chart_data','doorder\DashboardController@getMetricsAverageChartData')->name('doorder_metrics_average_chart_data');
            Route::get('orders', 'doorder\OrdersController@getOrdersTable')->name('doorder_ordersTable');
            Route::get('orders/history', 'doorder\OrdersController@getOrdersHistoryTable')->name('doorder_ordersHistoryTable');
            Route::get('single-order/{id}', 'doorder\OrdersController@getSingleOrder')->name('doorder_singleOrder');
            Route::post('orders/import', 'doorder\OrdersController@postImportOrders')->name('doorder_addNewOrder');
            Route::post('order/delete', 'doorder\OrdersController@deleteOrder')->name('doorder_deleteOrderOrder');


            Route::get('calendar-orders-events', 'doorder\OrdersController@getCalendarOrdersEvents')->name('doorder_getCalendarOrdersEvents');

            Route::get('map_routes', 'doorder\MapRoutesConroller@index')->name('doorder_mapRoutes');
            Route::get('get_route_driver', 'doorder\MapRoutesConroller@getRouteOfDriver')->name('doorder_getRouteDriver');

            Route::post('assign_orders', 'doorder\DriversController@assignOrders')->name('doorder_assignOrders');
            Route::get('driver-page', 'doorder\DriversController@driverPage')->name('doorder_driverPage');
            Route::post('assign_orders_drivers', 'doorder\MapRoutesConroller@assignDriverEnableRouteOptimization')->name('doorder_assignOrdersDrivers');
            Route::get('view_route_optimization_map', 'doorder\MapRoutesConroller@getMapRoutes')->name('doorder_postMapRoutesView');
            Route::get('confirm_route_optimization_map', 'doorder\MapRoutesConroller@SendOrdersToDrivers')->name('doorder_ConfirmRouteOptimization');

            Route::group([
                'middleware' => "client"
            ], function () {
                Route::get('admin-map', 'doorder\DashboardController@getAdminMap')->name('doorder_adminMap');
                // Retailers
                Route::get('retailers/requests', 'doorder\RetailerController@getRetailerRequests')->name('doorder_retailers_requests');
                Route::get('retailers/requests/{id}', 'doorder\RetailerController@getSingleRequest')->name('doorder_retailers_single_request');
                Route::post('retailers/request/{id}', 'doorder\RetailerController@postSingleRequest')->name('post_doorder_retailers_single_request');
                Route::get('retailers', 'doorder\RetailerController@getRetailers')->name('doorder_retailers');
                Route::get('retailers/{id}', 'doorder\RetailerController@getSingleRetailer')->name('doorder_retailers_single_driver');
                Route::get('retailers/view/{id}', 'doorder\RetailerController@getViewRetailer')->name('doorder_retailers_view_retailer');
                // Setting
                Route::get('settings', 'doorder\SettingsController@getSettings')->name('doorder_getSettings');
                Route::post('save_notification', 'doorder\SettingsController@postSaveNotification')->name('doorder_postSaveNotification');
                Route::post('save_stripe_api', 'doorder\SettingsController@postSaveStripeApi')->name('doorder_postSaveStripeApi');
                Route::post('user/delete', 'doorder\SettingsController@deleteUser')->name('doorder_deleteUser');
                Route::post('user/save', 'doorder\SettingsController@saveUser')->name('doorder_saveUser');
                Route::post('user/edit', 'doorder\SettingsController@editUser')->name('doorder_editUser');
                Route::post('save_general_settings', 'doorder\SettingsController@postSaveGeneralSettings')->name('doorder_postSaveGeneralSettings');
            });
            Route::group([
                'middleware' => ["client_or_driver_manager"]
            ], function () {
                Route::post('order/assign', 'doorder\OrdersController@assignDriverToOrder')->name('doorder_assignOrder');
                Route::post('order/update', 'doorder\OrdersController@updateOrder')->name('doorder_updateOrder');
                // Drivers
                Route::get('drivers/requests', 'doorder\DriversController@getDriverRegistrationRequests')->name('doorder_drivers_requests');
                Route::get('drivers/requests/{id}', 'doorder\DriversController@getSingleRequest')->name('doorder_drivers_single_request');
                Route::post('drivers/requests/{id}', 'doorder\DriversController@postSingleRequest')->name('post_doorder_drivers_single_request');
                Route::get('drivers', 'doorder\DriversController@getDrivers')->name('doorder_drivers');
                Route::get('drivers/{id}', 'doorder\DriversController@getSingleDriver')->name('doorder_drivers_single_driver');
                Route::get('drivers/view/{id}', 'doorder\DriversController@getViewDriver')->name('doorder_drivers_view_driver');
                Route::get('drivers/view_orders/{id}', 'doorder\DriversController@getViewDriverAndOrders')->name('doorder_drivers_view_driver_orders');
            });
            Route::group([
                'middleware' => "retailer"
            ], function () {
                Route::get('orders/add', 'doorder\OrdersController@addNewOrder')->name('doorder_addNewOrder');
                Route::post('orders/save', 'doorder\OrdersController@saveNewOrder')->name('doorder_saveNewOrder');
                Route::get('orders/upload_orders', 'doorder\OrdersController@importOrders')->name('doorder_uploadOrders');
                Route::get('orders/print_label/{id}', 'doorder\OrdersController@printLabel')->name('doorder_printLabel');
            });

            Route::post('driver/delete', 'doorder\DriversController@deleteDriver')->name('doorder_deleteDriver');
            Route::post('drivers/{id}', 'doorder\DriversController@saveUpdateDriver')->name('post_doorder_drivers_edit_driver');

            Route::post('retailer/delete', 'doorder\RetailerController@deleteRetailer')->name('doorder_deleteRetailer');
            Route::post('retailers/{id}', 'doorder\RetailerController@saveUpdateRetailer')->name('post_doorder_retailers_single_retailer');

            Route::get('invoice', 'doorder\InvoiceController@getInvoiceList')->name('doorder_getInvoiceList');
            Route::post('invoice/export', 'doorder\InvoiceController@exportInvoiceList')->name('doorder_exportInvoiceList');
            Route::get('invoice_view/{id}', 'doorder\InvoiceController@getSingleInvoice')->name('doorder_getSingleInvoice');
            Route::get('invoice_edit/{id}', 'doorder\InvoiceController@getEditSingleInvoice')->name('doorder_getEditSingleInvoice');
            Route::post('send_invoice/{id}', 'doorder\InvoiceController@postSendInvoice')->name('doorder_sendInvoice');

            Route::post('send_invoice_email', 'doorder\InvoiceController@postSendInvoiceEmail')->name('doorder_sendInvoiceEmail');
            Route::get('pay_invoice/{retailer_id}/{invoice_number}', 'doorder\InvoiceController@getPayInvoice')->name('doorder_payInvoice');
            Route::post('set-invoice-payment-intent', 'StripeController@setInvoicePaymentIntent');
            Route::post('pay-invoice', 'doorder\InvoiceController@postPayInvoice');

            Route::get('drivers_invoice', 'doorder\InvoiceDriversController@getInvoiceList')->name('doorder_getDriversInvoiceList');
            Route::post('update_last_payout_date', 'doorder\InvoiceDriversController@postUpdateLastPayoutDate')->name('doorder_postUpdateDriverLastPayoutDate');
            Route::get('invoice_driver_view/{id}', 'doorder\InvoiceDriversController@getSingleInvoice')->name('doorder_getSingleDriverInvoice');
            Route::post('send_notification_driver', 'doorder\InvoiceDriversController@postSendNotificationDriver')->name('doorder_sendNotificationDriver');
            Route::post('payout_driver_invoice', 'doorder\InvoiceDriversController@postSendDriverPayout')->name('doorder_sendDriverPayout');


            // Edit Retailer profile
            Route::get('profile/edit', 'doorder\RetailerController@editRetailerProfile')->name('doorder_retailers_view_retailer');
        });
        /*
         * Doom Yoga Routes
         */
        Route::get('customer/registration', 'doom_yoga\CustomerController@getCustomerRegistrationForm')->name('getCustomerRegistrationForm');
        Route::post('customer/registration', 'doom_yoga\CustomerController@postCustomerRegistrationForm')->name('postCustomerRegistrationForm');
        Route::post('customer/registration/signup', 'doom_yoga\CustomerController@postCustomerRegistrationCardForm')->name('postCustomerRegistrationCardForm');

        Route::get('event_booking/{id}', 'doom_yoga\EventsController@getEventBooking')->name('getYogaEventBooking');
        Route::post('event_booking', 'doom_yoga\EventsController@postEventBooking')->name('postYogaEventBooking');
        Route::post('event_booking', 'doom_yoga\EventsController@postSignupEventBooking')->name('postYogaSignupEventBooking');

        Route::group([
            'middleware' => "auth:doom-yoga"
        ], function () {
            Route::get('customers/registrations', 'doom_yoga\CustomerController@getCustomersRegistrations')->name('getCustomersRegistrations');

            Route::group([
                'prefix' => 'events'
            ], function () {
                Route::get('add_event', 'doom_yoga\EventsController@addNewEvent')->name('getNewEventDoomYoga');
                Route::post('add_event', 'doom_yoga\EventsController@postNewEvent')->name('postNewEventDoomYoga');
                Route::get('my_events', 'doom_yoga\EventsController@getEvents')->name('getEventsDoomYoga');
                Route::post('share_event', 'doom_yoga\EventsController@postShareEvent')->name('postShareEventDoomYoga');
                Route::get('get_event_data', 'doom_yoga\EventsController@getEventData')->name('getEventDataDoomYoga');
                Route::post('launch_meeting', 'doom_yoga\EventsController@postLaunchMeeting')->name('postLaunchMeetingDoomYoga');
            });

            Route::get('videos_list', 'doom_yoga\MediaController@getVideosList')->name('doomyoga_getVideosList');
            Route::get('edit_video/{id}', 'doom_yoga\MediaController@getEditVideo')->name('doomyoga_getEditVideo');
            Route::post('delete_video', 'doom_yoga\MediaController@postDeleteVideo')->name('doomyoga_postDeleteVideo');
            Route::post('edit_video', 'doom_yoga\MediaController@postEditVideo')->name('doomyoga_postEditVideo');
            Route::get('add_video', 'doom_yoga\MediaController@getAddVideo')->name('doomyoga_getAddVideo');
            Route::post('add_video', 'doom_yoga\MediaController@postAddVideo')->name('doomyoga_postAddVideo');

            Route::get('audio_list', 'doom_yoga\MediaController@getAudioList')->name('doomyoga_getAudioList');
            Route::get('edit_audio/{id}', 'doom_yoga\MediaController@getEditAudio')->name('doomyoga_getEditAudio');
            Route::post('delete_audio', 'doom_yoga\MediaController@postDeleteAudio')->name('doomyoga_postDeleteAudio');
            Route::post('edit_audio', 'doom_yoga\MediaController@postEditAudio')->name('doomyoga_postEditAudio');
            Route::get('add_audio', 'doom_yoga\MediaController@getAddAudio')->name('doomyoga_getAddAudio');
            Route::post('add_audio', 'doom_yoga\MediaController@postAddAudio')->name('doomyoga_postAddAudio');

            Route::get('spotify_test', 'doom_yoga\TestController@getPlaylist')->name('getPlayList');
            Route::get('video_library', 'doom_yoga\TestController@getVideoLibrary')->name('getVideoLibrary');
        });

        Route::get('customer/login', 'doom_yoga\CustomerController@getCustomerLogin')->name('getCustomerLogin');
        Route::post('customer/login', 'doom_yoga\CustomerController@postCustomerLogin')->name('postCustomerLogin');

        Route::get('customer/account', 'doom_yoga\CustomerController@getCustomerAccount')->name('getCustomerAccount');
        Route::get('customer/video_library', 'doom_yoga\CustomerController@getVideoLibrary')->name('getVideoLibrary');
        Route::get('customer/music_library', 'doom_yoga\CustomerController@getMusicLibrary')->name('getMusicLibrary');
        Route::get('customer/meditation_library', 'doom_yoga\CustomerController@getMeditationLibrary')->name('getMeditationLibrary');

        Route::group([
            'middleware' => "auth:unified"
        ], function () {
            Route::group([
                'prefix' => 'customers'
            ], function () {
                Route::get('list', 'unified\CustomerController@getCustomersList')->name('unified_getCustomersList');
                Route::post('delete', 'unified\CustomerController@deleteCustomer')->name('unifiedDeleteCustomer');
                Route::get('view/{id}', 'unified\CustomerController@getSingleCustomer')->name('unified_getCustomerSingleView');
                Route::get('edit/{id}', 'unified\CustomerController@getSingleCustomerEdit')->name('unified_getCustomerSingleEdit');
                Route::post('edit/{id}', 'unified\CustomerController@postEditCustomer')->name('unified_postCustomerSingleEdit');
                Route::post('import', 'unified\CustomerController@postCustomersImport')->name('unified_postCustomersImport');
                Route::post('get_company_data', 'unified\CalendarController@getCompanyData')->name('unified_getCompanyData');
                Route::get('add_customer', 'unified\CustomerController@getAddCustomer')->name('unified_getAddCustomer');
                Route::post('add_customer', 'unified\CustomerController@postAddCustomer')->name('unified_postAddCustomer');
                Route::get('add_product_to_customer/{id}', 'unified\CustomerController@getAddProductToCustomer')->name('unified_getAddProductToCustomer');
                Route::post('save_productCustomer_hostedCpbx', 'unified\CustomerController@postSaveProductHostedCpbx')->name('unified_saveProductCustomer_hostedCpbx');
                Route::post('save_productCustomer_accessControl', 'unified\CustomerController@postSaveProductAccessControl')->name('unified_saveProductCustomer_accessControl');
                Route::post('save_productCustomer_cctv', 'unified\CustomerController@postSaveProductCCTV')->name('unified_saveProductCustomer_cctv');
                Route::post('save_productCustomer_fireAlarm', 'unified\CustomerController@postSaveProductFireAlarm')->name('unified_saveProductCustomer_fireAlarm');
                Route::post('save_productCustomer_intruderAlarm', 'unified\CustomerController@postSaveProductIntruderAlarm')->name('unified_saveProductCustomer_intruderAlarm');
                Route::post('save_productCustomer_wifiData', 'unified\CustomerController@postSaveProductWifiData')->name('unified_saveProductCustomer_wifiData');
                Route::post('save_productCustomer_structuredCablingSystems', 'unified\CustomerController@postStructuredCablingSystems')->name('unified_saveProductCustomer_structuredCablingSystems');

                Route::get('product_form', 'unified\ProductFormController@getProductForm')->name('unified_getProductForm');
                Route::post('save_product_form', 'unified\ProductFormController@postSaveProductForm')->name('unified_postAddProductForm');
                Route::post('get_customer_product_types', 'unified\ProductFormController@getProductTypesOfCustomer');
                Route::post('get_product_type_fields', 'unified\ProductFormController@getFormFieldsOfProductType');
            });
            Route::group([
                'prefix' => 'product_types'
            ], function () {
                Route::get('list', 'unified\ProductFormController@getProductTypesList')->name('unified_getProductTypesList');
                Route::post('delete', 'unified\ProductFormController@deleteProductType')->name('unifiedDeleteProductType');
                Route::get('view/{id}', 'unified\ProductFormController@getSingleProductType')->name('unified_getProductTypeSingleView');
                Route::get('edit/{id}', 'unified\ProductFormController@getSingleProductTypeEdit')->name('unified_getProductTypeSingleEdit');
                Route::post('edit/{id}', 'unified\ProductFormController@postEditProductType')->name('unified_postProductTypeSingleEdit');
                Route::get('add', 'unified\ProductFormController@getAddProductType')->name('unified_getAddProductType');
                Route::post('add', 'unified\ProductFormController@postAddProductType')->name('unified_postAddProductType');
            });

            Route::group([
                'prefix' => 'job_types'
            ], function () {
                Route::get('list', 'unified\JobTypeController@getJobTypesList')->name('unified_getJobTypesList');
                Route::post('delete', 'unified\JobTypeController@deleteJobType')->name('unifiedDeleteJobType');
                Route::get('view/{id}', 'unified\JobTypeController@getSingleJobType')->name('unified_getJobTypeSingleView');
                Route::get('edit/{id}', 'unified\JobTypeController@getSingleJobTypeEdit')->name('unified_getJobTypeSingleEdit');
                Route::post('edit', 'unified\JobTypeController@postEditJobType')->name('unified_postJobTypeSingleEdit');
                Route::get('add', 'unified\JobTypeController@getAddJobType')->name('unified_getAddJobType');
                Route::post('add', 'unified\JobTypeController@postAddJobType')->name('unified_postAddJobType');
            });

            Route::group([
                'prefix' => 'engineers'
            ], function () {
                Route::get('list', 'unified\EngineerController@getEngineersList')->name('unified_getEngineersList');
                Route::post('delete', 'unified\EngineerController@deleteEngineer')->name('unifiedDeleteEngineer');
                Route::get('view/{id}', 'unified\EngineerController@getSingleEngineer')->name('unified_getEngineerSingleView');
                Route::get('edit/{id}', 'unified\EngineerController@getSingleEngineerEdit')->name('unified_getEngineerSingleEdit');
                Route::post('edit/{id}', 'unified\EngineerController@postEditEngineer')->name('unified_postEngineerSingleEdit');
                Route::get('add_engineer', 'unified\EngineerController@getAddEngineer')->name('unified_getAddEngineer');
                Route::post('add_engineer', 'unified\EngineerController@postAddEngineer')->name('unified_postAddEngineer');
            });

            Route::get('unified_dashboard', 'unified\DashboardController@index')->name('unified_dashboard');
            Route::get('calendar', 'unified\CalendarController@getCalendar')->name('unified_getCalendar');
            Route::get('calendar-events', 'unified\CalendarController@getCalendarEvents')->name('unified_getCalendarEvents');
            Route::get('calendar/add_scheduled_job/{date}/{serviceId}', 'unified\CalendarController@getAddScheduledJob')->name('unified_getAddScheduledJob');
            Route::post('add_scheduled_job', 'unified\CalendarController@postAddScheduledJob')->name('unified_postAddScheduledJob');
            Route::get('calendar/edit_scheduled_job/{id}', 'unified\CalendarController@getEditScheduledJob')->name('unified_getEditScheduledJob');
            Route::post('edit_scheduled_job', 'unified\CalendarController@postEditScheduledJob')->name('unified_postEditScheduledJob');
            Route::post('delete_scheduled_job', 'unified\CalendarController@postDeleteScheduledJob')->name('unified_postDeleteScheduledJob');
            Route::post('get_job_data', 'unified\CalendarController@getJobData')->name('unified_getJobData');
            Route::get('get_job_list', 'unified\CalendarController@getJobList')->name('unified_getJobList');
            Route::get('get_company_list_of_service', 'unified\CalendarController@getCompanyListOfService')->name('unified_getCompanyListOfService');
            Route::get('get_contract_expire', 'unified\CalendarController@getContractExpireList')->name('unified_getContractExpire');
            Route::post('get_engineer_location', 'unified\CalendarController@getEngineerLocation')->name('unified_getEngineerLocation');
        });
        Route::get('authenticate-zoom', 'ZoomController@getAuthenticateZoom');
    }
);
Route::group(['middleware' => 'auth:garden-help,doorder,doom-yoga,unified'], function () {
    // Zoom redirect
    Route::get('zoom-oauth-redirect', 'ZoomController@authenticateZoomRedirect');
    // Zoom API test for token validation
    Route::get('test-zoom', 'ZoomController@testZoomApi');
});
// DoOrder Routes
Route::get('driver_app', function () {
    return view('templates/driver_app');
});
// GardenHelp App
Route::get('contractors_app', function () {
    return view('templates/garden_help_app');
});
Route::get('service-booking/{id}', 'garden_help\CustomersController@getServicesBooking')->name('garde_help_getServicesBooking');
Route::post('service-booking/{id}', 'garden_help\CustomersController@postServicesBooking')->name('garde_help_postServicesBooking');

// Cancel service
Route::get('service-cancel/{id}', 'garden_help\CustomersController@getServicesCancelation')->name('garde_help_getServicesCancel');
Route::post('service-cancel/{id}', 'garden_help\CustomersController@postServicesCancelation')->name('garde_help_postServicesCancel');

Route::get('customer/order/{customer_confirmation_code}', 'doorder\CustomerController@getCustomerOrderPage');
Route::get('customer/tracking/{customer_confirmation_code}', 'doorder\CustomerController@getOrderTracking');
Route::get('customer/delivery_confirmation/{customer_confirmation_code}', 'doorder\CustomerController@getDeliveryConfirmationURL')->name('getDeliveryConfirmationURL');
Route::post('customer/delivery_confirmation', 'doorder\CustomerController@postDeliveryConfirmationURL')->name('postDeliveryConfirmationURL');
// Frontend error logging route
Route::post('frontend/error', 'HelperController@logFrontendError');

Route::get('da-lgs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('optimize-orders-route', 'doorder\OrdersController@optimizeOrdersRoute');
Route::get('customer/job/{customer_confirmation_code}', 'unified\CustomerController@getJobConfirmation');
Route::post('customer/job/{customer_confirmation_code}', 'unified\CustomerController@postJobConfirmation');
Route::get('gh/customer/job/{customer_confirmation_code}', 'garden_help\CustomersController@getJobConfirmation');
Route::post('gh/customer/job/confirm', 'garden_help\CustomersController@postJobConfirmation')->name('postCustomerConfirmationURL');
Route::get('garden-help/commercial/job', 'garden_help\JobsController@getCommercialJobs')->name('getCommercialJobs');

Route::get('run-payment-intent-command', function () {
    \Illuminate\Support\Facades\Artisan::call('gardenhelpcustomerpaymentintent:cron');
    $output = \Illuminate\Support\Facades\Artisan::output();
    return 'Done';
});