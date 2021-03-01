<?php
namespace App\Http\Controllers\garden_help;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobsController extends Controller
{

    public function getJobsTable()
    {
        $jobs = Customer::where('type', 'job')
            ->orderBy('id', 'desc')->paginate(20);

        return view('admin.garden_help.jobs_table.jobs', [
            'jobs' => $jobs
        ]);
    }
    
    public function getSingleJob($client_name, $id) {
        $customer_request = Customer::find($id);
        $customer_request->email = $customer_request->user->email;
        // dd($customer_request);
        if (!$customer_request) {
            abort(404);
        }
        
        $contractors = collect([
            [
                'id' => 1,
                'name' => 'abc contractor',
                'level' => 'Level 2',
                'away_km' => '10'
            ],[
                'id' => 2,
                'name' => 'contractor 2',
                'level' => 'Level 2',
                'away_km' => '15'
            ],[
                'id' => 3,
                'name' => 'contractor ss',
                'level' => 'Level 1',
                'away_km' => '10'
            ]
        ]);
        
        
          return view('admin.garden_help.jobs_table.single_job', ['job' => $customer_request,'contractors'=>$contractors]);
        
    }
    
    public function assignContractorToJob(Request $request){
        $job_id = $request->get('jobId');
        $contractor_id = $request->get('contractorId');
       
        alert()->success( "The job has been successfully assigned to $contractor_id");
        return redirect()->to('garden-help/jobs_table/jobs');
    }
}
