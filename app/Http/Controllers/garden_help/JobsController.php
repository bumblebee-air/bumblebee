<?php
namespace App\Http\Controllers\garden_help;

use App\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobsController extends Controller
{

    public function getJobsTable()
    {
        $jobs_table = collect([
            [
                'created_at' => '25/2/2021',
                'scheduled_at' => '1/3/2021 10:00',
                'service_type' => 'Garden Maintenance',
                'job_number' => '1',
                'status' => 'not_assigned',
                'stage_width'=>0,
                'customer_name' => 'sara reda'
            ],[
                'created_at' => '25/2/2021',
                'scheduled_at' => '1/3/2021 10:00',
                'service_type' => 'Garden Maintenance',
                'job_number' => '2',
                'status' => 'assigned',
                'stage_width'=>20,
                'customer_name' => 'sara reda'
            ],[
                'created_at' => '25/2/2021',
                'scheduled_at' => '1/3/2021 10:00',
                'service_type' => 'Garden Maintenance',
                'job_number' => '3',
                'status' => 'accepted',
                'stage_width'=>40,
                'customer_name' => 'sara reda'
            ], [
                'created_at' => '25/2/2021',
                'scheduled_at' => '1/3/2021 10:00',
                'service_type' => 'Garden Maintenance',
                'job_number' => '4',
                'status' => 'on_way_job_location',
                'stage_width'=>60,
                'customer_name' => 'sara reda'
            ],[
                'created_at' => '25/2/2021',
                'scheduled_at' => '1/3/2021 10:00',
                'service_type' => 'Garden Maintenance',
                'job_number' => '5',
                'status' => 'arrived_to_job_location',
                'stage_width'=>80,
                'customer_name' => 'sara reda'
            ],[
                'created_at' => '25/2/2021',
                'scheduled_at' => '1/3/2021 10:00',
                'service_type' => 'Garden Maintenance',
                'job_number' => '6',
                'status' => 'completed',
                'stage_width'=>100,
                'customer_name' => 'sara reda'
            ]
        ]);
       
        
        
        return view('admin.garden_help.jobs_table.jobs', [
            'jobs_table' => $jobs_table
        ]);
    }
    
    public function getSingleJob($client_name, $id) {
        $customer_request = Customer::find($id);
        $customer_request->email = $customer_request->user->email;
        // dd($customer_request);
        if (!$customer_request) {
            abort(404);
        }
          return view('admin.garden_help.jobs_table.single_job', ['job' => $customer_request]);
        
    }
}
