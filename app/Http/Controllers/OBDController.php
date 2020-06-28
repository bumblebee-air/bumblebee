<?php

namespace App\Http\Controllers;

use App\OBDConnection;
use App\User;
use Illuminate\Http\Request;

class OBDController extends Controller
{
    public function saveAppOBDConnection(Request $request){
        $validator = Validator::make(
            $request->all(),
            [
                'customer_token' => 'required',
            ]
        );
        if ($validator->fails()) {
            return response()->json([
                "error" => 1,
                "message" => $validator->errors()
            ])->setStatusCode(422);
        }
        $customer_token = $request->get('customer_token');
        $customer = User::where('token',$customer_token)->first();
        if(!$customer){
            return response()->json([
                "error" => 1,
                "message" => 'No customer was found with this token!'
            ])->setStatusCode(422);
        }
        $obd_connection = new OBDConnection();
        $obd_connection->customer_id = $customer->id;
        $obd_connection->save();
        $response = [
            'error' => 0,
            'message' => 'The obd connection was saved successfully'
        ];
        return response()->json($response)->setStatusCode(200);
    }
}
