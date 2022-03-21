<?php

namespace App\Http\Controllers\garden_help;

use App\Contractor;
use App\Customer;
use App\CustomerExtraData;
use App\CustomerProperty;
use App\GardenServiceType;
use App\Helpers\CustomNotificationHelper;
use App\Helpers\GardenHelpUsersNotificationHelper;
use App\Helpers\StripePaymentHelper;
use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
use App\TermAndPolicy;
use App\User;
use App\UserClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;
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
        $client = \App\Client::where('name', 'GardenHelp')->first();
        if(!$client){
            alert()->error('GardenHelp tenant is not setup correctly');
            return redirect()->back();
        }
        $terms_policies = TermAndPolicy::where('type', 'customer')
            ->where('client_id','=',$client->id)->first();
        $terms = '#';
        $privacy = '#';
        if($terms_policies){
            $terms = $terms_policies->terms!=null? asset($terms_policies->terms) : '#';
            $privacy = $terms_policies->policy!=null? asset($terms_policies->policy) : '#';
        }
        return view('garden_help.customers.registration', ['services' => $services,
            "termsFile"=>$terms,"privacyFile"=>$privacy]);
    }

    public function postRegistrationForm(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users,email,NULL,id,deleted_at,NULL',
            'contact_through' => 'required',
            'phone' => 'required|regex:/^[0-9*#+]+$/|unique:users,phone,NULL,id,deleted_at,NULL',
            'password' => 'required|confirmed|min:8',
        ]);
        //Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = ($request->type_of_work == 'Commercial') ? $request->contact_number : $request->phone;
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
        //Sending Redis event
//        try{
//            Redis::publish('garden-help-channel', json_encode([
//                'event' => 'new-customer-request'.'-'.env('APP_ENV','dev'),
//                'data' => [
//                    'id' => $customer->id,
//                    'toast_text' => 'There is a new customer request.',
//                    'alert_text' => "There is a new customer request! with order No# $customer->id",
//                    'click_link' => route('garden_help_getcustomerSingleRequest' , ['garden-help', $customer->id]),
//                ]
//            ]));
//        } catch (\Exception $exception){
//            \Log::error('Publish Redis new order notification from external shop API failed');
//        }

