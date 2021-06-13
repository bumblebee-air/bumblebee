<?php
namespace App\Http\Controllers\unified;

use App\Http\Controllers\Controller;
use App\UnifiedCompany;
use App\UnifiedCustomer;
use App\UnifiedEngineer;
use App\UnifiedJob;
use App\UnifiedJobType;
use App\UnifiedService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\True_;

class CalendarController extends Controller
{

    public function getCalendar()
    {
        $services = UnifiedService::withCount(['jobs' => function($q) {
            $q->whereDate('start_at', '>=', Carbon::now()->toDateString())->whereDate('end_at', '<=', Carbon::now()->toDateString());
        }])->get();
        $events = UnifiedJob::whereDate('start_at', '>=', Carbon::now()->toDateString())->whereDate('end_at', '<=', Carbon::now()->toDateString())->get();
     //  dd($events);
        $companyNames = UnifiedCustomer::select(['id', 'name'])->get();
        $jobTypes = UnifiedJobType::all();
        $engineers = UnifiedEngineer::all();

        $eventData = new EventData(11, "", "2021-06-06", "2021-06-06", "transparent");
        $eventData->textColor='#d95353';
        $eventData->className='expireContract';
        
        $event1 = new EventData(1, "1", "2021-06-06", "2021-06-06", "#41aec2bf");
        
        
        $eventData2 = new EventData(11, "", "2021-06-07", "2021-06-07", "transparent");
        $eventData2->textColor='#d95353';
        $eventData2->className='expireContract';
        
        
        $eventData3 = new EventData(11, "", "2021-06-08", "2021-06-08", "transparent");
        $eventData3->textColor='#d95353';
        $eventData3->className='expireContract';
        
        $event2 = new EventData(2, "10", "2021-06-08", "2021-06-08", "#41aec2bf");
        
      // $events=array($eventData,$event1,$eventData2,$event2,$eventData3);
        
        return view('admin.unified.calendar', [
            'services' => $services,
            'events' => json_encode($events),
            'companyNames' => $companyNames,
            'jobTypes' => $jobTypes,
            'engineers' => $engineers
        ]);
    }

    public function getCompanyData(Request $request)
    {
        $customerData = UnifiedCustomer::find($request->companyId);

//       $customerData = new CustomerData($request->companyId, "ACCA Ireland", "", true, "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com", "12345678", "98745632");

        $serviceTypesIDs = array_column($customerData->services->toArray(), 'service_id');
        $customerData->serviceType = UnifiedService::whereIn('id', $serviceTypesIDs)->get();
        if ($customerData->contacts) {
            $contactJson = json_decode($customerData->contacts, true);
            $customerData->contact = $contactJson[0]['contactName'];
            $customerData->email = $contactJson[0]['contactEmail'];
            $customerData->mobile = $contactJson[0]['contactNumber'];
        }
        
        if($customerData->contract){
            $customerData->contractStartDate = '06/01/2021';
            $customerData->contractEndDate = '06/30/2021';
        }
        
        return response()->json(array(
            "msg" => "test test",
            "company" => $customerData
        ));
    }

    public function postAddScheduledJob(Request $request, $client_name)
    {
        //dd($request);
         $this->validate($request, [
            'typeOfJob' => 'required|exists:unified_job_types,id',
            'engineer' => 'required|exists:unified_engineers,id',
            'selectedServiceType' => 'required|exists:unified_services_job,id',
            'date' => 'required',
            'time' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'companyName' => 'required|exists:unified_jobs,id',
        ]); 
        $customer = UnifiedCustomer::find($request->companyName);
        $engineer = UnifiedEngineer::find($request->engineer);
        $service = UnifiedService::find($request->selectedServiceType);
        $title = "$customer->name / $service->name / $request->time / Enginner: $engineer->name";
        $job = new UnifiedJob();
        $job->title = $title;
        $job->address = $request->address;
        $job->start_at = Carbon::parse("$request->date $request->time")->toDateTimeString();
        $job->end_at = Carbon::parse("$request->date $request->time")->toDateTimeString();
        $job->email = $request->email;
        $job->phone = $request->phone;
        $job->mobile = $request->mobile;
        $job->engineer_id = $request->engineer;
        $job->job_type_id = $request->typeOfJob;
        $job->service_id = $request->selectedServiceType;
        $job->is_reminder = (bool)$request->send_reminder;
        $job->company_id = $customer->id;
        $job->save();

        alert()->success('The job created successfully');
        return redirect()->back();
    }

