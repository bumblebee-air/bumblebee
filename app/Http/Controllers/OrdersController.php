<?php

namespace App\Http\Controllers;

use App\AudioTextTranscript;
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
}
