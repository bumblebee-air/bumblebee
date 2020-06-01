<?php

namespace App\Http\Controllers;

use App\OBDConnection;
use Illuminate\Http\Request;

class OBDController extends Controller
{
    public function saveAppOBDConnection(Request $request){
        $customer_id = $request->get('customer_id');
        $obd_connection = new OBDConnection();
        $obd_connection->customer_id = $customer_id;
        $obd_connection->save();
        $response = [
            'error' => 0,
            'message' => 'The obd connection was saved successfully'
        ];
        return response()->json($response)->setStatusCode(200);
    }
}
