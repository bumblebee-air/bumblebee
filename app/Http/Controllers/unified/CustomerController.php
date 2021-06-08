<?php
namespace App\Http\Controllers\unified;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Imports\UnifiedCustomersImport;
use App\UnifiedCustomer;
use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{

    public $services_types;

    public function __construct()
    {
        $this->services_types = $services_types = collect([
            [
                'id' => 1,
                'name' => 'hosted_pbx'
            ],
            [
                'id' => 2,
                'name' => 'access_control'
            ],
            [
                'id' => 3,
                'name' => 'cctv'
            ],
            [
                'id' => 4,
                'name' => 'fire_alarm'
            ],
            [
                'id' => 5,
                'name' => 'intruder_alarm'
            ],
            [
                'id' => 6,
                'name' => 'wifi_data'
            ],
            [
                'id' => 7,
                'name' => 'structured_cabling_system'
            ]
        ]);
    }

    public function getCustomersList()
    {
        // $customer1 = new CustomerData(1, "ACCA Ireland", "Intruder_alarm", true, "The Liberties", "52 Dolphins Barn Street,
        // The Liberties", "Shane Martin", "shane.martin@accaglobal.com");
        // $customer2 = new CustomerData(2, "ACCA Ireland", "CCTV,Fire alram", false, "The Liberties", "52 Dolphins Barn Street,
        // The Liberties", "Shane Martin", "shane.martin@accaglobal.com");
        $customers = UnifiedCustomer::all();
        foreach ($customers as $customer) {
            $customer->serviceType = $customer->hosted_pbx ? 'hosted_pbx, ' : '';
            $customer->serviceType .= $customer->access_control ? 'access_control, ' : '';
            $customer->serviceType .= $customer->cctv ? 'cctv, ' : '';
            $customer->serviceType .= $customer->fire_alarm ? 'fire_alarm, ' : '';
            $customer->serviceType .= $customer->intruder_alarm ? 'intruder_alarm, ' : '';
            $customer->serviceType .= $customer->wifi_data ? 'wifi_data, ' : '';
            $customer->serviceType .= $customer->structured_cabling_system ? 'structured_cabling_system, ' : '';

            if ($customer->serviceType == '') {
                $customer->serviceType = 'N/A';
            }
            
            $customer->address = $customer->street_1 . ', ' . $customer->street_2 . ', ' . $customer->town . ', ' . $customer->country;
        }
        return view('admin.unified.customers.list', [
            'customers' => $customers
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
        $selectedServiceType = [];
        $customer->hosted_pbx ? $selectedServiceType[] = 1 : '';
        $customer->access_control ? $selectedServiceType[] = 2 : '';
        $customer->cctv ? $selectedServiceType[] = 3 : '';
        $customer->fire_alarm ? $selectedServiceType[] = 4 : '';
        $customer->intruder_alarm ? $selectedServiceType[] = 5 : '';
        $customer->wifi_data ? $selectedServiceType[] = 6 : '';
        $customer->structured_cabling_system ? $selectedServiceType[] = 7 : '';
        // $customer->contract ? $selectedServiceType = 8 : '';

        $customer->selectedServiceType = $selectedServiceType;
        
        $customer->address = $customer->street_1 . ', ' . $customer->street_2 . ', ' . $customer->town . ', ' . $customer->country;
        
        $customerContact1 = new ContactData($customer->contact, "p1", $customer->phone, $customer->email);
        $customerContact2 = new ContactData('2 '.$customer->contact, "p2", $customer->phone.'22', 'ss'.$customer->email);
        $customerContacts = array($customerContact1,$customerContact2);
        $customer->contacts = json_encode($customerContacts);
        
        return view('admin.unified.customers.single_customer', [
            'customer' => $customer,
            'readOnly' => 1,
            'serviceTypes' => $this->services_types
        ]);
    }

    public function getSingleCustomerEdit($client_name, $id)
    {
        $customer = UnifiedCustomer::find($id);
        if (! $customer) {
            abort(404);
        }
        $selectedServiceType = [];
        $customer->hosted_pbx ? $selectedServiceType[] = 1 : '';
        $customer->access_control ? $selectedServiceType[] = 2 : '';
        $customer->cctv ? $selectedServiceType[] = 3 : '';
        $customer->fire_alarm ? $selectedServiceType[] = 4 : '';
        $customer->intruder_alarm ? $selectedServiceType[] = 5 : '';
        $customer->wifi_data ? $selectedServiceType[] = 6 : '';
        $customer->structured_cabling_system ? $selectedServiceType[] = 7 : '';

        $customer->selectedServiceType = $selectedServiceType;
        
        $customer->address = $customer->street_1 . ', ' . $customer->street_2 . ', ' . $customer->town . ', ' . $customer->country;
        
        $customerContact1 = new ContactData($customer->contact, "p1", $customer->phone, $customer->email);
        $customerContact2 = new ContactData('2 '.$customer->contact, "p2", $customer->phone.'22', 'ss'.$customer->email);
        $customerContacts = array($customerContact1,$customerContact2);
        $customer->contacts = json_encode($customerContacts);
        
        return view('admin.unified.customers.single_customer', [
            'customer' => $customer,
            'readOnly' => 0,
            'serviceTypes' => $this->services_types
        ]);
    }

    public function postEditCustomer(Request $request)
    {
        //dd($request);
        $customer = UnifiedCustomer::find($request->customer_id);
        if (! $customer) {
            abort(404);
        }
        // Check services Types
        $selected_services_types_array = json_decode($request->serviceTypeSelectValues);
        foreach ($this->services_types as $service_type) {
            $service_type_name = $service_type['name'];
            $service_type_key = array_search($service_type['id'], $selected_services_types_array);
            if ($service_type_key !== false) {
                $customer[$service_type_name] = true;
            } else {
                $customer[$service_type_name] = false;
            }
        }
        $customer->name = $request->name;
        $customer->contact = $request->contact;
        $customer->contract = $request->contract;
        $customer->street_1 = $request->address;
        $customer->email = $request->email;
        $customer->post_code = $request->postcode;
        $customer->phone = $request->phone;
        $customer->mobile = $request->mobile;
        $customer->save();

        $user = User::find($customer->user_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->mobile;
        $user->save();

        alert()->success('Customer updated successfully');

        return redirect()->route('unified_getCustomersList', 'unified');
    }
    
    public function getAddCustomer(){
        return view('admin.unified.customers.add_customer', [
            
            'serviceTypes' => $this->services_types
        ]);
    }
    public function postAddCustomer(Request $request){
        dd($request);
    }
}

class CustomerData
{

    public $id, $name, $serviceType, $contract, $location, $address, $contact, $email;

    public function __construct($id, $name, $serviceType, $contract, $location, $address, $contact, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->serviceType = $serviceType;
        $this->contract = $contract;
        $this->location = $location;
        $this->address = $address;
        $this->contact = $contact;
        $this->email = $email;
    }
}

class ServiceTypeData
{

    public $id, $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

class ContactData{
    public $contactName,$position, $contactNumber, $contactEmail;
    
    public function __construct( $contactName,$position, $contactNumber, $contactEmail){
        $this->contactName=$contactName;
        $this->position=$position;
        $this->contactNumber=$contactNumber;
        $this->contactEmail=$contactEmail;
    }
}
