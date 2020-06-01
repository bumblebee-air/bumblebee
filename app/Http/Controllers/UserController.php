<?php

namespace App\Http\Controllers;

use App\User;
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
}
