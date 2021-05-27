<?php
namespace App\Http\Controllers\unified;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\PseudoTypes\True_;

class CalendarController extends Controller
{

    public function getCalendar()
    {
        $service1 = new ServiceData(1, "Hosted/Cpbx", "#d95353", "#d9535326", 2);
        $service2 = new ServiceData(2, "Access Control", "#eeaf07", "#eeaf0726", 3);
        $service3 = new ServiceData(3, "CCTV", "#41aec2", "#41aec226", 1);
        $service4 = new ServiceData(4, "Fire Alarm", "#5fc97c", "#5fc97c26", 0);
        $service5 = new ServiceData(5, "Intruder Alarm", "#f97032", "#f9703226", 3);
        $service6 = new ServiceData(6, "Wifi/Data", "#9e35cf", "#9e35cf26", 1);
        $service7 = new ServiceData(7, "structured cabling systems", "#5f76c9", "#5f76c926", 0);

        $services = array(
            $service1,
            $service2,
            $service3,
            $service4,
            $service5,
            $service6,
            $service7
        );

        $event1 = new EventData(1, "1", "2021-05-05", "2021-05-05", "#41aec2bf"); // background: servicedata->borderColor+'bf'
        $event1->serviceId = 3;
        $event2 = new EventData(2, "4", "2021-05-05", "2021-05-05", "#5fc97cbf");
        $event2->serviceId = 4;
        $event3 = new EventData(3, "3", "2021-05-20", "2021-05-20", "#5f76c9bf");
        $event3->serviceId = 7;

        $events = array(
            $event1,
            $event2,
            $event3
        );

        $company1 = new SelectData(1, "ACCA Ireland");
        $company2 = new SelectData(2, "B&C Contractors Ltd");
        $company3 = new SelectData(3, "Barsan Global Logistics Ltd");
        $companyNames = array(
            $company1
        );

        $jobType1 = new SelectData(1, "Maintenance");
        $jobType2 = new SelectData(2, "Installation");
        $jobTypes = array(
            $jobType1,
            $jobType2
        );

        $engineer1 = new SelectData(1, "John Dow");
        $engineer2 = new SelectData(2, "Peter Adams");
        $engineers = array(
            $engineer1,
            $engineer2
        );

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
        $customerData = new CustomerData($request->companyId, "ACCA Ireland", "", true, "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com", "12345678", "98745632");
        $serviceType1 = new ServiceTypeData(1, "Hosted/Cpbx");
        $serviceType2 = new ServiceTypeData(2, "Access control");
        $serviceType3 = new ServiceTypeData(3, "CCTV");
        $serviceType4 = new ServiceTypeData(4, "Fire Alarm");
        $serviceType5 = new ServiceTypeData(5, "Intruder Alarm");
        $serviceType6 = new ServiceTypeData(6, "Wifi/Data");
        $serviceType7 = new ServiceTypeData(7, "structured cabling systems");
        
        $serviceTypes = array(
            $serviceType1,
            $serviceType2,
            $serviceType3,
            $serviceType4,
            $serviceType5,
            $serviceType6,
            $serviceType7,
        );
        $customerData->serviceType = $serviceTypes;

        return response()->json(array(
            "msg" => "test test ",
            "company" => $customerData
        ));
    }

    public function postAddScheduledJob(Request $request, $client_name)
    {
        //dd($request);
        alert()->success('The job created successfully');
        return redirect()->back();
    }

    public function getJobData(Request $request)
    {
        $serviceType1 = new ServiceTypeData(1, "Hosted/Cpbx");
        $serviceType2 = new ServiceTypeData(2, "Access control");
        $serviceType3 = new ServiceTypeData(3, "CCTV");
        $serviceType4 = new ServiceTypeData(4, "Fire Alarm");
        $serviceType5 = new ServiceTypeData(5, "Intruder Alarm");
        $serviceType6 = new ServiceTypeData(6, "Wifi/Data");
        $serviceType7 = new ServiceTypeData(7, "structured cabling systems");
        
        $serviceTypes = array(
            $serviceType1,
            $serviceType2,
            $serviceType3,
            $serviceType4,
            $serviceType5,
            $serviceType6,
            $serviceType7,
        );
        $jobData = new JobData($request->jobId, 1, "ACCA Ireland", 2, "", $serviceTypes, 2, "05/25/2021", "12:00 AM", 1, "",
            false, "52 Dolphins Barn Street, The Liberties", "shane.martin@accaglobal.com", "123456", "987456321", false);
      
        return response()->json(array(
            "msg" => "test test ",
            "job" => $jobData
        ));
    }

