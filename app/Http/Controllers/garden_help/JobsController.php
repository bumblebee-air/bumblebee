<?php
namespace App\Http\Controllers\garden_help;

use App\Contractor;
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
        
        $contractors = Contractor::where('status', 'completed')->get();

        return view('admin.garden_help.jobs_table.single_job', ['job' => $customer_request,'contractors'=>$contractors]);
    }
    
    public function assignContractorToJob(Request $request){
        $job_id = $request->get('jobId');
        $contractor_id = $request->get('contractorId');

        $job = Customer::find($job_id);
        $contractor = Contractor::find($contractor_id);

        if (!$job) {
            abort(404);
        }

        $job->status = 'assigned';
        $job->contractor_id = $contractor_id;
        $job->save();

        //Redis code

        alert()->success( "The job has been successfully assigned to $contractor->name");
        return redirect()->to('garden-help/jobs_table/jobs');
    }

    public function addNewJob() {
        return view('admin.garden_help.jobs_table.add_job');
    }
}
