<?php

namespace App\Http\Controllers\doorder;

use App\Helpers\CustomNotificationHelper;
use App\Http\Controllers\Controller;
use App\Retailer;
use App\User;
use App\UserClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Stripe;
use Twilio\Rest\Client;

class RetailerController extends Controller
{
    public function getRetailerRegistrationForm() {
        return view('doorder.retailers.registration');
    }

    public function postRetailerRegistrationForm(Request $request) {
        $this->validate($request, [
            'company_name' => 'required',
            'company_website' => 'required',
            'business_type' => 'required',
            'number_business_locations' => 'required',
            'locations_details' => 'required',
            'contacts_details' => 'required',
        ]);
        $firstContact = json_decode($request->contacts_details, true)[0];
        $errors = \Validator::make($firstContact, [
            'contact_email' => 'required|unique:users,email',
            'contact_phone' => 'required|unique:users,phone',
        ]);
        if ($errors->fails()) {
            return redirect()->back()->with(['errors' => $errors->errors()])->withInput($request->all());
        }

        $user = new User();
        $user->name = $firstContact['contact_name'];
        $user->phone = $firstContact['contact_phone'];
        $user->email = $firstContact['contact_email'];
        $user->password = bcrypt(Str::random(6));
        $user->user_role = 'retailer';
        $user->save();
        $customer_id= null;
        $stripe_token = $request->stripeToken;
        if($stripe_token!=null && $stripe_token!='') {
            if (env('APP_ENV') == 'local' || env('APP_ENV') == 'development') {
                $stripe_token = 'tok_visa';
            }
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $customer = $stripe->customers->create([
                'name' => $user->name,
                'email' => $user->email,
                'source' => $stripe_token
            ]);
            $customer_id = $customer->id;
        }
        $retailer = new Retailer();
        $retailer->user_id = $user->id;
        $retailer->name = $request->company_name;
        $retailer->company_website = $request->company_website;
        $retailer->business_type = $request->business_type;
        $retailer->nom_business_locations = $request->number_business_locations;
        $retailer->locations_details = $request->locations_details;
        $retailer->contacts_details = $request->contacts_details;
//        $retailer->stripe_token = $stripeToken;
//        $retailer->customer_id = $customer;
        $retailer->stripe_customer_id = $customer_id;
        $retailer->save();

        //Getting Doorder Client and linking the user to the client
        $client = \App\Client::where('name', 'DoOrder')->first();
        if($client) {
            //Making Client Relation
            UserClient::create([
                'user_id' => $user->id,
                'client_id' => $client->id
            ]);
        }
        if(env('APP_ENV')=='production'){
            try{
                Mail::send('email.doorder_new_request', [
                    'request_type' => 'retailer',
                    'request_name' => $retailer->name,
                    'request_url_view' => url('doorder/retailers/requests/'.$retailer->id)
                ],
                    function ($message) {
                        $message->from('no-reply@doorder.eu', 'DoOrder platform');
                        $message->to(env('DOORDER_NOTIF_EMAIL','doorderdelivery@gmail.com'),
                            'DoOrder')->subject('New retailer registration request');
                    });
                CustomNotificationHelper::send('new_retailer', $retailer->id);
            }catch (\Exception $exception){
                \Log::error($exception->getMessage(),$exception->getTrace());
            }
        }
        alert()->success('You are registered successfully');
        return redirect()->back();
    }

    public function getRetailerRequests() {
        $retailers_requests = Retailer::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.doorder.retailers.requests', ['retailers_requests' => $retailers_requests]);
    }

