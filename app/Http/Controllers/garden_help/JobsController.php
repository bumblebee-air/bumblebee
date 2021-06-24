<?php
namespace App\Http\Controllers\garden_help;

use App\Contractor;
use App\Customer;
use App\CustomerExtraData;
use App\GardenServiceType;
use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
use App\User;
use App\UserClient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Twilio\Rest\Client;

class JobsController extends Controller
{

    public function getJobsTable()
    {
        $jobs = Customer::where('type', 'job')->orderBy('id', 'desc')->paginate(20);

        return view('admin.garden_help.jobs_table.jobs', [
            'jobs' => $jobs
        ]);
    }

    public function getSingleJob($client_name, $id)
    {
        $customer_request = Customer::find($id);
        if ($customer_request->user != null) {
            $customer_request->email = $customer_request->user->email;
        }
        // dd($customer_request);
        if (! $customer_request) {
            abort(404);
        }

        $contractors = Contractor::where('status', 'completed')->get();
        // dd($customer_request);
        if ($customer_request->status != 'ready' ) {
            $contractor = Contractor::where('user_id', $customer_request->contractor_id)->first();
            return view('admin.garden_help.jobs_table.single_job', [
                'job' => $customer_request,
                'contractor' => $contractor,
                'contractors' => [],
                'reassign'=>0
            ]);
        } else {
            return view('admin.garden_help.jobs_table.single_job', [
                'job' => $customer_request,
                'contractors' => $contractors,
                'reassign'=>0
            ]);
        }
    }

    public function getSingleJobReassign($client_name, $id)
    {
        $customer_request = Customer::find($id);
        if ($customer_request->user != null) {
            $customer_request->email = $customer_request->user->email;
        }
        // dd($customer_request);
        if (! $customer_request) {
            abort(404);
        }

        $contractors = Contractor::where('status', 'completed')->get();
        // dd($customer_request);

        return view('admin.garden_help.jobs_table.single_job', [
            'job' => $customer_request,
            'contractors' => $contractors,
            'reassign'=>1
        ]);
    }

    public function assignContractorToJob(Request $request)
    {
        $job_id = $request->get('jobId');
        $contractor_id = $request->get('contractorId');

        $job = Customer::find($job_id);
        $contractor = Contractor::find($contractor_id);

        if (! $job) {
            abort(404);
        }

        $job->status = 'assigned';
        $job->contractor_id = $contractor->user->id;
        $job->save();
        $user_tokens = $contractor->user->firebase_tokens;
        if (count($user_tokens) > 0) {
            self::sendFCM($user_tokens, [
                'title' => 'Job assigned',
                'message' => "Job #$job_id has been assigned to you",
                'order_id' => $job_id
            ]);
        }
        $sid = env('TWILIO_SID', '');
        $token = env('TWILIO_AUTH', '');
        $twilio = new Client($sid, $token);
        $twilio->messages->create($contractor->user->phone, [
            "from" => "GardenHelp",
            "body" => "Hi $contractor->name, there is an job assigned to you, please open your app. " . url('contractors_app#/order-details/' . $job_id)
        ]);

        alert()->success("The job has been successfully assigned to $contractor->name");
        return redirect()->to('garden-help/jobs_table/jobs');
    }

    public function addNewJob()
    {
        $services = GardenServiceType::all();
        foreach ($services as $item) {
            $item->title = $item->name;
            $item->is_checked = $item->false;
            $item->is_recurring = "0";
        }
        return view('admin.garden_help.jobs_table.add_job', ['services' => $services]);
    }

