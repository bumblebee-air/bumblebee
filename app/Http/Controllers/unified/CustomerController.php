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
        $lineTypes=$this->getLineTypes();
        $lineVendors = $this->getLineVendors();
        //////////// access control
        $accountTypesAccessControl = $this->getAccountTypesAccessControl();
        $brandsAccessControl  =$this->getBrandsAccessControl();
        $systemTypesAccessControl = $this->getSystemTypesAccessControl();
        $cardFobListAccessControl = $this->getCardFobListAccessControl();
        /////////// CCTV 
        $manufacturersCCTV = $this->getManufacturersCCTV();   
        $modelsCCTV = $this->getModelsCCTV();
        $monitoringCentreListCCTV = $this->getMonitoringCentreListCCTV();
        $cameraBrandsCCTV = $this->getCameraBrandsCCTV();
        $maintenanceFrequenciesCCTV = $this->getMaintenanceFrequenciesCCTV();

        return view('admin.unified.customers.products.add_product', [
            'serviceTypes' => $services_types,
            'customer' => $customer,
            'hostedPackages' => $hostedPackages,
            'ipVendors' => $ipVendors,
            'accountTypes' => $accountTypes,
            'systemModels' => $systemModels,
            'lineTypes'=>$lineTypes,
            'lineVendors'=>$lineVendors,
            'accountTypesAccessControl'=>$accountTypesAccessControl,
            'brandsAccessControl'=>$brandsAccessControl,
            'systemTypesAccessControl'=>$systemTypesAccessControl,
            'cardFobListAccessControl'=>$cardFobListAccessControl,
            'manufacturersCCTV'=>$manufacturersCCTV,
            'modelsCCTV'=>$modelsCCTV,
            'monitoringCentreListCCTV'=>$monitoringCentreListCCTV,
            'cameraBrandsCCTV'=>$cameraBrandsCCTV,
            'maintenanceFrequenciesCCTV'=>$maintenanceFrequenciesCCTV
        ]);
    }
    
    public function postSaveProductHostedCpbx(Request $request){
        //dd($request);
        alert()->success('Hosted/Cpbx data saved successfully.');
        return redirect()->back();
    }
    public function postSaveProductAccessControl(Request $request){
        //dd($request);
        alert()->success('Access control data saved successfully.');
        return redirect()->back();
    }
    public function postSaveProductCCTV(Request $request){
        dd($request);
        alert()->success('CCTV data saved successfully.');
        return redirect()->back();
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
        
        $lineTypes = array($lineType1,$lineType2,$lineType3,$lineType4,$lineType5);
        
        return $lineTypes;
    }
    
    private function getLineVendors(){
        $lineVendor1 = new ItemData(1, "IP Telecom");
        $lineVendor2 = new ItemData(2, "Cloudvoice");
        $lineVendor3 = new ItemData(3, "Eir");
        $lineVendor4 = new ItemData(4, "Vodafone");
        $lineVendor5 = new ItemData(5, "Magnet");
        $lineVendor6 = new ItemData(6, "Other");
        
        $lineVendors = array($lineVendor1,$lineVendor2,$lineVendor3,$lineVendor4,$lineVendor5,$lineVendor6);
        
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
    
    private function getBrandsAccessControl(){
        $brand1 = new ItemData(1, "ACT");
        $brand2 = new ItemData(2, "HKC");
        $brand3 = new ItemData(3, "Aritech");
        
        $brands =array($brand1,$brand2,$brand3);
        
        return $brands;
    }
    private function getSystemTypesAccessControl() {
        $systemType1 = new ItemData(1, "Network");
        $systemType2 = new ItemData(2, "Standalone");
        $systemType3 = new ItemData(3, "Wireless");
        
        $systemTypes = array($systemType1,$systemType2,$systemType3);
        
        return $systemTypes;
    }
    private function getCardFobListAccessControl(){
        $cardFob1 = new ItemData(1, "Act Mifare Card");
        $cardFob2 = new ItemData(2, "Act Mifare FOB");
        $cardFob3 = new ItemData(3, "HID Prox Card");
        $cardFob4 = new ItemData(4, "HID Prox FOB");
        $cardFob5 = new ItemData(5, "Site Code Card");
        $cardFob6 = new ItemData(6, "Site Code FOB");
        
        $cardFobList = array($cardFob1,$cardFob2,$cardFob3,$cardFob4,$cardFob5,$cardFob6);
        
        return $cardFobList;
    }
    private function getManufacturersCCTV(){
        $manufacturer1 = new ItemData(1, "HIK Vision");
        $manufacturer2 = new ItemData(2, "Avigilon");
        $manufacturer3 = new ItemData(3, "SmartWatch");
        $manufacturer4 = new ItemData(4, "Hi-Tel");
        
        $manufacturers = array($manufacturer1,$manufacturer2,$manufacturer3,$manufacturer4);
        
        $manufacturers;
    }
    private function getModelsCCTV(){
        $model1 = new ItemData(1, "4CHPOE");
        $model2 = new ItemData(2, "8CHPOE");
        $model3 = new ItemData(3, "16CHPOE");
        $model4 = new ItemData(4, "32CHPOE");
        
        $models = array($model1,$model2,$model3,$model4);
        
        return $models;
    }
    private function getMonitoringCentreListCCTV(){
        $monitoringCentre1 = new ItemData(1, "Alarm 24");
        $monitoringCentre2 = new ItemData(2, "Other");
        
        $monitoringCentreList = array($monitoringCentre1,$monitoringCentre2);
        
        return $monitoringCentreList;
    }
    private function getCameraBrandsCCTV(){
        $cameraBrand1 = new ItemData(1, "HIK Vision");
        $cameraBrand2 = new ItemData(2, "Avigilon");
        $cameraBrand3 = new ItemData(3, "Motorola");
        $cameraBrand4 = new ItemData(4, "AVE");
        
        $cameraBrands = array($cameraBrand1,$cameraBrand2,$cameraBrand3,$cameraBrand4);
        
        return $cameraBrands;
    }
    private function getMaintenanceFrequenciesCCTV(){
        $maintenanceFrequency1 = new ItemData(1, "6 months");
        $maintenanceFrequency2 = new ItemData(2, "12 months");
        
        $maintenanceFrequencies = array($maintenanceFrequency1,$maintenanceFrequency2);
        
        return $maintenanceFrequencies;
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