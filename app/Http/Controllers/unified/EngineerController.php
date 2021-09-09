<?php
namespace App\Http\Controllers\unified;

use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
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
        $user_password = bcrypt(Str::random(8));
        $user = new User();
        $user->name = "$request->first_name $request->last_name";
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = $user_password;
        $user->role = 'unified_engineer';
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
        $jobs = $jobs->where(function ($query) use ($engineer_profile) {
            $query->whereHas('engineers', function ($q) use ($engineer_profile) {
                $q->where('engineer_id', $engineer_profile->id)->where('status', '!=', 'skipped');
            })->orDoesntHave('engineers');
        });
        if ($request->has('job_type_id')) {
            $jobs = $jobs->where('job_type_id', $request->job_type_id);
        }
        if ($request->has('status')) {
            $jobs = $jobs->whereHas('engineers', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $jobs = $jobs->with(['customer', 'engineers' => function ($q) {
            $q->where('engineer_id', auth()->user()->id)->first();
        }]);
        $jobs = $jobs->paginate(50);
        foreach ($jobs as $job) {
            $job->company = $job->customer;
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
        $job = UnifiedJob::with(['customer', 'engineers' => function ($q) {
            $q->where('engineer_id', auth()->user()->id)->first();
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
        $job->company = $job->customer;
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
        } else {
            $this->validate($request, [
                'additional_job_type_id' => 'exists:unified_job_types,id',
                'service_id' => 'exists:unified_services_job,id',
                'comment' => 'string|max:500',
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
                'comment' => json_encode($expenses_receipts_paths),
                'additional_cost' => $request->additional_cost,
                'additional_job_type_id' => $request->additional_job_type_id
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
}
