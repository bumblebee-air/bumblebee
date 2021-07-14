<?php

namespace App\Imports;

use App\Order;
use App\Retailer;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToCollection,WithHeadingRow {
    public $retailer_id = null;
    public function  __construct($retailer_id) {
        $this->retailer_id = $retailer_id;
    }

    public function collection(Collection $collection) {
        foreach($collection as $row){
//            dd($row);
            $scheduled_date = $row['scheduled_date'];
            $scheduled_time = $row['scheduled_time'];
            $rescheduled_datetime = $row['rescheduled_datetime'];
            $customer_address = $row['destination'];
            $customer_address_coordinates = $this->getCustomerAddressCoordinates($customer_address);
            $customer_lat = $customer_address_coordinates['lat'];
            $customer_lon = $customer_address_coordinates['lng'];
            $menu = $row['menu'];
            $order_number = $row['order_number'];
            $customer_name = $row['customer'];
            $customer_phone = $this->parsingPhoneNumber($row['phone']);
            $customer_email = $row['email'];
            $message = $row['message'];
            $items = $row['items'];
            $total_price = $row['total_price'];
            $fulfilled_time = $this->calcFulfillTime($rescheduled_datetime?:  $scheduled_date . ", ". $scheduled_time);
            if($customer_address=='' && $order_number=='' && $customer_name==''){
                continue;
            }
            //Add new order
            $retailer_profile = Retailer::find($this->retailer_id);
            $retailer_locations = json_decode($retailer_profile->locations_details);
            $retailer_main_location = $retailer_locations[0];
            $retailer_main_location->coordinates = str_replace('lat','"lat"',$retailer_main_location->coordinates);
            $retailer_main_location->coordinates = str_replace('lon','"lon"',$retailer_main_location->coordinates);
            $retailer_main_location_coordinates = json_decode($retailer_main_location->coordinates);
            $order = Order::create([
                'customer_name' => $customer_name,
                'order_id' => $order_number,
                'customer_email' => $customer_email,
                'customer_phone' => $customer_phone,
                'customer_address' => $customer_address,
                'customer_address_lat' => $customer_lat,
                'customer_address_lon' => $customer_lon,
                'eircode' => 'N/A',
                'pickup_address' => $retailer_main_location->address,
                'pickup_lat' => $retailer_main_location_coordinates->lat,
                'pickup_lon' => $retailer_main_location_coordinates->lon,
                'fulfilment' => $fulfilled_time?? null,
                'notes' => $items . " \n " . $message,
                'deliver_by' => 'N/A',
                'fragile' => 0,
                'retailer_name' => $retailer_profile->name,
                'retailer_id' => $retailer_profile->id,
                'status' => 'ready',
                'weight' => 'N/A',
                'dimensions' => 'N/A',
            ]);
        }
    }

    public function headingRow(): int {
        return 1;
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
            Log::error($e->getMessage());
        }
        return $coordinates;
    }

    public function parsingPhoneNumber($phone):string {
        if ($phone) {
            //Check if phone start with 0
            if (substr($phone, 0, 1) == '0') {
                $phone = substr($phone, 1);
            }
            //Check if phone start with country code
            if (substr($phone, 0, 4) != '+353') {
                $phone = "+353$phone";
            }
            //Return and replacing all spaces
            return str_replace(' ', '', $phone);
        }
        return '';
    }

    public function calcFulfillTime($date_time):int {
        $fulfillment_time = 0;
        $parsed_date_time = Carbon::createFromFormat('d M Y, H:ia e', $date_time);
        $now = Carbon::now();
        if ($parsed_date_time->getTimestamp() > $now->getTimestamp()) {
            $fulfillment_time = $parsed_date_time->diffInMinutes($now);
        }
        return $fulfillment_time;
    }
}
