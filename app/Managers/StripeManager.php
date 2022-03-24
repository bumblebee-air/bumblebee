<?php

namespace App\Managers;

use App\Helpers\GardenHelpUsersNotificationHelper;
use App\Helpers\TwilioHelper;
use App\StripeAccount;
use App\User;
use Illuminate\Support\Str;
use Stripe\Exception\ApiErrorException;
use Stripe\StripeClient;
use Twilio\Rest\Client;

class StripeManager
{
    private $stripe_key = '';
    public function __construct(){
        $stripe_key = env('STRIPE_SECRET');
        if($stripe_key==null){
            dd('Stripe secret key is not configured');
        }
        $this->stripe_key = $stripe_key;
    }

    public function createCustomAccount($user,$business_type='individual',$merchant_code=null, $contact_through='sms'){
        /*Stripe merchant code for 'Motor Freight Carriers and Trucking
            - Local and Long Distance, Moving and Storage Companies,
            and Local Delivery Services'*/
        $product_description = 'Service Supplier';
        $company_name = 'DoOrder';
        if($merchant_code==null) {
            $merchant_code = 4214;
            $product_description = $company_name.' package delivery service';
        } elseif($merchant_code==5261){
            $company_name = 'GardenHelp';
            $product_description = $company_name.' garden maintenance';
        }
        $account_type = 'express';
        $user_name = explode(' ',$user->name);
        $first_name = $user_name[0];
        $last_name = $user_name[1] ?? '';
        $email = $user->email;
        $phone = $user->phone;
        $stripe = new StripeClient($this->stripe_key);
        try {
            $stripe_account = $stripe->accounts->create([
                'type' => $account_type,
                'country' => 'IE',
                'email' => $email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                /*'address' => [
                    'line1' => $address
                ],*/
                'business_type' => $business_type,
                'individual' => [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'phone' => $phone,
                ],
                'business_profile' => [
                    'mcc' => $merchant_code,
                    'name' => $first_name . ' ' . $last_name,
                    'product_description' => $product_description
                ]
            ]);
        } catch (ApiErrorException $e) {
            \Log::error('Stripe account creation error: '.$e->getMessage());
            $request_url = \Request::getUri();
            if(strpos($request_url,'api/')!==false){
                $response = [
                    'message' => 'Stripe account creation error: '.$e->getMessage(),
                    'error' => 1
                ];
                return response()->json($response,500);
            }else{
                alert()->error('Stripe account creation error: '.$e->getMessage());
                return redirect()->back();
            }
        }
        //dd($stripe_account);
        $onboard_code = '';
        for ($i = 0; $i<8; $i++) {
            $onboard_code .= mt_rand(0,9);
        }
        $new_stripe_account = new StripeAccount();
        $new_stripe_account->user_id = $user->id;
        $new_stripe_account->account_id = $stripe_account->id;
        $new_stripe_account->business_type = $stripe_account->business_type;
        $new_stripe_account->type = $account_type;
        $new_stripe_account->onboard_code = $onboard_code;
        $new_stripe_account->save();
        //send onboarding link to user
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $twilio = new Client($sid, $token);
        $message_body = 'Hi '.$first_name.', Click on the following link to start your Stripe account on-boarding: '.
            url('stripe-onboard/'.$onboard_code);
        if ($company_name=='GardenHelp') {
            GardenHelpUsersNotificationHelper::notifyUser($user, $message_body, $contact_through);
        } else {
            TwilioHelper::sendSMS($company_name, $phone, $message_body);
        }
        return $stripe_account;
    }

    public function deleteCustomAccount($id){
        try {
            $stripe = new StripeClient($this->stripe_key);
            $stripe->accounts->delete($id);
        }
        catch (ApiErrorException $e){
            \Log::error('Stripe account delete error: '.$e->getMessage());
            $request_url = \Request::getUri();
            if(strpos($request_url,'api/')!==false){
                $response = [
                    'message' => 'Stripe account delete error: '.$e->getMessage(),
                    'error' => 1
                ];
                return response()->json($response,500);
            }else{
                alert()->error('Stripe account delete error: '.$e->getMessage());
                return redirect()->back();
            }
        }
        return true;


    }

    public function stripeAccountOnboardComplete($stripe_account_id){
        $stripe_account = StripeAccount::where('account_id','=',$stripe_account_id)->first();
        if(!$stripe_account){
            return false;
        }
        $user = $stripe_account->user;
        if(!$user){
            return false;
        }
        $user_client = $user->client;
        if(!$user_client){
            return false;
        }
        $client = $user_client->client;
        if(!$client){
            return false;
        }
        $client_name = strtolower($client->name);
        if($client_name=='gardenhelp'){
            try {
                if ($user->contractor_profile->status == 'completed') {
                    $new_pass = Str::random(6);
                    $user->password = bcrypt($new_pass);
                    $user->save();
                    $body = "Hi $user->name, your contractor profile has been accepted. " .
                        "Login details are the email: $user->email and the password: $new_pass . " .
                        "Web app: " . url('contractors_app');
                    //Sending SMS
                    TwilioHelper::sendSMS('GardenHelp', $user->phone, $body);
                }
            }catch(\Exception $exception){
                \Log::error($exception->getMessage(),$exception->getTrace());
            }
        }/*elseif($client_name=='doorder'){
        }*/
        return true;
    }

    public function createCustomer($name, $email, $description=''){
        try {
            $stripe = new StripeClient($this->stripe_key);
            $customer = $stripe->customers->create([
                'name' => $name,
                'email' => $email,
                'description' => $description
            ]);
            $stripe_customer_id = $customer->id;
            return ['error'=>0, 'customer_id'=>$stripe_customer_id, 'message'=>'Customer created'];
        } catch (\Exception $exception){
            return ['error'=>1, 'customer_id'=>null, 'message'=>$exception->getMessage()];
        }
    }

    public function setupIntentSepa($stripe_customer_id){
        try {
            $stripe = new StripeClient($this->stripe_key);
            $setup_intent = $stripe->setupIntents->create([
                'payment_method_types' => ['sepa_debit'],
                'customer' => $stripe_customer_id,
            ]);
            $client_secret = $setup_intent->client_secret;
            return ['error'=>0, 'client_secret'=>$client_secret, 'message'=>'Setup Intent successful'];
        } catch (\Exception $exception){
            return ['error'=>1, 'client_secret'=>null, 'message'=>$exception->getMessage()];
        }
    }
}
