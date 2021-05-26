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
            Log::error($e->getMessage());
            return null;
        }
    }

    public static function capturePaymentIntent($intent_id, $amount = null) {
        try {
            $options = [];
            if ($amount > 0 && $amount != null) {
                $options = [
                    'amount_to_capture' => $amount * 100
                ];
            }
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $payment_intent_capture = $stripe->paymentIntents->capture($intent_id, $options);
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
            Log::error($e->getMessage());
            return false;
        }
    }

    public static function createCustomer($name, $email, $stripeToken):string {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $stripe_customer = $stripe->customers->create([
                'name' => $name,
                'email' => $email,
                'source' => $stripeToken
            ]);
            return $stripe_customer->id;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return '';
        }
    }

    public static function createCustomerSubscription($customer_id, $price_id):string {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $subscription = $stripe->subscriptions->create([
                'customer' => $customer_id,
                'items' => [
                    ['price' => $price_id],
                ],
            ]);
            return $subscription->id;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return '';
        }
    }

    public static function transferPaymentToConnectedAccount($connected_account_id, $amount, $currency = 'eur'):string {
        try {
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $transfer = $stripe->transfers->create([
                'amount' => $amount * 100,
                'currency' => $currency,
                'destination' => $connected_account_id,
            ]);
            return $transfer->id;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return '';
        }
    }

    public static function getPercentageOfTotalPrice($total_price, $percentage) {
        return ($percentage / 100 ) * $total_price;
    }
}
