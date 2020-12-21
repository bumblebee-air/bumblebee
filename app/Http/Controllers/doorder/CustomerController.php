<?php

namespace App\Http\Controllers\doorder;

use App\Http\Controllers\Controller;
use App\KPITimestamp;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getDeliveryConfirmationURL($customer_confirmation_code)
    {
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
        $timestamps = KPITimestamp::where('model','=','order')
            ->where('model_id','=',$checkIfCodeExists->id)->first();
        $current_timestamp = Carbon::now();
        $checkIfCodeExists->update([
            'delivery_confirmation_status' => 'confirmed',
            'status' => 'delivered',
            'driver_status' => 'delivered'
        ]);
        $timestamps->completed = $current_timestamp->toDateTimeString();
        $timestamps->save();

        \Redis::publish('doorder-channel', json_encode([
            'event' => "delivery-confirmation-order-id-$checkIfCodeExists->id",
            'data' => [
                'message' => 'Customer has confirmed the delivery successfully',
            ]
        ]));
        return redirect()->back();
    }
}
