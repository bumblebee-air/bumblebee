<?php

namespace App\Http\Controllers\doorder;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function getOrdersTable()
    {
        $orders = Order::paginate(20);
        return view('admin.doorder.orders', ['orders' => $orders]);
    }

    public function addNewOrder() {
        return view('admin.doorder.add_order');
    }
    public function saveNewOrder(Request $request) {
//        dd($request->all());
        $this->validate($request, [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'customer_phone' => 'required',
            'customer_address' => 'required',
            'customer_lat' => 'required',
            'customer_lon' => 'required',
            'eircode' => 'required',
            'pickup_address' => 'required',
            'fulfilment' => 'required',
            'deliver_by' => 'required',
            'fragile' => 'required',
        ]);

        Order::create([
            'customer_name' => "$request->first $request->last_name",
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
        return redirect()->back();
    }
}
