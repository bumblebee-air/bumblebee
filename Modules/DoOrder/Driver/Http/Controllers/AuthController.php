<?php

namespace Modules\DoOrder\Driver\Controllers;

use App\Contractor;
use App\DriverProfile;
use App\GeneralSetting;
use App\Helpers\CustomNotificationHelper;
use App\Helpers\SecurityHelper;
use App\Helpers\TwilioHelper;
use App\KPITimestamp;
use App\Managers\StripeManager;
use App\Order;
use App\Retailer;
use App\User;
use App\UserClient;
use App\UserFirebaseToken;
use App\UserPasswordReset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Modules\Admin\User\Http\Requests\LoginRequest;
use Modules\DoOrder\Driver\Http\Requests\RegistrRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Twilio\Rest\Client;

class AuthController extends Controller
{
    public function driversLogin(LoginRequest $request)
    {
        $data = $request->only(['phone', 'password']);
        if (!$user = \Auth::attempt($data)) {
            return response()->json(['message' => 'Incorrect phone or password'])->setStatusCode(401);
        }
        if ($request->firebase_token) {
            //Check if token registered before with another user and delete them
            UserFirebaseToken::where('token', $request->firebase_token)->where('user_id', '!=', $user->id)->delete();
            //Check if token registered with the same user
            UserFirebaseToken::firstOrCreate(['token'=> $request->firebase_token,'user_id'=> $user->id],['token'=> $request->firebase_token,'user_id'=> $user->id])->where()->first();
        }
        $access_token = $user->createToken('PAT');
        $response = [
            'access_token' => $access_token->accessToken,
            'token_type' => 'Bearer ',
            'user_name' => $user->name,
            'is_profile_completed' => $user->is_profile_completed,
            'message' => 'Login successful',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function registration()
    {
        return view('doorder.drivers.registration');
    }

    public function postRegistration(RegistrRequest $request)
    {
        try {
            $request_url = $request->url();
            
            if (strpos($request_url, 'api/') !== false) {
                $response = [
                    'message' => 'Your profile has been registered successfully, the administration will review your request soon',
                    'error' => 0
                ];
            return response()->json($response);
            } else {
                alert()->success('Your profile has been registered successfully, the administration will review your request soon');
            }
        } catch (\Exception $exception) {
            $response = [
                'message' => $exception->getMessage(),
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
        return redirect()->back();
    }

    public function getDriverRegistrationRequests()
    {
        $drivers_requests = DriverProfile::with('user')
            ->orderBy('created_at', 'desc')->paginate(20);
        //->where('is_confirmed', false)->whereNull('rejection_reason')
        return view('admin.doorder.drivers.requests', ['drivers_requests' => $drivers_requests]);
    }
    public function sendForgotPasswordCode(Request $request)
    {
        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            //Check if deliverer profile has been completed
            $driver_profile = DriverProfile::where('user_id', '=', $checkIfUserExists->id)->first();
            if (!$driver_profile) {
                $response = [
                    'access_token' => '',
                    'message' => 'No driver profile was found',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            if ($driver_profile->is_confirmed != true) {
                $response = [
                    'access_token' => '',
                    'message' => 'Driver profile has not been accepted yet',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            //$resetPasswordCode = Str::random(6);
            $rand_code = rand(100000, 999999);
            $resetPasswordCode = strval($rand_code);
            try {
                $sid = env('TWILIO_SID', '');
                $token = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $sender_name = "DoOrder";
                foreach ($this->unallowed_sms_alpha_codes as $country_code) {
                    if (strpos($checkIfUserExists->phone, $country_code) !== false) {
                        $sender_name = env('TWILIO_NUMBER', 'DoOrder');
                    }
                }
                $twilio->messages->create(
                    $checkIfUserExists->phone,
                    [
                        "from" => $sender_name,
                        "body" => "Hi $checkIfUserExists->name, this message has been sent upon a reset password request.\n" .
                            "This is your reset password code: " . $resetPasswordCode
                    ]
                );
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
            }

            UserPasswordReset::create([
                'user_id' => $checkIfUserExists->id,
                'code' => $resetPasswordCode
            ]);
            $response = [
                'access_token' => '',
                'message' => 'Please enter the reset password code.',
                'error' => 0
            ];
            return response()->json($response);
        } else {
            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
    }

    public function sendGHForgotPasswordCode(Request $request)
    {
        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            //Check if deliverer profile has been completed
            $driver_profile = Contractor::where('user_id', '=', $checkIfUserExists->id)->first();
            if (!$driver_profile) {
                $response = [
                    'access_token' => '',
                    'message' => 'No contractor profile was found',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            if ($driver_profile->status != "completed") {
                $response = [
                    'access_token' => '',
                    'message' => 'Contractor profile has not been accepted yet',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            //$resetPasswordCode = Str::random(6);
            $rand_code = rand(100000, 999999);
            $resetPasswordCode = strval($rand_code);
            try {
                $sid = env('TWILIO_SID', '');
                $token = env('TWILIO_AUTH', '');
                $twilio = new Client($sid, $token);
                $sender_name = "GardenHelp";
                foreach ($this->unallowed_sms_alpha_codes as $country_code) {
                    if (strpos($checkIfUserExists->phone, $country_code) !== false) {
                        $sender_name = env('TWILIO_NUMBER', 'DoOrder');
                    }
                }
                $twilio->messages->create(
                    $checkIfUserExists->phone,
                    [
                        "from" => $sender_name,
                        "body" => "Hi $checkIfUserExists->name, this message has been sent upon a reset password request.\n" .
                            "This is your reset password code: " . $resetPasswordCode
                    ]
                );
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
            }

            UserPasswordReset::create([
                'user_id' => $checkIfUserExists->id,
                'code' => $resetPasswordCode
            ]);
            $response = [
                'access_token' => '',
                'message' => 'Please enter the reset password code.',
                'error' => 0
            ];
            return response()->json($response);
        } else {
            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
    }

    public function checkForgotPasswordCode(Request $request)
    {
        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            $userResetCode = UserPasswordReset::where('user_id', $checkIfUserExists->id)->where('code', $request->password_reset_code)->first();
            if (!$userResetCode) {
                $response = [
                    'access_token' => '',
                    'message' => 'password reset code was not correct.',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            $response = [
                'access_token' => '',
                'message' => '',
                'error' => 0
            ];
            return response()->json($response);
        } else {
            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
    }

    public function changeUserPassword(Request $request)
    {
        if (!$request->password_reset_code || !$request->password || !$request->phone) {
            $response = [
                'access_token' => '',
                'message' => 'Missing password or reset code',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }

        $checkIfUserExists = User::where('phone', $request->phone)->first();
        if ($checkIfUserExists) {
            $userResetCode = UserPasswordReset::where('user_id', $checkIfUserExists->id)->where('code', $request->password_reset_code)->first();
            if (!$userResetCode) {
                $response = [
                    'access_token' => '',
                    'message' => 'password reset code was not correct.',
                    'error' => 1
                ];
                return response()->json($response)->setStatusCode(422);
            }
            $checkIfUserExists->update([
                'password' => bcrypt($request->password)
            ]);
            //Delete password reset codes
            UserPasswordReset::where('user_id', $checkIfUserExists->id)->delete();
            $response = [
                'access_token' => '',
                'message' => 'Password has been changed successfully',
                'error' => 0
            ];
            return response()->json($response);
        } else {
            $response = [
                'access_token' => '',
                'message' => 'No user was found with this phone number',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(422);
        }
    }
}
