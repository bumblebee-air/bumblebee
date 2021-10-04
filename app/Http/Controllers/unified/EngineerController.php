<?php
namespace App\Http\Controllers\unified;

use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
use App\KPITimestamp;
use App\UnifiedCustomer;
use App\UnifiedEngineer;
use App\UnifiedEngineerJob;
use App\UnifiedEngineerJobExpenses;
use App\UnifiedJob;
use App\UnifiedJobType;
use App\UnifiedService;
use App\User;
use App\UserPasswordReset;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Twilio\Rest\Client;

class EngineerController extends Controller
{

    public function getEngineersList()
    {
        $engineers = UnifiedEngineer::all();
        return view('admin.unified.engineers.list', [
            'engineers' => $engineers
        ]);
    }

    public function deleteEngineer(Request $request)
    {
        $checkIfExists = UnifiedEngineer::find($request->engineerId);
        if(!$checkIfExists) {
            alert()->warning("There no engineer with this id #$request->engineerId");
            return redirect()->back();
        }
        $checkIfExists->user->delete();
        $checkIfExists->delete();
        alert()->success('Engineer deleted successfully');
        return redirect()->route('unified_getEngineersList', 'unified');
    }
    
    public function getAddEngineer(){
        
        return view('admin.unified.engineers.add_engineer');
    }
    
