<?php


namespace App\Helpers;


use Twilio\Rest\Client;

class TwilioHelper
{
    /**
     * @param $from
     * @param $to
     * @param $body
     * @throws \Twilio\Exceptions\ConfigurationException
     * @throws \Twilio\Exceptions\TwilioException
     */
    public static function sendSMS($from, $to, $body) {
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $twilio = new Client($sid, $token);
        $twilio->messages->create($to,
            [
                "from" => $from,
                "body" => $body
            ]
        );
    }
}
