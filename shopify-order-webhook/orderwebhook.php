<?php

define('SHOPIFY_APP_SECRET', '{{insert_app_secret_key_here}}');



function verify_webhook($data, $hmac_header)
{
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
  return hash_equals($hmac_header, $calculated_hmac);
}



$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$data = file_get_contents('php://input');
$verified = verify_webhook($data, $hmac_header);

$shop = "{{insert_shop_url_here}}";
$token = "{{insert_shop_token_here}}";
$query = array(
  "Content-type" => "application/json" 
);


$webhook_data = array(
  'webhook' =>
  array(
    'topic' => 'orders/create',
    'address' => 'https://www.anasource.com/team3/webhook/test.php',
    'format' => 'json'
  )
);


$webhook_content = NULL;

// Get webhook content from the POST
$webhook = fopen('php://input' , 'rb');
while (!feof($webhook)) {
  $webhook_content .= fread($webhook, 4096);
}
fclose($webhook);

$orders = json_decode($webhook_content);

if( count($orders->shipping_lines) > 0){

   $aShippingLine = $orders->shipping_lines[0];
   if( $aShippingLine->code == "Same Day Delivery"){

      $iLineItemsCount = count($orders->line_items);

      $aWebhook = [];
      $aWebhook["order_id"] = $orders->name;
      $aWebhook["note"] = $orders->note;

      //description
      $aWebhook["description"] = "";
      $count = 0;
      $weightprd = 0;
      foreach ($orders->line_items as $line_item) {

         $total_weight = $orders->total_weight;
         $currency = $orders->currency;

         $count++;
         $weightprd = $line_item->grams/1000;
         if($count!=$iLineItemsCount){
            $aWebhook["description"] .= $line_item->title."|".$weightprd."kg"."|".$line_item->price." ".$currency.",";
         }else{
            $aWebhook["description"] .= $line_item->title."|".$weightprd."kg"."|".$line_item->price." ".$currency;
         }
      }
      
      $total_weightprd = $total_weight/1000;
      $aWebhook["weight"] = $total_weightprd."kg";
      
      //Retailer Name & Pickup Address
      $curl = curl_init();
      
      $url = '{{insert_shopify_app_admin_api_url_here}}/admin/api/2020-10/shop.json';
      curl_setopt_array($curl, [
         CURLOPT_RETURNTRANSFER => 1,
         CURLOPT_URL => $url,
         CURLOPT_USERAGENT => 'Shopify API'
      ]);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
      $shopJSONresponse = curl_exec($curl);
      $oShopData = json_decode($shopJSONresponse);

      $aWebhook["retailer_name"] = $oShopData->shop->name;
      $aWebhook["pickup_address"] = $oShopData->shop->address1.", ".$oShopData->shop->phone.", ".$oShopData->shop->city.", ".$oShopData->shop->zip.", ".$oShopData->shop->province.", ".$oShopData->shop->country;

      //customer name & address
      $aWebhook["customer_name"] = $orders->shipping_address->first_name." ".$orders->shipping_address->last_name;
      $aWebhook["customer_address"] = $orders->shipping_address->address1.", ".$orders->shipping_address->phone.", ".$orders->shipping_address->city.", ".$orders->shipping_address->zip.", ".$orders->shipping_address->province.", ".$orders->shipping_address->country;
      $aWebhook["customer_phone"] = $orders->shipping_address->phone;
      $aWebhook["customer_email"] = $orders->email;
      $aWebhook["pickup_lat"] = $oShopData->shop->latitude;
      $aWebhook["pickup_lon"] = $oShopData->shop->longitude;
      $aWebhook["customer_address_lat"] = $orders->shipping_address->latitude;
      $aWebhook["customer_address_lon"] = $orders->shipping_address->longitude;


      $sWebhookJSON = json_encode($aWebhook);

      $sOrderAPIurl = "https://admin.doorder.eu/api/order";
      $ch2 = curl_init($sOrderAPIurl);
      curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "POST");
      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch2, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
      curl_setopt($ch2, CURLOPT_POSTFIELDS, $sWebhookJSON);
      $result = curl_exec($ch2);      
   }
}
?>