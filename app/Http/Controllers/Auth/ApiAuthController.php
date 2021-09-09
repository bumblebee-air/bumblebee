<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\GeneralHelpers;
use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
use App\User;
use App\UserPasswordReset;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiAuthController extends Controller
{
    public function login(Request $request) {
        $this->validate($request, [
            'role' => 'required|in:unified_engineer,driver',
            'email' => [
                'required_without:phone',
                Rule::exists('users')->where('user_role', $request->role)
            ],
            'phone' => [
                'required_without:email',
                Rule::exists('users')->where('user_role', $request->role)
            ],
            'password' => 'required|min:8'
        ]);

        $user = User::query();
        if ($request->email) {
            $user = $user->where('email', $request->email);
        }else {
            $user = $user->where('phone', $request->phone);
        }
        $user = $user->where('user_role', $request->role);
        $user = $user->first();
        if (!password_verify($request->password, $user->password)) {
            return response()->json([
                'errors' => [
                    'password' => 'The password in not matched.'
                ]
            ], 422);
        }
        $access_token = $user->createToken('API user');
        return response()->json([
            'message' => 'Success.',
            'data' => [
                'name' => $user->name,
                'access_token' => $access_token->accessToken,
                'token_type' => 'Bearer ',
            ]
        ]);
    }

    public function forgotPassword(Request $request) {
        $this->validate($request, [
            'role' => 'required|in:unified_engineer,driver',
            'email' => [
                'required_without:phone',
                Rule::exists('users')->where('user_role', $request->role)
            ],
            'phone' => [
                'required_without:email',
                Rule::exists('users')->where('user_role', $request->role)
            ],
        ]);

        $user = User::query();
        if ($request->email) {
            $user = $user->where('email', $request->email);
        } else {
            $user = $user->where('phone', $request->phone);
        }
        $user = $user->where('user_role', $request->role);
        $user = $user->first();

        UserPasswordReset::where('user_id', $user->id)->delete();
//        $rand_code = rand(1000,9999);
//        $resetPasswordCode = strval($rand_code);
        $resetPasswordCode = '1234';
        $client = GeneralHelpers::getUserClientViaRole($request->role);
        if ($request->email) {
            //Sending Verification Email
        } else {
            TwilioHelper::sendSMS($client->name, $request->phone, "Your verification code is: $resetPasswordCode");
        }
        UserPasswordReset::create([
            'user_id' => $user->id,
            'code' => $resetPasswordCode
        ]);
        return response()->json([
            'message' => 'Success.'
        ]);
    }

    public function checkVerificationCode(Request $request) {
        $this->validate($request, [
            'role' => 'required|in:unified_engineer,driver',
            'email' => [
                'required_without:phone',
                Rule::exists('users')->where('user_role', $request->role)
            ],
            'phone' => [
                'required_without:email',
                Rule::exists('users')->where('user_role', $request->role)
            ],
            'code' => 'required'
        ]);

        $user = User::query();
        if ($request->email) {
            $user = $user->where('email', $request->email);
        } else {
            $user = $user->where('phone', $request->phone);
        }
        $user = $user->where('user_role', $request->role);
        $user = $user->first();

        $checkIfCodeExists = UserPasswordReset::where('code', $request->code)->where('user_id', $user->id)->first();
        if (!$checkIfCodeExists) {
            return response()->json([
                'message' => 'The gavin parameters was invalid.',
                'errors' => [
                    'code' => 'The code was invalid'
                ]
            ], 422);
        }
        $access_token = $user->createToken('API user');
        return response()->json([
            'message' => 'Success.',
            'data' => [
                'name' => $user->name,
                'access_token' => $access_token->accessToken,
                'token_type' => 'Bearer',
            ]
        ]);
    }

    public function updatePassword(Request $request) {
        $this->validate($request, [
            'old_password' => 'required_without:code',
            'code' => 'required_without:old_password',
            'password' => 'required|min:8',
        ]);

        $user = $request->user();
        if ($request->has('code')) {
            $checkIfCodeExists = UserPasswordReset::where('code', $request->code)->where('user_id', $user->id)->first();
            if (!$checkIfCodeExists) {
                return response()->json([
                    'message' => 'The gavin parameters was invalid.',
                    'errors' => [
                        'code' => 'The code was invalid'
                    ]
                ]);
            }
            $checkIfCodeExists->delete();
        } else {
            if (!password_verify($request->password, $user->password)) {
                return response()->json([
                    'message' => 'The gavin parameters was invalid.',
                    'errors' => [
                        'old_password' => 'The old password was not matched.'
                    ]
                ]);
            }
        }
        return response()->json([
            'message' => 'Success.'
        ]);
    }
}
