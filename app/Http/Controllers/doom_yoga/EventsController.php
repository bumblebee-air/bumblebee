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
                $zoom_meeting_data = json_decode($response);
                $meeting_id = $zoom_meeting_data->id;
                $meeting_pass = $zoom_meeting_data->password;
                $createNewEvent->stream_link = $meeting_id;
                $createNewEvent->stream_password = $meeting_pass;
                $createNewEvent->save();
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
        /*$event1 = new Event(1, "Humble Heart", "01/09/2020 10:00", 30, "Regular Event", "No", 3, "Yes");
        $event2 = new Event(2, "Bloom Bliss", "01/09/2020 11:00", 60, "Class", "No", 10, "No");

        $events = array(
            $event1,
            $event2
        );*/
        $events = DoomYogaEvent::all();

        return view('admin.doom_yoga.events.my_events', [
            'myevents' => $events
        ]);
    }
    
    public function getEventData(Request $request){
        
        $event = DoomYogaEvent::find($request->eventId);
        $event->attending=0;
        
        return response()->json(array(
            "event"=>$event
        ),200);
    }
    
    public function postLaunchMeeting(Request $request){
        //dd($request->all());
        $current_user = \Auth::user();
        $event_id = $request->get('eventId');
        $event = DoomYogaEvent::find($event_id);
        if(!$event){
            alert()->error('No Event found with this ID!');
            return redirect()->back();
        }
        if($event->stream_link==null || $event->stream_password==null){
            alert()->error('The meeting\'s data is missing!');
            return redirect()->back();
        }
        //Generate Zoom meeting signature
        $api_key = env('ZOOM_JWT_API_KEY');
        $api_secret = env('ZOOM_JWT_API_SECRET');
        $role = '1'; //1 if host and 0 if attendee
        $meeting_number = $event->stream_link;
        $meeting_password = $event->stream_password;
        //Set the timezone to UTC
        date_default_timezone_set("UTC");
        $time = time() * 1000 - 30000;//time in milliseconds (or close enough)
        $data = base64_encode($api_key . $meeting_number . $time . $role);
        $hash = hash_hmac('sha256', $data, $api_secret, true);
        $sig = $api_key . "." . $meeting_number . "." . $time . "." . $role . "." . base64_encode($hash);
        $signature = rtrim(strtr(base64_encode($sig), '+/', '-_'), '=');
        //alert()->success('The event launched successfully');
        //return redirect()->back();
        return view('admin.doom_yoga.events.join_event_meeting',['role'=>$role,
            'api_key'=>$api_key, 'meeting_number'=>$meeting_number, 'meeting_password'=>$meeting_password,
            'lang'=>'en-US', 'signature'=>$signature, 'user_name'=>$current_user->name,
            'user_email'=>$current_user->email, 'leave_url'=>url('doom-yoga/events/my_events')]);
    }
}

/*class Event
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
}*/

class SubscriberData{
    public $id,$name;
    public function __construct($id,$name){
        $this->id=$id;
        $this->name=$name;
    }
    
}
