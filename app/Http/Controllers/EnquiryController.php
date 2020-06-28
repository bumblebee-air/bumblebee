<?php

namespace App\Http\Controllers;

use App\Client;
use App\GeneralEnquiry;
use App\Supplier;
use App\WhatsappMessage;
use Twilio\Rest\Client as TwilioClient;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except(['saveGeneralEnquiry']);
    }

    public function getGeneralEnquiryIndex(){
        $current_user = \Auth::user();
        if($current_user->user_role == 'client'){
            $client = Client::where('user_id','=',$current_user->id)->first();
            $enquiries = GeneralEnquiry::where('client_id','=',$client->id)->paginate(10);
        } elseif($current_user->user_role == 'admin'){
            $enquiries = GeneralEnquiry::paginate(10);
        }
        return view('admin.enquiries.index',compact('enquiries'));
    }

    public function getAddGeneralEnquiry(){
        $clients = Client::all();
        $is_client = false;
        $current_user = \Auth::user();
        if($current_user->user_role == 'client'){
            $is_client = true;
            $clients = Client::where('user_id','=',$current_user->id)->first();
        }
        $suppliers = Supplier::all()->toArray();
        $suppliers = json_encode($suppliers);
        return view('admin.enquiries.add', compact('clients',
            'is_client', 'suppliers'));
    }

    public function postGeneralEnquiry(Request $request){
        $client_id = $request->get('client_id');
        $client = Client::find($client_id);
        if(!$client){
            \Session::flash('error','No Client was found with this ID');
            return redirect()->back();
        }
        $enquiry_id = $request->get('enquiry_id');
        $customer_name = $request->get('customer_name');
        $customer_phone = $request->get('customer_phone');
        $customer_phone_international = $request->get('customer_phone_international');
        $customer_email = $request->get('customer_email');
        $customer_location = $request->get('customer_location');
        $location_lat = $request->get('location_lat');
        $location_lon = $request->get('location_lon');
        $the_enquiry = $request->get('enquiry');
        $contractor_id = $request->get('contractor');

        if($enquiry_id != null) {
            $enquiry = GeneralEnquiry::find($enquiry_id);
        } else {
            $enquiry = new GeneralEnquiry();
        }
        $enquiry->client_id = $client_id;
        $enquiry->customer_name = $customer_name;
        $enquiry->customer_phone = $customer_phone;
        $enquiry->customer_phone_international = $customer_phone_international;
        $enquiry->customer_email = $customer_email;
        $enquiry->enquiry = $the_enquiry;
        if($contractor_id !=null && $enquiry_id!=null && $enquiry->contractor!=$contractor_id) {
            $contractor = Supplier::find($contractor_id);
            $sid = env('TWILIO_SID', '');
            $token = env('TWILIO_AUTH', '');
            $body = "Hello $contractor->name, we've a job request for $customer_name at $customer_location scheduled for ASAP.
To confirm acceptance or rejection of the job, please respond with 'yes', 'no' or 'maybe'.";
            try {
                $twilio = new TwilioClient($sid, $token);
                $message = $twilio->messages->create('whatsapp:' . $contractor->phone,
                    ["from" => "whatsapp:+447445341335",
                        "body" => $body]
                );
                //dd($message);
                /*$whats = new WhatsappMessage();
                $whats->message = $body;
                $whats->from = 'Bumblebee (' . '+447445341335' . ')';
                $whats->to = $customer_phone;
                $whats->user_id = $contractor_id;
                $whats->status = $message->status;
                $whats->external_id = $message->sid;
                $whats->save();*/
            } catch (\Exception $e) {
                \Log::error($e->getMessage());
            }
        }
        $enquiry->contractor = $contractor_id;
        $enquiry->location = $customer_location;
        $enquiry->location_lat = $location_lat;
        $enquiry->location_lon = $location_lon;
        $enquiry->save();
        \Session::flash('success','Enquiry saved successfully');
        return redirect()->to('general-enquiry');
    }

    public function getEditGeneralEnquiry($id){
        $enquiry = GeneralEnquiry::find($id);
        if(!$enquiry){
            \Session::flash('error','No Enquiry was found with this ID!');
        }
        $clients = Client::all();
        $is_client = false;
        $current_user = \Auth::user();
        if($current_user->user_role == 'client'){
            $is_client = true;
            $clients = Client::where('user_id','=',$current_user->id)->first();
        }
        $suppliers = Supplier::all()->toArray();
        $suppliers = json_encode($suppliers);
        return view('admin.enquiries.edit', compact('enquiry','clients',
            'is_client', 'suppliers'));
    }

    public function saveGeneralEnquiry(Request $request){
        $client_name = $request->get('client');
        $client = Client::where('name','%like%',$client_name)->first();
        if(!$client){
            $response = [
                'error' => 1,
                'message' => 'No client was found with this name'
            ];
            return response()->json($response)->setStatusCode(200);
        }
        $enquiry = new GeneralEnquiry();
        $enquiry->client_id = $client->id;
        $enquiry->customer_name = $request->get('customer_name');
        $enquiry->customer_phone = $request->get('customer_phone');
        $enquiry->customer_phone_international = $request->get('customer_phone_international');
        $enquiry->customer_email = $request->get('customer_email');
        $enquiry->enquiry = $request->get('enquiry');
        $enquiry->save();
        $response = [
            'error' => 0,
            'message' => 'The enquiry was saved successfully'
        ];
        return response()->json($response)->setStatusCode(200);
    }
}
