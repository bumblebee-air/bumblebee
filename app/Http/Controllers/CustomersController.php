<?php
/**
 * Created by PhpStorm.
 * User: mfayez
 * Date: 11/03/19
 * Time: 03:36 م
 */

namespace App\Http\Controllers;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;
use Twilio\Rest\Client;

class CustomersController extends Controller
{
    public function __construct(){

    }

    public function getCustomerRegister($company){
        return view('customer.register');
    }

    public function postCustomerRegister(Request $request){
        $this->validate($request,[
            'vehicle_reg' => 'required|string|max:255',
            'phone' => ['required|string|max:255', Rule::notIn('users')->where('role','customer')],
            'password' => 'required|string|min:6|confirmed',
        ]);

        //$this->guard()->login($user);
        $user = User::create([
            'name' => '',
            'phone' => $request->phone,
            'password' => bcrypt($request->password)
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'mileage' => $request->mileage,
            'vehicle_reg' => $request->vehicle_reg
        ]);

        $request->session()->flash('message','Registration successful');

    }

    public function getCustomerLogin(){

    }

    public function postCustomerLogin(Request $request){
        $this->validate($request,[
            'phone' => ['required|string', Rule::In('users')->where('role','customer')],
            'password' => 'required|string',
        ]);

        $user = User::where('phone','=',$request->phone)->frist();
        if(password_verify($request->password, $user->password)){
            Auth::loginUsingId($user->id);
            dd('Login successful');
        }
        $request->session()->flash('message', 'Phone or password is not correct');
        return redirect()->back();
    }

    public function getSendTestSMS(){
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        try {
            $twilio = new Client($sid, $token);
            $message = $twilio->messages->create("+201281977661",
                ["from" => "+447445341335",
                    "body" => "I sent this message in under 10 minutes!"]
            );
            dd($message);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}