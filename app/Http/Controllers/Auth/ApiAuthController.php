<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ApiAuthController extends Controller
{
    public function login(Request $request) {
        $this->validate($request, [
//            'role' => 'required|in:unified_engineer,driver',
            'email' => 'required|exists:users',
            'password' => 'required|min:8'
        ]);

        $user = User::where('email', $request->email)->first();
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
}
