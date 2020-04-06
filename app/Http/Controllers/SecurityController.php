<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SecurityPin;

class SecurityController extends Controller
{
    public function customerIdentification(Request $request)
    {
        $validator = $request->validate([
            'customer_pin' => 'required',
        ]);

        if (!$validator) {
            return response()->json(['errors' => $validator->errors()])->setStatusCode(422);
        }

        $pin = SecurityPin::where('security_pin', $request->customer_pin)->first();
        $expires_at = strtotime($pin->expires_at);

        if (!empty($pin) && $expires_at > time()) {
            $response = [
                'customer_id' => $pin->user_id,
                'message' => '',
                'error' => 0
            ];
        } else {
            $response = [
                'customer_id' => NULL,
                'error' => 1,
                'message' => 'Invalid security pin'
            ];
        }

        return response()->json($response)->setStatusCode(200);
    }
}
