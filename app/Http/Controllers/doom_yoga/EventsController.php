<?php
namespace App\Http\Controllers\doom_yoga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function addNewEvent()
    {
        return view('admin.doom_yoga.events.new_event');
    }

    public function postNewEvent(Request $request)
    {

        // alert()->success('The Event Was Created Successfully ');
        // dd($request);
        // return redirect()->back();
        return response()->json(array(
            "msg" => "The Event Was Created Successfully",
            "eventId" => 1
        ), 200);
    }

    public function getEventBooking()
    {
        ///// if subscriber
       /*  $event = new Event();
        $event->id = 1;
        $event->event_name = 'Humble Heart';
        $event->description = 'A slow and steady paced practice. tension releasing a dynamic flow leads into relaxing meditative long holds bringing balance and equanimity ending the practice deep in sound and silence.';
        $event->dateTime = 'Tuesdays / 6PM -7PM UK GMT ';
        $event->place = 'On Zoom';
        $event->duration = '60 mins';
        $event->level = 'All Levels are welcome';
        return view('doom_yoga.events.book_event', [
            'event' => $event
        ]); */
        
        ///// if non subscriber
        $event = new Event();
        $event->id = 1;
        $event->event_name = 'Humble Heart';
        $event->description = 'A slow and steady paced practice. tension releasing a dynamic flow leads into relaxing meditative long holds bringing balance and equanimity ending the practice deep in sound and silence.';
        $event->dateTime = 'Tuesdays / 6PM -7PM UK GMT ';
        $event->place = 'On Zoom';
        $event->duration = '60 mins';
        $event->level = 'All Levels are welcome';
        $event->pricePerClass='£15';
        return view('doom_yoga.events.book_event_non_subscriber', [
            'event' => $event
        ]);
    }
    
    public function postEventBooking(Request $request){
      //  dd($request);
        alert()->success('The event was booked successfully');
        return redirect()->back();
    }
    
    public function postSignupEventBooking(Request $request){
        
        alert()->success('The event was booked successfully.');
        return redirect()->back();
    }
}

class Event
{

    public $id, $event_name, $description, $dateTime, $place, $duration, $level,$pricePerClass;
}