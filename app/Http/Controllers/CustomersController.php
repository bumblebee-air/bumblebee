<?php
/**
 * Created by PhpStorm.
 * User: mfayez
 * Date: 11/03/19
 * Time: 03:36 م
 */

namespace App\Http\Controllers;
use App\CustomerInvitation;
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

    public function getCustomerRegister($code){
        $customer_invitation = CustomerInvitation::where('code',$code)->first();
        return view('customer.register', ['invitation'=>$customer_invitation]);
    }

    public function postCustomerRegister(Request $request){
        $invitation = CustomerInvitation::find($request->get('invitation'));
        if(!$invitation){
            return redirect()->back()->with('error','This invitation code is invalid!');
        }
        $request->merge([
            'name'=>$invitation->name,
            'phone'=>$invitation->phone
        ]);
        $this->validate($request,[
            'vehicle_reg' => 'required|string|max:255',
            'phone' => ['required','string','max:255', Rule::unique('users')->where('user_role','customer')],
            'password' => 'required|string|min:6|confirmed',
        ]);

        //$this->guard()->login($user);
        $user = User::create([
            'name' => $request->get('name'),
            'phone' => $request->get('phone'),
            'password' => bcrypt($request->get('password')),
            'user_role' => 'customer'
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'mileage' => $request->get('mileage'),
            'vehicle_reg' => $request->get('vehicle_reg'),
            'vehicle_make' => $request->get('make'),
            'vehicle_model' => $request->get('model'),
            'vehicle_version' => $request->get('version'),
            'vehicle_fuel' => $request->get('fuel'),
            'vehicle_colour' => $request->get('colour'),
            'vehicle_external_id' => $request->get('external_id'),
        ]);
        //Login the user
        Auth::loginUsingId($user->id);
        //$request->session()->flash('message','Registration successful');
        return redirect()->to('customer/health-check')->with('success','Registration successful');
    }

    public function getCustomerLogin(){
        return view('auth.customer_login');
    }

    public function postCustomerLogin(Request $request){
        $this->validate($request,[
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('phone','=',$request->phone)->first();
        if(!$user){
            redirect()->back()->with('error','Phone or password is incorrect');
        }
        if(password_verify($request->password, $user->password)){
            Auth::login($user, $request->get('remember_me'));
            return redirect()->to('customer/health-check');
        }
        return redirect()->back()->with('error','Phone or password is incorrect');
    }

    public function getHealthCheck(){
        return view('customer.health_check');
    }

    public function getHealthCheckWithSupport($room){
        return view('health_check_with_support', compact('room'));
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

    public function postSendTestWhatsapp(Request $request){
        $customer_name = $request->get('customer_name');
        $customer_phone = $request->get('customer_phone');
        $supplier = $request->get('supplier');
        $tracking_link = 'https://cartow.spiressl.com';
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        try {
            $twilio = new Client($sid, $token);
            $message = $twilio->messages->create("whatsapp:".$customer_phone,
                ["from" => "whatsapp:+447445341335",
                    "body" => "Hi $customer_name, your roadside assistance from $supplier is on its way to you, you can track it here $tracking_link."]
            );
            dd($message);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()->back()->with('message','Whatsapp message sent successfully!');
    }
}