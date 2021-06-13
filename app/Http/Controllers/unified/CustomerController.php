<?php
namespace App\Http\Controllers\unified;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Imports\UnifiedCustomersImport;
use App\UnifiedCustomer;
use App\UnifiedCustomerService;
use App\UnifiedService;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function getCustomersList()
    {
        $customers = UnifiedCustomer::with('services')->get();
        foreach ($customers as $customer) {
            if (count($customer->services) > 0){
                $customer->serviceType == '';
                foreach ($customer->services as $service) {
                    $customer->serviceType .= $service->service->name;
                }
            } else {
                $customer->serviceType = 'N/A';
            }
            $county = explode(',', $customer->address);
            $customer->county = $county[count($county) - 1];
        }
//        return $customers;
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
        $selectedServiceType = array_column($customer->services->toArray(), 'service_id');
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
        $selectedServiceType = array_column($customer->services->toArray(), 'service_id');
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
