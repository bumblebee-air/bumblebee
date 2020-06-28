<?php

namespace App\Http\Controllers;

use App\User;
use App\WhatsappMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\SecurityPin;
use App\Helpers\SecurityHelper;
use Twilio\Rest\Client;
use SimpleXMLElement;
use Response;
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
                'customer_token' => NULL,
                "error" => 1,
                "message" => $validator->errors()
            ])->setStatusCode(422);
        }

        $pin = SecurityPin::where('security_pin', $request->customer_pin)->first();

        if (!empty($pin)) {
            $expires_at = strtotime($pin->expires_at);
            if ($expires_at > time()) {
                $user = User::find($pin->user_id);
                $security_helper = new SecurityHelper();
                $security_token = $security_helper->generateSecurityToken(32);
                $user->token = $security_token;
                $user->save();
                $response = [
                    'customer_token' => $security_token,
                    'message' => '',
                    'error' => 0
                ];
                return response()->json($response)->setStatusCode(200);
            }
        }

        $response = [
            'customer_token' => NULL,
            'error' => 1,
            'message' => 'Invalid security pin'
        ];

        return response()->json($response)->setStatusCode(200);
    }

    public function generateCustomerPin(Request $request){
        $customer_phone = $request->get('phone');
        if($customer_phone==null){
            $response = [
                'error' => 1,
                'message' => 'Customer\'s phone is required'
            ];
            return response()->json($response)->setStatusCode(422);
        }
        $customer = User::where('phone','=',$customer_phone)->first();
        if(!$customer){
            $response = [
                'error' => 1,
                'message' => 'No customer was found with this phone'
            ];
            return response()->json($response)->setStatusCode(422);
        }
        $customer_name = $customer->name;
        //Generate random security pin for customer
        $code = '';
        for ($i = 0; $i<6; $i++) {
            $code .= mt_rand(0,9);
        }
        $security_pin = new SecurityPin();
        $security_pin->user_id = $customer->id;
        $security_pin->security_pin = $code;
        $security_pin->expires_at = Carbon::now()->addHour()->toDateTimeString();
        $security_pin->save();
        //Send security pin to customer
        try {
            $sid    = env('TWILIO_SID', '');
            $token  = env('TWILIO_AUTH', '');
            $body = "Hi $customer_name, your Bumblebee AIR pin code is $code. You can use it to log in the app.";
            //"Hi, your security pin is $code"
            $twilio = new Client($sid, $token);
            $message = $twilio->messages->create('whatsapp:'.$customer_phone,
                ["from" => "whatsapp:+447445341335",
                    "body" => $body]
            );
            //dd($message);
            $whats = new WhatsappMessage();
            $whats->message = $body;
            $whats->from = 'Bumblebee ('.'+447445341335'.')';
            $whats->to = $customer_phone;
            $whats->user_id = $customer->id;
            $whats->status = $message->status;
            $whats->external_id = $message->sid;
            $whats->save();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $response = [
                'error' => 1,
                'message' => 'There was an error while sending the security pin to the customer'
            ];
            return response()->json($response)->setStatusCode(500);
        }
        $response = [
            'error' => 0,
            'message' => 'The security pin was sent to the customer successfully'
        ];
        return response()->json($response)->setStatusCode(200);
    }
}
