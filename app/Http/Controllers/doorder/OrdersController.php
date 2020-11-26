<?php

namespace App\Http\Controllers\doorder;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class OrdersController extends Controller
{
    public function getOrdersTable()
    {
        $orders = Order::paginate(20);
        foreach ($orders as $order) {
            $order->time = $order->created_at->format('h:i');
            $order->driver = $order->orderDriver ? $order->orderDriver->name : null;
        }
        return view('admin.doorder.orders', ['orders' => $orders]);
    }

    public function addNewOrder() {
        return view('admin.doorder.add_order');
    }
    public function saveNewOrder(Request $request) {
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'customer_phone' => 'required',
            'customer_address' => 'required',
            'customer_lat' => 'required',
            'customer_lon' => 'required',
            'pickup_address' => 'required',
            'fulfilment' => 'required',
            'deliver_by' => 'required',
            'fragile' => 'required',
        ]);

        $order = Order::create([
            'customer_name' => "$request->first_name $request->last_name",
            'order_id' => random_int(000001, 999999),
            'customer_email' => $request->email,
            'customer_phone' => $request->customer_phone,
            'customer_address' => $request->customer_address,
            'customer_address_lat' => $request->customer_lat,
            'customer_address_lon' => $request->customer_lon,
            'eircode' => $request->eircode,
            'pickup_address' => $request->pickup_address,
            'fulfilment' => $request->fulfilment,
            'notes' => $request->notes,
            'deliver_by' => $request->deliver_by,
            'fragile' => $request->fragile,
            'retailer_name' => auth()->user()->name,
        ]);

        Redis::publish('doorder-channel', json_encode([
            'event' => 'new-order',
            'data' => [
                'id' => $order->id,
                'time' => $order->created_at->format('h:i'),
                'order_id' => $order->order_id,
                'retailer_name' => $order->retailer_name,
                'status' => $order->status,
                'driver' => $order->orderDriver ? $order->orderDriver->name : 'N/A',
                'pickup_address' => $order->pickup_address,
                'customer_address' => $order->customer_address,
                'created_at' => $order->created_at,
            ]
        ]));
        alert()->success( 'Your order saved successfully');
        return redirect()->back();
    }
}
