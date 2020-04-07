<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecurityPin;
use Validator;

class SecurityController extends Controller
{
    public function customerIdentification(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'customer_pin' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                "error" => 1,
                "message" => $validator->errors()
            ])->setStatusCode(422);
        }

        $pin = SecurityPin::where('security_pin', $request->customer_pin)->first();

        if (!empty($pin)) {
            $expires_at = strtotime($pin->expires_at);
            if ($expires_at > time()) {
                $response = [
                    'customer_id' => $pin->user_id,
                    'message' => '',
                    'error' => 0
                ];
                return response()->json($response)->setStatusCode(200);
            }
        }

        $response = [
            'customer_id' => NULL,
            'error' => 1,
            'message' => 'Invalid security pin'
        ];

        return response()->json($response)->setStatusCode(200);
    }
}