    public function postAddEngineer(Request $request) {
        $this->validate($request, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|unique:users,phone|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'address' => 'required',
            'job_type' => 'required|in:full_time,contract',
            'address_coordinates' => 'required',
        ]);
        UnifiedEngineer::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'address_coordinates' => $request->address_coordinates,
            'job_type' => $request->job_type,
        ]);
        $user_password = Str::random(8);
        $user = new User();
        $user->name = "$request->first_name $request->last_name";
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($user_password);
        $user->user_role = 'unified_engineer';
        $user->save();
        /*
         * Sending The credentials to the user
         */
        $body = "Welcome to Unified. These are your credentials to be able to access the mobile app. email: $request->email, password: $user_password";
        TwilioHelper::sendSMS('Unified', $request->phone, $body);
        alert()->success('Engineer added successfully');
        return redirect()->route('unified_getEngineersList', 'unified');
    }
    
    public function getSingleEngineer($client_name, $id) {
        $checkIfExists = UnifiedEngineer::find($id);
        if(!$checkIfExists) {
            alert()->warning("There no engineer with this id #$id");
            return redirect()->back();
        }
        
        return view('admin.unified.engineers.single_engineer', [
            'engineer' => $checkIfExists,
            'readOnly' => 1]);
    }
    
    public function getSingleEngineerEdit($client_name, $id) {
        $checkIfExists = UnifiedEngineer::find($id);
        if(!$checkIfExists) {
            alert()->warning("There no engineer with this id #$id");
            return redirect()->back();
        }
        return view('admin.unified.engineers.single_engineer', [
            'engineer' => $checkIfExists,
            'readOnly' => 0
        ]);
    }
    
    public function postEditEngineer(Request $request) {
        $checkIfExists = UnifiedEngineer::find($request->engineer_id);
        if(!$checkIfExists) {
            alert()->warning("There no engineer with this id #$request->engineer_id");
            return redirect()->back();
        }
        $checkIfExists->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'address_coordinates' => $request->address_coordinates,
            'job_type' => $request->job_type,
        ]);
        alert()->success('Engineer updated successfully');
        return redirect()->route('unified_getEngineersList', 'unified');
    }

    public function getJobsList(Request $request) {
        $this->validate($request, [
            'status' => 'in:in_progress,completed'
        ]);
        $user = $request->user();
        $engineer_profile = $user->engineer_profile;
        $jobs = UnifiedJob::query();
        if ($request->has('status')) {
            $jobs = $jobs->whereHas('engineers', function ($q) use ($engineer_profile, $request) {
                $q->where('engineer_id', $engineer_profile->id)->where('status', $request->status);
            });
        } else {
            $jobs = $jobs->whereHas('engineers', function ($q) use ($engineer_profile, $request) {
                $q->where('engineer_id', $engineer_profile->id)->whereNotIn('status', ['skipped', 'completed', 'checked_out']);
            });
        }
        if ($request->has('job_type_id')) {
            $jobs = $jobs->where('job_type_id', $request->job_type_id);
        }
        $jobs = $jobs->with(['service', 'job_type', 'engineers' => function($q) use ($engineer_profile) {
            $q->where('engineer_id', $engineer_profile->id);
        }]);
        $jobs = $jobs->with(['service', 'job_type', 'engineers' => function($q) use ($engineer_profile) {
            $q->where('engineer_id', $engineer_profile->id);
        }]);
        $jobs = $jobs->paginate(50);
        foreach ($jobs as $job) {
            $job->company = $job->customer;
            $job->kpi_timestamps = KPITimestamp::where('model','=','unified_job_engineer')
                ->where('model_id','=',$job->id)->first();
            $job_engineers = UnifiedEngineerJob::where('job_id', $job->id)->get();
            $engineers_names = [];
            foreach ($job_engineers as $engineer) {
                $job_engineer_profile = $engineer->engineer;
                if ($job_engineer_profile) {
                    $engineers_names[] = "$job_engineer_profile->first_name $job_engineer_profile->last_name";
                }
            }
            $job->engineers_names = $engineers_names;
        }
        return response()->json([
            'data' => $jobs
        ]);
    }

    public function getJobsTypes(Request $request) {
        $jobs_types = UnifiedJobType::all();
        return response()->json([
            'data' => $jobs_types
        ]);
    }

    public function getJobDetails(Request $request, $id) {
        $user = $request->user();
        $engineer_profile = $user->engineer_profile;
        $job = UnifiedJob::with(['service', 'job_type', 'engineers' => function ($q) use ($engineer_profile) {
            $q->where('engineer_id', $engineer_profile->id)->first();
        }])->find($id);
        if (!$job) {
            return response()->json([
                'message' => 'The job id is not valid.'
            ],422);
        }
        if ($job->engineer_id && $job->engineer_id != $engineer_profile->id) {
            return response()->json([
                'message' => 'The job id is assigned to another engineer.'
            ],422);
        }
        $engineer_job = $job->engineers->where('engineer_id', $engineer_profile->id);
        $job->kpi_timestamps = KPITimestamp::where('model','=','unified_job_engineer')
            ->where('model_id','=',$engineer_job[0]->id)->first();
        return response()->json([
            'data' => $job
        ]);
    }

    public function postJob(Request $request, $id) {
        $user = $request->user();
        $engineer_profile = $user->engineer_profile;
        $job = UnifiedJob::find($id);
        if (!$job) {
            return response()->json([
                'message' => 'The job id is not valid.'
            ],422);
        }
        $engineer_job = $job->engineers->where('engineer_id', $engineer_profile->id)->first();
        $timestamps = KPITimestamp::where('model','=','unified_job_engineer')
            ->where('model_id','=',$engineer_job->id)->first();
        if(!$timestamps){
            $timestamps = new KPITimestamp();
            $timestamps->model = 'unified_job_engineer';
            $timestamps->model_id = $engineer_job->id;
        }
        //Check If the job checked out by the engineer
        $checkIfJobAssignedToTheEngineer = $job->engineers->where('engineer_id', $engineer_profile->id)->first();
        if ($checkIfJobAssignedToTheEngineer && $checkIfJobAssignedToTheEngineer->status == 'checked_out') {
            return response()->json([
                'message' => 'The job is checked out.'
            ],422);
        }
        if ($request->has('status')) {
            $this->validate($request, [
                'status' => 'in:in_progress,accepted,completed,arrived,picked_up,skipped',
                'skip_reason' => 'required_if:status,==,skipped'
            ]);
            switch ($request->status) {
                case 'in_progress':
                    $timestamps->in_progress = Carbon::now();
                    break;
                case 'accepted':
                    $timestamps->accepted = Carbon::now();
                    break;
                case 'completed':
                    $timestamps->completed = Carbon::now();
                    break;
                case 'picked_up':
                    $timestamps->arrived_first = Carbon::now();
                    break;
                case 'arrived':
                    $timestamps->arrived_second = Carbon::now();
                    break;
            }
            if ($checkIfJobAssignedToTheEngineer) {
                $checkIfJobAssignedToTheEngineer->update([
                    'status' => $request->status,
                    'skip_reason' => $request->skip_reason,
                ]);
            } else {
                UnifiedEngineerJob::create([
                    'status' => $request->status,
                    'engineer_id' => $engineer_profile->id,
                    'job_id' => $id
                ]);
            }
            $timestamps->save();
        } else {
            $this->validate($request, [
                'additional_job_type_id' => 'exists:unified_job_types,id',
                'service_id' => 'exists:unified_services_job,id',
                'comment' => 'string|max:500',
                'number_of_hours' => 'numeric',
                'additional_cost' => 'numeric',
                'expenses_receipts' => 'array',
                'expenses_receipts.*' => 'mimes:jpeg,jpg,png|required|max:10000',
                'job_images' => 'array',
                'job_images.*' => 'required|mimes:jpeg,jpg,png|required|max:10000',
            ]);
            if (!$checkIfJobAssignedToTheEngineer) {
                return response()->json([
                    'message' => 'The job id is not assigned to you.'
                ],422);
            }
            $job_images_paths = [];
            $expenses_receipts_paths = [];
            if ($request->has('job_images')) {
                foreach ($request->job_images as $key => $job_image) {
                    $job_images_paths[] = $request->job_images[$key]->store('uploads/unified_uploads');
                }
            }
            if ($request->has('expenses_receipts')) {
                foreach ($request->expenses_receipts as $key => $expenses_receipt) {
                    $expenses_receipts_paths[] = $request->expenses_receipts[$key]->store('uploads/unified_uploads');
                }
            }
            $checkIfJobAssignedToTheEngineer->update([
                'service_id' => $request->service_id,
                'job_images' => json_encode($job_images_paths),
                'expenses_receipts' => json_encode($expenses_receipts_paths),
                'comment' => $request->comment,
                'additional_cost' => $request->additional_cost,
                'additional_job_type_id' => $request->additional_job_type_id,
                'is_feedback_filled' => true,
                'number_of_hours' => $request->number_of_hours,
                'rejection_reason' => $request->rejection_reason,
                'skip_reason' => $request->skip_reason,
            ]);
        }
        return response()->json([
            'message' => 'Success'
        ]);
    }

    public function getServices() {
        $service = UnifiedService::all();
        return response()->json([
            'message' => 'Success.',
            'data' => $service
        ]);
    }

    public function updateLocation(Request $request) {
        $this->validate($request, [
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);
        $user = $request->user();
        $engineer_profile = $user->engineer_profile;
        $engineer_profile->latest_coordinates = ['lat' => $request->lat, 'lng' => $request->lng];
        $engineer_profile->latest_coordinates_updated_at = Carbon::now();
        $engineer_profile->save();
        return response()->json([
            'message' => 'Success.'
        ]);
    }

    public function checkOutJobs(Request $request) {
        $user = $request->user();
        $engineer_profile = $user->engineer_profile;
        $completed_jobs = UnifiedJob::whereHas('engineers', function ($q) use ($engineer_profile) {
            $q->where('engineer_id', $engineer_profile->id)->where('status', 'completed');
        })->get();

        $feedback_filled_jobs_count = UnifiedJob::whereHas('engineers', function ($q) use ($engineer_profile) {
            $q->where('engineer_id', $engineer_profile->id)->where('status', 'completed')->where('is_feedback_filled', true);
        })->count();

        if ($completed_jobs->count() != $feedback_filled_jobs_count) {
            return response()->json([
                'message' => 'There is a job not filled with the feedback.'
            ], 422);
        }
        foreach ($completed_jobs as $completed_job) {
            $engineer_job = $completed_job->engineers->where('engineer_id', $engineer_profile->id)->first();
            if ($engineer_job) {
                $engineer_job->update([
                    'status' => 'checked_out'
                ]);
            }
        }
        return response()->json([
            'message' => 'Success.'
        ]);
    }
}