    public function getJobData(Request $request)
    {
        $jobData = UnifiedJob::find($request->jobId);
        $serviceTypes = UnifiedService::whereHas('customers', function ($q) use ($jobData) {
            $q->where('customer_id', $jobData->company_id);
        })->select(['id', 'name'])->get();
        $customer = $jobData->customer;
        $jobData->jobTypeId = $jobData->job_type_id;
        $jobData->companyName = $customer->name;
        $jobData->companyId = $customer->id;
        $jobData->selectedServiceType = $jobData->service_id;
        $jobData->date = Carbon::parse($jobData->start_at)->format('m/d/Y');
        $jobData->time = Carbon::parse($jobData->start_at)->format('h:i A');
        $jobData->engineerId = $jobData->engineer_id;
        $jobData->contract = (bool)$customer->contract;
        $jobData->sendEmail = (bool)$jobData->is_reminder;
        $jobData->serviceTypes = $serviceTypes;
        
        
        if($customer->contract){
            $jobData->contractStartDate = '07/01/2021';
            $jobData->contractEndDate = '07/30/2021';
        }

        return response()->json(array(
            "msg" => "test test ",
            "job" => $jobData
        ));
    }

    public function postEditScheduledJob(Request $request, $client_name)
    {
        $job = UnifiedJob::find($request->jobId);
        if (!$job) {
            abort(404);
        }

        $this->validate($request, [
            'typeOfJob' => 'required|exists:unified_job_types,id',
            'engineer' => 'required|exists:unified_engineers,id',
            'selectedServiceType' => 'required|exists:unified_services_job,id',
            'date' => 'required',
            'time' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'companyName' => 'required',
        ]); 
        $customer = UnifiedCustomer::find($request->companyName);
        $engineer = UnifiedEngineer::find($request->engineer);
        $service = UnifiedService::find($request->selectedServiceType);
        $title = "$customer->name / $service->name / $request->time / Enginner: $engineer->name";
        $job->title = $title;
        $job->address = $request->address;
        $job->start_at = Carbon::parse("$request->date $request->time")->toDateTimeString();
        $job->end_at = Carbon::parse("$request->date $request->time")->toDateTimeString();
        $job->email = $request->email;
        $job->phone = $request->phone;
        $job->mobile = $request->mobile;
        $job->engineer_id = $request->engineer;
        $job->job_type_id = $request->typeOfJob;
        $job->service_id = $request->selectedServiceType;
        $job->is_reminder = (bool)$request->send_reminder;
        $job->company_id = $customer->id;
        $job->update();

        alert()->success('The job updated successfully');
        return redirect()->back();
    }

    public function postDeleteScheduledJob(Request $request, $client_name)
    {
        $job = UnifiedJob::find($request->jobId);
        if (!$job) {
            abort(404);
        }
        $job->delete();
        alert()->success('The job deleted successfully');
        return redirect()->back();
    }

    public function getJobList(Request $request)
    {
        $date = $request->date;
        $serviceId = $request->serviceId; // 0 if all
        $titleModal = '';
        $viewName = '';
        if($request->viewName){
            $viewName= $request->viewName;
        }

        if ($serviceId == 0) {
            $jobsList = UnifiedJob::whereDate('start_at', Carbon::parse($date)->toDateString())->get();
            foreach ($jobsList as $job) {
                $job->backgroundColor = $job->service->backgroundColor;
            }
        } else {
            $jobsList = UnifiedJob::where('service_id', $serviceId)->whereDate('start_at', Carbon::parse($date)->toDateString())->get();
            foreach ($jobsList as $job) {
                $job->backgroundColor = $job->service->backgroundColor;
            }
            $service = UnifiedService::find($serviceId);
            $titleModal = $service->name?: 'N/A'; // service name
        }

        return response()->json(array(
            "msg" => "test test job list ",
            "jobsList" => $jobsList,
            "titleModal"=>$titleModal
        ));
    }
    
    public function getCompanyListOfService(Request $request){
        $serviceId = $request->serviceId;
        $companyNames = array();
        
        if($serviceId==0){// get all customers
            $companyNames = UnifiedCustomer::select(['id', 'name'])->get();
            
        }else{
            $companyNames = UnifiedCustomer::whereHas('services', function ($q) use ($serviceId) {
                $q->where('services_id', $serviceId);
            })->select(['id', 'name'])->get();
        }
        return response()->json(array(
            "msg" => "test test company list ",
            "companyNames" => $companyNames,
        ));
    }
    public function getContractExpireList(Request $request) {
        $date = $request->date;
        
        $event1 = new EventData(1, "ACCA Ireland ".$date, null, NULL, 'rgba(217, 83, 83, 0.5)');
        $events =array($event1);
        
        return response()->json(array(
            "msg" => "test test contractt expire ",
            "jobsList" => $events,
            "titleModal"=>"Contract Expiry List"
        ));
    }
}


class EventData
{
    
    public $id, $title, $start, $end, $backgroundColor;
    
    public function __construct($id, $title, $start, $end, $backgroundColor)
    {
        $this->id = $id;
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        $this->backgroundColor = $backgroundColor;
    }
}

