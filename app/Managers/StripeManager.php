<?php

namespace App\Managers;

use App\StripeAccount;
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

    public function createCustomAccount($user,$business_type='individual'){
        /*Stripe merchant code for 'Motor Freight Carriers and Trucking
            - Local and Long Distance, Moving and Storage Companies,
            and Local Delivery Services'*/
        $merchant_code = 4214;
        $user_name = explode(' ',$user->name);
        $first_name = $user_name[0];
        $last_name = isset($user_name[1])? $user_name[1] : '';
        $email = $user->email;
        $phone = $user->phone;
        $stripe = new StripeClient($this->stripe_key);
        $stripe_account = $stripe->accounts->create([
            'type' => 'custom',
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
            'business_profile'=> [
                'mcc' => $merchant_code,
                'name' => $first_name.' '.$last_name,
                'product_description' => 'DoOrder package delivery service'
            ]
        ]);
        //dd($stripe_account);
        $onboard_code = '';
        for ($i = 0; $i<8; $i++) {
            $onboard_code .= mt_rand(0,9);
        }
        $new_stripe_account = new StripeAccount();
        $new_stripe_account->user_id = $user->id;
        $new_stripe_account->account_id = $stripe_account->id;
        $new_stripe_account->business_type = $stripe_account->business_type;
        $new_stripe_account->type = 'custom';
        $new_stripe_account->onboard_code = $onboard_code;
        $new_stripe_account->save();
        //send onboarding link to user
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $twilio = new Client($sid, $token);
        $message_body = 'Hi '.$first_name.', Click on the following link to start your Stripe account on-boarding: '.
            url('stripe-onboard/'.$onboard_code);
        $message = $twilio->messages->create($phone,
            ["from" => "DoOrder",
                "body" => $message_body]
        );
        return $stripe_account;
    }
}
