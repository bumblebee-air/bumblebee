<?php
namespace App\Http\Controllers\unified;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Imports\UnifiedCustomersImport;
use App\UnifiedCustomer;
use App\UnifiedCustomerService;
use App\UnifiedService;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{

    public function getCustomersList()
    {
        $customers = UnifiedCustomer::with('services')->get();
        foreach ($customers as $customer) {
            if (count($customer->services) > 0) {
                $customer->serviceType == '';
                for ($i = 0; $i < count($customer->services); $i ++) {
                    if ($i == count($customer->services) - 1) {
                        $customer->serviceType .= $customer->services[$i]->service->name;
                    } else {
                        $customer->serviceType .= $customer->services[$i]->service->name . ', ';
                    }
                }
                /*
                 * foreach ($customer->services as $service) {
                 * $customer->serviceType .= $service->service->name . ',';
                 * }
                 */
            } else {
                $customer->serviceType = 'N/A';
            }
            $county = explode(',', $customer->address);
            $customer->county = $county[count($county) - 1];
        }

        $services = array(
            'Hosted/Cpbx',
            'Access Control',
            'CCTV',
            'Fire Alarm',
            'Intruder Alarm',
            'Wifi/Data',
            'structured cabling systems'
        );

        // return $customers;
        return view('admin.unified.customers.list', [
            'customers' => $customers,
            'services' => json_encode($services)
        ]);
    }

    public function postCustomersImport(Request $request)
    {
        Excel::import(new UnifiedCustomersImport(), $request->file('customers-file'));
        return redirect()->to('unified/customers/list');
    }

    public function deleteCustomer(Request $request)
    {
        $customer = UnifiedCustomer::find($request->customerId);
        if (! $customer) {
            abort(404);
        }
        $user = User::find($customer->user_id);
        if ($user) {
            $user->delete();
        } else {
            $customer->delete();
        }
        alert()->success('Customer deleted successfully');
        return redirect()->route('unified_getCustomersList', 'unified');
    }

    public function getSingleCustomer($client_name, $id)
    {
        $customer = UnifiedCustomer::find($id);
        if (! $customer) {
            abort(404);
        }
        $selectedServiceType = array_column($customer->services->toArray(), 'service_id');
        $customer->selectedServiceType = $selectedServiceType;
        $services_types = UnifiedService::select([
            'id',
            'name'
        ])->get();

        return view('admin.unified.customers.single_customer', [
            'customer' => $customer,
            'readOnly' => 1,
            'serviceTypes' => $services_types
        ]);
    }

    public function getSingleCustomerEdit($client_name, $id)
    {
        $customer = UnifiedCustomer::find($id);
        if (! $customer) {
            abort(404);
        }
        $selectedServiceType = array_column($customer->services->toArray(), 'service_id');
        $customer->selectedServiceType = $selectedServiceType;
        $services_types = UnifiedService::select([
            'id',
            'name'
        ])->get();

        $customer->contractStartDate = '06/01/2021';
        $customer->contractEndDate = '06/30/2021';

        return view('admin.unified.customers.single_customer', [
            'customer' => $customer,
            'readOnly' => 0,
            'serviceTypes' => $services_types
        ]);
    }

    public function postEditCustomer(Request $request)
    {
        $customer = UnifiedCustomer::find($request->customer_id);
        if (! $customer) {
            abort(404);
        }
        $this->validate($request, [
            'name' => 'required',
            'contract' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'companyPhoneNumner' => 'required',
            'serviceTypeSelectValues' => 'required',
            'contractStartDate' => 'required_if:contract,true|date',
            'contractEndDate' => 'required_if:contract,true|date'
        ]);
        $contact_details_json = json_decode($request->contact_detailss, true);
        $services_types_json = json_decode($request->serviceTypeSelectValues, true);
        $customer->update([
            "name" => $request->name,
            "post_code" => $request->postcode,
            "contract" => $request->contract,
            "phone" => $request->companyPhoneNumner,
            "address" => $request->address,
            "address_coordinates" => json_decode($request->address_coordinates),
            "contacts" => json_encode($contact_details_json),
            "contract_start_date" => Carbon::parse($request->contractStartDate)->toDateString(),
            "contract_end_date" => Carbon::parse($request->contractEndDate)->toDateString()
        ]);

        UnifiedCustomerService::where('customer_id', $customer->id)->delete();
        foreach ($services_types_json as $service) {
            UnifiedCustomerService::create([
                'service_id' => $service,
                'customer_id' => $customer->id
            ]);
        }

        $user = User::find($customer->user_id);
        $user->name = $request->name;
        $user->email = $contact_details_json[0]['contactEmail'];
        $user->phone = $contact_details_json[0]['contactNumber'];
        $user->save();

        alert()->success('Customer updated successfully');

        return redirect()->route('unified_getCustomersList', 'unified');
    }

    public function getAddCustomer()
    {
        $services_types = UnifiedService::select([
            'id',
            'name'
        ])->get();
        return view('admin.unified.customers.add_customer', [
            'serviceTypes' => $services_types
        ]);
    }

    public function postAddCustomer(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'contract' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'companyPhoneNumner' => 'required',
            'serviceTypeSelectValues' => 'required',
            'contractStartDate' => 'required_if:contract,true|date',
            'contractEndDate' => 'required_if:contract,true|date'
        ]);

        $contact_details_json = json_decode($request->contact_detailss, true);
        $services_types_json = json_decode($request->serviceTypeSelectValues, true);
        $user = new User();
        $user->name = $request->name;
        $user->email = $contact_details_json[0]['contactEmail'];
        $user->phone = $contact_details_json[0]['contactNumber'];
        $user->user_role = 'unified_customer';
        $user->password = bcrypt(Str::random(8));
        $user->save();

        UnifiedCustomer::create([
            "user_id" => $user->id,
            "name" => $request->name,
            "post_code" => $request->postcode,
            "contract" => $request->contract,
            "phone" => $request->companyPhoneNumner,
            "address" => $request->address,
            "address_coordinates" => json_decode($request->address_coordinates),
            "contacts" => json_encode($contact_details_json),
            "hosted_pbx" => in_array(1, $services_types_json),
            "access_control" => in_array(2, $services_types_json),
            "cctv" => in_array(3, $services_types_json),
            "fire_alarm" => in_array(4, $services_types_json),
            "intruder_alarm" => in_array(5, $services_types_json),
            "wifi_data" => in_array(6, $services_types_json),
            "structured_cabling_system" => in_array(7, $services_types_json),
            "contract_start_date" => Carbon::parse($request->contractStartDate)->toDateString(),
            "contract_end_date" => Carbon::parse($request->contractEndDate)->toDateString()
        ]);
        alert()->success('Customer has added successfully.');
        return redirect()->route('unified_getCustomersList', 'unified');
    }

    public function getAddProductToCustomer($client_name, $id)
    {
        $customer = UnifiedCustomer::find($id);
        if (! $customer) {
            abort(404);
        }
        $selectedServiceType = array_column($customer->services->toArray(), 'service_id');
        $customer->selectedServiceType = $selectedServiceType;
        $services_types = UnifiedService::select([
            'id',
            'name'
        ])->get();

        
        // /////////// hosted
        $hostedPackages = $this->getHostedPackages();
        $ipVendors = $this->getIPVendors();
        $accountTypes = $this->getAccountTypes();
        $systemModels = $this->getSystemModels();
        $lineTypes = $this->getLineTypes();
        $lineVendors = $this->getLineVendors();
        // ////////// access control
        $accountTypesAccessControl = $this->getAccountTypesAccessControl();
        $brandsAccessControl = $this->getBrandsAccessControl();
        $systemTypesAccessControl = $this->getSystemTypesAccessControl();
        $cardFobListAccessControl = $this->getCardFobListAccessControl();
        // ///////// CCTV
        $manufacturersCCTV = $this->getManufacturersCCTV();
        $modelsCCTV = $this->getModelsCCTV();
        $monitoringCentreListCCTV = $this->getMonitoringCentreListCCTV();
        $cameraBrandsCCTV = $this->getCameraBrandsCCTV();
        $maintenanceFrequenciesCCTV = $this->getMaintenanceFrequenciesCCTV();
        // ///////// fire
        $systemTypesFireAlarm = $this->getSystemTypesFire();
        $wiredWirlessFireAlarm = $this->getWiredWirlessFire();
        $manufacturersFireAlarm = $this->getManufacturersFireAlarm();
        $modelsFireAlarm = $this->getModelsFireAlarm();
        $protocolsFireAlarm = $this->getProtocolsFireAlarm();
        $panelOperationsFireAlarm = $this->getPanelOperationsFireAlarm();
        $monitoredListFireAlarm = $this->getMonitoredListFireAlarm();
        $monitoringCentreListFireAlarm = $this->getMonitoringCentreListFireAlarm();
        $digiTypesFireAlarm = $this->getDigiTypesFireAlarm();
        $maintenanceFrequenciesFireAlarm = $this->getMaintenanceFrequenciesFireAlarm();
        $accountTypesFireAlarm = $this->getAccountTypesFireAlarm();
        // ///////// Intruder Alarm
        $accountTypesIntruderAlarm = $this->getAccountTypesIntruderAlarm();
        $systemTypesIntruderAlarm = $this->getWiredWirlessFire();
        $manufacturersIntruderAlarm = $this->getManufacturersIntruderAlarm();
        $panelTypesIntruderAlarm = $this->getPanelTypesIntruderAlarm();
        $digiTypesIntruderAlarm = $this->getDigiTypesIntruderAlarm();
        // ///////// Wifi data
        $systemTypesWifiData = $this->getSystemTypesWifiData();
        $manufacturersWifiData = $this->getSystemTypesWifiData();
        $switchTypesWifiData = $this->getSwitchTypesWifiData();
        $uplinksWifiData = $this->getUplinksWifiData();
        $broabbandProvidersWifiData = $this->getBroabbandProvidersWifiData();
        // ////////// structured_cabling_systems
        $modelsStructuredCabling = $this->getModelsStructuredCabling();
        $accountTypesStructuredCabling = $this->getAccountTypesStructuredCabling();

        // service data
        $hostedCpbxData = $this->getHostedCpbxDataOfCustomer($id);
        $accessControlData = $this->getAccessControlDataOfCustomer($id);
        $cctvData = $this->getCCTVDataOfCutomer($id);
        $fireAlarmData = $this->getFireAlarmDataOfCustomer($id);
        $intruderAlarmData = $this->getIntruderAlarmDataOfCustomer($id);
        $wifiData = $this->getWifiDataOfCustomer($id);
        $structuredCablingData = $this->getStructuredCablingDataOfCustomer($id);

        return view('admin.unified.customers.products.add_product', [
            'serviceTypes' => $services_types,
            'customer' => $customer,
            'hostedPackages' => $hostedPackages,
            'ipVendors' => $ipVendors,
            'accountTypes' => $accountTypes,
            'systemModels' => $systemModels,
            'lineTypes' => $lineTypes,
            'lineVendors' => $lineVendors,
            'accountTypesAccessControl' => $accountTypesAccessControl,
            'brandsAccessControl' => $brandsAccessControl,
            'systemTypesAccessControl' => $systemTypesAccessControl,
            'cardFobListAccessControl' => $cardFobListAccessControl,
            'manufacturersCCTV' => $manufacturersCCTV,
            'modelsCCTV' => $modelsCCTV,
            'monitoringCentreListCCTV' => $monitoringCentreListCCTV,
            'cameraBrandsCCTV' => $cameraBrandsCCTV,
            'maintenanceFrequenciesCCTV' => $maintenanceFrequenciesCCTV,
            'systemTypesFireAlarm' => $systemTypesFireAlarm,
            'wiredWirlessFireAlarm' => $wiredWirlessFireAlarm,
            'manufacturersFireAlarm' => $manufacturersFireAlarm,
            'modelsFireAlarm' => $modelsFireAlarm,
            'protocolsFireAlarm' => $protocolsFireAlarm,
            'panelOperationsFireAlarm' => $panelOperationsFireAlarm,
            'monitoredListFireAlarm' => $monitoredListFireAlarm,
            'monitoringCentreListFireAlarm' => $monitoringCentreListFireAlarm,
            'digiTypesFireAlarm' => $digiTypesFireAlarm,
            'maintenanceFrequenciesFireAlarm' => $maintenanceFrequenciesFireAlarm,
            'accountTypesFireAlarm' => $accountTypesFireAlarm,
            'accountTypesIntruderAlarm' => $accountTypesIntruderAlarm,
            'systemTypesIntruderAlarm' => $systemTypesIntruderAlarm,
            'manufacturersIntruderAlarm' => $manufacturersIntruderAlarm,
            'panelTypesIntruderAlarm' => $panelTypesIntruderAlarm,
            'digiTypesIntruderAlarm' => $digiTypesIntruderAlarm,
            'systemTypesWifiData' => $systemTypesWifiData,
            'manufacturersWifiData' => $manufacturersWifiData,
            'switchTypesWifiData' => $switchTypesWifiData,
            'uplinksWifiData' => $uplinksWifiData,
            'broabbandProvidersWifiData' => $broabbandProvidersWifiData,
            'modelsStructuredCabling' => $modelsStructuredCabling,
            'accountTypesStructuredCabling' => $accountTypesStructuredCabling,
            'hostedCpbxData' => $hostedCpbxData,
            'accessControlData' => $accessControlData,
            'cctvData' => $cctvData,
            'fireAlarmData' => $fireAlarmData,
            'intruderAlarmData' => $intruderAlarmData,
            'wifiData' => $wifiData,
            'structuredCablingData'=>$structuredCablingData
        ]);
    }

    public function postSaveProductHostedCpbx(Request $request)
    {
        // dd($request);
        alert()->success('Hosted/Cpbx data saved successfully.');
        return redirect()->back();
    }

    public function postSaveProductAccessControl(Request $request)
    {
        // dd($request);
        alert()->success('Access control data saved successfully.');
        return redirect()->back();
    }

    public function postSaveProductCCTV(Request $request)
    {
        // dd($request);
        alert()->success('CCTV data saved successfully.');
        return redirect()->back();
    }

    public function postSaveProductFireAlarm(Request $request)
    {
        // dd($request);
        alert()->success('Fire alarm data saved successfully.');
        return redirect()->back();
    }

    public function postSaveProductIntruderAlarm(Request $request)
    {
        // dd($request);
        alert()->success('Intruder alarm data saved successfully.');
        return redirect()->back();
    }

    public function postSaveProductWifiData(Request $request)
    {
        // dd($request);
        alert()->success('Wifi/data data saved successfully.');
        return redirect()->back();
    }

    public function postStructuredCablingSystems(Request $request)
    {
        //dd($request);
        alert()->success('Structured cabling systems data saved successfully.');
        return redirect()->back();
    }

    private function getHostedCpbxDataOfCustomer($customerId)
    {
        $hostedCpbxData = new \ArrayObject();
        $hostedCpbxData->hosted_package = 1;
        $hostedCpbxData->hosted_ip_vendor = 2;
        $hostedCpbxData->hosted_provisioning_url = "";
        $hostedCpbxData->hosted_account_portal_id = "3334324";
        $hostedCpbxData->hosted_line_ddi_numbers = "12245";
        $hostedCpbxData->hosted_broadband_provider = "123";
        $hostedCpbxData->hosted_number_of_users = 27;
        $hostedCpbxData->hosted_handset_type = "";
        $hostedCpbxData->hosted_call_recording = 1;
        $hostedCpbxData->hosted_crm_interface = 0;
        $hostedCpbxData->hosted_installation_date = "09/09/2021";
        $hostedCpbxData->hosted_maintenance_due_date = "09/23/2021";
        $hostedCpbxData->hosted_maintenance = 0;
        $hostedCpbxData->hosted_account_type = 4;
        $hostedCpbxData->hosted_account_notes = "notes";

        $hostedCpbxData->cpbx_system_model = 1;
        $hostedCpbxData->cpbx_system_user_id = "sara";
        $hostedCpbxData->cpbx_system_password = "1234";
        $hostedCpbxData->cpbx_line_type = 2;
        $hostedCpbxData->cpbx_line_vendor = 5;
        $hostedCpbxData->cpbx_sip_account_user_id = "saraa";
        $hostedCpbxData->cpbx_sip_account_password = "65412";
        $hostedCpbxData->cpbx_number_of_users = 44;
        $hostedCpbxData->cpbx_handset_type = "";
        $hostedCpbxData->cpbx_static_ip_address = "1.1.1.1";
        $hostedCpbxData->cpbx_port_number = "1111";
        $hostedCpbxData->cpbx_line_ddi_numbers = "545211";
        $hostedCpbxData->cpbx_broadband_provider = "test";
        $hostedCpbxData->cpbx_call_recording = 0;
        $hostedCpbxData->cpbx_crm_interface = 1;
        $hostedCpbxData->cpbx_installation_date = "09/16/2021";
        $hostedCpbxData->cpbx_maintenance_due_date = "09/21/2021";
        $hostedCpbxData->cpbx_maintenance = 0;
        $hostedCpbxData->cpbx_account_type = 2;
        $hostedCpbxData->cpbx_account_notes = "notesss";

        return $hostedCpbxData;
    }

    private function getAccessControlDataOfCustomer($customerId)
    {
        $accessControlData = new \ArrayObject();

        $accessControlData->access_account_type = 1;
        $accessControlData->access_brand = 2;
        $accessControlData->access_single_multi_user = "multi";
        $accessControlData->access_network_ip_address = "128.0.0.1";
        $accessControlData->access_user_id = "123456";
        $accessControlData->access_password = "654132";
        $accessControlData->access_remote_access = 1;
        $accessControlData->access_system_type = 2;
        $accessControlData->access_number_of_doors = 11;
        $accessControlData->access_card_fob = 6;
        $accessControlData->access_installation_date = "09/12/2021";
        $accessControlData->access_maintenance_start_date = "09/08/2021";
        $accessControlData->access_maintenance_cancellation_date = "09/19/2021";
        $accessControlData->access_last_maintenance_date = "09/23/2021";
        $accessControlData->access_maintenance_due_date = "09/26/2021";
        $accessControlData->access_maintenance_contract = "sara";
        $accessControlData->access_maintenance_cost = 500;
        $accessControlData->access_account_notes = "access notes";

        return $accessControlData;
    }

    private function getCCTVDataOfCutomer($cutomerId)
    {
        $cctvData = new \ArrayObject();

        $cctvData->cctv_account_type = 1;
        $cctvData->cctv_manufacturer = 1;
        $cctvData->cctv_dvr = false;
        $cctvData->cctv_nvr = true;
        $cctvData->cctv_model = 2;
        $cctvData->cctv_location = "Salthill Guest House, Salthill Road Lower, Galway, County Galway, Ireland";
        $cctvData->cctv_location_lat = "53.26402";
        $cctvData->cctv_location_lon = "-9.07284";
        $cctvData->cctv_public_network_ip_address = "128.1.1.1";
        $cctvData->cctv_local_network_ip_address = "128.56.64.22";
        $cctvData->cctv_unified_user_name = "sara";
        $cctvData->cctv_unified_user_code = "123465";
        $cctvData->cctv_local_user_name = "sarah";
        $cctvData->cctv_local_user_code = "565326";
        $cctvData->cctv_remote_access = 0;
        $cctvData->cctv_remote_monitoring = 1;
        $cctvData->cctv_monitoring_centre = 1;
        $cctvData->cctv_number_of_cameras = 16;
        $cctvData->cctv_camera_brand = 3;
        $cctvData->cctv_installation_date = "09/08/2021";
        $cctvData->cctv_maintenace_contract = 0;
        $cctvData->cctv_maintenance_start_date = "09/12/2021";
        $cctvData->cctv_maintenance_cancellation_date = "09/16/2021";
        $cctvData->cctv_last_maintenance_date = "09/18/2021";
        $cctvData->cctv_maintenance_due_date = "09/19/2021";
        $cctvData->cctv_maintenance_frequency = 1;
        $cctvData->cctv_maintenance_cost = 500;
        $cctvData->cctv_account_notes = "cctv notes";

        return $cctvData;
    }

    private function getFireAlarmDataOfCustomer($customerId)
    {
        $fireAlarmData = new \ArrayObject();

        $fireAlarmData->fire_system_type = 2;
        $fireAlarmData->fire_wired = 3;
        $fireAlarmData->fire_manufacturer = 5;
        $fireAlarmData->fire_model = null;
        $fireAlarmData->fire_panel_location = "Klify Moheru, Lislorkan North, County Clare, Ireland";
        $fireAlarmData->fire_panel_location_lat = "52.97154";
        $fireAlarmData->fire_panel_location_lon = "-9.43088";
        $fireAlarmData->fire_number_of_loops = 8;
        $fireAlarmData->fire_protocol = 2;
        $fireAlarmData->fire_panel_operation = 2;
        $fireAlarmData->fire_networked = 1;
        $fireAlarmData->fire_password_level1 = "123456";
        $fireAlarmData->fire_password_level2 = "2456999";
        $fireAlarmData->fire_password_level3 = "6325636363";
        $fireAlarmData->fire_remote_access = 0;
        $fireAlarmData->fire_monitored = null;
        $fireAlarmData->fire_monitoring_centre = null;
        $fireAlarmData->fire_digi_type = null;
        $fireAlarmData->fire_digi_number = 21;
        $fireAlarmData->fire_number_of_devices = 10;
        $fireAlarmData->fire_installation_date = "09/08/2021";
        $fireAlarmData->fire_maintenace_contract = 1;
        $fireAlarmData->fire_maintenance_start_date = "09/12/2021";
        $fireAlarmData->fire_maintenance_cancellation_date = "09/15/2021";
        $fireAlarmData->fire_maintenance_frequency = 1;
        $fireAlarmData->fire_maintenance_due_date = "09/25/2021";
        $fireAlarmData->fire_maintenance_cost = 455;
        $fireAlarmData->fire_account_type = null;
        $fireAlarmData->fire_account_notes = "notes fire";

        return $fireAlarmData;
    }

    private function getIntruderAlarmDataOfCustomer($customerId)
    {
        $intruderAlarmData = new \ArrayObject();

        $intruderAlarmData->intruder_account_type = null;
        $intruderAlarmData->intruder_system_type = 1;
        $intruderAlarmData->intruder_manufacturer = 3;
        $intruderAlarmData->intruder_panel_type = 5;
        $intruderAlarmData->intruder_panel_location = "Klub Kildare, Elm Road, Naas East, Naas, County Kildare, Ireland";
        $intruderAlarmData->intruder_panel_location_lat = null;
        $intruderAlarmData->intruder_panel_location_lon = null;
        $intruderAlarmData->intruder_panel_battery_date = "09/08/2021";
        $intruderAlarmData->intruder_wireless_battery_date = "09/11/2021";
        $intruderAlarmData->intruder_networked = 1;
        $intruderAlarmData->intruder_remote_access = 0;
        $intruderAlarmData->intruder_secure_comm_id = 45;
        $intruderAlarmData->intruder_secure_comm_code = 852;
        $intruderAlarmData->intruder_remote_user_code = 631;
        $intruderAlarmData->intruder_monitored = 1;
        $intruderAlarmData->intruder_monitoring_centre = 1;
        $intruderAlarmData->intruder_digi_type = 2;
        $intruderAlarmData->intruder_digi_number = 4569;
        $intruderAlarmData->intruder_radio_number = 741;
        $intruderAlarmData->intruder_app_only_monitoring = 0;
        $intruderAlarmData->intruder_number_of_devices = 12;
        $intruderAlarmData->intruder_installation_date = "09/12/2021";
        $intruderAlarmData->intruder_maintenace_contract = 1;
        $intruderAlarmData->intruder_maintenance_start_date = "09/16/2021";
        $intruderAlarmData->intruder_maintenance_canceled_date = "09/20/2021";
        $intruderAlarmData->intruder_maintenance_frequency = 2;
        $intruderAlarmData->intruder_last_maintenance_date = "09/24/2021";
        $intruderAlarmData->intruder_maintenance_due_date = "09/28/2021";
        $intruderAlarmData->intruder_maintenance_and_monitoring_cost = 1000;
        $intruderAlarmData->intruder_account_notes = "alarm notes";

        return $intruderAlarmData;
    }

    private function getWifiDataOfCustomer($customerId)
    {
        $wifiData = new \ArrayObject();

        $wifiData->wifi_account_type = 2;
        $wifiData->wifi_system_type = 1;
        $wifiData->wifi_manufacturer = 2;
        $wifiData->wifi_switch_type = 2;
        $wifiData->wifi_uplink = 2;
        $wifiData->wifi_ups_backup = 0;
        $wifiData->wifi_broabband_provider = 2;
        $wifiData->wifi_remote_access = 1;
        $wifiData->wifi_username = "sara";
        $wifiData->wifi_password = "123456";
        $wifiData->wifi_number_of_devices = 5;
        $wifiData->wifi_installation_date = "09/08/2021";
        $wifiData->wifi_maintenace_contract = 1;
        $wifiData->wifi_maintenance_start_date = "09/10/2021";
        $wifiData->wifi_maintenance_canceled_date = "09/18/2021";
        $wifiData->wifi_maintenance_frequency = 2;
        $wifiData->wifi_last_maintenance_date = "09/27/2021";
        $wifiData->wifi_maintenance_due_date = "09/30/2021";
        $wifiData->wifi_maintenance_and_monitoring_cost = 500;
        $wifiData->wifi_account_notes = "wifi notes";

        return $wifiData;
    }

    private function getStructuredCablingDataOfCustomer($customerId)
    {
        $structuredCablingData = new \ArrayObject();

        $structuredCablingData->structured_model = null;
        $structuredCablingData->structured_single_multi_user = "single";
        $structuredCablingData->structured_network_ip_address = "12.2.2.2";
        $structuredCablingData->structured_user_id = "sara";
        $structuredCablingData->structured_password = "123456";
        $structuredCablingData->structured_remote_access = 1;
        $structuredCablingData->structured_number_of_doors = 5;
        $structuredCablingData->structured_number_of_fobs = 10;
        $structuredCablingData->structured_installation_date = "09/08/2021";
        $structuredCablingData->structured_maintenance_due_date = "09/23/2021";
        $structuredCablingData->structured_maintenace = 0;
        $structuredCablingData->structured_maintenance_cost = 200;
        $structuredCablingData->structured_account_type = null;
        $structuredCablingData->structured_account_notes = "notes";

        return $structuredCablingData;
    }

    private function getHostedPackages()
    {
        $hostedPackage1 = new ItemData(1, " Hosted 10");
        $hostedPackage2 = new ItemData(2, "Hosted 20");
        $hostedPackage3 = new ItemData(3, "Hosted 50");
        $hostedPackage4 = new ItemData(4, "Hosted 100");
        $hostedPackage5 = new ItemData(5, "Hosted 500");

        $hostedPackages = array(
            $hostedPackage1,
            $hostedPackage2,
            $hostedPackage3,
            $hostedPackage4,
            $hostedPackage5
        );

        return $hostedPackages;
    }

    private function getIPVendors()
    {
        $ipVendor1 = new ItemData(1, "IP Telecom");
        $ipVendor2 = new ItemData(2, "Cloudvoice");

        $ipVendors = array(
            $ipVendor1,
            $ipVendor2
        );

        return $ipVendors;
    }

    private function getAccountTypes()
    {
        $accountType1 = new ItemData(1, "  Account 30");
        $accountType2 = new ItemData(2, "C.O.D.");
        $accountType3 = new ItemData(3, " Upfront Payment");
        $accountType4 = new ItemData(4, " Bad Debt");

        $accountTypes = array(
            $accountType1,
            $accountType2,
            $accountType3,
            $accountType4
        );

        return $accountTypes;
    }

    private function getSystemModels()
    {
        $systemModel1 = new ItemData(1, "Ericsson LG IPLDK-20");
        $systemModel2 = new ItemData(2, "Ericsson LG IPLDK-50");
        $systemModel3 = new ItemData(3, " Ericsson LG IPLDK-100");
        $systemModel4 = new ItemData(4, " Ericsson LG IPECS 50");
        $systemModel5 = new ItemData(5, " Ericsson LG IPECS 100");
        $systemModel6 = new ItemData(6, "Ericsson LG IPECS 300");
        $systemModel7 = new ItemData(7, " Ericsson LG UCP 100");
        $systemModel8 = new ItemData(8, "Ericsson LG UCP 300");
        $systemModel9 = new ItemData(9, " Goldstar Old System");
        $systemModel10 = new ItemData(10, "Panasonic System");

        $systemModels = array(
            $systemModel1,
            $systemModel2,
            $systemModel3,
            $systemModel4,
            $systemModel5,
            $systemModel6,
            $systemModel7,
            $systemModel8,
            $systemModel9,
            $systemModel10
        );

        return $systemModels;
    }

    private function getLineTypes()
    {
        $lineType1 = new ItemData(1, " SIP");
        $lineType2 = new ItemData(2, " ISDN BRA");
        $lineType3 = new ItemData(3, "ISDN FRA");
        $lineType4 = new ItemData(4, " ISDN PRA");
        $lineType5 = new ItemData(5, " PSTN");

        $lineTypes = array(
            $lineType1,
            $lineType2,
            $lineType3,
            $lineType4,
            $lineType5
        );

        return $lineTypes;
    }

    private function getLineVendors()
    {
        $lineVendor1 = new ItemData(1, "IP Telecom");
        $lineVendor2 = new ItemData(2, "Cloudvoice");
        $lineVendor3 = new ItemData(3, "Eir");
        $lineVendor4 = new ItemData(4, "Vodafone");
        $lineVendor5 = new ItemData(5, "Magnet");
        $lineVendor6 = new ItemData(6, "Other");

        $lineVendors = array(
            $lineVendor1,
            $lineVendor2,
            $lineVendor3,
            $lineVendor4,
            $lineVendor5,
            $lineVendor6
        );

        return $lineVendors;
    }

    private function getAccountTypesAccessControl()
    {
        $accountType1 = new ItemData(1, "Commercial");
        $accountType2 = new ItemData(2, "Domestic");

        $accountTypes = array(
            $accountType1,
            $accountType2
        );

        return $accountTypes;
    }

    private function getBrandsAccessControl()
    {
        $brand1 = new ItemData(1, "ACT");
        $brand2 = new ItemData(2, "HKC");
        $brand3 = new ItemData(3, "Aritech");

        $brands = array(
            $brand1,
            $brand2,
            $brand3
        );

        return $brands;
    }

    private function getSystemTypesAccessControl()
    {
        $systemType1 = new ItemData(1, "Network");
        $systemType2 = new ItemData(2, "Standalone");
        $systemType3 = new ItemData(3, "Wireless");

        $systemTypes = array(
            $systemType1,
            $systemType2,
            $systemType3
        );

        return $systemTypes;
    }

    private function getCardFobListAccessControl()
    {
        $cardFob1 = new ItemData(1, "Act Mifare Card");
        $cardFob2 = new ItemData(2, "Act Mifare FOB");
        $cardFob3 = new ItemData(3, "HID Prox Card");
        $cardFob4 = new ItemData(4, "HID Prox FOB");
        $cardFob5 = new ItemData(5, "Site Code Card");
        $cardFob6 = new ItemData(6, "Site Code FOB");

        $cardFobList = array(
            $cardFob1,
            $cardFob2,
            $cardFob3,
            $cardFob4,
            $cardFob5,
            $cardFob6
        );

        return $cardFobList;
    }

    private function getManufacturersCCTV()
    {
        $manufacturer1 = new ItemData(1, "HIK Vision");
        $manufacturer2 = new ItemData(2, "Avigilon");
        $manufacturer3 = new ItemData(3, "SmartWatch");
        $manufacturer4 = new ItemData(4, "Hi-Tel");

        $manufacturers = array(
            $manufacturer1,
            $manufacturer2,
            $manufacturer3,
            $manufacturer4
        );

        return $manufacturers;
    }

    private function getModelsCCTV()
    {
        $model1 = new ItemData(1, "4CHPOE");
        $model2 = new ItemData(2, "8CHPOE");
        $model3 = new ItemData(3, "16CHPOE");
        $model4 = new ItemData(4, "32CHPOE");

        $models = array(
            $model1,
            $model2,
            $model3,
            $model4
        );

        return $models;
    }

    private function getMonitoringCentreListCCTV()
    {
        $monitoringCentre1 = new ItemData(1, "Alarm 24");
        $monitoringCentre2 = new ItemData(2, "Other");

        $monitoringCentreList = array(
            $monitoringCentre1,
            $monitoringCentre2
        );

        return $monitoringCentreList;
    }

    private function getCameraBrandsCCTV()
    {
        $cameraBrand1 = new ItemData(1, "HIK Vision");
        $cameraBrand2 = new ItemData(2, "Avigilon");
        $cameraBrand3 = new ItemData(3, "Motorola");
        $cameraBrand4 = new ItemData(4, "AVE");

        $cameraBrands = array(
            $cameraBrand1,
            $cameraBrand2,
            $cameraBrand3,
            $cameraBrand4
        );

        return $cameraBrands;
    }

    private function getMaintenanceFrequenciesCCTV()
    {
        $maintenanceFrequency1 = new ItemData(1, "6 months");
        $maintenanceFrequency2 = new ItemData(2, "12 months");

        $maintenanceFrequencies = array(
            $maintenanceFrequency1,
            $maintenanceFrequency2
        );

        return $maintenanceFrequencies;
    }

    private function getSystemTypesFire()
    {
        $systemType1 = new ItemData(1, "Conventional");
        $systemType2 = new ItemData(2, "Addressable");

        $systemTypes = array(
            $systemType1,
            $systemType2
        );

        return $systemTypes;
    }

    private function getWiredWirlessFire()
    {
        $item1 = new ItemData(1, "Wired");
        $item2 = new ItemData(2, "Wireless");
        $item3 = new ItemData(3, "Hybrid");

        $wiredWirelessList = array(
            $item1,
            $item2,
            $item3
        );

        return $wiredWirelessList;
    }

    private function getManufacturersFireAlarm()
    {
        $manufacturer1 = new ItemData(1, "Ctec");
        $manufacturer2 = new ItemData(2, "Apollo");
        $manufacturer3 = new ItemData(3, "Advanced");
        $manufacturer4 = new ItemData(4, "Morley");
        $manufacturer5 = new ItemData(5, "Syncro");

        $manufacturers = array(
            $manufacturer1,
            $manufacturer2,
            $manufacturer3,
            $manufacturer4,
            $manufacturer5
        );

        return $manufacturers;
    }

    private function getModelsFireAlarm()
    {
        $models = array();
        return $models;
    }

    private function getProtocolsFireAlarm()
    {
        $protocol1 = new ItemData(1, "Hochiki");
        $protocol2 = new ItemData(2, "Apollo");
        $protocol3 = new ItemData(3, "Other");

        $protocols = array(
            $protocol1,
            $protocol2,
            $protocol3
        );

        return $protocols;
    }

    private function getPanelOperationsFireAlarm()
    {
        $panelOperation1 = new ItemData(1, "Keyswitch");
        $panelOperation2 = new ItemData(2, "Buttons");
        $panelOperation3 = new ItemData(3, "code");

        $panelOperations = array(
            $panelOperation1,
            $panelOperation2,
            $panelOperation3
        );

        return $panelOperations;
    }

    private function getMonitoredListFireAlarm()
    {
        $monitoredList = array();
        return $monitoredList;
    }

    private function getMonitoringCentreListFireAlarm()
    {
        $monitoringCentreList = array();
        return $monitoringCentreList;
    }

    private function getDigiTypesFireAlarm()
    {
        $digiTypes = array();
        return $digiTypes;
    }

    private function getMaintenanceFrequenciesFireAlarm()
    {
        $maintenanceFrequency1 = new ItemData(1, "Quarterly");
        $maintenanceFrequency2 = new ItemData(2, "6 months");

        $maintenanceFrequencies = array(
            $maintenanceFrequency1,
            $maintenanceFrequency2
        );

        return $maintenanceFrequencies;
    }

    private function getAccountTypesFireAlarm()
    {
        $accountTypes = array();
        return $accountTypes;
    }

    private function getAccountTypesIntruderAlarm()
    {
        $accountTypes = array();
        return $accountTypes;
    }

    private function getManufacturersIntruderAlarm()
    {
        $manufacturer1 = new ItemData(1, "HKC");
        $manufacturer2 = new ItemData(2, "Aritech");
        $manufacturer3 = new ItemData(3, "UTC");
        $manufacturer4 = new ItemData(4, "Other");

        $manufacturers = array(
            $manufacturer1,
            $manufacturer2,
            $manufacturer3,
            $manufacturer4
        );

        return $manufacturers;
    }

    private function getPanelTypesIntruderAlarm()
    {
        $panelType1 = new ItemData(1, "HKC Quantum");
        $panelType2 = new ItemData(2, "HKC 10/70");
        $panelType3 = new ItemData(3, "HKC 10/240");
        $panelType4 = new ItemData(4, "HKC 16/120");
        $panelType5 = new ItemData(5, "HKC8/12/Advisor Advanced");
        $panelType6 = new ItemData(6, "Aritech CD95");

        $panelTypes = array(
            $panelType1,
            $panelType2,
            $panelType3,
            $panelType4,
            $panelType5,
            $panelType6
        );

        return $panelTypes;
    }

    private function getDigiTypesIntruderAlarm()
    {
        $digiType1 = new ItemData(1, "HKC Plug on GSM");
        $digiType2 = new ItemData(2, "HKC DTM");
        $digiType3 = new ItemData(3, "HKC Plug on and Dual Comm");
        $digiType4 = new ItemData(4, "Dual Comm");
        $digiType5 = new ItemData(5, "UTC Dual Comm");

        $digiTypes = array(
            $digiType1,
            $digiType2,
            $digiType3,
            $digiType4,
            $digiType5
        );
        return $digiTypes;
    }

    private function getSystemTypesWifiData()
    {
        $systemType1 = new ItemData(1, "Ubiquity");
        $systemType2 = new ItemData(2, "Other");

        $systemTypes = array(
            $systemType1,
            $systemType2
        );

        return $systemTypes;
    }

    private function getSwitchTypesWifiData()
    {
        $switchType1 = new ItemData(1, "4 Port POE");
        $switchType2 = new ItemData(2, "8 Port POE");
        $switchType3 = new ItemData(3, "16 Port POE");
        $switchType4 = new ItemData(4, "24 Port POE");

        $switchTypes = array(
            $switchType1,
            $switchType2,
            $switchType3,
            $switchType4
        );

        return $switchTypes;
    }

    private function getUplinksWifiData()
    {
        $uplink1 = new ItemData(1, "Data Cable");
        $uplink2 = new ItemData(2, "Fibre");

        $uplinks = array(
            $uplink1,
            $uplink2
        );

        return $uplinks;
    }

    private function getBroabbandProvidersWifiData()
    {
        $broabbandProvider1 = new ItemData(1, "EIR");
        $broabbandProvider2 = new ItemData(2, "Virgin Media");
        $broabbandProvider3 = new ItemData(3, "Other");

        $broabbandProviders = array(
            $broabbandProvider1,
            $broabbandProvider2,
            $broabbandProvider3
        );
        return $broabbandProviders;
    }

    private function getModelsStructuredCabling()
    {
        $models = array();

        return $models;
    }

    private function getAccountTypesStructuredCabling()
    {
        $accountTypes = array();

        return $accountTypes;
    }
}

class ItemData
{

    public $id, $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
