<?php
namespace App\Http\Controllers\unified;

use App\Customer;
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
        // dd(Carbon::now()->startOfMonth());
        // $services = UnifiedService::withCount(['jobs' => function($q) {
        // $q->whereDate('start_at', '>=', Carbon::now()->startOfMonth()->toDateString())->whereDate('end_at', '<=', Carbon::now()->endOfMonth()->toDateString());
        // }])->get();
        $companyNames = UnifiedCustomer::select([
            'id',
            'name'
        ])->get();
        $jobTypes = UnifiedJobType::all();
        $engineers = UnifiedEngineer::all();

        // Get Services Events by day
        // $events = [];
        // $daysOfMonth = Carbon::now()->daysInMonth + 1;
        // foreach ($services as $service) {
        // for ($i=0; $i < $daysOfMonth; $i++) {
        // $date = Carbon::now()->startOfMonth()->addDays($i);
        // $Jobs = UnifiedJob::where('service_id', $service->id)->whereDate('start_at', $date->toDateString())->get();
        // $normalJobsCount = 0;
        // $expiredJobsCount = 0;

        // foreach ($Jobs as $job) {
        // if ($job->customer->contract) {
        // //if (Carbon::parse($job->customer->contract_start_date)->getTimestamp() <= $date->getTimestamp() && Carbon::parse($job->customer->contract_end_date)->getTimestamp() >= $date->getTimestamp()) {
        // $contract_start_date = Carbon::parse($job->customer->contract_start_date)->startOfDay();
        // $contract_end_date = Carbon::parse($job->customer->contract_end_date)->endOfDay();
        // if ($contract_end_date >= $date) {
        // $normalJobsCount++;
        // } else {
        // $expiredJobsCount++;
        // }
        // } else {
        // $normalJobsCount++;
        // }
        // }
        // if ($normalJobsCount > 0) {
        // $events[] = [
        // 'id' => $service->id,
        // 'start' => $date->toDateString(),
        // 'end' => $date->toDateString(),
        // 'backgroundColor' => $service->backgroundColor,
        // 'borderColor' => $service->borderColor,
        // 'textColor' => '',
        // 'className' => '',
        // 'title' => $normalJobsCount,
        // 'serviceId' => $service->id
        // ];
        // }
        // if ($expiredJobsCount > 0) {
        // $events[] = [
        // 'id' => $service->id,
        // 'start' => $date->toDateString(),
        // 'end' => $date->toDateString(),
        // 'backgroundColor' => 'transparent',
        // 'borderColor' => $service->borderColor,
        // 'textColor' => '#d95353',
        // 'className' => 'expireContract',
        // 'title' => '',
        // 'serviceId' => $service->id
        // ];
        // }
        // }
        // }
        return view('admin.unified.calendar', [
            'companyNames' => $companyNames,
            'jobTypes' => $jobTypes,
            'engineers' => $engineers
        ]);
    }

    public function getCalendarEvents(Request $request)
    {
        $start_date = Carbon::createFromTimestamp($request->start_date);
        $end_date = Carbon::createFromTimestamp($request->end_date);

        $services = UnifiedService::withCount([
            'jobs' => function ($q) use ($start_date, $end_date) {
                $q->whereDate('start_at', '>=', $start_date->toDateString())
                    ->whereDate('end_at', '<=', $end_date->toDateString());
            }
        ])->get();
        //dd($services);

        // Get Services Events by day
        $events = [];
        $daysOfMonth = $end_date->diffInDays($start_date); // Carbon::now()->daysInMonth + 1;
                                                           // dd($start_date .' '.$end_date.' '.$daysOfMonth);
        foreach ($services as $service) {
            $date_for_loop = Carbon::createFromTimestamp($request->start_date);

            for ($i = 0; $i < $daysOfMonth; $i ++) {
                $date_for_loop->addDay();
                $Jobs = UnifiedJob::where('service_id', $service->id)->whereDate('start_at', $date_for_loop->toDateString())
                    ->get();

                $normalJobsCount = 0;
                $expiredJobsCount = 0;

                foreach ($Jobs as $job) {
                    if ($job->customer->contract) {
                        // if (Carbon::parse($job->customer->contract_start_date)->getTimestamp() <= $date->getTimestamp() && Carbon::parse($job->customer->contract_end_date)->getTimestamp() >= $date->getTimestamp()) {
                        $contract_start_date = Carbon::parse($job->customer->contract_start_date)->startOfDay();
                        $contract_end_date = Carbon::parse($job->customer->contract_end_date)->endOfDay();
                        if ($contract_end_date >= $date_for_loop) {
                            $normalJobsCount ++;
                        } else {
                            $expiredJobsCount ++;
                        }
                    } else {
                        $normalJobsCount ++;
                    }
                }
                if ($normalJobsCount > 0) {
                    $events[] = [
                        'id' => $service->id,
                        'start' => $date_for_loop->toDateString(),
                        'end' => $date_for_loop->toDateString(),
                        'backgroundColor' => $service->backgroundColor,
                        'borderColor' => $service->borderColor,
                        'textColor' => '',
                        'className' => '',
                        'title' => $normalJobsCount,
                        'serviceId' => $service->id
                    ];
                }
                if ($expiredJobsCount > 0) {
                    $events[] = [
                        'id' => $service->id,
                        'start' => $date_for_loop->toDateString(),
                        'end' => $date_for_loop->toDateString(),
                        'backgroundColor' => 'transparent',
                        'borderColor' => $service->borderColor,
                        'textColor' => '#d95353',
                        'className' => 'expireContract',
                        'title' => '',
                        'serviceId' => $service->id
                    ];
                }
            }
        }

        return response()->json([
            'events' => json_encode($events),
            'services' => $services
        ]);
    }

    public function getCompanyData(Request $request)
    {
        $customerData = UnifiedCustomer::find($request->companyId);

        $serviceTypesIDs = array_column($customerData->services->toArray(), 'service_id');
        $customerData->serviceType = UnifiedService::whereIn('id', $serviceTypesIDs)->get();
        if ($customerData->contacts) {
            $contactJson = json_decode($customerData->contacts, true);
            $customerData->contact = $contactJson[0]['contactName'];
            $customerData->email = $contactJson[0]['contactEmail'];
            $customerData->mobile = $contactJson[0]['contactNumber'];
        }

        if ($customerData->contract) {
            $customerData->contractStartDate = '06/01/2021';
            $customerData->contractEndDate = '06/30/2021';
        }
        
        $customerData->addressLatlng =  array(
            "lat" => 53.341060324,
            "lng" => - 6.251008668
        );

        return response()->json(array(
            "msg" => "test test",
            "company" => $customerData
        ));
    }

    public function getAddScheduledJob($client_name, $date, $serviceId)
    {
        // dd($date);
        if ($serviceId == 0) { // get all customers
            $companyNames = UnifiedCustomer::select([
                'id',
                'name'
            ])->get();
        } else {
            $companyNames = UnifiedCustomer::whereHas('services', function ($q) use ($serviceId) {
                $q->where('service_id', $serviceId);
            })->select([
                'id',
                'name'
            ])->get();
        }
        $jobTypes = UnifiedJobType::all();
        $engineers = UnifiedEngineer::all();

        return view('admin.unified.add_job', [
            'companyNames' => $companyNames,
            'jobTypes' => $jobTypes,
            'engineers' => $engineers,
            'date' => $date,
            'serviceId' => $serviceId
        ]);
    }

    public function getEngineerLocation(Request $request)
    {
        $location = array(
            "lat" => 53.334613214,
            "lng" => - 6.2581668
        );
        return response()->json(array(
            "msg" => "test test engineer location",
            "engineer" => $request->engineerId,
            "location" => json_encode($location)
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
            'companyName' => 'required|exists:unified_customers_list,id'
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
        $job->is_reminder = (bool) $request->send_reminder;
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
        })->select([
            'id',
            'name'
        ])->get();
        $customer = $jobData->customer;
        $jobData->jobTypeId = $jobData->job_type_id;
        $jobData->companyName = $customer->name;
        $jobData->companyId = $customer->id;
        $jobData->selectedServiceType = $jobData->service_id;
        $jobData->date = Carbon::parse($jobData->start_at)->format('m/d/Y');
        $jobData->time = Carbon::parse($jobData->start_at)->format('h:i A');
        $jobData->engineerId = $jobData->engineer_id;
        $jobData->contract = (bool) $customer->contract;
        $jobData->sendEmail = (bool) $jobData->is_reminder;
        $jobData->serviceTypes = $serviceTypes;

        if ($customer->contract) {
            $jobData->contractStartDate = '07/01/2021';
            $jobData->contractEndDate = '07/30/2021';
        }

        return response()->json(array(
            "msg" => "test test ",
            "job" => $jobData
        ));
    }

    public function getEditScheduledJob($client_name, $id)
    {
        $jobData = UnifiedJob::find($id);
        $serviceTypes = UnifiedService::whereHas('customers', function ($q) use ($jobData) {
            $q->where('customer_id', $jobData->company_id);
        })->select([
            'id',
            'name'
        ])->get();
        $customer = $jobData->customer;
        $jobData->jobTypeId = $jobData->job_type_id;
        $jobData->companyName = $customer->name;
        $jobData->companyId = $customer->id;
        $jobData->selectedServiceType = $jobData->service_id;
        $jobData->date = Carbon::parse($jobData->start_at)->format('m/d/Y');
        $jobData->time = Carbon::parse($jobData->start_at)->format('h:i A');
        $jobData->engineerId = $jobData->engineer_id;
        $jobData->contract = (bool) $customer->contract;
        $jobData->sendEmail = (bool) $jobData->is_reminder;
        $jobData->serviceTypes = $serviceTypes;
        
        $jobData->job_description='description';
        $jobData->accounts_note='notes';
        $jobData->pickup_needed=1;
        $jobData->pickupAddress = 'Killarney, County Kerry, Ireland';
        $jobData->costEstimate=200.0;
        
        $jobData->engineer_location = array(
            "lat" => 53.3463204,
            "lng" => - 6.2586608
        );
        $jobData->address_coordinates=array(
            "lat" => 53.34060324,
            "lng" => - 6.25008668
        );
        $jobData->pickup_coordinates=array(
            "lat" => 53.34063204,
            "lng" => - 6.25086608
        );
        
        
        if ($customer->contract) {
            $jobData->contractStartDate = '07/01/2021';
            $jobData->contractEndDate = '08/30/2021';
        }
        $companyNames = UnifiedCustomer::select([
            'id',
            'name'
        ])->get();

        $jobTypes = UnifiedJobType::all();
        $engineers = UnifiedEngineer::all();

        return view('admin.unified.edit_job', [
            'companyNames' => $companyNames,
            'jobTypes' => $jobTypes,
            'engineers' => $engineers,'job'=>$jobData
        ]);
    }

    public function postEditScheduledJob(Request $request, $client_name)
    {
        //dd($request);
        $job = UnifiedJob::find($request->jobId);
        if (! $job) {
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
            'companyName' => 'required'
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
        $job->is_reminder = (bool) $request->send_reminder;
        $job->company_id = $customer->id;
        $job->update();

        alert()->success('The job updated successfully');
        return redirect()->back();
    }

    public function postDeleteScheduledJob(Request $request, $client_name)
    {
        $job = UnifiedJob::find($request->jobId);
        if (! $job) {
            abort(404);
        }
        $job->delete();
        alert()->success('The job deleted successfully');
        return redirect()->to('unified/calendar');
    }

    public function getJobList(Request $request)
    {
        // dd($request);
        $date = $request->date;
        $serviceId = $request->serviceId; // 0 if all
        $titleModal = '';
        $viewName = '';
        if ($request->viewName) {
            $viewName = $request->viewName;
        }
        if ($serviceId == 0) {
            $jobsList = UnifiedJob::whereDate('start_at', $date)->get();
            foreach ($jobsList as $job) {
                $job->backgroundColor = $job->service->backgroundColor;
            }
        } else {
            $jobsList = UnifiedJob::where('service_id', $serviceId)->whereDate('start_at', '>=', Carbon::now()->startOfMonth()
                ->toDateString())
                ->whereDate('start_at', '<=', Carbon::now()->endOfMonth()
                ->toDateString())
                ->get();
            foreach ($jobsList as $job) {
                $job->backgroundColor = $job->service->backgroundColor;
            }
            $service = UnifiedService::find($serviceId);
            $titleModal = $service->name ?: 'N/A'; // service name
        }

        return response()->json(array(
            "msg" => "test test job list ",
            "jobsList" => $jobsList,
            "titleModal" => $titleModal
        ));
    }

    public function getCompanyListOfService(Request $request)
    {
        $serviceId = $request->serviceId;

        if ($serviceId == 0) { // get all customers
            $companyNames = UnifiedCustomer::select([
                'id',
                'name'
            ])->get();
        } else {
            $companyNames = UnifiedCustomer::whereHas('services', function ($q) use ($serviceId) {
                $q->where('service_id', $serviceId);
            })->select([
                'id',
                'name'
            ])->get();
        }
        return response()->json(array(
            "msg" => "test test company list ",
            "companyNames" => $companyNames
        ));
    }

    public function getContractExpireList(Request $request)
    {
        $date = Carbon::parse($request->date);
        $expiredJobs = [];
        $jobs = UnifiedJob::whereDate('start_at', $date->toDateString())->whereHas('customer', function ($q) use ($date) {
            $q->whereDate('start_at', '>=', Carbon::now()->toDateString())
                ->whereDate('end_at', '<=', Carbon::now()->toDateString());
        })
            ->get();

        foreach ($jobs as $job) {
            $expiredJobs[] = [
                'id' => $job->id,
                'title' => $job->customer->name . " " . $date->toDateString(),
                'start' => '',
                'end' => '',
                'backgroundColor' => 'rgba(217, 83, 83, 0.5)',
                'serviceId' => $job->service_id,
                'customerId' => $job->customer->id
            ];
        }
        return response()->json(array(
            "msg" => "test test contract expire ",
            "jobsList" => $expiredJobs,
            "titleModal" => "Contract Expiry List"
        ));
    }
}

