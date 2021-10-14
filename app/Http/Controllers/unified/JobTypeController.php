<?php
namespace App\Http\Controllers\unified;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UnifiedJobType;

class JobTypeController extends Controller
{
    public function getJobTypesList()
    {
        $job_types = UnifiedJobType::all();
        
        return view('admin.unified.job_type.list', [
            'job_types' => $job_types
        ]);
    }
    
    public function deleteJobType(Request $request)
    {
        $checkIfExists = UnifiedJobType::find($request->jobTypeId);
        if(!$checkIfExists) {
            alert()->warning("There no job type with this id #$request->jobTypeId");
            return redirect()->back();
        }
        $checkIfExists->delete();
        
        alert()->success('Job type deleted successfully');
        return redirect()->route('unified_getJobTypesList', 'unified');
    }
    
    public function getAddJobType()
    {
        return view('admin.unified.job_type.add_job_type');
    }
    
    public function postAddJobType(Request $request)
    {
        $jobType = new UnifiedJobType();
        $jobType->name = $request->name;
        $jobType->save();
        
        alert()->success('Job type saved successfully');
        return redirect()->route('unified_getJobTypesList', 'unified');
    }
    
    public function getSingleJobType($client_name, $id)
    {
        $jobType =  UnifiedJobType::find($id);
        
        return view('admin.unified.job_type.single_job_type', [
            'jobType' => $jobType,
            'readOnly' => 1
        ]);
    }
    
    public function getSingleJobTypeEdit($client_name, $id)
    {
        $jobType =  UnifiedJobType::find($id);
        
        return view('admin.unified.job_type.single_job_type', [
            'jobType' => $jobType,
            'readOnly' => 0
        ]);
    }
    
    public function postEditJobType(Request $request)
    {
        $jobType = UnifiedJobType::find($request->job_type_id);
        if (! $jobType) {
            alert()->error('The job type was not exist.');
            return redirect()->back();
        }
        $jobType->name = $request->name;
        $jobType->save();
        
        alert()->success('Job type has updated successfully');
        return redirect()->route('unified_getJobTypesList', 'unified');
    }
}

