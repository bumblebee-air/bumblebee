<?php

namespace App\Http\Controllers\doom_yoga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function addNewEvent() {
        return view('admin.doom_yoga.events.new_event');
    }
    
    public function postNewEvent(Request $request){
       
        //alert()->success('The Event Was Created Successfully ');
        //dd($request);
       //return redirect()->back();
        
        return response()->json(array("msg"=>"The Event Was Created Successfully","eventId"=>1), 200);
    }
    
  
}