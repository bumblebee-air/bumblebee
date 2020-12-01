<?php

namespace App\Http\Controllers;

use App\AudioTextTranscript;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use User;
use Storage;
use File;

class OrdersController extends Controller
{

    public function index() {
		$user = null;
		$orders = null;
        $url="https://83d6f59b19d8e99f79ed0e765c841a28:0b59636651c5dba9f8a09428d5a18466@henshestore.myshopify.com/admin/api/2020-10/orders.json?limit=250";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,            $url );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: application/json')); 

		$result=curl_exec ($ch);
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
		}
		$data = json_decode($result, true);
		//dd($data);die;
		foreach($data['orders'] as $key => $order){
			$orders[$key]['from'] = $order['billing_address']['name'].", ".$order['billing_address']['address1'].", ".$order['billing_address']['address2'].", ".$order['billing_address']['city'].", ".$order['billing_address']['province'].", ".$order['billing_address']['country'].", ".$order['billing_address']['zip'];
			$orders[$key]['to'] = $order['billing_address']['name'].", ".$order['billing_address']['address1'].", ".$order['billing_address']['address2'].", ".$order['billing_address']['city'].", ".$order['billing_address']['province'].", ".$order['billing_address']['country'].", ".$order['billing_address']['zip'];
			$orders[$key]['orderno'] = $order['order_number'];
		}
		return view('orders', ['user'=> $user,'orders'=> $orders]);
    }

    public function receiveOrder(Request $request){
        try {
            $order_id = $request->get('order_id');
            $description = $request->get('description');
            $weight = $request->get('weight');
            $dimensions = $request->get('dimensions');
            $paid = $request->get('paid');
            $notes = $request->get('notes');
            $retailer_name = $request->get('retailer_name');
            $pickup_address = $request->get('pickup_address');
            $pickup_lat = $request->get('pickup_lat');
            $pickup_lon = $request->get('pickup_lon');
            $customer_name = $request->get('customer_name');
            $customer_phone = $request->get('customer_phone');
            $customer_email = $request->get('customer_email');
            $customer_address = $request->get('customer_address');
            $customer_address_lat = $request->get('customer_address_lat');
            $customer_address_lon = $request->get('customer_address_lon');
            $status = 'pending';

            $order = new Order();
            $order->order_id = $order_id;
            $order->description = $description;
            $order->weight = $weight;
            $order->dimensions = $dimensions;
            $order->notes = $notes;
            $order->retailer_name = $retailer_name;
            $order->pickup_address = $pickup_address;
            $order->pickup_lat = $pickup_lat;
            $order->pickup_lon = $pickup_lon;
            $order->customer_name = $customer_name;
            $order->customer_phone = $customer_phone;
            $order->customer_email = $customer_email;
            $order->customer_address = $customer_address;
            $order->customer_address_lat = $customer_address_lat;
            $order->customer_address_lon = $customer_address_lon;
            $order->status = $status;
            $order->ericode = '12345';
            $order->save();
        } catch (\Exception $exception){
            $response = [
                'message' => 'Error in saving the order. Details: '.$exception->getMessage()
            ];
            return response()->json($response)->setStatusCode(500);
        }
        $response = [
            'message' => 'Order saved successfully'
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function fulfillOrder(Request $request){
        $order_id = $request->get('order_id');

        $order = Order::where('order_id','=',$order_id)->first();
        if(!$order){
            $response = [
                'message' => 'Error! No order was found with this order ID'
            ];
            return response()->json($response)->setStatusCode(500);
        }
        $order->status = 'ready';
        $order->save();
        $response = [
            'message' => 'Order\'s status updated to fulfilled successfully'
        ];
        return response()->json($response)->setStatusCode(200);
    }
}
