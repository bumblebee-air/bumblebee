<?php

namespace App\Http\Controllers\doorder;

use App\Http\Controllers\Controller;
use App\Retailer;
use App\User;
use App\UserClient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe;

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
        $user->email = $firstContact['contact_email'];
        $user->password = bcrypt(Str::random(6));
        $user->user_role = 'retailer';
        $user->save();
        
        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
        );
        $customer_details = $stripe->customers->create([
        'name' => $firstContact['contact_name'],
        'email' => $firstContact['contact_email'],
        'phone' => $firstContact['contact_phone'],
        'description' => 'Customer Company name is '.$request->company_name,
        ]);
        
        $payment_exp_date = explode('/', $request->payment_exp_date);
        $exp_month = $payment_exp_date[0];
        $exp_year = $payment_exp_date[1];
        
        $getCreatedStripeTokenDetail = $stripe->tokens->create([
        'card' => [
            'number' => $request->payment_card_number,
            'exp_month' => $exp_month,
            'exp_year' => $exp_year,
            'cvc' => $request->payment_cvc_number,
        ],
        ]);

        $stripeToken = $getCreatedStripeTokenDetail['id'];
//        if (env('APP_ENV') == 'local') {
        if (str_contains(env('STRIPE_SECRET'), 'test_')) {
            $customer_card_details = $stripe->customers->createSource(
                $customer_details['id'],
                ['source' => 'tok_visa']
                );
            $stripeTokenforCharge = 'tok_visa';
        } else{
            $customer_card_details = $stripe->customers->createSource(
                $customer_details['id'],
                ['source' => ['object' => 'card',
                'number' => $request->payment_card_number,
                'exp_month' => $exp_month,
                'exp_year' => $exp_year,
                'cvc' => $request->payment_cvc_number]
                ]
                );
            $stripeTokenforCharge = $stripeToken;
        }

        /*$amount = '1000';
        $currency = 'usd';
        $description = 'Testing Payment Reason';
        $this->chargeRetailer($amount, $currency, $stripeTokenforCharge, $description);*/
        /*$customer = $stripe->customers->create([
            'email' => $user->email,
            'source' => $request->stripeToken
        ]);*/

        $retailer = new Retailer();
        $retailer->user_id = $user->id;
        $retailer->name = $request->company_name;
        $retailer->company_website = $request->company_website;
        $retailer->business_type = $request->business_type;
        $retailer->nom_business_locations = $request->number_business_locations;
        $retailer->locations_details = $request->locations_details;
        $retailer->contacts_details = $request->contacts_details;
        $retailer->stripe_token = $stripeToken;
        $retailer->customer_id = $customer_details['id'];
        //$retailer->stripe_customer_id = $customer->id;
        $retailer->save();

        //Getting Doorder Client
        $client = \App\Client::where('name', 'DoOrder')->first();
        if($client) {
            //Making Client Relation
            UserClient::create([
                'user_id' => $retailer,
                'client_id' => $client->id
            ]);
        }

        alert()->success('You are registered successfully');
        return redirect()->back();
    }

    public function getRetailerRequests() {
        $retailers_requests = Retailer::paginate(20);
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
        if ($request->rejection_reason) {
            $singleRequest->rejection_reason = $request->rejection_reason;
            $singleRequest->status = 'missing';
            $singleRequest->save();
            alert()->success('Retailer Form rejected successfully');
        } else {
            $singleRequest->status = 'completed';
            $singleRequest->save();
            alert()->success('Retailer Form accepted successfully');
        }
        return redirect()->route('doorder_retailers_requests', 'doorder');
    }
}
