<?php

namespace App\Http\Controllers;

use App\Client;
use App\ServiceType;
use Illuminate\Http\Request;
use Session;

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
        $clients = Client::paginate(10);;
        return view('admin.clients.index',
            ['clients'=>$clients]);
    }

    public function getClientAdd(){
        return view('admin.clients.add');
    }

    public function postClientAdd(Request $request){
        $name = $request->get('name');
        $client = new Client();
        $client->name = $name;
        $client->save();
        Session::flash('success', 'The client was added successfully!');
        return redirect()->to('clients');
    }

    public function getClientEdit($id){
        $client = Client::find($id);
        if(!$client){
            Session::flash('error','No client was found with this ID!');
        }
        return view('admin.clients.edit',
            ['client'=>$client]);
    }

    public function postClientEdit(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $client = Client::find($id);
        if(!$client){
            Session::flash('error','No client was found with this ID!');
        }
        $client->name = $name;
        $client->save();
        Session::flash('success', 'The client was edited successfully!');
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
