<?php

namespace App\Http\Controllers;

use App\Client;
use App\GeneralEnquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function getGeneralEnquiry(){
        $clients = Client::all();
        return view('admin.enquiries.add', compact('clients'));
    }

    public function postGeneralEnquiry(Request $request){
        $client_id = $request->get('client_id');
        $client = Client::find($client_id);
        if(!$client){
            \Session::flash('error','No Client was found with this ID');
            return redirect()->back();
        }
        $enquiry = new GeneralEnquiry();
        $enquiry->client_id = $client_id;
        $enquiry->customer_name = $request->get('customer_name');
        $enquiry->customer_phone = $request->get('customer_phone');
        $enquiry->customer_phone_international = $request->get('customer_phone_international');
        $enquiry->customer_email = $request->get('customer_email');
        $enquiry->enquiry = $request->get('enquiry');
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
