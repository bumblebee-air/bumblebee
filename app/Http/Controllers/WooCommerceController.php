<?php

namespace App\Http\Controllers;

use App\Order;
use App\Retailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class WooCommerceController extends Controller
{
    public function receiveOrder(Request $request){
        \Log::debug("WooCommerce incoming order with details: " . json_encode($request->all()));
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
            $aWebhook["customer_address_lat"] = $orders['shipping_address_latitude'];
            $aWebhook["customer_address_lon"] = $orders['shipping_address_longitude'];
            $aWebhook["eircode"] = $orders['zip'];

            try {
                $order_id = $aWebhook['order_id'] ?? null;
                $description = $aWebhook['description'] ?? null;
                $weight = $aWebhook['weight'] ?? null;
                $dimensions = $aWebhook['dimensions'] ?? null;
                $paid = $aWebhook['paid'] ?? null;
                $notes = $aWebhook['notes'] ?? null;
                $retailer_name = $aWebhook['retailer_name'] ?? null;
                $pickup_address = $aWebhook['pickup_address'] ?? null;
                $pickup_lat = $aWebhook['pickup_lat'] ?? null;
                $pickup_lon = $aWebhook['pickup_lon'] ?? null;
                $customer_name = $aWebhook['customer_name'] ?? null;
                $customer_phone = $aWebhook['customer_phone'] ?? null;
                $customer_email = $aWebhook['customer_email'] ?? null;
                $customer_address = $aWebhook['customer_address'] ?? null;
                $customer_address_lat = $aWebhook['customer_address_lat'] ?? null;
                $customer_address_lon = $aWebhook['customer_address_lon'] ?? null;
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
                \Log::error('Error in saving WooCommerce order. Details: '.$exception->getMessage());
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
        \Log::debug("WooCommerce order fulfillment with details: " . json_encode($request->all()));
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
}
