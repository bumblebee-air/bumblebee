<?php

namespace App\Helpers;


use Illuminate\Support\Facades\Log;
use Twilio\Rest\Client;

class StripePaymentHelper
{
    public static function paymentIntent($amount, $stripe_customer_id, $currency = 'eur') {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $payment_intent = $stripe->paymentIntents->create([
                'amount' => $amount * 100,
                'currency' => $currency,
                'payment_method_types' => ['card'],
                'capture_method' => 'manual',
                'customer' => $stripe_customer_id,
                'description' => 'Customer payment intent'
            ]);
            return $payment_intent;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return null;
        }
    }
}
