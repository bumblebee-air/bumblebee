<?php

namespace App\Http\Controllers\doorder;

use App\DriverProfile;
use App\Helpers\CustomNotificationHelper;
use App\Helpers\TwilioHelper;
use App\Imports\OrdersImport;
use App\JobComment;
use App\Order;
use App\Retailer;
use App\User;
use App\UserFirebaseToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Maatwebsite\Excel\Facades\Excel;
use Twilio\Rest\Client;

class OrdersController extends Controller
{
    public function getOrdersTable() {
        if (auth()->user()->user_role == 'retailer') {
            $orders = Order::where('retailer_id', auth()->user()->retailer_profile->id)->orderBy('id', 'desc')->paginate(20);
        } else {
            $orders = Order::where('is_archived', false)->where('status', '!=', 'delivered')->orderBy('id', 'desc')->paginate(20);
        }

        foreach ($orders as $order) {
            $order->time = $order->created_at->format('d M H:i');
            $order->driver = $order->orderDriver ? $order->orderDriver->name : null;
        }
        return view('admin.doorder.orders', ['orders' => $orders]);
    }

    public function addNewOrder() {
        $pickup_addresses = [];
        $user_profile = auth()->user()->retailer_profile;
        if ($user_profile) {
            $pickup_addresses = json_decode($user_profile->locations_details, true);
        }
        return view('admin.doorder.add_order', with(['pickup_addresses' => $pickup_addresses]));
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
            //'deliver_by' => 'required',
            'fragile' => 'required',
        ]);
        $current_user = auth()->user();
        $retailer_profile = $current_user->retailer_profile;
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
            'retailer_name' => ($retailer_profile!=null)? $retailer_profile->name : $current_user->name,
            'retailer_id' => ($retailer_profile!=null)? $retailer_profile->id : '0',
            'status' => 'ready',
            'weight' => $request->weight,
            'dimensions' => $request->dimensions,
        ]);

        Redis::publish('doorder-channel', json_encode([
            'event' => 'new-order'.'-'.env('APP_ENV','dev'),
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
        CustomNotificationHelper::send('new_order', $order->id);
        alert()->success( 'Your order saved successfully');
        return redirect()->back();
    }

    public function getSingleOrder($client_name, $id) {
        if (auth()->user()->user_role == 'retailer') {
            $order = Order::where('retailer_id', auth()->user()->retailer_profile->id)
                ->where('id', $id)->first();
        } else {
            $order = Order::find($id);
        }

        if(!$order){
            alert()->error( 'No order was found!');
            return redirect()->back();
        }
        //dd($order);
        $accepted_deliverers = DriverProfile::where('is_confirmed','=',1)->get();
       /*  $user_ids = [];
        foreach($accepted_deliverers as $deliverer){
            $user_ids[] = $deliverer->user_id;
        }
        //$available_drivers = User::where('user_role','=','driver')->get();
        $available_drivers = User::whereIn('id',$user_ids)->get(); */
        $customer_name = explode(' ',$order->customer_name);
        $first_name = $customer_name[0];
        $last_name = isset($customer_name[1])? $customer_name[1] : '';
        $order->first_name = $first_name;
        $order->last_name = $last_name;
        return view('admin.doorder.single_order', ['order' => $order,
            'available_drivers'=>$accepted_deliverers]);
    }

    public function assignDriverToOrder(Request $request){
        //dd($request->all());
        $order_id = $request->get('order_id');
        $selected_drivers = $request->get('selected-driver');
        $order = Order::find($order_id);
        //$send_to_all = $driver_id=='all';
        $driver = null;
        $driver_ids = [];
        $old_driver = null;
        if(!$order){
            alert()->error( 'No order was found!');
            return redirect()->back();
        }
        $drivers_count = count($selected_drivers);
        if($drivers_count<1){
            alert()->error( 'No drivers were selected!');
            return redirect()->back();
        }
        /*if(!$send_to_all) {
            $driver = User::where('id', '=', $driver_id)->where('user_role', '=', 'driver')->first();
            $old_driver = $order->orderDriver;
            if(!$driver) {
                alert()->error('This driver is invalid!');
                return redirect()->back();
            }
            $order->driver = $driver_id;
            $order->status = 'assigned';
            $order->driver_status = 'assigned';
            $order->save();
            $driver_ids[] = $driver_id;
        }
        if($send_to_all){
            //Get all accepted drivers
            $driver_ids = DriverProfile::where('is_confirmed','=',1)->get()->pluck('user_id')->toArray();
            $notification_message = "Order #$order->order_id has been added to the available orders list";
            $sms_message = "Hi, a new order #$order->order_id has been added to the available orders list";
        } else {
            $notification_message = "Order #$order->order_id has been assigned to you";
            $sms_message = "Hi $driver->name, there is an order assigned to you, please open your app. ".
                url('driver_app#/order-details/'.$order->id);
        }*/
        $notification_message = '';
        $sms_message = '';
        foreach($selected_drivers as $selected_driver){
            $driver = User::where('id', '=', $selected_driver)->where('user_role', '=', 'driver')->first();
            $old_driver = $order->orderDriver;
            if($drivers_count==1) {
                if(!$driver) {
                    alert()->error('This driver is invalid!');
                    return redirect()->back();
                }
                $order->driver = $selected_driver;
                $order->status = 'assigned';
                $order->driver_status = 'assigned';
                $order->save();
                $notification_message = "Order #$order->order_id has been assigned to you";
                $sms_message = "Hi $driver->name, there is an order assigned to you, please open your app. ".
                    url('driver_app#/order-details/'.$order->id);
            } else {
                $notification_message = "Order #$order->order_id has been added to the available orders list";
                $sms_message = "Hi, a new order #$order->order_id has been added to the available orders list";
                $order->status = 'ready';
                $order->driver = null;
                $order->driver_status = null;
                $order->save();
            }
            $driver_ids[] = $selected_driver;
        }
        //Send Assignment Notification
        $user_tokens = UserFirebaseToken::whereIn('user_id', $driver_ids)->get()->pluck('token')->toArray();
        if (count($user_tokens) > 0) {
            self::sendFCM($user_tokens,[
                'title' => 'Order assigned',
                'message' => $notification_message,
                'order_id' => $order->id
            ]);
        }
        //SMS Assignment Notification
        if($drivers_count>1){
            foreach($driver_ids as $an_id){
                $user_profile = User::find($an_id);
                if($user_profile){
                    TwilioHelper::sendSMS('DoOrder', $user_profile->phone, $sms_message);
                }
            }
            alert()->success("The accepted drivers have been notified about the order successfully");
        } else {
            TwilioHelper::sendSMS('DoOrder', $driver->phone, $sms_message);
            //Sending message to the old driver
            if ($old_driver) {
                TwilioHelper::sendSMS('DoOrder', $old_driver->phone, "Hi $old_driver->name, We need to inform you that the order #$order->order_id is no longer available.");
            }
            alert()->success("The order has been successfully assigned to $driver->name");
        }
        return redirect()->to('doorder/orders');
    }
    
    public function updateOrder(Request $request){
        $order_id = $request->get('order_id');
        $order_status = $request->get('order_status');
        $comment = $request->get('comment');
        $order = Order::find($order_id);
        if (!$order) {
            alert()->error('There is no order with this id.');
            return redirect()->back();
        }
        $order->status = $order_status;
        $order->driver_status = $order_status;
        if ($order_status == 'not_delivered') {
            $order->is_archived = true;
        }
        $order->save();
        if ($comment) {
            JobComment::create([
                'comment' => $comment,
                'job_id' => $order->id,
                'job_model' => 'App\Order',
                'user_id' => $request->user()->id
            ]);
        }
        alert()->success("The order has been updated successfully ");
        return redirect()->to('doorder/orders');
        
    }

    public function getOrdersHistoryTable(Request $request) {
        $orders = Order::query();
        $orders = $orders->where('is_archived', true);
        if ($request->has('from')) {
            $orders = $orders->whereDate('created_at', '>=', $request->from);
        }

        if ($request->has('to')) {
            $orders = $orders->whereDate('created_at', '<=', $request->to);
        }
        $orders = $orders->with('comments')->paginate(50);
        foreach ($orders as $order) {
            $order->time = $order->created_at->format('d M H:i');
            $order->driver = $order->orderDriver ? $order->orderDriver->name : null;
        }


        if ($request->has('export')) {
            //export
        } else {
            return view('admin.doorder.orders_history', ['orders' => $orders]);
        }
    }

    public function importOrders(){
        $pickup_addresses = [];
        $user_profile = auth()->user()->retailer_profile;
        if ($user_profile) {
            $pickup_addresses = json_decode($user_profile->locations_details, true);
        }
        return view('admin.doorder.upload_orders', ['pickup_addresses' => $pickup_addresses]);
    }
    
    public function postImportOrders(Request $request){
        $current_user = \Auth::user();
        $retailer_profile = Retailer::where('user_id','=',$current_user->id)->first();
        if(!$retailer_profile){
            alert()->error('No retailer profile found!');
            return redirect()->back();
        }
        $address = null;
        if ($request->address) {
            $address = json_decode($request->address, true);
        } else {
            $retailer_locations = json_decode($retailer_profile->locations_details, true);
            $address = $retailer_locations[0];
        }
        Excel::import(new OrdersImport($retailer_profile->id, $address), $request->file('orders-file'));
        alert()->success('The orders have been imported successfully');
        return redirect()->to('doorder/orders');
    }
    
    public function deleteOrder(Request $request)
    {
        $this->validate($request, [
            'orderId' => 'required|exists:orders,id'
        ]);
        Order::find($request->orderId)->delete();
        alert()->success('The order deleted successfully');
        return redirect()->to('doorder/orders');
    }
    
    public function printLabel($client_name, $id) {
        //dd("print label ". $id);
        $order = Order::find($id);
        
        return view('admin.doorder.print_label_order', ['order' => $order]);
    }
}
