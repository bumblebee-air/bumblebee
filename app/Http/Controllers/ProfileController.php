<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function getProfile(){
        $current_user = auth()->user();
        if(!$current_user){
            alert()->error('Please log in');
            return redirect()->back();
        }
        $client_url_prefix = '';
        foreach(array_keys(config('auth.guards')) as $guard){
            if(auth()->guard($guard)->check()) $client_url_prefix = $guard;
        }
        
        if($client_url_prefix == 'doorder'){
            return view('admin.doorder.profile',compact('client_url_prefix'));   
        }
        
        return view('admin.profile',compact('client_url_prefix'));
    }

    public function postPasswordReset(Request $request){
        $current_user = auth()->user();
        if(!$current_user){
            alert()->error('Please log in');
            return redirect()->back();
        }
        $current_password = $request->get('current_password');
        if(!Hash::check($current_password, $current_user->password)){
            alert()->error('The current password is incorrect');
            return redirect()->back()->withInput();
        }
        $new_password = $request->get('new_password');
        $confirm_password = $request->get('confirm_password');
        if($new_password!=$confirm_password){
            alert()->error('The password confirmation does not match');
            return redirect()->back()->withInput();
        }
        $hashed_new_pass = bcrypt($new_password);
        $current_user->password = $hashed_new_pass;
        $current_user->save();
        alert()->success('The password has been successfully changed');
        return redirect()->back();
    }
}
