<?php

namespace App\Http\Controllers\garden_help;

use App\Customer;
use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;


class CustomersController extends Controller
{
    public function getRegistrationForm() {
        return view('garden_help.customers.registration');
    }

    public function postRegistrationForm(Request $request) {
//        dd($request->all());
        $this->validate($request, [
            'work_location' => 'required',
        ]);
        if ($request->work_location == 'other') {
            $this->validate($request, [
                'email' => 'required'
            ]);

            $customer = new Customer();
            $customer->email = $request->email;
            $customer->work_location = $request->work_location;
            $customer->save();
        } else {
            $this->validate($request, [
                'type_of_work' => 'required|in:Commercial,Residential',
                'name' => 'required',
                'email' => 'required|unique:users',
                'contact_through' => 'required',
                'phone' => 'required_if:type_of_work,Residential',
                'password' => 'required_if:type_of_work,Residential|confirmed',
                'service_types' => 'required_if:type_of_work,Residential',
                'location' => 'required_if:type_of_work,Residential',
                'location_coordinates' => 'required_if:type_of_work,Residential',
                'property_photo' => 'required_if:type_of_work,Residential',
                'is_first_time' => 'required_if:type_of_work,Residential',
                'last_services' => 'required_if:is_first_time,0',
                'site_details' => 'required_if:is_first_time,0',
                'is_parking_site' => 'required_if:type_of_work,Residential',
                'contact_name' => 'required_if:type_of_work,Commercial',
                'contact_number' => 'required_if:type_of_work,Commercial',
                'available_date_time' => 'required_if:type_of_work,Commercial',
            ]);

            //Create User
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = $request->password ? bcrypt($request->password) : bcrypt(Str::random(8));
            $user->user_role = 'customer';
            $user->save();

            //Create Customer
            $customer = new Customer();
            $customer->user_id = $user->id;
            $customer->work_location = $request->work_location;
            $customer->type_of_work = $request->type_of_work;
            $customer->name = $request->name;
//            $customer->email = $request->email;
            $customer->contact_through = $request->contact_through;
            $customer->phone_number = $request->phone;
//            $customer->password = $request->password;
            $customer->service_types = $request->service_types;
            $customer->location = $request->location;
            $customer->location_coordinates = $request->location_coordinates;
            $customer->property_photo = $request->hasFile('property_photo') ? $request->file('property_photo')->store('uploads/customers_uploads') : null;
            $customer->property_size = $request->property_size;
            $customer->is_first_time = $request->is_first_time;
            $customer->last_service = $request->last_services;
            $customer->site_details = $request->site_details;
            $customer->is_parking_access = $request->is_parking_site;
            $customer->contact_name = $request->contact_name;
            $customer->contact_number = $request->contact_number;
            $customer->available_date_time = $request->available_date_time;
            $customer->area_coordinates = $request->area_coordinates;
          //  $customer->address = $request->address;
            $customer->save();

          
            //Sending Redis event
            try{
            Redis::publish('garden-help-channel', json_encode([
                'event' => 'new-request',
                'data' => [
                    'id' => $customer->id,
                    'created_at' => $customer->created_at,
                    'type_of_work' => ucfirst($customer->type_of_work),
                    'name' => $customer->name,
                    'status' => 'received',
                    'work_location' => ucfirst($customer->work_location),
                ]
            ]));
            } catch (\Exception $exception){
                \Log::error('Publish Redis new order notification from external shop API failed');
            }
        }
        alert()->success('We will Get back to you shortly on the Company Email.', 'Thank you for filling the Registration Form');
        return redirect()->back();
    }
    
    
    public function getCustomersRequests() {
        $customers_requests = Customer::orderBy('id', 'desc')->paginate(20);
        return view('admin.garden_help.customers.requests', ['customers_requests' => $customers_requests]);
    }
    
    public function getSingleRequest($client_name, $id) {
        $customer_request = Customer::find($id);
        $customer_request->email = $customer_request->user->email;
       // dd($customer_request);
        if (!$customer_request) {
            abort(404);
        }
        if($customer_request->type_of_work=="Commercial"){
            return view('admin.garden_help.customers.single_request', ['customer_request' => $customer_request]);
        }else{
            return view('admin.garden_help.customers.single_request_residential', ['customer_request' => $customer_request]);            
        }
    }
    
    public function postSingleRequest(Request $request, $client_name, $id) {
        $singleRequest = Customer::find($id);
        if (!$singleRequest) {
            abort(404);
        }
        if ($request->rejection_reason) {
            $singleRequest->rejection_reason = $request->rejection_reason;
            //$singleRequest->status = 'missing';
            //$singleRequest->save();
            alert()->success('Customer rejected successfully');
        } else {
            //$singleRequest->status = 'completed';
            //$singleRequest->save();
           
            alert()->success('The Quotation was sent successfully to the client');
        }
        return redirect()->route('garden_help_getCustomerssRequests', 'garden-help');
    }
}
