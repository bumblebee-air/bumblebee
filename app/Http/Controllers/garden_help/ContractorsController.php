<?php

namespace App\Http\Controllers\garden_help;

use App\Contractor;
use App\Customer;
use App\Helpers\TwilioHelper;
use App\Mail\ContractorRegistrationMail;
use App\Managers\StripeManager;
use App\User;
use App\UserClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Validator;

class ContractorsController extends Controller
{
    public function index()
    {
        return view('garden_help.contractors.registration');
    }

    public function save(Request $request) {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|unique:users,phone',
            'experience_level' => 'required|string',
            'experience_level_value' => 'required|string',
            'age_proof' => 'required_if:experience_level_value,==,2|file',
            'cv' => 'required_if:experience_level_value,==,3|file',
            'job_reference' => 'required_if:experience_level_value,==,3|file',
            'type_of_work_exp' => 'required|string',
            'address' => 'required|string',
            'insurance_document' => 'required|file',
            'has_smartphone' => 'required|boolean',
            'type_of_transport' => 'required|string',
            'charge_rate' => 'required|string',
            'contact_through' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone_number;
        $user->password = bcrypt(Str::random(8));
        $user->user_role = 'contractor';
        $user->save();

        $client = \App\Client::where('name', 'GardenHelp')->first();
        if($client) {
            //Making Client Relation
            UserClient::create([
                'user_id' => $user->id,
                'client_id' => $client->id
            ]);
        }

        //Saving new contractor registration
        $contractor = Contractor::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'experience_level' => $request->experience_level,
            'experience_level_value' => $request->experience_level_value,
            'age_proof' => $request->hasFile('age_proof') ? $request->file('age_proof')->store('uploads/contractors_uploads') : null,
            'cv' => $request->hasFile('cv') ? $request->file('cv')->store('uploads/contractors_uploads') : null,
            'job_reference' => $request->hasFile('job_reference') ? $request->file('job_reference')->store('uploads/contractors_uploads') : null,
            'available_equipments' => $request->available_equipments,
            'type_of_work_exp' => $request->type_of_work_exp,
            'address' => $request->address,
            'address_coordinates' => $request->address_coordinates,
            'company_number' => $request->company_number,
            'vat_number' => $request->vat_number,
            'insurance_document' => $request->file('insurance_document')->store('uploads/contractors_uploads'),
            'has_smartphone' => $request->has_smartphone,
            'type_of_transport' => $request->type_of_transport,
            'charge_type' => $request->charge_type,
            'charge_rate' => $request->charge_rate,
            'has_callout_fee' => $request->has_callout_fee,
            'callout_fee_value' => $request->callout_fee_value,
            'rate_of_green_waste' => $request->rate_of_green_waste,
            'green_waste_collection_method' => $request->green_waste_collection_method,
            'social_profile' => $request->social_profiles,
            'website_address' => $request->website,
            'type_of_work' => $request->type_of_work,
            'contact_through' => $request->contact_through,
            'type_of_work_selected_value' => $request->type_of_work_selected_value
        ]);

        \Mail::to(env('GH_NOTIF_EMAIL','kim@bumblebeeai.io'))->send(new ContractorRegistrationMail($contractor));
        if($contractor->email!=null && $contractor->email!=''){
            \Mail::to($contractor->email)->send(new ContractorRegistrationMail($contractor));
        }

        Redis::publish('garden-help-channel', json_encode([
            'event' => 'new-contractor-request',
            'data' => [
                'id' => $contractor->id,
                'toast_text' => 'There is a new contractor request.',
                'alert_text' => "There is a new contractor request! with order No# $contractor->id",
                'click_link' => route('garden_help_getContractorSingleRequest' , ['garden-help', $contractor->id]),
            ]
        ]));

        alert()->success( 'You registration saved successfully');
        return redirect()->back();
    }

    public function getContractorsRequests() {

        $contractors_requests = Contractor::paginate(20);
        return view('admin.garden_help.contractors.requests', ['contractors_requests' => $contractors_requests]);
    }

    public function getSingleRequest($client_name, $id) {
        $contractor_request = Contractor::find($id);
        if (!$contractor_request) {
            abort(404);
        }
        return view('admin.garden_help.contractors.single_request', ['contractor_request' => $contractor_request]);
    }

    public function postSingleRequest(Request $request, $client_name, $id) {
        $singleRequest = Contractor::find($id);
        if (!$singleRequest) {
            abort(404);
        }
        if ($request->rejection_reason) {
            $singleRequest->rejection_reason = $request->rejection_reason;
            $singleRequest->status = 'missing';
            $singleRequest->save();
            alert()->success('Contractor rejected successfully');
            //Sending SMS
            $body = "Hi ". $singleRequest->name . ",
             we are sorry, your contractor profile has been rejected.";
            TwilioHelper::sendSMS('GardenHelp', $singleRequest->phone_number, $body);
        } else {
            $singleRequest->status = 'completed';
            $singleRequest->save();
            //update user password send sms to contractor with login details
            $user = User::find($singleRequest->user_id);
            $new_pass = Str::random(6);
            $user->password = bcrypt($new_pass);
            $user->save();
            //Sending SMS
            $body = "Hi $user->name, your contractor profile has been accepted. ".
                "Login details are the email: $user->email and the password: $new_pass . ".
                "Web app: ".url('contractors_app');
            TwilioHelper::sendSMS('GardenHelp', $singleRequest->phone_number, $body);

            try{
                $stripe_manager = new StripeManager();
                $stripe_account = $stripe_manager->createCustomAccount($user,'individual',5261);
            }catch(\Exception $exception){
                \Log::error($exception->getMessage(),$exception->getTrace());
            }

            alert()->success('Contractor accepted successfully');
        }
        return redirect()->route('garden_help_getContractorsRequests', 'garden-help');
    }

    public function getJobsList(Request $request) {
        $availableJobs = Customer::where('type', 'job')->
            whereNull('contractor_id')->get();
        $myJobs = Customer::where('type', 'job')->
        where('contractor_id', $request->user()->id)->get();

        return response()->json([
            'available_jobs' => $availableJobs,
            'my_jobs' => $myJobs,
        ]);
    }

    public function getJobDetails(Request $request) {
        $job_id = $request->get('job_id');
        $job = Customer::find($job_id);
        if(!$job){
            $response = [
                'order' => [],
                'message' => 'No order was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        } else if ($job->type == 'request') {
            $response = [
                'order' => [],
                'message' => 'No order was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }

        $response = [
            'job' => $job,
            'message' => 'Job retrieved successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function updateJobDriverStatus(Request $request) {
        $erorrs = Validator::make($request->all(), [
            'job_id' => 'required',
            'status' => 'required|in:accepted,rejected,on_route,arrived,completed'
        ]);

        if ($erorrs->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter',
            ], 402);
        }
        //Check if this job exists
        $job = Customer::where('id', $request->job_id)
            ->where('type', 'job')->first();
        if($job) {
            if (!in_array($request->status, ['accepted', 'rejected'])) {
                if($job->contractor_id != $request->user()->id){
                    return response()->json([
                        'message' => 'This order does not belong to this driver',
                        'error' => 1
                    ],403);
                }
                if ($request->status == 'on_route') {
                    $job->status = $request->status;
                    $body = "The contractor is on his way to you.";
                    TwilioHelper::sendSMS('GardenHelp', $job->phone, $body);
                } elseif ($request->status=='arrived') {
                    $job->status = $request->status;
                } elseif($request->status=='completed'){
                    $job->status = $request->status;
                }
                $job->save();
                if ($request->status!='delivery_arrived') {
                    Redis::publish('garden-help-channel', json_encode([
                        'event' => 'update-job-status',
                        'data' => [
                            'id' => $job->id,
                            'status' => $job->status,
                            'contactor' => $job->contractor ? $job->contractor->name : null,
                        ]
                    ]));
                }
                return response()->json([
                    'message' => 'The job\'s status has been updated successfully',
                    'delivery_confirmation_code' => /*$request->status == 'completed' ? $order->delivery_confirmation_code : null */ Str::random(6),
                    'error' => 0
                ]);
            } else {
                if($request->status == 'accepted'){
                    if($job->contractor_id != null && $job->contractor_id != $request->user()->id){
                        return response()->json([
                            'message' => 'This job has already been taken by another contractor',
                            'error' => 1
                        ], 403);
                    }
                    $job->status = 'matched';
                    $job->contractor_id = $request->user()->id;
                    //Sending Twilio SMS
                    $body = "Your request has accepted by: " . $request->user()->name . " and has been scheduled in " . $job->available_date_time;
                    TwilioHelper::sendSMS('GardenHelp', $job->phone_number, $body);
                } elseif ($request->status == 'rejected'){
                    if($job->driver != $request->user()->id){
                        return response()->json([
                            'message' => 'This job does not belong to this contractor',
                            'error' => 1
                        ], 403);
                    }
                    $job->status = 'ready';
                    $job->contractor_id = null;
                }
                $job->save();
                Redis::publish('garden-help-channel', json_encode([
                    'event' => 'update-job-status',
                    'data' => [
                        'id' => $job->id,
                        'status' => $job->status,
                        'contactor' => $job->contractor ? $job->contractor->name : null,
                    ]
                ]));
                return response()->json([
                    'message' => 'The job\'s status has been updated successfully',
                    'error' => 0
                ]);
            }
        }
        return response()->json([
            'errors' => 1,
            'message' => 'No job was found with this ID'
        ], 403);
    }

    public function changePassword(Request $request) {
        $errors = \Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($errors->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter',
            ], 402);
        }

        if (password_verify($request->old_password, auth()->user()->password)) {
            User::find(auth()->user()->id)->update([
                'password' => bcrypt($request->new_password)
            ]);
            return response()->json([
                'errors' => 0,
                'message' => 'Your password has changed successfully'
            ]);
        } else {
            return response()->json([
                'errors' => 1,
                'message' => 'The old password is not matched.'
            ], 403);
        }
    }

    public function updateProfile(Request $request) {
        $errors = \Validator::make($request->all(), [
            'business_hours' => 'required',
            'business_hours_json' => 'required',
            'name' => 'required',
        ]);

        if ($errors->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter',
            ], 402);
        }
        //Update User Name
        $user =  User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->is_profile_completed = true;
        $user->save();
        //Update User profile
        $contractor = Contractor::where('user_id', $user->id)->first();
        $contractor->update([
            'name' => $request->name,
            'business_hours' => $request->business_hours,
            'business_hours_json' => json_encode($request->business_hours_json),
        ]);
        return response()->json([
            'errors' => 0,
            'message' => 'Your profile has updated successfully.'
        ]);
    }

    public function getProfile(Request $request) {
        return response()->json([
            'errors' => 0,
            'data' => [
                'full_name' => auth()->user()->name,
                'phone' => auth()->user()->phone,
                'email' => auth()->user()->email,
            ]
        ]);
    }
}
