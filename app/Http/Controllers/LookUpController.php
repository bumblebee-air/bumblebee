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
        $url = 'https://api.autodata-group.com/docs/v1/vehicles?id='.$vehicle_reg.'&method=ie_vrm&country-code=gb&api_key=19243ffqqcioyjfakpxfbtvn';
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
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        if ($status != 200) {
            \Log::error('Autodata vehicle info retrieval failed',[
                'Response'=>$resp,
                'Curl error'=>curl_error($curl),
                'Curl error no.'=>curl_errno($curl)]);
            return response()->json([
                'error' => 1,
                'error_bag' => ['response'=>$resp,
                    'error'=>curl_error($curl),
                    'error_no'=>curl_errno($curl)],
                'vehicle' => null
            ]);
            //die("Error: call to URL $url failed with status $status, response $resp, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }
        curl_close($curl);
        $the_vehicle = json_decode($resp);
        return response()->json([
            'error' => 0,
            'vehicle' => $the_vehicle->data[0]
        ]);
    }

    public function getDtcInformation($dtc){

    }
}