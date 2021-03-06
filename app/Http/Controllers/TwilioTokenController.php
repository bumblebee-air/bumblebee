<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\ChatGrant;

class TwilioTokenController extends Controller
{
    public function generate(Request $request, AccessToken $accessToken, ChatGrant $chatGrant)
    {
        $appName = "TwilioChat";
        $deviceId = $request->input("device");
        $identity = $request->input("identity");

        $TWILIO_CHAT_SERVICE_SID = env('TWILIO_CHAT_SERVICE_SID','');

        $endpointId = $appName . ":" . $identity . ":" . $deviceId;

        $accessToken->setIdentity($identity);

        $chatGrant->setServiceSid($TWILIO_CHAT_SERVICE_SID);
        $chatGrant->setEndpointId($endpointId);

        $accessToken->addGrant($chatGrant);

        $response = array(
            'identity' => $identity,
            'token' => $accessToken->toJWT()
        );

        return response()->json($response);
    }
}