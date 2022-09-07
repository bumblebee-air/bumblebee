<?php

namespace App\Http\Controllers;

use App\DriverProfile;
use App\Order;
use App\Retailer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    public function __construct()
    {
        $countries = [];
        $drivers_country = DriverProfile::all()->pluck('country')->toArray();
        $retailers = Retailer::all()->pluck('locations_details')->toArray();
        $retailer_country = Retailer::all()->map(function($item) {
            foreach (json_decode($item->locations_details) as $address){
                if(property_exists($address,'country')){
                   return $address->country;
                }
            }
        });
        $countries = collect($drivers_country)->merge($retailer_country)->flatten()->unique()->filter();
        View::share('countries', $countries);
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $unallowed_sms_alpha_codes = ['+91'];

    public static function sendFCM($user_tokens, $data, $message = null) {

        $url = 'https://fcm.googleapis.com/fcm/send';

        $fields = array (
            'registration_ids' => $user_tokens,
            'notification' => [
                'title' => $data['title'],
                'body' => $data['message'],
                'sound' => 'default',
                'badge' => '1'
            ],
            'data' => $data
        );
        $fields = json_encode($fields);

        $headers = array (
            'Authorization: key=' . env('FCM_KEY'),
            'Content-Type: application/json'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

        $result = curl_exec ( $ch );
        curl_close ( $ch );
    }

    public function checkPhoneInternationalFormat($phone_number,$format='+353'){
        if($phone_number == null) return $phone_number;
        //Replace spaces and hyphens if present
        $phone_number = str_replace(' ', '', $phone_number);
        $phone_number = str_replace('-', '', $phone_number);
        //Remove first 0 if present
        if (substr($phone_number, 0, 1) == '0') {
            $phone_number = substr($phone_number, 1);
        }
        //Add country code if not present
        if (substr($phone_number, 0, 4) != $format) {
            $phone_number = $format . $phone_number;
        }
        return $phone_number;
    }
}
