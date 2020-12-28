<?php

namespace App\Http\Controllers;

use App\Retailer;
use Illuminate\Http\Request;

class ShopifyController extends Controller
{
    public function receiveOrder(Request $request){
        $shop_domain = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];
        $retailer = Retailer::where('shopify_store_domain','=',$shop_domain)->first();
        if(!$retailer){
            \Log::error('Retailer not registered on the system, domain: '.$shop_domain);
            return response()->json(['error'=>1,'message'=>'Unregistered on platform']);
        }
        $shop = "https://" . $retailer->shopify_store_domain;
        $shopName = $retailer->shopify_store_domain;
        $api_key = $retailer->shopify_app_api_key;
        $password = $retailer->shopify_app_password;
        $app_secret = $retailer->shopify_app_secret;
        $admin_url = 'https://' . $api_key . ':' . $password . '@' . $shopName . '/admin/api/2020-10/shop.json';

        /*$myfile = fopen("dynamic.txt", "a");
        fwrite($myfile, $admin_url);
        fclose($myfile);*/

        $hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
        //$data = file_get_contents('php://input');
        $data = file_get_contents('php://input');

        $verified = $this->verify_webhook($data, $hmac_header, $app_secret);
        if(!$verified){
            \Log::error('Webhook not verified: ' . var_export($verified, true));
            return response()->json(['error'=>1,'message'=>'Unverified']);
        }
        /*var_export($verified);
        error_log('Webhook verified: ' . var_export($verified, true));*/
        /*$token = $password;
        $query = array(
            "Content-type" => "application/json" // Tell Shopify that we're expecting a response in JSON format
        );
        $webhook_data = array(
            'webhook' =>
                array(
                    'topic' => 'orders/create',
                    'address' => 'https://www.anasource.com/team3/webhook/webhook.php',
                    'format' => 'json'
                )
        );*/

        $webhook_content = NULL;
        // Get webhook content from the POST
        /*$webhook = fopen('php://input', 'rb');
        while (!feof($webhook)) {
            $webhook_content .= fread($webhook, 4096);
        }
        fclose($webhook);
        $orders = json_decode($webhook_content);*/
        $orders = $request->all();
        if (count($orders['shipping_lines']) > 0) {
            $aShippingLine = $orders['shipping_lines'][0];
            if (strtolower($aShippingLine->code) == "same day delivery" ||
                strtolower($aShippingLine->code) == "doorder") {
                $iLineItemsCount = count($orders['line_items']);

                $aWebhook = [];
                $aWebhook["order_id"] = $orders['name'];
                $aWebhook["note"] = $orders['note'];

                //description
                $aWebhook["description"] = "";
                $count = 0;
                $weightprd = 0;
                $total_weight = $orders['total_weight'];
                $currency = $orders['currency'];
                foreach ($orders['line_items'] as $line_item) {
                    $count++;
                    $weightprd = $line_item->grams / 1000;
                    $aWebhook["description"] .= $line_item->title . "|" . $weightprd . "kg" .
                        "|" . $line_item->price . " " . $currency;
                    if ($count != $iLineItemsCount) {
                        $aWebhook["description"] .= ",";
                    }
                }

                $total_weightprd = $total_weight / 1000;
                $aWebhook["weight"] = $total_weightprd . "kg";
                //Retailer Name & Pickup Address
                $curl = curl_init();
                $admin_url = $admin_url;
                curl_setopt_array($curl, [
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $admin_url,
                    CURLOPT_USERAGENT => 'Shopify API'
                ]);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                $shopJSONresponse = curl_exec($curl);
                $oShopData = json_decode($shopJSONresponse);
                //retailer name & address
                $aWebhook["retailer_name"] = $oShopData->shop->name;
                $aWebhook["pickup_address"] = $oShopData->shop->address1 . ", " .
                    $oShopData->shop->phone . ", " . $oShopData->shop->city . ", " .
                    $oShopData->shop->zip . ", " . $oShopData->shop->province . ", " .
                    $oShopData->shop->country;
                $aWebhook["pickup_lat"] = $oShopData->shop->latitude;
                $aWebhook["pickup_lon"] = $oShopData->shop->longitude;
                //customer name,details and address
                $aWebhook["customer_name"] = $orders['shipping_address']->first_name .
                    " " . $orders['shipping_address']->last_name;
                $aWebhook["customer_address"] = $orders['shipping_address']->address1 . ", " .
                    $orders['shipping_address']->phone . ", " .
                    $orders['shipping_address']->city . ", " .
                    $orders['shipping_address']->zip . ", " .
                    $orders['shipping_address']->province . ", " .
                    $orders['shipping_address']->country;
                $aWebhook["customer_phone"] = $orders['shipping_address']->phone;
                $aWebhook["customer_email"] = $orders['email'];
                $aWebhook["customer_address_lat"] = $orders['shipping_address']->latitude;
                $aWebhook["customer_address_lon"] = $orders['shipping_address']->longitude;

                /*$sWebhookJSON = json_encode($aWebhook);
                $sOrderAPIurl = "https://admin.doorder.eu/api/order";
                $ch2 = curl_init($sOrderAPIurl);
                curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
                curl_setopt($ch2, CURLOPT_POSTFIELDS, $sWebhookJSON);
                $result = curl_exec($ch2);
                $http_status = curl_getinfo($ch2, CURLINFO_HTTP_CODE);*/

                /*$webhookfile1 = fopen("webhookjsonstringDynamic.txt", "w");
                fwrite($webhookfile1, $sWebhookJSON);
                fclose($webhookfile1);

                $webhookfile2 = fopen("webhookOrderAPIHTTPStatusCodeDynamic.txt", "w");
                fwrite($webhookfile2, $http_status);
                fclose($webhookfile2);*/

            }
        }
        return response()->json(['error'=>0,'message'=>'Order received successfully']);
    }

    function verify_webhook($data, $hmac_header, $app_secret){
        $calculated_hmac = base64_encode(hash_hmac('sha256', $data, $app_secret, true));
        return hash_equals($hmac_header, $calculated_hmac);
    }
}
