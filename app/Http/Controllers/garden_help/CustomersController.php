<?php

namespace App\Http\Controllers\garden_help;

use App\Customer;
use App\CustomerExtraData;
use App\GardenServiceType;
use App\Http\Controllers\Controller;
use App\User;
use App\UserClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Twilio\Rest\Client;


class CustomersController extends Controller
{
    public function getRegistrationForm() {
        $services = GardenServiceType::all();
        foreach ($services as $item) {
            $item->title = $item->name;
            $item->is_checked = $item->false;
            $item->is_recurring = "0";
        }
        return view('garden_help.customers.registration', ['services' => $services]);
    }

    public function postRegistrationForm(Request $request) {
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
                'phone' => 'required_if:type_of_work,Residential|unique:users',
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
                'service_types_json' => 'required_if:type_of_work,Residential',
            ]);

            //Create User
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = ($request->type_of_work=='Commercial')? $request->contact_number : $request->phone;
            $user->password = $request->password ? bcrypt($request->password) : bcrypt(Str::random(8));
            $user->user_role = 'customer';
            $user->save();

            $client = \App\Client::where('name', 'GardenHelp')->first();
            if($client) {
                //Making Client Relation
                UserClient::create([
                    'user_id' => $user->id,
                    'client_id' => $client->id
                ]);
            }

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
            $customer->address = $request->address;
            $customer->services_types_json = $request->service_types_json;
            $customer->save();
          
            //Sending Redis event
            try{
                Redis::publish('garden-help-channel', json_encode([
                    'event' => 'new-customer-request',
                    'data' => [
                        'id' => $customer->id,
                        'toast_text' => 'There is a new customer request.',
                        'alert_text' => "There is a new customer request! with order No# $customer->id",
                        'click_link' => route('garden_help_getcustomerSingleRequest' , ['garden-help', $customer->id]),
                    ]
                ]));
            } catch (\Exception $exception){
                \Log::error('Publish Redis new order notification from external shop API failed');
            }
        }
        alert()->success('We will Get back to you shortly.', 'Thank you for filling the Registration Form');
        return redirect()->back();
    }
    
    
    public function getCustomersRequests() {
        $customers_requests = Customer::orderBy('id', 'desc')
            ->where('type', 'request')->paginate(20);
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
            $singleRequest->status = 'quote_sent';
            $singleRequest->save();

            try {
                //Sending booking URL via SMS
                $sid = env('TWILIO_SID', '');
                $token = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $twilio->messages->create($singleRequest->phone_number,
                    [
                        "from" => "GardenHelp",
                        "body" => "Hi $singleRequest->name, Please visit " . route('garde_help_getServicesBooking', $singleRequest->id) . " to view quotation and book your service. "
                    ]
                );
            }catch(\Exception $exception){
                \Log::error($exception->getMessage(),$exception->getTrace());
            }
           
            alert()->success('The Quotation was sent successfully to the client');
        }
        return redirect()->route('garden_help_getCustomerssRequests', 'garden-help');
    }

    public function getServicesBooking($id) {
        $customer_request = Customer::find($id);
        if (!$customer_request) {
            abort(404);
        }
        return view('garden_help.customers.service_booking', ['id' => $id, 'customer_request' => $customer_request]);
    }

    public function postServicesBooking(Request $request, $id) {
        $customer = Customer::find($id);
        if (!$customer) {
            abort(404);
        }
        $this->validate($request, [
            'stripeToken' => 'required'
        ]);
        $customer->type = 'job';
        $customer->status = 'ready';

        //Create Stripe Customer
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $stripe_customer = $stripe->customers->create([
                'name' => $customer->user->name,
                'email' => $customer->user->email,
                'source' => $request->stripeToken
            ]);
        } catch (\Exception $e) {
            alert()->error($e->getMessage());
            return redirect()->back();
        }
        $stripe_customer_id = $stripe_customer->id;
        //Saving customer id
        CustomerExtraData::create([
            'user_id' => $customer->user_id,
            'job_id' => $customer->id,
            'stripe_customer_id' => $stripe_customer_id
        ]);

        try {
            Redis::publish('garden-help-channel', json_encode([
                'event' => 'new-booked-service',
                'data' => [
                    'id' => $customer->id,
                    'toast_text' => 'A new service has been booked.',
                    'alert_text' => "A customer has booked a service with service No# $customer->id",
                    'click_link' => route('garden_help_getSingleJob' , ['garden-help', $customer->id]),
                ]
            ]));
        } catch(\Exception $e) {
            \Log::error('Publish Redis for a new booked service');
        }
        $customer->save();
        alert()->success('Your service has been booked successfully', 'Thank You');
        return redirect()->back();
    }
}
