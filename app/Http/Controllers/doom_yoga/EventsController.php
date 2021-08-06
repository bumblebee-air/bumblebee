<?php
namespace App\Http\Controllers\doom_yoga;

use App\DoomYogaEvent;
use App\Http\Controllers\Controller;
use App\UserToken;
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
        // dd($request->all());
        $createNewEvent = new DoomYogaEvent();
        $createNewEvent->name = $request->event_name;
        $createNewEvent->type = $request->event_type;
        //$createNewEvent->level = $request->level;
        $createNewEvent->short_description = $request->short_description;
        $createNewEvent->max_participants = $request->max_participants;
        $event_datetime = Carbon::parse($request->date_time);
        $createNewEvent->date_Time = $event_datetime->toDateTimeString();
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
        // $createNewEvent->id = 1;
        $zoom_meeting_data = null;
        if($request->automatic_zoom_link == '1') {
            //Create Zoom meeting for the event
            $current_user = \Auth::user();
            if ($current_user) {
                $user_tokens = UserToken::where('user_id', $current_user->id)->first();
                if (!$user_tokens || $user_tokens->zoom_api == null) {
                    return json_encode(['error_code' => 401, 'error_message' => 'No user tokens yet']);
                }
                $access_token = $user_tokens->zoom_api;
                $guzzle_client = new \GuzzleHttp\Client();
                $token_request = $guzzle_client->request('POST', 'https://api.zoom.us/v2/users/me/meetings', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $access_token,
                    ],
                    'json' => [
                        "topic" => $request->event_name,
                        "type" => 2,
                        "start_time" => $event_datetime->toIso8601ZuluString(),
                        "duration" => $request->duration_in_minutes,
                        //"timezone": "string",
                        //"password": "string",
                    ]
                ]);
                $response = $token_request->getBody()->getContents();
                $zoom_meeting_data = $response;
            }
        }
        $subscriberData1 = new SubscriberData(1, "Jane Dow");
        $subscriberData2 = new SubscriberData(2, "Adam Andrews");
        $subscribers = array($subscriberData1,$subscriberData2);
         
        return response()->json(array(
            "msg" => "The Event Was Created Successfully",
            "eventId" => $createNewEvent->id,
            "subscribers" => $subscribers,
            'zoom_meeting_data' => $zoom_meeting_data
        ),200);
    }

    public function postShareEvent(Request $request)
    {
        // dd($request);
        alert()->success('The event  shared successfully');
        return redirect()->back();
    }

    public function getEventBooking($client_name, $id)
    {
        // /// if subscriber
        /*
         * $event = new Event();
         * $event->id = 1;
         * $event->event_name = 'Humble Heart';
         * $event->description = 'A slow and steady paced practice. tension releasing a dynamic flow leads into relaxing meditative long holds bringing balance and equanimity ending the practice deep in sound and silence.';
         * $event->dateTime = 'Tuesdays / 6PM -7PM UK GMT ';
         * $event->place = 'On Zoom';
         * $event->duration = '60 mins';
         * $event->level = 'All Levels are welcome';
         * return view('doom_yoga.events.book_event', [
         * 'event' => $event
         * ]);
         */

        // /// if non subscriber
        $event = DoomYogaEvent::find($id);
        if (! $event) {
            abort(404);
        }
        return view('doom_yoga.events.book_event_non_subscriber', [
            'event' => $event
        ]);
    }

    public function postEventBooking(Request $request)
    {
        dd($request);
        // alert()->success('The event was booked successfully');
        return redirect()->back();
    }

    public function postSignupEventBooking(Request $request)
    {
        alert()->success('The event was booked successfully.');
        return redirect()->back();
    }

    public function getEvents()
    {
        $event1 = new Event(1, "Humble Heart", "01/09/2020 10:00", 30, "Regular Event", "No", 3, "Yes");
        $event2 = new Event(2, "Bloom Bliss", "01/09/2020 11:00", 60, "Class", "No", 10, "No");

        $events = array(
            $event1,
            $event2
        );

        return view('admin.doom_yoga.events.my_events', [
            'myevents' => $events
        ]);
    }
    
    public function getEventData(Request $request){
        
        $event = DoomYogaEvent::find($request->eventId);
        $event->attending =4;
        
        return response()->json(array(
            "event"=>$event
        ),200);
    }
    
    public function  postLaunchMeeting(Request $request){
        //dd($request);
        
        alert()->success('The event launched successfully');
        return redirect()->back();
    }
}

class Event
{

    public $id, $event_name, $dateTime, $durationInMins, $event_type, $eventInPerson, $attending, $reccuring;

    public function __construct($id, $event_name, $dateTime, $durationInMins, $event_type, $eventInPerson, $attending, $reccuring)
    {
        $this->id = $id;
        $this->event_name = $event_name;
        $this->dateTime = $dateTime;
        $this->durationInMins = $durationInMins;
        $this->event_type = $event_type;
        $this->eventInPerson = $eventInPerson;
        $this->attending = $attending;
        $this->reccuring = $reccuring;
    }
}

class SubscriberData{
    public $id,$name;
    public function __construct($id,$name){
        $this->id=$id;
        $this->name=$name;
    }
    
}
