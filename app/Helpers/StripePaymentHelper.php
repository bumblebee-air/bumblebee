<?php

namespace App\Helpers;


use App\Customer;
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
                'description' => 'Customer payment intent',
                'confirm' => true
            ]);
            return $payment_intent;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return null;
        }
    }

    public static function capturePaymentIntent($intent_id) {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $payment_intent_capture = $stripe->paymentIntents->capture($intent_id);
            return $payment_intent_capture;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public static function chargePayment($amount, $stripe_customer_id, $currency = 'eur') {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $charge = $stripe->charges->create([
                'amount' => $amount * 100,
                'currency' => $currency,
                'customer' => $stripe_customer_id,
                'description' => 'Customer charge creation'
            ]);
            return $charge;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return null;
        }
    }

    public static function cancelPaymentIntent($intent_id) {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $payment_cancelation = $stripe->paymentIntents->cancel($intent_id);
            return true;
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::error($e->getMessage());
            return false;
        }
    }
}
