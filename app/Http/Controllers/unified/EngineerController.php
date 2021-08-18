<?php
namespace App\Http\Controllers\unified;

use App\Http\Controllers\Controller;
use App\UnifiedCustomer;
use App\UnifiedEngineer;
use App\UnifiedJob;
use App\UnifiedJobType;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255',
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
        if ($request->has('job_type_id')) {
            $jobs = $jobs->where('job_type_id', $request->job_type_id);
        }
        $jobs = $jobs->whereHas('engineers', function ($q) use ($engineer_profile) {
            $q->where('engineer_id', $engineer_profile->id);
        });
        if ($request->has('status')) {
            $jobs = $jobs->whereHas('engineers', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        } else {
            $jobs = $jobs->whereHas('engineers', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }
        $jobs = $jobs->get();
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
        $job = UnifiedJob::find($id);
        if (!$job) {
            return response()->json([
                'message' => 'The job id is not valid.'
            ],422);
        }
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
            $this->validate($request->status, [
                'status' => 'in:in_progress,accepted,completed,arrived,picked_up'
            ]);
        } else {
            $this->validate($request, [
                'job_type_id' => 'required|exists:unified_job_types,id',
                'service_id' => 'required|exists:unified_services_job,id'
            ]);

        }
        return response()->json([
            'message' => 'Success'
        ]);
    }
}
