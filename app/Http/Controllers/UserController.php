<?php

namespace App\Http\Controllers;

use App\Client;
use App\DriverProfile;
use App\User;
use App\UserClient;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    public function usersIndex() {
        $users = User::all();
        return view('admin.users.index',compact('users'));
    }

    public function getAddUser() {

    }

    public function postAddUser(Request $request) {
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $phone = $request->get('phone');
        $role = $request->get('role');

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->phone = $phone;
        $user->user_role = $role;
        $user->save();

        \Mail::send([], [], function ($message) use($email, $name, $password) {
            $message->to($email)
                ->subject('Registration')
                ->setBody("Hi {$name}, you have been registered on Bumblebee and here are your login credentials:<br/><br/> <strong>Email:</strong> {$email}<br/> <strong>Password</strong>: {$password}", 'text/html');
        });

        \Session::flash('success','The user '.$name.' was added successfully');
        return redirect()->back();
    }

    public function getEditUser() {

    }

    public function postEditUser(Request $request) {
        $user_id = $request->get('user_id');
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $phone = $request->get('phone');
        $role = $request->get('role');

        $user = User::find($user_id);
        if(!$user){
            \Session::flash('error','No user was found with this ID');
            return redirect()->back();
        }
        $user->name = $name;
        $user->email = $email;
        if($password!=null) {
            $user->password = Hash::make($password);
        }
        $user->phone = $phone;
        $user->user_role = $role;
        $user->save();

        /*\Mail::send([], [], function ($message) use($email, $name, $password) {
            $message->to($email)
                ->subject('Registration')
                ->setBody("Hi {$name}, your user on Bumblebee has been edited", 'text/html');
        });*/

        \Session::flash('success','The user '.$name.' was edited successfully');
        return redirect()->back();
    }

    public function deleteUserData(Request $request){
        $client = $request->get('client');
        $client_entry = Client::where('name','=',$client)->first();
        if(!$client_entry){
            return response()->json(['message'=>'This client was not found!'],422);
        }
        $current_user = Auth::user();
        if($current_user->user_role == 'client' || $current_user->user_role == 'admin'){
            $user_id = $request->get('user_id');
            if(!$user_id){
                return response()->json(['message'=>'The user ID was not provided!'],422);
            }
            $current_user = User::find($user_id);
            if(!$current_user){
                return response()->json(['message'=>'The user was not found!'],422);
            }
        }
        $user_id = $current_user->id;
        $user_client_entry = UserClient::where('user_id','=',$user_id)
            ->where('client_id','=',$client_entry->id)->first();
        if(!$user_client_entry){
            return response()->json(['message'=>'This user does not belong to this client!'],422);
        }
        try {
            //Start data scrambling
            $current_user->email = 'deleted_user_' . $user_id . '@mail.com';
            $current_user->phone = '000000000000' . $user_id;
            $current_user->password = bcrypt('P@$$w0rd');
            $current_user->remember_token = null;
            $current_user->save();
            if ($current_user->user_role == 'driver') {
                $driver_profile = DriverProfile::where('user_id', '=', $user_id)->first();
                if ($driver_profile != null) {
                    $driver_profile->dob = null;
                    $driver_profile->pps_number = null;
                    $driver_profile->legal_word_evidence .= 'nulled';
                    $driver_profile->driver_license .= 'nulled';
                    $driver_profile->driver_license_back .= 'nulled';
                    $driver_profile->insurance_proof .= 'nulled';
                    $driver_profile->address_proof .= 'nulled';
                    $driver_profile->save();
                }
            }
        } catch (\Exception $exception){
            return response()->json(['message'=>'Error occurred while deleting user: '.$exception->getMessage()],422);
        }
        return response()->json(['message'=>'The user has been deleted successfully!']);
    }
}
