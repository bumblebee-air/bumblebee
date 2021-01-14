<?php

namespace App\Http\Controllers\doorder;

use App\Order;
use App\User;
use App\UserFirebaseToken;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Twilio\Rest\Client;

class OrdersController extends Controller
{
    public function getOrdersTable() {
        if (auth()->user()->role == 'retailer') {
            $orders = Order::where('retailer_id', auth()->user()->retailer_profile->id)->orderBy('id', 'desc')->paginate(20);
        } else {
            $orders = Order::orderBy('id', 'desc')->paginate(20);
        }

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
            'pickup_address' => ($request->pickup_address=='Other')? $request->pickup_address_alt : $request->pickup_address,
            'pickup_lat' => $request->pickup_lat,
            'pickup_lon' => $request->pickup_lon,
            'fulfilment' => $request->fulfilment,
            'notes' => $request->notes,
            'deliver_by' => $request->deliver_by,
            'fragile' => $request->fragile,
            'retailer_name' => auth()->user()->name,
            'retailer_id' => auth()->user()->id,
            'status' => 'ready',
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
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

    public function getSingleOrder($client_name, $id) {
        $order = Order::find($id);
        if(!$order){
            alert()->error( 'No order was found!');
            return redirect()->back();
        }
        //dd($order);
        $available_drivers = User::where('user_role','=','driver')->get();
        $customer_name = explode(' ',$order->customer_name);
        $first_name = $customer_name[0];
        $last_name = isset($customer_name[1])? $customer_name[1] : '';
        $order->first_name = $first_name;
        $order->last_name = $last_name;
        return view('admin.doorder.single_order', ['order' => $order,
            'available_drivers'=>$available_drivers]);
    }

    public function assignDriverToOrder(Request $request){
        $order_id = $request->get('order_id');
        $driver_id = $request->get('driver_id');
        $order = Order::find($order_id);
        $driver = User::where('id','=',$driver_id)->where('user_role','=','driver')->first();
        if(!$order){
            alert()->error( 'No order was found!');
            return redirect()->back();
        }
        if(!$driver){
            alert()->error( 'This driver is invalid!');
            return redirect()->back();
        }
        $order->driver = $driver_id;
        $order->status = 'assigned';
        $order->driver_status = 'assigned';
        $order->save();
        //Send Assignment Notification
        $user_tokens = UserFirebaseToken::where('user_id', $driver_id)->get()->pluck('token')->toArray();
        if (count($user_tokens) > 0) {
            self::sendFCM($user_tokens,[
                'title' => 'Order assigned',
                'message' => "Order #$order->order_id has been assigned to you",
                'order_id' => $order->id
            ]);
        }
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $twilio = new Client($sid, $token);
        $twilio->messages->create($driver->phone,
            [
                "from" => "DoOrder",
                "body" => "Hi $driver->name, there is an order assigned to you, please open your app. ".
                    url('driver_app#/order-details/'.$order->id)
            ]
        );
        alert()->success( "The order has been successfully assigned to $driver->name");
        return redirect()->to('doorder/orders');
    }
}
