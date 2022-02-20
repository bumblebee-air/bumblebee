<?php

namespace App\Http\Controllers;

use App\Helpers\CustomNotificationHelper;
use App\Helpers\GoogleMapsHelper;
use App\Order;
use App\QrCode;
use App\Retailer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class SAPHybrisController extends Controller
{
    public function receiveOrder(Request $request){
        \Log::debug("SAP Hybris incoming order with details: " . json_encode($request->all()));
        $shop_name = $request->get('store_name');
        $shop_api_key = $request->get('api_key');
        //$shop_api_secret = $request->get('api_secret');
        $retailer = Retailer::where('api_key','=',$shop_api_key)->first();
        if(!$retailer){
            \Log::error('Retailer not registered on the system, name: '.$shop_name);
            return response()->json(['error'=>1,'message'=>'Unregistered on platform']);
        }
        $retailer_id = $retailer->id;
        $retailer_locations = json_decode($retailer->locations_details, true);

        $order_data = $request->all();
        $shipping_method_name = $order_data['shipping_method_name'];
        if(strpos(strtolower($shipping_method_name),"same day")!==false ||
            strpos(strtolower($shipping_method_name),"doorder")!==false) {
            $the_line_items = json_decode($order_data['line_items']);
            $line_items_count = count($the_line_items);

            $aWebhook = [];
            $aWebhook["order_id"] = $order_data['order_id'];
            $aWebhook["notes"] = $order_data['notes'];

            //description
            $aWebhook["description"] = "";
            $count = 0;
            $total_weight = $order_data['total_weight'];
            $currency = $order_data['currency'];
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
            $aWebhook["pickup_address"] = $order_data['store_address'] ?? '';
                /*$oShopData->shop->address1 . ", " .
                $oShopData->shop->city . ", " .
                $oShopData->shop->zip . ", " . $oShopData->shop->province . ", " .
                $oShopData->shop->country;*/
            //$oShopData->shop->phone . ", "
            $aWebhook["pickup_lat"] = $request->get('store_latitude');
            $aWebhook["pickup_lon"] = $request->get('store_longitude');
            //customer name,details and address
            $aWebhook["customer_name"] = $order_data['customer_name'];
            $aWebhook["customer_address"] = $order_data['shipping_address'];
                /*$orders['shipping_address']['address1'] . ", " .
                $orders['shipping_address']['city'] . ", " .
                $orders['shipping_address']['zip'] . ", " .
                $orders['shipping_address']['province'] . ", " .
                $orders['shipping_address']['country'];*/
            //$orders['shipping_address']['phone'] . ", "
            $aWebhook["customer_phone"] = $order_data['customer_phone'];
            $aWebhook["customer_email"] = $order_data['customer_email'] ?? null;
            $aWebhook["customer_address_lat"] = $order_data['shipping_address_latitude'] ?? null;
            $aWebhook["customer_address_lon"] = $order_data['shipping_address_longitude'] ?? null;
            $aWebhook["eircode"] = $order_data['zip_code'] ?? null;

            try {//Get the nearest retailer location to the customer location
                if($aWebhook["customer_address_lat"]!=null && $aWebhook["customer_address_lon"]!=null) {
                    $customer_address_coordinates = [
                        'lat' => $aWebhook["customer_address_lat"],
                        'lng' => $aWebhook["customer_address_lon"]
                    ];
                } else {
                    $customer_address_coordinates = $this->getCustomerAddressCoordinates($aWebhook['customer_address'] ?: null);
                }
                $the_nearest_location = GoogleMapsHelper::getTheNearestLocation($retailer_locations, ['lat' => $customer_address_coordinates['lat'], 'lon' => $customer_address_coordinates['lng']]);
                $the_nearest_location_coordinates = $the_nearest_location['coordinates'];
                if ($the_nearest_location_coordinates) {
                    $the_nearest_location_coordinates = str_replace("lat", "\"lat\"", $the_nearest_location_coordinates);
                    $the_nearest_location_coordinates = str_replace("lon", "\"lon\"", $the_nearest_location_coordinates);
                    $the_nearest_location_coordinates = json_decode($the_nearest_location_coordinates, true);
                }

                $order_id = $aWebhook['order_id'] ?? null;
                $description = $aWebhook['description'] ?? null;
                $weight = $aWebhook['weight'] ?? null;
                $dimensions = $aWebhook['dimensions'] ?? null;
                $paid = $aWebhook['paid'] ?? null;
                $notes = $aWebhook['notes'] ?? null;
                $retailer_name = $aWebhook['retailer_name'] ?? null;
                $pickup_address = count($the_nearest_location) > 0 ? $the_nearest_location['address'] : ($aWebhook['pickup_address'] ?? null);
                $pickup_lat = $the_nearest_location_coordinates ? $the_nearest_location_coordinates['lat'] : ($aWebhook['pickup_lat'] ?? null);
                $pickup_lon = $the_nearest_location_coordinates ? $the_nearest_location_coordinates['lon'] : ($aWebhook['pickup_lon'] ?? null);
                $customer_name = $aWebhook['customer_name'] ?? null;
                $customer_phone = $aWebhook['customer_phone'] ?? null;
                $customer_email = $aWebhook['customer_email'] ?? null;
                $customer_address = $aWebhook['customer_address'] ?? null;
                //$customer_address_coordinates = $this->getCustomerAddressCoordinates($customer_address);
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
                \Log::error('Error in saving SAP Hybris order. Details: '.$exception->getMessage());
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
                CustomNotificationHelper::send('new_order', $order->id);
            } catch (\Exception $exception){
                \Log::error('Publish Redis new order notification from external shop API failed');
            }
        }
        return response()->json(['error'=>0,'message'=>'Order received successfully']);
    }

    public function fulfillOrder(Request $request){
        \Log::debug("SAP Hybris order fulfillment with details: " . json_encode($request->all()));
        $shop_name = $request->get('store_name');
        $shop_api_key = $request->get('api_key');
        //$shop_api_secret = $request->get('api_secret');
        $label_urls = [];
        $tracking_url = null;
        $retailer = Retailer::where('api_key','=',$shop_api_key)->first();
        if(!$retailer){
            \Log::error('Retailer not registered on the system, name: '.$shop_name);
            return response()->json(['error'=>1,'message'=>'Unregistered on platform',
                'label_urls'=>$label_urls]);
        }
        $retailer_id = $retailer->id;
        $order_id = $request->get('order_id');
        $no_of_items = $request->get('no_of_items');
        $require_label = $request->get('require_label');
        $order = Order::where('order_id',$order_id)
            ->where('retailer_id',$retailer_id)->first();
        if($order){
            $order->status = 'ready';
            if($no_of_items!=null && intval($no_of_items)>0){
                $no_of_items = intval($no_of_items);
                $order->no_of_items = $no_of_items;
            }
            $order->label_qr_scan = ($require_label==1)? 1 : 0;
            $order->customer_confirmation_code = Str::random(8);
            $order->delivery_confirmation_code = Str::random(32);
            $order->save();
            if($require_label==1){
                try {
                    if($no_of_items<=0){
                        \Log::warning('QR code labels required for order: '.$order_id
                            .' but the number of items is not provided!');
                    }
                    for($i=0; $i<$no_of_items; $i++){
                        $code = new QrCode();
                        $code->model = 'order';
                        $code->model_id = $order->id;
                        $code->model_sub = 'label';
                        $code->code = Str::random(32);
                        $code->save();
                        $label_qr = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->generate($code->code);
                        $pdf = Pdf::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif',
                            'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true]);
                        //To use the generated svg qr code in the view
                        //<img src="data:image/svg+xml;base64,{{ base64_encode($qr_str) }}"/>
                        $pdf->loadView('admin.doorder.view_qr',[
                            'name' => 'Fayez test',
                            'order_number' => $order_id,
                            'qr_str' => $label_qr
                        ]);
                        $label_qr_file_name = 'uploads/pdfs/'.$code->code.'.pdf';
                        \Storage::put($label_qr_file_name, $pdf->output());
                        $label_urls[] = ['url'=>url('uploads/'.$label_qr_file_name),
                            'qr_code'=>$code->code];
                    }
                } catch (\Exception $exception){
                    \Log::error('Unable to create qr code label entries for order: '
                        .$order_id.' due to: '.$exception->getMessage());
                }
            }
            $tracking_url = url('customer/order/' . $order->customer_confirmation_code);
            CustomNotificationHelper::send('external_store_fulfillment', $order->id);
        }
        return response()->json(['error'=>0,'message'=>'Order fulfillment received successfully',
            'label_urls'=>$label_urls, 'tracking_url'=>$tracking_url]);
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
}