    public function postNewJob(Request $request)
    {
        $this->validate($request, [
            'work_location' => 'required'
        ]);
        if ($request->work_location == 'other') {
            $this->validate($request, [
                'email' => 'required'
            ]);

            $customer = new Customer();
            $customer->email = $request->email;
            $customer->work_location = $request->work_location;
            $customer->save();
        } else {
            $this->validate($request, [
                'type_of_work' => 'required|in:Commercial,Residential',
                'name' => 'required',
                'email' => 'required',
                'contact_through' => 'required',
                'phone' => 'required_if:type_of_work,Residential',
                /*'password' => 'required_if:type_of_work,Residential|confirmed',*/
                'service_types' => 'required_if:type_of_work,Residential',
                'location' => 'required_if:type_of_work,Residential',
                'location_coordinates' => 'required_if:type_of_work,Residential',
                'property_photo' => 'required_if:type_of_work,Residential',
                'is_first_time' => 'required_if:type_of_work,Residential',
                'last_services' => 'required_if:is_first_time,0',
                /*'site_details' => 'required_if:is_first_time,0',*/
                'is_parking_site' => 'required_if:type_of_work,Residential',
                'contact_name' => 'required_if:type_of_work,Commercial',
                'contact_number' => 'required_if:type_of_work,Commercial',
                'available_date_time' => 'required_if:type_of_work,Commercial',
                'stripeToken' => 'required'
            ]);

            $user = User::where('email','=',$request->email)
                ->where('phone','=',$request->phone)->first();
            if(!$user) {
                $check_phone = User::where('phone','=',$request->phone)->first();
                if($check_phone!=null){
                    alert()->error('This phone number is already registered with another email!');
                    return redirect()->back()->withInput();
                }
                $check_email = User::where('email','=',$request->email)->first();
                if($check_email!=null){
                    alert()->error('This email is already registered with another phone number!');
                    return redirect()->back()->withInput();
                }
                //Create User
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->phone = ($request->type_of_work == 'Commercial') ? $request->contact_number : $request->phone;
                $user->password = $request->password ? bcrypt($request->password) : bcrypt(Str::random(8));
                $user->user_role = 'customer';
                $user->save();

                $client = \App\Client::where('name', 'GardenHelp')->first();
                if($client) {
                    //Making Client Relation
                    UserClient::create([
                        'user_id' => $user->id,
                        'client_id' => $client->id
                    ]);
                }
            }

            // Create Customer
            $customer = new Customer();
            $customer->user_id = $user->id;
            $customer->work_location = $request->work_location;
            $customer->type_of_work = $request->type_of_work;
            $customer->name = $request->name;
            $customer->type = 'job';
            $customer->status = 'ready';
            $customer->contact_through = $request->contact_through;
            $customer->phone_number = $request->phone;
            // $customer->password = $request->password;
            $customer->service_types = $request->service_types;
            $customer->location = $request->location;
            $customer->location_coordinates = $request->location_coordinates;
            $customer->property_photo = $request->hasFile('property_photo') ? $request->file('property_photo')->store('uploads/customers_uploads') : null;
            $customer->property_size = $request->property_size;
            $customer->is_first_time = $request->is_first_time;
            $customer->last_service = $request->last_services;
            $customer->site_details = $request->site_details;
            $customer->is_parking_access = $request->is_parking_site;
            $customer->contact_name = $request->contact_name;
            $customer->contact_number = $request->contact_number;
            $customer->available_date_time = $request->available_date_time;
            $customer->area_coordinates = $request->area_coordinates;
            $customer->address = $request->address;
            $customer->services_types_json = $request->services_types_json;
            $customer->save();

            try {
                $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
                $stripe_customer = $stripe->customers->create([
                    'name' => $customer->user->name,
                    'email' => $customer->user->email,
                    'source' => $request->stripeToken
                ]);
            } catch (\Exception $e) {
                alert()->error($e->getMessage());
                return redirect()->back();
            }
            $stripe_customer_id = $stripe_customer->id;
            //Saving customer id
            CustomerExtraData::create([
                'user_id' => $customer->user_id,
                'job_id' => $customer->id,
                'stripe_customer_id' => $stripe_customer_id
            ]);
            if ($customer->phone_number) {
                TwilioHelper::sendSMS('GardenHelp', $customer->phone_number, 'Your job has been received. Thank you for using GardenHelp.');
            }
        }
        alert()->success("The job is added successfully");
        return redirect()->to('garden-help/jobs_table/add_job');
    }
}
