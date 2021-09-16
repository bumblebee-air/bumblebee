<?php
namespace App\Http\Controllers\unified;

use App\Customer;
use App\Http\Controllers\Controller;
use App\UnifiedCompany;
use App\UnifiedCustomer;
use App\UnifiedEngineer;
use App\UnifiedEngineerJob;
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
        $viewName = $request->viewName;
        $viewTitle = $request->viewTitle;

        if ($viewName == 'agendaWeek') {
            $month = substr($viewTitle, 0, 3);
            $year = substr($viewTitle,-4);
            $parsed_date = Carbon::parse("$month, $year");
            $end_date->subDay();
        } else {
            $parsed_date = Carbon::parse($viewTitle);
        }
        $services = UnifiedService::withCount([
            'jobs' => function ($q) use ($parsed_date) {
                $q->whereMonth('start_at', $parsed_date->month)->whereYear('start_at', $parsed_date->year);
            }
        ])->get();

        // Get Services Events by day
        $events = [];
        $daysOfMonth = $end_date->diffInDays($start_date);
        $date_for_loop = Carbon::createFromTimestamp($request->start_date);
        for ($i = 0; $i < $daysOfMonth+1; $i ++) {
            foreach ($services as $service) {
                $JobsCount = UnifiedJob::where('service_id', $service->id)->whereDate('start_at', $date_for_loop->toDateString())
                    ->count();
                if ($JobsCount > 0) {
                    $events[] = [
                        'id' => $service->id,
                        'start' => $date_for_loop->toDateString(),
                        'end' => $date_for_loop->toDateString(),
                        'backgroundColor' => $service->backgroundColor,
                        'borderColor' => $service->borderColor,
                        'textColor' => '',
                        'className' => '',
                        'title' => $JobsCount,
                        'serviceId' => $service->id
                    ];
                }
            }
            $expiredContracts = UnifiedCustomer::whereDate('contract_end_date', $date_for_loop)->get();
            if (count($expiredContracts) > 0) {
                $events[] = [
                    'id' => '',
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
            $date_for_loop->addDay();
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
            if ($customerData->contract_start_date) {
                $customerData->contractStartDate = Carbon::parse($customerData->contract_start_date)->format('m/d/Y');
            }
            if ($customerData->contract_end_date) {
                $customerData->contractEndDate = Carbon::parse($customerData->contract_end_date)->format('m/d/Y');
            }
        }

        $customerData->addressLatlng = array(
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
        //$engineer = UnifiedEngineer::find($request->engineerId);
        $engineer = UnifiedEngineer::where('id',$request->engineerId)->first();
        //dd($engineer);
        return response()->json(array(
            "msg" => "test test engineer location",
            "engineer" => $request->engineerId,
            "location" => json_encode($engineer->address_coordinates)
        ));
    }

    public function postAddScheduledJob(Request $request, $client_name)
    {
        $this->validate($request, [
            'typeOfJob' => 'required|exists:unified_job_types,id',
            'engineer' => 'required|array',
            'engineer.*' => 'required|exists:unified_engineers,id',
            'selectedServiceType' => 'required|exists:unified_services_job,id',
            'date' => 'required',
            'time' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'companyName' => 'required|exists:unified_customers_list,id'
        ]);
        $customer = UnifiedCustomer::find($request->companyName);
        $service = UnifiedService::find($request->selectedServiceType);
        $title = "$customer->name / $service->name / $request->time";
        $job = new UnifiedJob();
        $job->title = $title;
        $job->address = $request->address;
        $job->address_coordinates = json_decode($request->address_coordinates);
        $job->start_at = Carbon::parse("$request->date $request->time")->toDateTimeString();
        $job->end_at = Carbon::parse("$request->date $request->time")->toDateTimeString();
        $job->email = $request->email;
        $job->phone = $request->phone;
        $job->mobile = $request->mobile;
        $job->job_type_id = $request->typeOfJob;
        $job->service_id = $request->selectedServiceType;
        $job->is_reminder = (bool) $request->send_reminder;
        $job->company_id = $customer->id;
        $job->job_description = $request->job_description;
        $job->accounts_note = $request->accounts_note;
        $job->cost_estimate = $request->costEstimate;
        $job->pickup_address = $request->pickupAddress;
        $job->pickup_coordinates = json_decode($request->pickup_coordinates);
        $job->date = Carbon::parse($request->date)->toDateString();
        $job->time = Carbon::parse($request->time)->toTimeString();
        $job->save();

        foreach ($request->engineer as $engineer) {
            UnifiedEngineerJob::create([
                'status' => 'assigned',
                'job_id' => $job->id,
                'engineer_id' => $engineer,
            ]);
        }
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
            if ($customer->contract_start_date) {
                $jobData->contractStartDate = Carbon::parse($customer->contract_start_date)->format('m/d/Y');
            }
            if ($customer->contract_end_date) {
                $jobData->contractEndDate = Carbon::parse($customer->contract_end_date)->format('m/d/Y');
            }
        }

        return response()->json(array(
            "msg" => "test test ",
            "job" => $jobData
        ));
    }

    public function getEditScheduledJob($client_name, $id)
    {
        $jobData = UnifiedJob::with(['engineers'])->find($id);
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
        $jobData->engineers_array = $jobData->engineers->pluck('engineer_id')->toArray();
        $jobData->contract = (bool) $customer->contract;
        $jobData->sendEmail = (bool) $jobData->is_reminder;
        $jobData->serviceTypes = $serviceTypes;

        $jobData->pickup_needed = $jobData->pickup_address ? 1 : 0;
        $jobData->pickupAddress = $jobData->pickup_address;
        $jobData->costEstimate = $jobData->cost_estimate;

//        $jobData->engineer_location = array(
//            "lat" => 53.3463204,
//            "lng" => - 6.2586608
//        );
//        $jobData->pickup_coordinates = array(
//            "lat" => 53.34063204,
//            "lng" => - 6.25086608
//        );

        if ($customer->contract) {
            if ($customer->contract_start_date) {
                $jobData->contractStartDate = Carbon::parse($customer->contract_start_date)->format('m/d/Y');
            }
            if ($customer->contract_end_date) {
                $jobData->contractEndDate = Carbon::parse($customer->contract_end_date)->format('m/d/Y');
            }
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
            'engineers' => $engineers,
            'job' => $jobData
        ]);
    }

    public function postEditScheduledJob(Request $request, $client_name)
    {
//        dd($request->all());
        $job = UnifiedJob::find($request->jobId);
        if (! $job) {
            alert()->info('The job was invalid');
            return redirect()->back();
        }
        $this->validate($request, [
            'typeOfJob' => 'required|exists:unified_job_types,id',
            'engineers' => 'required|array',
            'engineers.*' => 'required|exists:unified_engineers,id',
            'selectedServiceType' => 'required|exists:unified_services_job,id',
            'date' => 'required',
            'time' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'companyName' => 'required'
        ]);
        $customer = UnifiedCustomer::find($request->companyName);
        $service = UnifiedService::find($request->selectedServiceType);
//        $title = "$customer->name / $service->name / $request->time / Enginner: $engineer->first_name $engineer->last_name";
        $title = "$customer->name / $service->name / $request->time";
        $job->title = $title;
        $job->address = $request->address;
        $job->start_at = Carbon::parse("$request->date $request->time")->toDateTimeString();
        $job->end_at = Carbon::parse("$request->date $request->time")->toDateTimeString();
        $job->email = $request->email;
        $job->phone = $request->phone;
        $job->mobile = $request->mobile;
        $job->job_type_id = $request->typeOfJob;
        $job->service_id = $request->selectedServiceType;
        $job->is_reminder = (bool) $request->send_reminder;
        $job->company_id = $customer->id;
        $job->job_description = $request->job_description;
        $job->accounts_note = $request->accounts_note;
        $job->cost_estimate = $request->costEstimate;
        $job->pickup_address = $request->pickupAddress;
        $job->pickup_coordinates = json_decode($request->pickup_coordinates);
        $job->date = Carbon::parse($request->date)->toDateString();
        $job->time = Carbon::parse($request->time)->toTimeString();
        $job->update();

        foreach ($request->engineers as $engineer) {
            if (!UnifiedEngineerJob::where('job_id', $job->id)->where('engineer_id', $engineer)->first()) {
                $engineerJob = new UnifiedEngineerJob();
                $engineerJob->job_id = $job->id;
                $engineerJob->engineer_id = $engineer;
                $engineerJob->status = 'assigned';
                $engineerJob->save();

                /*
                 * Notifying User code
                 */
            }
        }
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
        $date = str_replace('%20', ' ', $request->date);
        $serviceId = $request->serviceId; // 0 if all
        $titleModal = '';
        $viewName = $request->viewName;
        if ($viewName) {
            if ($viewName == 'agendaWeek') {
                $month = substr($date, 0,3);
                $year = substr($date, -4);
                $parsed_date = Carbon::parse("$month, $year");
            } else {
                $parsed_date = Carbon::parse($date);
            }
            $jobsList = UnifiedJob::where('service_id', $serviceId)->whereMonth('start_at', $parsed_date->month)
                ->whereYear('start_at', $parsed_date->year)
                ->get();
        } else {
            if ($serviceId == 0) {
                $jobsList = UnifiedJob::whereDate('start_at', $date)->get();

            } else {
                $parsed_date = Carbon::parse($date);
                $jobsList = UnifiedJob::where('service_id', $serviceId)->whereDate('start_at', $parsed_date)->get();
                $service = UnifiedService::find($serviceId);
                $titleModal = $service->name ?: 'N/A'; // service name
            }
        }
        foreach ($jobsList as $job) {
            $job->backgroundColor = $job->service->backgroundColor;
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

    public function getContractExpireList(Request $request) // it is supposed display customers names that their contracts will expire in this day 
    {
        $date = Carbon::parse($request->date);
        $expiredContracts = [];
        $customers = UnifiedCustomer::whereDate('contract_end_date',$date->toDateTimeString())->get();

        foreach ($customers as $customer) {
            $expiredContracts[] = [
                'title' => $customer->name,
                'backgroundColor' => 'rgba(217, 83, 83, 0.5)',
                'customerId' => $customer->id
            ];
        }
        return response()->json(array(
            "msg" => "test test contract expire",
            "jobsList" => $expiredContracts,
            "titleModal" => "Contract Expiry List"
        ));
    }
}

