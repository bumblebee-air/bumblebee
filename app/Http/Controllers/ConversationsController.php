<?php

namespace App\Http\Controllers;

use App\Client;
use App\ConversationCategory;
use Illuminate\Http\Request;
use Session;

class ConversationsController extends Controller
{
    public function __construct(){
        //$this->middleware('auth');
    }

    public function getConversationCategoriesIndex(){
        $conversation_categories = ConversationCategory::paginate(10);;
        return view('admin.conversation-categories.index',
            ['categories'=>$conversation_categories]);
    }

    public function getConversationCategoryAdd(){
        $clients = Client::all();
        return view('admin.conversation-categories.add',
            compact('clients'));
    }

    public function postConversationCategoryAdd(Request $request){
        $name = $request->get('name');
        $client_id = $request->get('client_id');
        $conversation_category = new ConversationCategory();
        $conversation_category->name = $name;
        $conversation_category->client_id = $client_id;
        $conversation_category->save();
        Session::flash('success', 'The category was added successfully!');
        return redirect()->to('conversation-categories');
    }

    public function getConversationCategoryEdit($id){
        $conversation_category = ConversationCategory::find($id);
        $clients = Client::all();
        if(!$conversation_category){
            Session::flash('error','No category was found with this ID!');
        }
        return view('admin.conversation-categories.edit',
            ['category'=>$conversation_category,'clients'=>$clients]);
    }

    public function postConversationCategoryEdit(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $client_id = $request->get('client_id');
        $conversation_category = ConversationCategory::find($id);
        if(!$conversation_category){
            Session::flash('error','No category was found with this ID!');
        }
        $conversation_category->name = $name;
        $conversation_category->client_id = $client_id;
        $conversation_category->save();
        Session::flash('success', 'The category was edited successfully!');
        return redirect()->to('conversation-categories');
    }

    public function anyConversationCategoryDelete(Request $request, $id){
        //$id = $request->get('id');
        $conversation_category = ConversationCategory::find($id);
        if(!$conversation_category){
            Session::flash('error','No category was found with this ID!');
        }
        $name = $conversation_category->name;
        $conversation_category->delete();
        Session::flash('success', 'The category '.$name.' was deleted successfully!');
        return redirect()->to('conversation-categories');
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
