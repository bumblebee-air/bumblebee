<?php

namespace App\Http\Controllers;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;

class LookUpController extends Controller
{
    public function getVehicleDetails($vehicle_reg){
        $url = 'https://api.autodata-group.com/docs/v1/vehicles?id='.$vehicle_reg.'&method=uk_vrm&country-code=gb&api_key=19243ffqqcioyjfakpxfbtvn';
        $curl = curl_init();
        curl_setopt_array($curl, array(
            // CURLOPT_SSL_VERIFYPEER => false,
            // CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPHEADER => ['Content-type: application/json', 'Accept-Language: en-gb;q=0.8,en;q=0.7'],
            CURLOPT_URL => $url,
            // CURLOPT_POST => 1,
        ));
        $resp = curl_exec($curl);
        curl_close($curl);

        return $resp;
    }
}