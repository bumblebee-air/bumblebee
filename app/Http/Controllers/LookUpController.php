<?php

namespace App\Http\Controllers;
use App\OBD;
use App\ObdToVehicle;
use App\Profile;
use App\User;
use App\Vehicle;
use Carbon\Carbon;
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

    public function getDtcInformation(Request $request){
        $dtc = $request->get('dtc');
        $current_user = Auth::user();
        if(!$current_user){
            return response()->json([
                'error' => 1,
                'error_bag' => ['response'=>'No user is currently logged in',
                    'error'=>'No user is currently logged in'],
                'dtc_info' => null
            ]);
        }
        $user_profile = $current_user->profile;
        $mid = $user_profile->vehicle_external_id;
        $url = 'https://api.autodata-group.com/docs/v1/vehicles/'.$mid.'/dtc/'.$dtc.'?country-code=gb&api_key=19243ffqqcioyjfakpxfbtvn';
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
            \Log::error('Autodata DTC info retrieval failed',[
                'Response'=>$resp,
                'Curl error'=>curl_error($curl),
                'Curl error no.'=>curl_errno($curl)]);
            return response()->json([
                'error' => 1,
                'error_bag' => ['response'=>$resp,
                    'error'=>curl_error($curl),
                    'error_no'=>curl_errno($curl)],
                'dtc_info' => null
            ]);
        }
        curl_close($curl);
        $dtc_info = json_decode($resp);
        $faults = $dtc_info->data->fault_locations;
        return response()->json([
            'error' => 0,
            'dtc_info' => $faults
        ]);
    }

    public function getDtcInformationStaticMid(Request $request){
        $dtc = $request->get('dtc');
        $url = 'https://api.autodata-group.com/docs/v1/vehicles/PEU17173/dtc/'.$dtc.'?country-code=gb&api_key=19243ffqqcioyjfakpxfbtvn';
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
            \Log::error('Autodata DTC info retrieval failed',[
                'Response'=>$resp,
                'Curl error'=>curl_error($curl),
                'Curl error no.'=>curl_errno($curl)]);
            return response()->json([
                'error' => 1,
                'error_bag' => ['response'=>$resp,
                    'error'=>curl_error($curl),
                    'error_no'=>curl_errno($curl)],
                'dtc_info' => null
            ]);
        }
        curl_close($curl);
        $dtc_info = json_decode($resp);
        $faults = $dtc_info->data->fault_locations;
        return response()->json([
            'error' => 0,
            'dtc_info' => $faults
        ]);
    }

    public function postGetVehicleByObd(Request $request){
        $obd_id = $request->get('obd_id');
        $the_obd = OBD::where('the_id','=',$obd_id)->first();
        if(!$the_obd){
            return \Response::json(['errr'=>'This OBD device is not registered on the system', 'vehicle'=>null]);
        }
        $obd_vehicle = ObdToVehicle::where('obd_id','=',$the_obd->id)->first();
        if(!$obd_vehicle){
            return \Response::json(['errr'=>'No vehicle is associated with this OBD device', 'vehicle'=>null]);
        }
        $vehicle = Vehicle::find($obd_vehicle->vehicle_id);
        return \Response::json(['errr'=>null, 'vehicle'=>$vehicle]);
    }

    public function checkObdToVehicleConnection(Request $request){
        $type = $request->get('type');
        $id = $request->get('id');
        $obd_to_vehicle = null;
        if($type=='obd'){
            $obd_to_vehicle = ObdToVehicle::where('obd_id','=',$id)->first();
        } elseif ($type=='vehicle'){
            $obd_to_vehicle = ObdToVehicle::where('vehicle_id','=',$id)->first();
        }
        if($obd_to_vehicle!=null){
            return \Response::json(['found'=>1, 'obd'=>$obd_to_vehicle->obd,
                'vehicle'=>$obd_to_vehicle->vehicle]);
        }
        return \Response::json(['found'=>0, 'obd'=>null,
            'vehicle'=>null]);
    }

    public function testSoap(){
        /*$options = ['trace'=>true, 'exceptions'=>true, 'location'=>'https://ecars.esb.ie/externalIncoming/services/StationInfoService',
            'uri'=> 'https://ecars.esb.ie/externalIncoming/services/StationInfoService/',
            'login' => 'cartow_user', 'password' => 'gHJS632pofn831fvQ'];
        $soap = new \SoapClient(null, $options);
        try {
            $current_time = Carbon::now()->setTimezone('UTC');
            $params = ['Timestamp' => $current_time->toDateTimeString()];
            dd($soap->__soapCall('GetChargingStationInfo',
                $params,
                ['soapaction' => 'https://ecars.esb.ie/externalIncoming/services/StationInfoService']));
        } catch (\Exception $e){
            dd($soap->__getLastResponse());
        }*/

        $options = ['trace'=>true, 'exceptions'=>true, 'location'=>'http://driivz.com/stationinfo/2016/05/',
            'uri'=> 'http://driivz.com/stationinfo/',
            'login' => 'cartow_user', 'password' => 'gHJS632pofn831fvQ'];
        $soap = new \SoapClient(null, $options);
        try {
            $current_time = Carbon::now()->setTimezone('UTC');
            //$params = ['Timestamp' => $current_time->toDateTimeString()];
            $params = [];
            dd($soap->__soapCall('getChargingStationInfoRequest',
                $params));
        } catch (\Exception $e){
            dd($e);
            dd($soap->__getLastResponse());
        }
        //$data = $soap->GetChargingStationInfo($params);
    }
}