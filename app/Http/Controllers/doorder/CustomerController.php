<?php

namespace App\Http\Controllers\doorder;

use App\DriverProfile;
use App\Http\Controllers\Controller;
use App\KPITimestamp;
use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function getCustomerOrderPage($customer_confirmation_code)
    {
        $order = Order::where('customer_confirmation_code', $customer_confirmation_code)->first();
        if (!$order) {
            abort(404);
        }
        $order_status = $order->status;
        if (in_array($order_status, ['pending', 'ready', 'assigned', 'matched', 'on_route_pickup', 'picked_up', 'on_route'])) {
            return redirect()->to('customer/tracking/' . $order->customer_confirmation_code);
        } elseif (in_array($order_status, ['delivery_arrived', 'delivered'])) {
            return redirect()->to('customer/delivery_confirmation/' . $order->customer_confirmation_code);
        }
        return abort(404);
    }

    public function getOrderTracking($customer_confirmation_code, Request $request)
    {
        $return_type = $request->get('return');
        $order = Order::where('customer_confirmation_code', $customer_confirmation_code)->first();
        if (!$order) {
            abort(404);
        }
        $order_status = $order->status;
        if ($order_status == 'delivery_arrived' || $order_status == 'delivered') {
            if ($return_type == 'json') {
                return response()->json(['redirect' => url('customer/delivery_confirmation/' . $order->customer_confirmation_code)]);
            }
            return redirect()->to('customer/delivery_confirmation/' . $order->customer_confirmation_code);
        }
        $no_tracking_status = ['pending', 'ready', 'assigned', 'matched', 'on_route_pickup', 'picked_up'];
        $show_tracking = (in_array($order_status, $no_tracking_status))? 'no' : 'yes';
        $message_to_customer = '';
        $retailer_name = $order->retailer_name;
        $driver_id = $order->driver;
        $order_id = $order->order_id;
        $driver_lat = '';
        $driver_lon = '';
        $latest_timestamp = '';
        if($driver_id != null) {
            $driver_profile = DriverProfile::where('user_id', '=', $driver_id)->first();
            if ($driver_profile) {
                $driver_coordinates = json_decode($driver_profile->latest_coordinates);
                $driver_lat = $driver_coordinates->lat;
                $driver_lon = $driver_coordinates->lng;
                $coordinates_updated_at = new Carbon($driver_profile->coordinates_updated_at);
                $latest_timestamp = $coordinates_updated_at->format('H:i');
            }
        }
        if(in_array($order_status, ['pending', 'ready', 'assigned', 'matched', 'on_route_pickup'])){
            $message_to_customer = '<h3>We will be collecting your order shortly.</h3>'.
                '<h3>You will receive a text message when your order is collected. Please check back soon for further updates.</h3>';
        } elseif($order_status == 'picked_up') {
            $message_to_customer = '<h3>Your order has been collected and will be out for delivery soon.</h3>'.
                '<h3>You will receive a text message when our driver is on the way with a live tracking link.</h3>';
        }
        if ($return_type == 'json') {
            return response()->json([
                'redirect' => 0, 'order_id' => $order_id,
                'driver_lat' => $driver_lat, 'driver_lon' => $driver_lon,
                'latest_timestamp' => $latest_timestamp,
                'show_tracking' => $show_tracking,
                'message_to_customer' => $message_to_customer
            ]);
        }
        $customer_code = $customer_confirmation_code;
        return view('doorder.customers.order_tracking', compact(
            'order_id',
            'driver_lat',
            'driver_lon',
            'latest_timestamp',
            'customer_code',
            'retailer_name',
            'show_tracking',
            'message_to_customer'
        ));
    }

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

    public function postDeliveryConfirmationURL(Request $request)
    {
        $customer_confirmation_code = $request->customer_confirmation_code;
        $delivery_confirmation_code = $request->delivery_confirmation_code;
        $checkIfCodeExists = Order::where('customer_confirmation_code', $customer_confirmation_code)
            ->where('delivery_confirmation_code', $delivery_confirmation_code)->first();
        if (!$checkIfCodeExists) {
            alert()->error('The Delivery QR Code is not valid, Please try again.');
            return redirect()->back();
        }
        $timestamps = KPITimestamp::where('model', '=', 'order')
            ->where('model_id', '=', $checkIfCodeExists->id)->first();
        $current_timestamp = Carbon::now();
        $checkIfCodeExists->update([
            'delivery_confirmation_status' => 'confirmed',
            'status' => 'delivered',
            'driver_status' => 'delivered'
        ]);
        $timestamps->completed = $current_timestamp->toDateTimeString();
        $timestamps->save();

        \Redis::publish('doorder-channel', json_encode([
            'event' => "delivery-confirmation-order-id-$checkIfCodeExists->id" . '-' . env('APP_ENV', 'dev'),
            'data' => [
                'message' => 'Customer has confirmed the delivery successfully',
            ]
        ]));
        return redirect()->back();
    }
}
