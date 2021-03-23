<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class HelperController extends Controller
{
    public function postValidateEmailAndPhone(Request $request){
        try {
            $this->validate($request, [
                'email' => 'required|unique:users',
                'phone_number' => 'required|unique:users,phone'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['errors'=>1,'message'=>$e->errors()]);
        }
        return response()->json(['errors'=>0,'message'=>'All clear']);
    }

    public function logFrontendError(Request $request){
        $error_string = json_encode($request->all());
        \Log::error('Frontend error: '.$error_string);
    }
}