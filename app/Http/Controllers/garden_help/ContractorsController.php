<?php
namespace App\Http\Controllers\garden_help;

use App\ClientSetting;
use App\Contractor;
use App\ContractorBidding;
use App\Customer;
use App\Helpers\CustomNotificationHelper;
use App\Helpers\GardenHelpUsersNotificationHelper;
use App\Helpers\ServicesTypesHelper;
use App\Helpers\StripePaymentHelper;
use App\Helpers\TwilioHelper;
use App\JobTimestamp;
use App\KPITimestamp;
use App\Mail\ContractorRegistrationMail;
use App\Mail\ContractorRegistrationSuccessMail;
use App\Managers\StripeManager;
use App\TermAndPolicy;
use App\User;
use App\UserClient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Alert;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Twilio\Rest\Client;
use Validator;

class ContractorsController extends Controller
{

    public function index()
    {
        $client = \App\Client::where('name', 'GardenHelp')->first();
        if(!$client){
            alert()->error('GardenHelp tenant is not setup correctly');
            return redirect()->back();
        }
        $terms_policies = TermAndPolicy::where('type', 'contractor')
            ->where('client_id','=',$client->id)->first();
        $terms = '#';
        $privacy = '#';
        if($terms_policies){
            $terms = $terms_policies->terms!=null? asset($terms_policies->terms) : '#';
            $privacy = $terms_policies->policy!=null? asset($terms_policies->policy) : '#';
        }
        return view('garden_help.contractors.registration',["termsFile"=>$terms,"privacyFile"=>$privacy]);
    }

    public function save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone_number' => 'required|string',
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

        $user = User::where('email','=',$request->email)
            ->where('phone','=',$request->phone_number)->first();
        if(!$user) {
            $check_phone = User::where('phone', '=', $request->phone_number)->first();
            if ($check_phone != null) {
                alert()->error('This phone number is already registered with another email!');
                return redirect()->back()->withInput();
            }
            $check_email = User::where('email', '=', $request->email)->first();
            if ($check_email != null) {
                alert()->error('This email is already registered with another phone number!');
                return redirect()->back()->withInput();
            }
            //Create User
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone_number;
            $user->password = bcrypt(Str::random(8));
            $user->user_role = 'contractor';
            $user->save();

            $client = \App\Client::where('name', 'GardenHelp')->first();
            if ($client) {
                // Making Client Relation
                UserClient::create([
                    'user_id' => $user->id,
                    'client_id' => $client->id
                ]);
            }
        }

        // Saving new contractor registration
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

        \Mail::to(env('GH_NOTIF_EMAIL', 'kim@bumblebeeai.io'))->send(new ContractorRegistrationMail($contractor));
        if ($contractor->email != null && $contractor->email != '') {
            \Mail::to($contractor->email)->send(new ContractorRegistrationSuccessMail($contractor));
        }

        Redis::publish('garden-help-channel', json_encode([
            'event' => 'new-contractor-request'.'-'.env('APP_ENV','dev'),
            'data' => [
                'id' => $contractor->id,
                'toast_text' => 'There is a new contractor request.',
                'alert_text' => "There is a new contractor request! with order No# $contractor->id",
                'click_link' => route('garden_help_getContractorSingleRequest', [
                    'garden-help',
                    $contractor->id
                ])
            ]
        ]));

        //Customer Notification
        CustomNotificationHelper::send('new_contractor', $contractor->id, 'GardenHelp');