    public function chargeRetailer($amount, $currency, $stripeTokenforCharge, $description)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $stripe_charge = Stripe\Charge::create ([
                "amount" => $amount,
                "currency" => $currency,
                "source" => $stripeTokenforCharge,
                "description" => $description 
        ]);
        if($stripe_charge)
        {
            return true;
        } else{
            return false;
        }
    }

    public function getSingleRequest($client_name, $id) {
        $singleRequest = Retailer::find($id);
        if (!$singleRequest) {
            abort(404);
        }
        return view('admin.doorder.retailers.single_request', ['singleRequest' => $singleRequest]);
    }

    public function postSingleRequest(Request $request, $client_name, $id) {
        $singleRequest = Retailer::find($id);
        if (!$singleRequest) {
            abort(404);
        }
        $user = User::find($singleRequest->user_id);
        if (!$user) {
            abort(404);
        }
        if ($request->rejection_reason) {
            $singleRequest->rejection_reason = $request->rejection_reason;
            $singleRequest->status = 'missing';
            $singleRequest->save();
            alert()->success('Retailer rejected successfully');
        } else {
            $singleRequest->status = 'completed';
            $singleRequest->save();
            //update user password send sms to retailer with login details
            $new_pass = Str::random(6);
            $user->password = bcrypt($new_pass);
            $user->save();
            try {
                $sid = env('TWILIO_SID', '');
                $token = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $twilio->messages->create($user->phone,
                    [
                        "from" => "DoOrder",
                        "body" => "Hi $user->name, your retailer profile has been accepted.".
                        " Login details are the email: $user->email and the password: $new_pass .".
                        " Login page: ".url('doorder/login')
                    ]
                );
            } catch (\Exception $exception){
            }
            alert()->success('Retailer accepted successfully');
        }
        return redirect()->route('doorder_retailers_requests', 'doorder');
    }
    
    public function getRetailers($param) {
        $retailers = Retailer::where('status','completed')->get();
        //paginate(20);
        return view('admin.doorder.retailers.accepted_retailers', ['retailers' => $retailers]);
    }
    public function deleteRetailer(Request $request){
        $retailer_id = $request->get('retailerId');
        $retailer_profile = Retailer::find($retailer_id);
        if(!$retailer_profile){
            alert()->error('Retailer not found!');
            return redirect()->back();
        }
        $user_account = User::find($retailer_profile->user_id);
        if(!$user_account){
            alert()->error('Retailer not found!');
            return redirect()->back();
        }
        //delete user and retailer entries
        $retailer_profile->delete();
        $user_account->delete();
        alert()->success('Retailer deleted successfully');
        
        return redirect()->route('doorder_retailers', 'doorder');
    }
    
    public function getSingleRetailer($client_name, $id) {
        $retailer = Retailer::find($id);
//        dd(json_decode($retailer->locations_details, true));
        if (!$retailer) {
            //abort(404);
            alert()->error('Retailer not found!');
            return redirect()->back();
        }
        return view('admin.doorder.retailers.single_retailer', ['retailer' => $retailer,'readOnly'=>0]);
    }
    public function getViewRetailer($client_name,$id) {
        $retailer = Retailer::find($id);
        if (!$retailer) {
            //abort(404);
            alert()->error('Retailer not found!');
            return redirect()->back();
        }
        return view('admin.doorder.retailers.single_retailer', ['retailer' => $retailer,'readOnly'=>true]);
    }
    
    public function saveUpdateRetailer($client_name,$id, Request $request) {
        $retailer_id = $request->get('retailer_id');
        $retailer = Retailer::find($retailer_id);
        if(!$retailer){
            alert()->error('Retailer not found!');
            return redirect()->back();
        }
        $retailer->name = $request->get('company_name');
        $retailer->company_website = $request->get('company_website');
        $retailer->business_type = $request->get('business_type');
        $retailer->nom_business_locations = $request->get('number_business_locations');
        $retailer->locations_details = $request->locations_details;
        $retailer->contacts_details = $request->contacts_details;
        $retailer->shopify_store_domain = $request->get('shopify_store_domain');
        $retailer->shopify_app_api_key = $request->get('shopify_app_api_key');
        $retailer->shopify_app_password = $request->get('shopify_app_password');
        $retailer->shopify_app_secret = $request->get('shopify_app_secret');
        $retailer->save();
        alert()->success('Retailer updated successfully');
        //alert()->success('Work in progress');
        if (auth()->user()->user_role == "retailer") {
            return redirect()->back();
        } else {
            return redirect()->route('doorder_retailers', 'doorder');
        }
    }

    public function editRetailerProfile($client_name) {
        $retailer = auth()->user()->retailer_profile;
        if (!$retailer) {
            //abort(404);
            alert()->error('Retailer not found!');
            return redirect()->back();
        }
        return view('admin.doorder.retailers.single_retailer', ['retailer' => $retailer,'readOnly'=>0]);
    }


}
