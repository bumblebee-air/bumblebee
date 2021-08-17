<?php

namespace App\Http\Controllers;

use App\Order;
use App\Retailer;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BigCommerceController extends Controller
{
    private $api_path = 'https://api.bigcommerce.com/stores/';
    private $scope = 'order/*';
    private $api_webhook_version = 'v3';
    private $api_data_version = 'v2';

    public function receiveWebhookOrder(Request $request){
        $post_arr = $status_arr = [];
        $total_weight = $option_count = $product_count = 0;

        $webhook_content = NULL;
        $webhook = fopen('php://input' , 'rb');
        while (!feof($webhook)) {
            $webhook_content .= fread($webhook, 4096);
        }
        fclose($webhook);
        $orders = json_decode($webhook_content);
        $order_id = $orders->data->id;
        if(empty($order_id)){
            $order_id = 0;
        }
        $store_producer = $orders->producer;
        $store_hash = str_replace("stores/","",$store_producer);
        $action = $orders->scope;
        $action = str_replace("store/","",$action);
        if($action!='order/created' && $action!='order/updated' && $action!='order/statusUpdated'){
            return response()->json(['error'=>1,'message'=>'Irrelevant order status']);
        }
        $the_retailer = Retailer::where('api_key','=',$store_hash)->first();
        if(!$the_retailer){
            \Log::info('No retailer found with the BigCommerce store hash: '.$store_hash);
            return response()->json(['error'=>1,'message'=>'Unregistered on platform']);
        }
        $token = $the_retailer->api_secret;
        $url = $this->api_path.$store_hash.'/'.$this->api_data_version.'/orders/'.$order_id;
        $url_store = $this->api_path.$store_hash.'/'.$this->api_data_version.'/store';
        if($action=='order/created') {
            //GET STORE DATA
            $response_store = $this->curl_connection($token, $url_store, "GET");
            $response_store_array = json_decode($response_store, true);

            //GET ORDER DATA
            $response = $this->curl_connection($token, $url, "GET");
            $response_array = json_decode($response, true);

            //GET PRODUCT DATA
            $url_product = $url . '/products';
            $response_product = $this->curl_connection($token, $url_product, "GET");
            $response_product_array = json_decode($response_product, true);

            //GET SHIPPING ADDRESS
            $url_shipping = $url . '/shipping_addresses';
            $response_shipping = $this->curl_connection($token, $url_shipping, "GET");
            $response_shipping_array = json_decode($response_shipping, true);

            $store_id = $response_store_array['id'];
            $store_name = $response_store_array['name'];
            $store_address = $response_store_array['address'];
            $store_token = $token;
            $shipping_method = $response_shipping_array['0']['shipping_method']; // for dynamic shipping_method
            //$shipping_method = "doorder"; // or "same day" //static
            $notes = $response_array['customer_message'];
            $currency_code = $response_array['currency_code'];

            $product_lineitems_array = array();
            $product_count = count($response_product_array);

            for ($k = 0; $k < $product_count; $k++) {
                $option_count = count($response_product_array[$k]['product_options']);
                $option_array = array();
                $array_options = array();
                for ($j = 0; $j < $option_count; $j++) {
                    $option_array = array(
                        array(
                            'product_option_id' => $response_product_array[$k]['product_options'][$j]['product_option_id'],
                            'display_name' => $response_product_array[$k]['product_options'][$j]['display_name'],
                            'display_value' => $response_product_array[$k]['product_options'][$j]['display_value']
                        )
                    );
                    $array_options = array_merge($option_array, $array_options);
                }

                $product_array = array(array(
                    'product_id' => $response_product_array[$k]['product_id'],
                    'title' => $response_product_array[$k]['name'],
                    'quantity' => $response_product_array[$k]['quantity'],
                    'grams' => $response_product_array[$k]['weight'] * 1000,
                    'price' => $response_product_array[$k]['base_price'],
                    'base_cost_price' => $response_product_array[$k]['base_cost_price'],
                    'product_options' => $array_options
                ));

                if (empty($product_array[$k]['grams'])) {
                    $product_array[$k]['grams'] = 0;
                }

                $product_lineitems_array = array_merge($product_array, $product_lineitems_array);
                $total_weight += ($response_product_array[$k]['weight'] * 1000);
            }

            $product_lineitems_json = json_encode($product_lineitems_array);

            if (empty($total_weight)) {
                $total_weight = 0;
            }

            $customer_name = $response_array['billing_address']['first_name'] . ' ' . $response_array['billing_address']['last_name'];
            $customer_phone = $response_array['billing_address']['phone'];
            $customer_email = $response_array['billing_address']['email'];
            $customer_shipping_address = $response_shipping_array['0']['street_1'] . ', ' . $response_shipping_array['0']['street_2'] . ', ' . $response_shipping_array['0']['city'] . ', ' . $response_shipping_array['0']['state'] . ', ' . $response_shipping_array['0']['country'];
            $zip_code = $response_shipping_array['0']['zip'];

            $post_arr['store_name'] = $store_name;
            $post_arr['store_address'] = $store_address;
            $post_arr['api_key'] = $store_id;
            $post_arr['api_secret'] = $store_token;
            $post_arr['shipping_method_name'] = $shipping_method;
            $post_arr['order_id'] = $order_id;
            $post_arr['note'] = $notes;
            $post_arr['total_weight'] = $total_weight;
            $post_arr['currency'] = $currency_code;
            $post_arr['line_items'] = $product_lineitems_json;
            $post_arr['customer_name'] = $customer_name;
            $post_arr['customer_phone'] = $customer_phone;
            $post_arr['customer_email'] = $customer_email;
            $post_arr['shipping_address'] = $customer_shipping_address;
            $post_arr['zip'] = $zip_code;
            $post_arr['action'] = $action;
            //Send data to API
            $response_post = $this->curl_connection($token, url('api/bigcommerce/order'), "POST", $post_arr, $store_hash, $token);
        } elseif($action=='order/updated' || $action=='order/statusUpdated'){
            //GET ORDER DATA
            $response = $this->curl_connection($token, $url, "GET");
            $response_array = json_decode($response, true);
            $status_arr['store_name'] = 'N/A';
            $status_arr['api_key'] = $store_hash;
            $status_arr['api_secret'] = $token;
            $status_arr['order_id'] = $order_id;

            $order_status = strtolower($response_array['status']);
            if($order_status == 'awaiting shipment' || $order_status == 'awaiting pickup'){
                //Send data to API
                $response_status = $this->curl_connection($token, url('api/bigcommerce/fulfill-order'), "POST", $status_arr, $store_hash, $token);
            }
        }
        return response()->json(['error'=>0,'message'=>'Received successfully']);
    }

    public function receiveOrder(Request $request){
        \Log::debug("BigCommerce incoming order with details: " . json_encode($request->all()));
        $shop_name = $request->get('store_name');
        $shop_api_key = $request->get('api_key');
        $shop_api_secret = $request->get('api_secret');
        $retailer = Retailer::where('api_key','=',$shop_api_key)
            ->where('api_secret','=',$shop_api_secret)->first();
        if(!$retailer){
            \Log::error('Retailer not registered on the system, name: '.$shop_name);
            return response()->json(['error'=>1,'message'=>'Unregistered on platform']);
        }
        $retailer_id = $retailer->id;
        $retailer_locations = json_decode($retailer->locations_details, true);
        $retailer_first_location_coordinates = count($retailer_locations) > 0 ? $retailer_locations[0]['coordinates'] : null;
        if ($retailer_first_location_coordinates) {
            $retailer_first_location_coordinates = str_replace("lat", "\"lat\"", $retailer_first_location_coordinates);
            $retailer_first_location_coordinates = str_replace("lon", "\"lon\"", $retailer_first_location_coordinates);
            $retailer_first_location_coordinates = json_decode($retailer_first_location_coordinates, true);
        }
        $orders = $request->all();
        $shipping_method_name = $orders['shipping_method_name'];
        if(strpos(strtolower($shipping_method_name),"same day")!==false ||
            strpos(strtolower($shipping_method_name),"doorder")!==false) {
            $the_line_items = json_decode($orders['line_items']);
            $line_items_count = count($the_line_items);

            $aWebhook = [];
            $aWebhook["order_id"] = $orders['order_id'];
            $aWebhook["note"] = $orders['note'];

            //description
            $aWebhook["description"] = "";
            $count = 0;
            $total_weight = $orders['total_weight'];
            $currency = $orders['currency'];
            foreach ($the_line_items as $line_item) {
                $count++;
                $weightprd = $line_item->grams / 1000;
                $aWebhook["description"] .= $line_item->title . "|" . $weightprd . "kg" .
                    "|" . $line_item->price . " " . $currency;
                if ($count != $line_items_count) {
                    $aWebhook["description"] .= ",";
                }
            }

            $total_weightprd = $total_weight / 1000;
            $aWebhook["weight"] = $total_weightprd . "kg";
            //retailer name & address
            $aWebhook["retailer_name"] = $shop_name;
            $aWebhook["pickup_address"] = $orders['store_address'];
                /*$oShopData->shop->address1 . ", " .
                $oShopData->shop->city . ", " .
                $oShopData->shop->zip . ", " . $oShopData->shop->province . ", " .
                $oShopData->shop->country;*/
            //$oShopData->shop->phone . ", "
            $aWebhook["pickup_lat"] = $request->get('store_latitude');
            $aWebhook["pickup_lon"] = $request->get('store_longitude');
            //customer name,details and address
            $aWebhook["customer_name"] = $orders['customer_name'];
            $aWebhook["customer_address"] = $orders['shipping_address'];
                /*$orders['shipping_address']['address1'] . ", " .
                $orders['shipping_address']['city'] . ", " .
                $orders['shipping_address']['zip'] . ", " .
                $orders['shipping_address']['province'] . ", " .
                $orders['shipping_address']['country'];*/
            //$orders['shipping_address']['phone'] . ", "
            $aWebhook["customer_phone"] = $orders['customer_phone'];
            $aWebhook["customer_email"] = $orders['customer_email'];
            //$aWebhook["customer_address_lat"] = $orders['shipping_address_latitude'];
            //$aWebhook["customer_address_lon"] = $orders['shipping_address_longitude'];
            $aWebhook["eircode"] = $orders['zip'];

            try {
                $order_id = $aWebhook['order_id'] ?? null;
                $description = $aWebhook['description'] ?? null;
                $weight = $aWebhook['weight'] ?? null;
                $dimensions = $aWebhook['dimensions'] ?? null;
                $paid = $aWebhook['paid'] ?? null;
                $notes = $aWebhook['notes'] ?? null;
                $retailer_name = $aWebhook['retailer_name'] ?? null;
                $pickup_address = count($retailer_locations) > 0 ? $retailer_locations[0]['address'] : (isset($aWebhook['pickup_address'])? $aWebhook['pickup_address'] : null);
                $pickup_lat = $retailer_first_location_coordinates ? $retailer_first_location_coordinates['lat'] : (isset($aWebhook['pickup_lat'])? $aWebhook['pickup_lat'] : null);
                $pickup_lon = $retailer_first_location_coordinates ? $retailer_first_location_coordinates['lon'] : (isset($aWebhook['pickup_lon'])? $aWebhook['pickup_lon'] : null);
                $customer_name = $aWebhook['customer_name'] ?? null;
                $customer_phone = $aWebhook['customer_phone'] ?? null;
                $customer_email = $aWebhook['customer_email'] ?? null;
                $customer_address = $aWebhook['customer_address'] ?? null;
                $customer_address_coordinates = $this->getCustomerAddressCoordinates($customer_address);
                $customer_address_lat = $customer_address_coordinates['lat'];
                $customer_address_lon = $customer_address_coordinates['lng'];
                $eircode = $aWebhook['eircode'] ?? null;
                //$status = 'ready';
                $status = 'pending';

                $order = new Order();
                $order->order_id = $order_id;
                $order->description = $description;
                $order->weight = $weight;
                $order->dimensions = $dimensions;
                $order->notes = $notes;
                $order->retailer_name = $retailer_name;
                $order->retailer_id = $retailer_id;
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
                $order->eircode = $eircode;
                $order->fulfilment = 0;
                $order->save();
            } catch (\Exception $exception){
                $response = [
                    'message' => 'Error in saving the order. Details: '.$exception->getMessage()
                ];
                \Log::error('Error in saving BigCommerce order. Details: '.$exception->getMessage());
                return response()->json($response)->setStatusCode(500);
            }
            try {
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
            } catch (\Exception $exception){
                \Log::error('Publish Redis new order notification from external shop API failed');
            }
        }
        return response()->json(['error'=>0,'message'=>'Order received successfully']);
    }

    public function fulfillOrder(Request $request){
        \Log::debug("BigCommerce order fulfillment with details: " . json_encode($request->all()));
        $shop_name = $request->get('store_name');
        $shop_api_key = $request->get('api_key');
        $shop_api_secret = $request->get('api_secret');
        $retailer = Retailer::where('api_key','=',$shop_api_key)
            ->where('api_secret','=',$shop_api_secret)->first();
        if(!$retailer){
            \Log::error('Retailer not registered on the system, name: '.$shop_name);
            return response()->json(['error'=>1,'message'=>'Unregistered on platform']);
        }
        $retailer_id = $retailer->id;
        $order_id = $request->get('order_id');
        $order = Order::where('order_id',$order_id)
            ->where('retailer_id',$retailer_id)->first();
        if($order){
            $order->status = 'ready';
            $order->save();
        }
        return response()->json(['error'=>0,'message'=>'Order fulfillment received successfully']);
    }

    public function getCustomerAddressCoordinates($address):array {
        $coordinates = ['lat' => null, 'lng' => null];
        try {
            $query = http_build_query(['address' => $address, 'key' => env('GOOGLE_API_KEY', '')]);
            $url = "https://maps.googleapis.com/maps/api/geocode/json?$query";
            $response = Http::get($url);
            $response_body = json_decode($response->body(), true);
            if ($response->status() == 200) {
                if ($response_body['status'] == 'OK') {
                    $coordinates = $response_body['results'][0]['geometry']['location'];
                }
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        return $coordinates;
    }

    public function createBigCommerceWebhook(Request $request){
        $retailer_id = $request->get('retailer_id');
        $retailer = Retailer::find($retailer_id);
        if(!$retailer){
            return response()->json(['error_message'=>'No Retailer found with this ID'])->setStatusCode(403);
        }
        $store_id = $retailer->api_key;
        $token = $retailer->api_secret;
        $url = $this->api_path.$store_id.'/'.$this->api_webhook_version.'/hooks';
        $data_array=array(
            'scope'=>'store/'.$this->scope,
            'destination'=>url('api/bigcommerce/webhook-order'),
            'is_active'=> true
        );
        $response = $this->curl_connection($token, $url, "POST", $data_array);
        $result_array = json_decode($response, true);
        return response()->json($result_array);
    }

    public function listOrDeleteBigCommerceWebhook(Request $request){
        $retailer_id = $request->get('retailer_id');
        $webhook_id = $request->get('webhook_id');
        $method = $request->get('method');
        if(!$method){
            return response()->json(['error_message'=>'No provided method'])->setStatusCode(403);
        }
        $retailer = Retailer::find($retailer_id);
        if(!$retailer){
            return response()->json(['error_message'=>'No Retailer found with this ID'])->setStatusCode(403);
        }
        $store_id = $retailer->api_key;
        $token = $retailer->api_secret;
        $data_array = [];
        if(strtolower($method)=='delete') {
            if(!$webhook_id){
                return response()->json(['error_message'=>'No provided webhook ID'])->setStatusCode(403);
            }
            $url = $this->api_path . $store_id . '/' . $this->api_webhook_version . '/hooks/' . $webhook_id;
            $response = $this->curl_connection($token, $url, strtoupper($method),$data_array);
        } elseif(strtolower($method)=='get'){
            $data_array['limit'] = '10';
            $url = $this->api_path . $store_id . '/' . $this->api_webhook_version . '/hooks';
            $response = $this->curl_connection($token, $url, strtoupper($method),$data_array);
        } else {
            return response()->json(['error_message'=>'Method is invalid'])->setStatusCode(403);
        }
        $result_array = json_decode($response, true);
        return response()->json($result_array);
    }

    public function curl_connection($token='', $url='', $curl_type='', $array=[], $username='', $password=''){
        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Accept: application/json';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        if(empty($username) && empty($password)){
            $headers[] = "x-auth-token: $token";
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        else{
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_VERBOSE, 0);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $curl_type);
        if($curl_type = "POST"){
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($array));
        }
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
