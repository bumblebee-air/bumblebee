<?php

namespace App\Http\Controllers\doorder;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getDeliveryConfirmationURL(Request $request)
    {
        $customer_confirmation_code = $request->customer_confirmation_code;
        if (!$customer_confirmation_code) {
            abort(404);
        }
        $checkIfCodeExists = Order::where('customer_confirmation_code', $customer_confirmation_code)->first();
        if (!$checkIfCodeExists) {
            abort(404);
        }
        return view('doorder.customers.confirm_delivery_order', ['order' => $checkIfCodeExists]);
    }

    public function postDeliveryConfirmationURL(Request $request) {
        $customer_confirmation_code = $request->customer_confirmation_code;
        $delivery_confirmation_code = $request->delivery_confirmation_code;
        $checkIfCodeExists = Order::where('customer_confirmation_code', $customer_confirmation_code)
            ->where('delivery_confirmation_code', $delivery_confirmation_code)->first();
        if (!$checkIfCodeExists) {
            alert()->error('The Delivery QR Code is not valid, Please try again.');
            return redirect()->back();
        }
        $checkIfCodeExists->update([
            'delivery_confirmation_status' => 'confirmed',
        ]);
        \Redis::publish('doorder-channel', json_encode([
            'event' => "delivery-confirmation-order-id-$checkIfCodeExists->id",
            'data' => [
                'message' => 'Customer has confirmed the delivery successfully',
            ]
        ]));
        return redirect()->back();
    }
}