    public function postEditScheduledJob(Request $request, $client_name)
    {
        // dd($request);
        alert()->success('The job updated successfully');
        return redirect()->back();
    }

    public function postDeleteScheduledJob(Request $request, $client_name)
    {
        // dd($request);
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
        $jobsList = array();

        if ($serviceId == 0) {
            $job1 = new EventData(1, "ACCA Ireland / Fire Alarm / 09:00 / Enginner: John Dow", null, null, "#5fc97c66"); //// background: servicedata->borderColor+'66'
            $job2 = new EventData(2, "Bag City Wholesale / Fire Alarm / 09:00 / Enginner: Peter Adams", null, null, "#5fc97c66");
            $job3 = new EventData(3, "AB Logistics / Hosted/Cpbx / 010:00 / Enginner: John Dow", null, null, "#d9535366");
            $job4 = new EventData(4, "Bag City Wholesale / CCTV / 13:00 / Enginner: Andy Anderson", null, null, "#41aec266");
            $job5 = new EventData(5, "Bag City Wholesale / CCTV / 13:00 / Enginner: Andy Anderson", null, null, "#41aec266");
            $job6 = new EventData(6, "Bag City Wholesale / CCTV / 13:00 / Enginner: Andy Anderson", null, null, "#41aec266");
            $jobsList = array(
                $job1,
                $job2,
                $job3,
                $job4,
                $job5,
                $job6
            );
        } else {
            $job1 = new EventData(1, "ACCA Ireland / Fire Alarm / 09:00 / Enginner: John Dow", null, null, "#5fc97c66");
            $job2 = new EventData(2, "Bag City Wholesale / Fire Alarm / 09:00 / Enginner: Peter Adams", null, null, "#5fc97c66");
            $jobsList = array($job1,
                $job2
            );
           $titleModal = "Fire Alarm "; // service name
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
            $company1 = new SelectData(1, "ACCA Ireland");
            $company2 = new SelectData(2, "B&C Contractors Ltd");
            $company3 = new SelectData(3, "Barsan Global Logistics Ltd");
            $companyNames = array(
                $company1,
                $company2,
                $company3
            );
            
        }else{
            $company1 = new SelectData(1, "ACCA Ireland");
            $company2 = new SelectData(2, "B&C Contractors Ltd");
            $companyNames = array(
                $company1,
                $company2
            );
            
        }
        return response()->json(array(
            "msg" => "test test company list ",
            "companyNames" => $companyNames,
        ));
    }
}

class ServiceData
{

    public $id, $serviceName, $borderColor, $backgroundColor, $numberOfJobs;

    public function __construct($id, $serviceName, $borderColor, $backgroundColor, $numberOfJobs)
    {
        $this->id = $id;
        $this->serviceName = $serviceName;
        $this->borderColor = $borderColor;
        $this->backgroundColor = $backgroundColor;
        $this->numberOfJobs = $numberOfJobs;
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

class ServiceTypeData
{

    public $id, $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

class SelectData
{

    public $id, $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}

class CustomerData
{

    public $id, $name, $serviceType, $contract, $address, $contact, $email, $phone, $mobile;

    public function __construct($id, $name, $serviceType, $contract, $address, $contact, $email, $phone, $mobile)
    {
        $this->id = $id;
        $this->name = $name;
        $this->serviceType = $serviceType;
        $this->contract = $contract;
        $this->address = $address;
        $this->contact = $contact;
        $this->email = $email;
        $this->phone = $phone;
        $this->mobile = $mobile;
    }
}

class JobData
{

    public $id, $companyId, $companyName, $jobTypeId, $jobTypeName, $serviceTypes, $selectedServiceType, $date, $time, $engineerId, $engineerName, $contract, $address, $email, $phone, $mobile, $sendEmail;

    public function __construct($id, $companyId, $companyName, $jobTypeId, $jobTypeName, $serviceTypes, $selectedServiceType, $date, $time, $engineerId, $engineerName, $contract, $address, $email, $phone, $mobile, $sendEmail)
    {
        $this->id = $id;
        $this->companyId = $companyId;
        $this->companyName = $companyName;
        $this->jobTypeId = $jobTypeId;
        $this->jobTypeName = $jobTypeName;
        $this->serviceTypes = $serviceTypes;
        $this->selectedServiceType = $selectedServiceType;
        $this->date = $date;
        $this->time = $time;
        $this->engineerId = $engineerId;
        $this->engineerName = $engineerName;
        $this->contract = $contract;
        $this->address = $address;
        $this->email = $email;
        $this->phone = $phone;
        $this->mobile = $mobile;
        $this->sendEmail = $sendEmail;
    }
}