//        CustomNotificationHelper::send('new_customer', $customer->id, 'GardenHelp');
        Auth::guard('garden-help')->attempt(['email' => $request->email, 'password' => $request->password]);
        alert()->success('Thank you for filling the Registration Form');
        return redirect()->route('garden_help_addNewJob', ['garden-help']);
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
        if ($request->rejected) {
            $singleRequest->rejection_reason = $request->rejection_reason;
            $singleRequest->status = 'missing';
            $singleRequest->save();
            alert()->success('Customer rejected successfully');
        } else {
            $singleRequest->status = 'quote_sent';
            $singleRequest->save();
            $body = "Hi $singleRequest->name, Please visit " . route('garde_help_getServicesBooking', $singleRequest->id) . " to view quotation and book your service. ";
//            TwilioHelper::sendSMS('GardenHelp', $singleRequest->phone_number, $body);
//            GardenHelpUsersNotificationHelper::notifyUser($job->user, $body, $job->contact_through);
            alert()->success('The Quotation was sent successfully to the client');
        }
        return redirect()->to('garden-help/jobs_table/jobs');
    }

    public function getServicesBooking($id) {
        $customer_request = Customer::find($id);
        $available_contractors = [];
        if ($customer_request->available_date_time) {
            $available_contractors = $this->availableContractors($customer_request->available_date_time);
        }
        if (!$customer_request) {
            abort(404);
        }
        return view('garden_help.customers.service_booking', ['id' => $id, 'customer_request' => $customer_request, 'available_contractors' => $available_contractors]);
    }

    public function postServicesBooking(Request $request, $id) {
        $customer = Customer::find($id);
        if (!$customer) {
            abort(404);
        }
        $this->validate($request, [
            'stripeToken' => 'required',
            'schedule_at' => 'required'
        ]);
        $customer->type = 'job';
        $customer->status = 'ready';
        $customer->available_date_time = Carbon::createFromFormat('d/m/Y H:i A', $request->schedule_at)->format('d/m/Y H:i A');

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
            'stripe_customer_id' => $stripe_customer_id,
            'payment_method_type' => $request->payment_type == 'sepa_debit' ? 'sepa_debit' : null,
            'capture_method' => $request->payment_type == 'sepa_debit' ? 'automatic' : null,
        ]);

        try {
            Redis::publish('garden-help-channel', json_encode([
                'event' => 'new-booked-service'.'-'.env('APP_ENV','dev'),
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
//        TwilioHelper::sendSMS('GardenHelp', $customer->phone_number, 'Thank You, your service has been booked successfully');
        $customer->save();
        alert()->success('Your service has been booked successfully. If you\'d like to cancel service you can visit the following link: ' . route('garde_help_getServicesCancel', $id) , 'Thank You');
        return redirect()->back();
    }

    public function getAvailableContractorsForBooking(Request $request) {
        return response()->json([
            'data' => $this->availableContractors($request->available_date)
        ]);
    }

    private function availableContractors($available_date) {
        $contractors = Contractor::all();
        $available_contractors = [];
        if ($available_date) {
            $currentDayName = Carbon::createFromFormat('d/m/Y H:i A', $available_date)->format('l');
            foreach ($contractors as $contractor) {
                if ($contractor->business_hours_json) {
                    $contractor_business_hours = json_decode($contractor->business_hours_json, true);
                    if($contractor_business_hours[$currentDayName]['isActive']){
                        $available_contractors[] = [
                            'name' => $contractor->name,
                            'experience_level' => $contractor->experience_level
                        ];
                    }
                }
            }
        }
        return $available_contractors;
    }

    public function getServicesCancelation($id) {
        $customer_request = Customer::find($id);
        if (!$customer_request) {
            abort(404);
        }
        return view('garden_help.customers.cancel_job', ['id' => $id, 'customer_request' => $customer_request]);
    }

    public function postServicesCancelation(Request $request, $id) {
        $customer = Customer::find($id);
        if (!$customer) {
            abort(404);
        }
        $customer->type = 'canceled';
//        $customer->status = 'canceled';

        if ($customer->payment_intent_id) {
            StripePaymentHelper::cancelPaymentIntent($customer->payment_intent_id);
        }
        if ($customer->contractor_id) {
            try {
//                TwilioHelper::sendSMS('GardenHelp', $customer->contractor->phone, "There is a customer has canceled his service, Scheduled at: $customer->available_date_time");
                $body = "The service scheduled at: $customer->available_date_time, has been canceled.";
                $contractor_profile = Contractor::where('user_id', $customer->contractor_id)->first();
                if ($contractor_profile) {
                    GardenHelpUsersNotificationHelper::notifyUser($customer->contractor, $body, $contractor_profile->contract_through);
                }
            } catch (Exception $e) {
                \Log::error($e->getMessage());
            }
        }

        try {
//            TwilioHelper::sendSMS('GardenHelp', $customer->phone_number, 'Your service has been canceled successfully');
            $body = 'Your service has been canceled successfully';
            GardenHelpUsersNotificationHelper::notifyUser($customer->user, $body, $customer->contract_through);

        } catch (Exception $e) {
            \Log::error($e->getMessage());
        }
        $customer->save();
        alert()->success('Your service has been canceled successfully', 'Thank You');
        return redirect()->back();
    }

    public function deleteCustomerRequest(Request $request, $client_name, $id) {
        $customer = Customer::find($id);
        if (!$customer) {
            alert()->warning('Customer is invalid');
        } else {
            alert()->success('Customer has deleted successfully');
            $customer->delete();
        }
        return redirect()->back();
    }

    public function getJobConfirmation($customer_confirmation_code) {
        if (!$customer_confirmation_code) {
            abort(404);
        }
        $checkIfCodeExists = Customer::where('customer_confirmation_code', $customer_confirmation_code)->first();
        if (!$checkIfCodeExists) {
            abort(404);
        }
        return view('garden_help.customers.confirm_completing_job', ['job' => $checkIfCodeExists]);
    }

    public function postJobConfirmation(Request $request) {
//        dd($request->all());
        $customer_confirmation_code = $request->customer_confirmation_code;
        $contractor_confirmation_code = $request->contractor_confirmation_code;
        $checkIfCodeExists = Customer::where('customer_confirmation_code', $customer_confirmation_code)
            ->where('contractor_confirmation_code', $contractor_confirmation_code)->first();
        if (!$checkIfCodeExists) {
            alert()->error('The Job QR Code is not valid, Please try again.');
            return redirect()->back();
        }
        $checkIfCodeExists->contractor_confirmation_status = 'confirmed';
        $checkIfCodeExists->save();

        \Redis::publish('garden-help-channel', json_encode([
            'event' => "contractor-confirmation-job-id-$checkIfCodeExists->id".'-'.env('APP_ENV','dev'),
            'data' => [
                'message' => 'Customer has confirmed the delivery successfully',
            ]
        ]));
        return redirect()->back();
    }

    public function getCustomersList(Request $request) {
        $customers = User::where('user_role', 'customer')->paginate(20);
        return view('admin.garden_help.customers.list', ['customers' => $customers]);
    }

    public function deleteCustomer(Request $request, $client, $id) {
        $customer = User::where('user_role', 'customer')->where('id', $id)->first();
        if (!$customer) {
            alert()->error("No customer found with ID #$id");
        } else {
            $customer->delete();
            Customer::where('user_id', $customer->id)->delete();
            CustomerProperty::where('user_id', $customer->id)->delete();
            alert()->success('Customer has deleted successfully');
        }
        return redirect()->back();
    }
}
