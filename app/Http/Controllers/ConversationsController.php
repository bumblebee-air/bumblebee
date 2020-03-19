<?php

namespace App\Http\Controllers;

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
        return view('admin.conversation-categories.add');
    }

    public function postConversationCategoryAdd(Request $request){
        $name = $request->get('name');
        $conversation_category = new ConversationCategory();
        $conversation_category->name = $name;
        $conversation_category->save();
        Session::flash('success', 'The category was added successfully!');
        return redirect()->to('conversation-categories');
    }

    public function getConversationCategoryEdit($id){
        $conversation_category = ConversationCategory::find($id);
        if(!$conversation_category){
            Session::flash('error','No category was found with this ID!');
        }
        return view('admin.conversation-categories.edit',
            ['category'=>$conversation_category]);
    }

    public function postConversationCategoryEdit(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        $conversation_category = ConversationCategory::find($id);
        if(!$conversation_category){
            Session::flash('error','No category was found with this ID!');
        }
        $conversation_category->name = $name;
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
}
