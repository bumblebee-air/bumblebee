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

    public function getGeneralEnquiry(){
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
        $customer_name = $request->get('customer_name');
        $customer_phone = $request->get('customer_phone');
        $customer_phone_international = $request->get('customer_phone_international');
        $customer_email = $request->get('customer_email');
        $customer_location = $request->get('customer_location');
        $the_enquiry = $request->get('enquiry');
        $contractor_id = $request->get('contractor');

        $contractor = Supplier::find($contractor_id);
        $sid    = env('TWILIO_SID', '');
        $token  = env('TWILIO_AUTH', '');
        $body = "Hello $contractor->name, we've a job request for $customer_name at $customer_location scheduled for ASAP.
To confirm acceptance or rejection of the job, please respond with 'yes', 'no' or 'maybe'.";
        try {
            $twilio = new TwilioClient($sid, $token);
            $message = $twilio->messages->create('whatsapp:'.$contractor->phone,
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
        } catch (\Exception $e){
            \Log::error($e->getMessage());
        }
        $enquiry = new GeneralEnquiry();
        $enquiry->client_id = $client_id;
        $enquiry->customer_name = $customer_name;
        $enquiry->customer_phone = $customer_phone;
        $enquiry->customer_phone_international = $customer_phone_international;
        $enquiry->customer_email = $customer_email;
        $enquiry->enquiry = $the_enquiry;
        $enquiry->contractor = $contractor_id;
        $enquiry->save();
        \Session::flash('success','Enquiry saved successfully');
        return redirect()->back();
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
