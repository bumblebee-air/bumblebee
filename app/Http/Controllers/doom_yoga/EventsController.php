<?php
namespace App\Http\Controllers\doom_yoga;

use App\DoomYogaEvent;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventsController extends Controller
{

    public function addNewEvent()
    {
        return view('admin.doom_yoga.events.new_event');
    }

    public function postNewEvent(Request $request)
    {
//        dd($request->all());
        $createNewEvent = new DoomYogaEvent();
        $createNewEvent->name = $request->event_name;
        $createNewEvent->type = $request->event_type;
        $createNewEvent->level = $request->level;
        $createNewEvent->short_description = $request->short_description;
        $createNewEvent->max_participants = $request->max_participants;
        $createNewEvent->date_Time = Carbon::parse($request->date_time)->toDateTimeString();
        $createNewEvent->duration = $request->duration_in_minutes;
        $createNewEvent->is_person = $request->is_event_person;
        $createNewEvent->is_reccuring = $request->is_event_reccuring;
        $createNewEvent->is_auto_zoom = $request->automatic_zoom_link;
        $createNewEvent->stream_link = $request->stream_link;
        $createNewEvent->stream_password = $request->stream_password;
        $createNewEvent->is_free = $request->free_event;
        $createNewEvent->is_free_ticket_option = $request->free_ticket_option;
        $createNewEvent->ticket_price_setting = $request->ticket_price_settings;
        $createNewEvent->price = $request->price;
        $createNewEvent->save();
        return response()->json(array(
            "msg" => "The Event Was Created Successfully",
            "eventId" => $createNewEvent->id
        ));
    }

    public function getEventBooking($client_name, $id)
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
        $event = DoomYogaEvent::find($id);
        if (!$event) {
            abort(404);
        }
        return view('doom_yoga.events.book_event_non_subscriber', [
            'event' => $event
        ]);
    }
    
    public function postEventBooking(Request $request){
        dd($request);
//        alert()->success('The event was booked successfully');
        return redirect()->back();
    }
    
    public function postSignupEventBooking(Request $request){
        
        alert()->success('The event was booked successfully.');
        return redirect()->back();
    }
}

//class Event
//{
//
//    public $id, $event_name, $description, $dateTime, $place, $duration, $level,$pricePerClass;
//}
