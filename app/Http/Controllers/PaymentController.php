<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class PaymentController extends Controller
{
    public function getCustomerPayment(){
        return view('customer.customer_payment');
    }

    public function setCustomCustomerPaymentAmount(Request $request){
        \Stripe\Stripe::setApiKey('sk_test_51Gj8Y3JlWhNAY9mY1HeEzlGSk9w7GTxI2lSNH7ONp1tRV9t93BHT5wjvctrbjWErtrqZkCiy3TxRBDCAxRfUiKcI00Mtx6mSJ2');
        $amount = $request->get('amount');
        $amount = floatval($amount);
        $payment_intent = \Stripe\PaymentIntent::create([
            'payment_method_types' => ['card'],
            'amount' => $amount*100,
            'currency' => 'eur',
            'application_fee_amount' => $amount*10,
            'transfer_data' => [
                'destination' => 'acct_1H6cxdDEnaX8ijhf',
            ],
        ]);
        return json_encode(['client_secret' => $payment_intent->client_secret]);
    }

    public function processCustomerPayment(Request $request){
        dd($request->all());
    }
}