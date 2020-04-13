<?php

namespace App\Http\Controllers;

use App\Client;
use App\ServiceType;
use Illuminate\Http\Request;
use Session;
use App\User;
use Illuminate\Support\Str;

class ConversationsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
    }

    public function getServiceTypesIndex(){
        $service_types = ServiceType::paginate(10);
        return view('admin.service-types.index',
            ['service_types'=>$service_types]);
    }

    public function getServiceTypeAdd(){
        $clients = Client::all();
        return view('admin.service-types.add',
            compact('clients'));
    }

    public function postServiceTypeAdd(Request $request){
        $name = $request->get('name');
        $client_id = $request->get('client_id');
        $service_type = new ServiceType();
        $service_type->name = $name;
        $service_type->client_id = $client_id;
        $service_type->save();
        Session::flash('success', 'The service type was added successfully!');
        return redirect()->to('service-types');
    }

    public function getServiceTypeEdit($id){
        $service_type = ServiceType::find($id);
        $clients = Client::all();
        if(!$service_type){
            Session::flash('error','No service type was found with this ID!');
        }
        return view('admin.service-types.edit',
            ['serviceType'=>$service_type,'clients'=>$clients]);
    }

    public function postServiceTypeEdit(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $client_id = $request->get('client_id');
        $service_type = ServiceType::find($id);
        if(!$service_type){
            Session::flash('error','No service type was found with this ID!');
        }
        $service_type->name = $name;
        $service_type->client_id = $client_id;
        $service_type->save();
        Session::flash('success', 'The service type was edited successfully!');
        return redirect()->to('service-types');
    }

    public function anyServiceTypeDelete(Request $request, $id){
        //$id = $request->get('id');
        $service_type = ServiceType::find($id);
        if(!$service_type){
            Session::flash('error','No service type was found with this ID!');
        }
        $name = $service_type->name;
        $service_type->delete();
        Session::flash('success', 'The service type '.$name.' was deleted successfully!');
        return redirect()->to('service-types');
    }

    public function getClientsIndex(){
        $clients = Client::with('user')->paginate(10);;
        return view('admin.clients.index',
            ['clients'=>$clients]);
    }

    public function getClientAdd(){
        return view('admin.clients.add');
    }

    public function postClientAdd(Request $request){
        $name = $request->get('name');
        $userName = $request->get('user_name');
        $email = $request->get('email');

        $rules = [
            'name' => 'required',
            'user_name' => 'required',
            'email' => 'required|unique:users,email',
        ];

        $messages = [
            'required_if' => 'The :attribute field is required.',
            'unique' => 'The :attribute is already exist.'
        ];

        $this->validate($request, $rules, $messages);

        //generate unique password
        $password = Str::random(6);

        $user = new User();
        $user->email = $request->email;
        $user->user_role = 'client';
        $user->name = $userName;
        $user->password = bcrypt($password);
        $user->save();

        $client = new Client();
        $client->user_id = $user->id;
        $client->name = $name;
        $client->save();

        // send registration mail to user
        \Mail::send([], [], function ($message) use($email, $userName, $password) {
        $message->to($email)
            ->subject('Registration')
            ->setBody("Hi {$userName}, you have been registered on Bumblebee and here are your login credentials:<br/><br/> <strong>Email:</strong> {$email}<br/> <strong>Password</strong>: {$password}", 'text/html');
        });

        Session::flash('success', 'The client was added successfully!');
        return redirect()->to('clients');
    }

    public function getClientEdit($id){
        
        $client = Client::find($id);

        $user = $client->user;
        
        if(!$client){
            Session::flash('error','No client was found with this ID!');
        }
        return view('admin.clients.edit',
            ['client'=>$client, 'user' => $user]);
    }

    public function postClientEdit(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $userName = $request->get('user_name');
        $email = $request->get('email');
        
        $client = Client::find($id);

        $user = $client->user;

        if(!empty($client)){

            $rules = [
                'name' => 'required',
                'user_name' => 'required',
                'email' => 'required|unique:users,email',
            ];

            $messages = [
                'required_if' => 'The :attribute field is required.',
                'unique' => 'The :attribute is already exist.'
            ];

            if(!empty($user))
            {
                $rules['email'] = 'required|unique:users,email,'. $user->id;
            }
            
            // validate the data
            $this->validate($request, $rules, $messages);

            if(!empty($user))
            {
                $user->email = $email;
                $user->name = $userName;
                $user->save();
            } else {
                //generate unique password
                $password = Str::random(6);

                $user = new User();
                $user->email = $email;
                $user->user_role = 'client';
                $user->name = $userName;
                $user->password = bcrypt($password);
                $user->save();

                // send registration mail to user
                \Mail::send([], [], function ($message) use($email, $userName, $password) {
                    $message->to($email)
                        ->subject('Registration')
                        ->setBody("Hi {$userName}, you have been registered on Bumblebee and here are your login credentials:<br/><br/> <strong>Email:</strong> {$email}<br/> <strong>Password</strong>: {$password}", 'text/html');
                });
            }

            $client->user_id = $user->id;
            $client->name = $name;
            $client->save();

            Session::flash('success', 'The client was edited successfully!');
        } else {
            Session::flash('error','No client was found with this ID!');
        }
        
        return redirect()->to('clients');
    }

    public function anyClientDelete(Request $request, $id){
        //$id = $request->get('id');
        $client = Client::find($id);
        if(!$client){
            Session::flash('error','No client was found with this ID!');
        }
        $name = $client->name;
        $client->delete();
        Session::flash('success', 'The client '.$name.' was deleted successfully!');
        return redirect()->to('clients');
    }
}