        alert()->success('You registration saved successfully');
        return redirect()->back();
    }

    public function getContractorsRequests()
    {
        $contractors_requests = Contractor::paginate(20);
        return view('admin.garden_help.contractors.requests', [
            'contractors_requests' => $contractors_requests
        ]);
    }

    public function getSingleRequest($client_name, $id)
    {
        $contractor_request = Contractor::find($id);
        if (! $contractor_request) {
            alert()->error('Contractor request not found!');
            return redirect()->back();
        }
        return view('admin.garden_help.contractors.single_request', [
            'contractor_request' => $contractor_request
        ]);
    }

    public function postSingleRequest(Request $request, $client_name, $id)
    {
        $singleRequest = Contractor::find($id);
        if (! $singleRequest) {
            alert()->error('Contractor request not found!');
            return redirect()->back();
        }
        if ($request->rejection_reason) {
            $singleRequest->rejection_reason = $request->rejection_reason;
            $singleRequest->status = 'missing';
            $singleRequest->save();
            alert()->success('Contractor rejected successfully');
            // Sending SMS
            $body = "Hi " . $singleRequest->name . ",
             we are sorry, your contractor profile has been rejected.";
//            TwilioHelper::sendSMS('GardenHelp', $singleRequest->phone_number, $body);
            GardenHelpUsersNotificationHelper::notifyUser($singleRequest->user, $body, $singleRequest->contact_through);
        } else {
            $singleRequest->status = 'completed';
            $singleRequest->save();
            // update user password send sms to contractor with login details
            $user = User::find($singleRequest->user_id);
            try {
                $stripe_manager = new StripeManager();
                $stripe_account = $stripe_manager->createCustomAccount($user, 'individual', 5261);
            } catch (\Exception $exception) {
                \Log::error($exception->getMessage(), $exception->getTrace());
            }
            alert()->success('Contractor accepted successfully');
        }
        return redirect()->route('garden_help_getContractorsRequests', 'garden-help');
    }

    public function getJobsList(Request $request)
    {
        $availableJobs = Customer::where('type', 'job')->whereNull('contractor_id')->where('status', '!=', 'completed')->get();
        $myJobs = Customer::where('type', 'job')->where('contractor_id', $request->user()->id)
            ->where('status', '!=', 'completed')->get();

        return response()->json([
            'available_jobs' => $availableJobs,
            'my_jobs' => $myJobs
        ]);
    }

    public function getJobDetails(Request $request)
    {
        $job_id = $request->get('job_id');
        $job = Customer::find($job_id);
        if (! $job) {
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
        if(!$job->customer_confirmation_code) {
            $job->customer_confirmation_code = Str::random(10);
        }
        if (!$job->contractor_confirmation_code) {
            $job->contractor_confirmation_code = Str::random(10);
        }
        $job->save();
        $job->kpi_timestamps = KPITimestamp::where('model', 'gardenhelp_job')->where('model_id', $job_id)->first();
        $response = [
            'job' => $job,
            'message' => 'Job retrieved successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function updateJobDriverStatus(Request $request)
    {
        $erorrs = Validator::make($request->all(), [
            'job_id' => 'required',
            'status' => 'required|in:accepted,rejected,on_route,arrived,completed'
        ]);

        if ($erorrs->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter'
            ], 402);
        }
        // Check if this job exists
        $job = Customer::where('id', $request->job_id)->where('type', 'job')->first();
        if ($job) {
            $timestamps = KPITimestamp::where('model','=','gardenhelp_job')
                ->where('model_id','=',$job->id)->first();
            if(!$timestamps){
                $timestamps = new KPITimestamp();
                $timestamps->model = 'gardenhelp_job';
                $timestamps->model_id = $job->id;
            }
            $current_timestamp = Carbon::now();
            $current_timestamp = $current_timestamp->toDateTimeString();
            if (! in_array($request->status, [
                'accepted',
                'rejected'
            ])) {
                if ($job->contractor_id != $request->user()->id) {
                    return response()->json([
                        'message' => 'This job does not belong to this contractor',
                        'error' => 1
                    ], 403);
                }
                if ($request->status == 'on_route') {
                    $job->status = $request->status;
//                    $body = "The contractor is on his way to you.";
                    $timestamps->on_the_way_first = $current_timestamp;
//                    TwilioHelper::sendSMS('GardenHelp', $job->phone_number, $body);
                } elseif ($request->status == 'arrived') {
                    $job->status = $request->status;
                    $timestamps->arrived_first = $current_timestamp;
                } elseif ($request->status == 'completed') {
                    // Saving Job Image
                    if ($request->job_image) {
                        $base64_images = $request->job_image;
                        $job_images_json = [];
                        foreach ($base64_images as $job_image) {
                            $base64_image_format = '';
                            if (preg_match('/^data:image\/(\w+);base64,/', $job_image, $base64_image_format)) {
                                $data = substr($job_image, strpos($job_image, ',') + 1);
                                $data = base64_decode($data);
                                $base64_image_path = 'uploads/jobs_uploads/' . Str::random(10) . ".$base64_image_format[1]";
                                Storage::disk('local')->put($base64_image_path, $data);
                                $job_images_json[] = $base64_image_path;
                            }
                        }
                        $job->job_image = $job_images_json;
                    }
                    // Saving extra receipt Image
//                    if ($request->extra_expenses_receipt) {
//                        $base64_image = $request->extra_expenses_receipt;
//                        $base64_image_format = '';
//                        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image, $base64_image_format)) {
//                            $data = substr($base64_image, strpos($base64_image, ',') + 1);
//                            $data = base64_decode($data);
//                            $base64_image_path = 'uploads/jobs_uploads/' . Str::random(10) . ".$base64_image_format[1]";
//                            Storage::disk('local')->put($base64_image_path, $data);
//                            $job->job_expenses_receipt_file = $base64_image_path;
//                        }
//                    }
                    $job->status = $request->status;
                    $job->skip_reason = $request->skip_reason;
                    $job->job_services_types_json = $request->job_services_types_json;
                    $job->job_other_expenses_json = $request->extra_expenses_json;
                    $job->notes = $request->notes;
                    //Capture the payment intent
//                    $extra_expenses = ServicesTypesHelper::getExtraExpensesAmount($request->extra_expenses_json);
//                    $services_amount = ServicesTypesHelper::getJobServicesTypesAmount($job);
//                    $services_amount_vat = ServicesTypesHelper::getVat(13.5, $services_amount);
//                    $actual_services_amount = ServicesTypesHelper::getJobServicesTypesAmount($job, true) + $services_amount_vat;
//                    $total_amount = $actual_services_amount + $services_amount_vat + $extra_expenses;
//                    $client_setting = '';
//                    if ($actual_services_amount > $services_amount) {
//                        if (StripePaymentHelper::chargePayment($total_amount, $job->stripe_customer->stripe_customer_id)) {
//                            StripePaymentHelper::cancelPaymentIntent($job->payment_intent_id);
//                        } else {
//                            if (StripePaymentHelper::capturePaymentIntent($job->payment_intent_id)) {
//                                $job->payment_details_object = json_encode([
//                                    'payment_type' => 'partial', //paid, partial
//                                    'residualـvalue' => $actual_services_amount - $total_amount
//                                ]);
//                            }
//                        }
//                    } else if ($actual_services_amount < $services_amount) {
//                        StripePaymentHelper::capturePaymentIntent($job->payment_intent_id, $actual_services_amount);
//                    } else {
                        StripePaymentHelper::capturePaymentIntent($job->payment_intent_id);
//                    }
                    //Transfer to the connected account
                    if ($job->contractor->contractor_profile && $job->contractor->contractor_profile->experience_level_value) {
                        $client_setting = ClientSetting::where('name', "lvl_".$job->contractor->contractor_profile->experience_level_value."_percentage")->first();
                        if ($client_setting) {
                            StripePaymentHelper::transferPaymentToConnectedAccount($request->user()->stripe_account->account_id, round(($client_setting->the_value / 100 ) * $actual_services_amount));
                        }
                    }
                    $job->is_paid = true;
                    $timestamps->completed = $current_timestamp;

                    if (count($job->job_timestamps) > 0) {
                        $job->job_timestamps()->orderBy('id', 'desc')->first()->update([
                            'stopped_at' => Carbon::now()
                        ]);
                    }

                    //Sending confirmation URL to the customer
                    if ($job->user && $job->user->phone) {
                        $body = "Hi $job->name, GardenHelp service has been completed, open the link to scan the QR code and confirm the job. " . url('gh/customer/job/' . $job->customer_confirmation_code);
//                        TwilioHelper::sendSMS('GardenHelp', $job->user->phone, $body);
                        GardenHelpUsersNotificationHelper::notifyUser($job->user, $body, $job->contact_through);
                    }
                }
                $job->save();
                if ($request->status != 'delivery_arrived') {
                    Redis::publish('garden-help-channel', json_encode([
                        'event' => 'update-job-status'.'-'.env('APP_ENV','dev'),
                        'data' => [
                            'id' => $job->id,
                            'status' => $job->status,
                            'contactor' => $job->contractor ? $job->contractor->name : null
                        ]
                    ]));
                }
                return response()->json([
                    'message' => 'The job\'s status has been updated successfully',
                    'delivery_confirmation_code' => /*$request->status == 'completed' ? $order->delivery_confirmation_code : null */ Str::random(6),
                    'error' => 0
                ]);
            } else {
                if ($request->status == 'accepted') {
                    if ($job->contractor_id != null && $job->contractor_id != $request->user()->id) {
                        return response()->json([
                            'message' => 'This job has already been taken by another contractor',
                            'error' => 1
                        ], 403);
                    }
                    $job->status = 'matched';
                    $job->contractor_id = $request->user()->id;
                    // Sending Twilio SMS
                    $body = "Your request has accepted by: " . $request->user()->name . " and has been scheduled on " . $job->available_date_time;
//                    TwilioHelper::sendSMS('GardenHelp', $job->phone_number, $body);
                    GardenHelpUsersNotificationHelper::notifyUser($job->user, $body, $job->contact_through);

                    $timestamps->accepted = $current_timestamp;
                } elseif ($request->status == 'rejected') {
                    if ($job->driver != $request->user()->id) {
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
                    'event' => 'update-job-status'.'-'.env('APP_ENV','dev'),
                    'data' => [
                        'id' => $job->id,
                        'status' => $job->status,
                        'contactor' => $job->contractor ? $job->contractor->name : null,
                        'toast_text' => "A contractor has updated a job status",
                        'alert_text' => $request->status == "accepted" ? "A contractor has accepted a job #$job->id" : "A contractor has rejected a job #$job->id",
                        'click_link' => route('garden_help_getSingleJob', ['client_name' => 'garden-help', 'id' => $job->id]),
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

    public function changePassword(Request $request)
    {
        $errors = \Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);

        if ($errors->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter'
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

    public function updateProfile(Request $request)
    {
        $errors = \Validator::make($request->all(), [
            'business_hours' => 'required',
            'business_hours_json' => 'required',
            'name' => 'required'
        ]);

        if ($errors->fails()) {
            return response()->json([
                'errors' => 1,
                'message' => 'There is an invalid parameter'
            ], 402);
        }
        // Update User Name
        $user = User::find(auth()->user()->id);
        $user->name = $request->name;
        $user->is_profile_completed = true;
        $user->save();
        // Update User profile
        $contractor = Contractor::where('user_id', $user->id)->first();
        $contractor->update([
            'name' => $request->name,
            'business_hours' => $request->business_hours,
            'business_hours_json' => json_encode($request->business_hours_json)
        ]);
        return response()->json([
            'errors' => 0,
            'message' => 'Your profile has updated successfully.'
        ]);
    }

    public function getProfile(Request $request)
    {
        return response()->json([
            'errors' => 0,
            'data' => [
                'full_name' => auth()->user()->name,
                'phone' => auth()->user()->phone,
                'email' => auth()->user()->email,
                'business_hours' => json_decode($request->user()->contractor_profile->business_hours_json, true)
            ]
        ]);
    }

    public function getContractorsList()
    {
        $contractors = Contractor::where('status', 'completed')->paginate(20);
        return view('admin.garden_help.contractors.completed_contractors', [
            'contractors' => $contractors
        ]);
    }

    public function getSingleContractor($client, $id)
    {
        $contractor = Contractor::find($id);
        if (! $contractor) {
            alert()->error('Contractor not found!');
            return redirect()->back();
        }
        return view('admin.garden_help.contractors.single_contractor', [
            'contractor' => $contractor,
            'readOnly' => 1
        ]);
    }

    public function getSingleContractorEdit($client, $id)
    {
        $contractor = Contractor::find($id);
        if (! $contractor) {
            alert()->error('Contractor not found!');
            return redirect()->back();
        }
        return view('admin.garden_help.contractors.single_contractor', [
            'contractor' => $contractor,
            'readOnly' => 0
        ]);
    }

    public function postEditContractor(Request $request)
    {
        $contractor = Contractor::find($request->contractorId);
        if (!$contractor) {
            alert()->warning('There is contractor with ths ID.');
            return redirect()->back();
        }

        $contractor->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'experience_level' => $request->experience_level,
            'experience_level_value' => $request->experience_level_value,
            'age_proof' => $request->hasFile('age_proof') ? $request->file('age_proof')->store('uploads/contractors_uploads') : $contractor->age_proof,
            'cv' => $request->hasFile('cv') ? $request->file('cv')->store('uploads/contractors_uploads') : null,
            'job_reference' => $request->hasFile('job_reference') ? $request->file('job_reference')->store('uploads/contractors_uploads') : $contractor->job_reference,
            'available_equipments' => $request->available_equipments,
            'type_of_work_exp' => $request->type_of_work_exp,
            'address' => $request->address,
            'address_coordinates' => $request->address_coordinates,
            'company_number' => $request->company_number,
            'vat_number' => $request->vat_number,
            'insurance_document' => $request->hasFile('insurance_document') ? $request->file('insurance_document')->store('uploads/contractors_uploads') : $contractor->insurance_document,
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
        alert()->success('Contractor updated successfully');
        return redirect()->to('garden-help/contractors/contractors_list');
    }

    public function postDeleteContractor(Request $request)
    {
        $contractor_id = $request->get('contractorId');
        $contractor_profile = Contractor::find($contractor_id);
        if(!$contractor_profile){
            alert()->error('Contractor not found!');
        }
        $user = User::find($contractor_profile->user_id);
        $contractor_profile->delete();
        if($user!=null){
            $user_client = UserClient::where('user_id','=',$user->id)->first();
            if($user_client!=null){
                $user_client->delete();
            }
            $user->delete();
        }
        alert()->success('Contractor deleted successfully');
        return redirect()->back();
    }

    public function getContractorsRoster(Request $request)
    {
        return view('admin.garden_help.contractors.roster');
    }

    public function getContractorsRosterEvents(Request $request)
    {
        $this->validate($request, [
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
        $start_date = Carbon::createFromTimestamp($request->start_date);
        $end_date = Carbon::createFromTimestamp($request->end_date);
        $days_count = $start_date->diffInDays($end_date) + 1;
        $contractors = Contractor::where('status', 'completed')->get();
        $events_array = [];
        $current_contractors = [];
        for ($i = 1; $i < $days_count; $i++) {

            $currentDate = Carbon::parse($start_date)->addDays($i);
            $currentDayName = $currentDate->format('l');
            $contractors_count_lvl1 = 0;
            $contractors_count_lvl2 = 0;
            $contractors_count_lvl3 = 0;
            $list_of_contractors = [];


            foreach ($contractors as $contractor) {
                if ($contractor->business_hours_json) {
                    $contractor_business_hours = json_decode($contractor->business_hours_json, true);
                    if($contractor_business_hours[$currentDayName]['isActive']){
                        $contractor_level = "contractors_count_lvl$contractor->experience_level_value";
                        $$contractor_level++;
                        $list_of_contractors[]=[
                            'title' => "$contractor->name / $contractor->experience_level / ".$contractor_business_hours[$currentDayName]['timeFrom']."-".$contractor_business_hours[$currentDayName]['timeTill']." / $contractor->address",
                            'className' => "level$contractor->experience_level_value"
                        ];
                    }
                }
            }
            for ($x=1; $x < 4; $x++) {
                $contractors_count_lvl = "contractors_count_lvl$x";
                if ($$contractors_count_lvl > 0) {
                    $events_array[] = [
                        'title' => $$contractors_count_lvl." contractors",
                        'start' => $currentDate->format('Y-m-d'),
                        'className' => "level$x",
                    ];
                }
            }
            $current_contractors[$currentDate->format('Y-m-d')] = $list_of_contractors;
        }
        return response()->json([
            'events' => $events_array,
            'contractors' => $current_contractors
        ]);
    }

    public function getContractorsFee(Request $request) {
        $client_id = $request->user()->client->client_id;
        $setting = ClientSetting::where('client_id', $client_id)->get();
        return view('admin.garden_help.contractors.fee_list', [
            'settings' => $setting
        ]);
    }

    public function editContractorsFee(Request $request) {
        $fee = ClientSetting::where('name', $request->fee_name)->where('client_id', $request->user()->client->client_id)->first();
        if (!$fee) {
            alert()->error('Contractor fee not found!');
            return redirect()->back();
        }
        return view('admin.garden_help.contractors.fee_edit', [
            'fee' => $fee
        ]);
    }

    public function updateContractorsFee(Request $request) {
        $fee = ClientSetting::find($request->id);
        if (!$fee) {
            alert()->error('Contractor fee not found!');
            return redirect()->back();
        }
        $fee->the_value = $request->the_value;
        $fee->save();
        alert()->success('Fee has updated successfully');
        return redirect()->route('garden_help_getContractorsFee', 'garden-help');
    }

    public function deleteContractorRequest(Request $request, $client_id, $id) {
        $contractor = Contractor::find($id);
        if (!$contractor) {
            alert()->warning('Contractor is invalid');
        } else {
            alert()->success('Contractor has deleted successfully');
            $contractor->delete();
        }
        return redirect()->back();
    }

    public function editSetting(Request $request) {
        $user = $request->user();
        return response()->json([
            'data' => [
                'is_notifiable' => $user->contractor_profile->is_notifiable
            ]
        ]);
    }

    public function updateSetting(Request $request) {
        $user = $request->user();
        $user->contractor_profile->update([
            'is_notifiable' => $request->is_notifiable
        ]);
        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function skipJobConfirmation(Request $request)
    {
        $skip_reason = $request->get('skip_reason');
        $job_id = $request->get('job_id');
        $job = Customer::find($job_id);
        if (!$job) {
            $response = [
                'order' => [],
                'message' => 'No job was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }
        $job->contractor_confirmation_status = 'skipped'; # skipped || confirmed
        $job->contractor_confirmation_skip_reason = $skip_reason;
        $job->save();
        $response = [
            'message' => 'Job confirmation skipped successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function jobTimeTracker(Request $request) {
        $job_id = $request->get('job_id');
        $status = $request->get('status');
        $job = Customer::find($job_id);
        if (!$job) {
            $response = [
                'order' => [],
                'message' => 'No job was found with this ID',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }
        if ($status == 'start_working' || $status == 'keep_working') {
            $timeTracker = new JobTimestamp([
                'started_at' => Carbon::now(),
            ]);
            $job->job_timestamps()->save($timeTracker);
            $job->contractor_status = 'keep_working';
        } else if($status == 'break') {
            $job->job_timestamps()->orderBy('id', 'desc')->first()->update([
                'stopped_at' => Carbon::now()
            ]);
            $job->contractor_status = 'break';
        }
        $job->save();
        $response = [
            'message' => 'Operation done successfully',
            'error' => 0
        ];
        return response()->json($response)->setStatusCode(200);
    }

    public function postContractorBid(Request $request) {
        $this->validate($request, [
            'estimated_quote' => 'required|min:1',
            'job_id' => 'required|exists:customers_registrations,id'
        ]);
        $job = Customer::find($request->job_id);
        $checkIfBidBefore = ContractorBidding::where('job_id', $request->job_id)->where('contractor_id', $request->user()->contractor_profile->id)->first();
        if ($checkIfBidBefore) {
            $response = [
                'message' => 'You already have a bid.',
                'error' => 1
            ];
            return response()->json($response)->setStatusCode(403);
        }
        ContractorBidding::create([
            'job_id' => $request->job_id,
            'estimated_quote' => $request->estimated_quote,
            'contractor_id' => $request->user()->contractor_profile->id
        ]);
        $response = [
            'message' => 'Operation done successfully',
            'error' => 0
        ];
        //Notify the customer
//        TwilioHelper::sendSMS('GardenHelp', $job->user->phone, 'There a new contractor has offered a new price, please click the following link for more details: '. route('garden_help_getSingleJob', ['garden-help', $job->id]));
        $body = 'A contractor has offered a new price, please click the following link for more details: '. route('garden_help_getSingleJob', ['garden-help', $job->id]);
        GardenHelpUsersNotificationHelper::notifyUser($job->user, $body, $job->contact_through);
        return response()->json($response)->setStatusCode(200);
    }
}
