<?php
namespace App\Http\Controllers\unified;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Imports\UnifiedCustomersImport;
use App\UnifiedCustomer;
use App\UnifiedService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function getCustomersList()
    {
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
        $services_types = UnifiedService::select(['id', 'name'])->get();

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
        $services_types = UnifiedService::select(['id', 'name'])->get();

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
        $contact_details_json = json_decode($request->contact_detailss,true);
        $services_types_json = json_decode($request->serviceTypeSelectValues,true);
        $customer->update([
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
        ]);

        $user = User::find($customer->user_id);
        $user->name = $request->name;
        $user->email = $contact_details_json[0]['contactEmail'];
        $user->phone = $contact_details_json[0]['contactNumber'];
        $user->save();

        alert()->success('Customer updated successfully');

        return redirect()->route('unified_getCustomersList', 'unified');
    }
    
    public function getAddCustomer(){
        $services_types = UnifiedService::select(['id', 'name'])->get();
        return view('admin.unified.customers.add_customer', [
            'serviceTypes' => $services_types
        ]);
    }
    public function postAddCustomer(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'contract' => 'required',
            'address' => 'required',
            'postcode' => 'required',
            'companyPhoneNumner' => 'required',
            'serviceTypeSelectValues' => 'required',
        ]);

        $contact_details_json = json_decode($request->contact_detailss,true);
        $services_types_json = json_decode($request->serviceTypeSelectValues,true);
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
        ]);
        alert()->success('Customer has added successfully.');
        return redirect()->route('unified_getCustomersList', 'unified');
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
