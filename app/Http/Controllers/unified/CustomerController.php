<?php
namespace App\Http\Controllers\unified;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function getCustomersList()
    {
        $customer1 = new CustomerData(1, "ACCA Ireland", "Intruder_alarm", true, "The Liberties", "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com");
        $customer2 = new CustomerData(2, "ACCA Ireland", "CCTV,Fire alram", false, "The Liberties", "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com");

        $customers = array(
            $customer1,
            $customer2
        );
        return view('admin.unified.customers.list', [
            'customers' => ($customers)
        ]);
    }

    public function postCustomersImport(Request $request)
    {
        // dd($request->all());
        return redirect()->to('unified/customers/list');
    }

    public function deleteCustomer(Request $request)
    {
        // dd($request->get('customerId'));
        alert()->success('Customer deleted successfully');

        return redirect()->route('unified_getCustomersList', 'unified');
    }

    public function getSingleCustomer($client_name, $id)
    {
        $customer1 = new CustomerData($id, "ACCA Ireland", "hosted_/_pbx", true, "The Liberties", "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com");
        $customer1->postcode = "D01 R5P3";
        $customer1->phone = "01234567899";
        $customer1->mobile = "01234567899";
        $customer1->selectedServiceType = '[2,3]';
        //dd($customer1);
        $serviceType1 = new ServiceTypeData(1, "CCTV");
        $serviceType2 = new ServiceTypeData(2, "Fire alram");
        $serviceType3 = new ServiceTypeData(3, "Intruder_alarm");
        $serviceTypes = array($serviceType1,$serviceType2,$serviceType3);
        return view('admin.unified.customers.single_customer', [
            'customer' => $customer1,'readOnly'=>1,'serviceTypes'=>$serviceTypes
        ]);
    }

    public function getSingleCustomerEdit($client_name, $id)
    {
        $customer1 = new CustomerData($id, "ACCA Ireland", "hosted_/_pbx", true, "The Liberties", "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com");
        $customer1->postcode = "D01 R5P3";
        $customer1->phone = "01234567888";
        $customer1->mobile = "01234567899";
        $customer1->selectedServiceType = '[2,3]';
       // dd($customer1);
       
        $serviceType1 = new ServiceTypeData(1, "CCTV");
        $serviceType2 = new ServiceTypeData(2, "Fire alram");
        $serviceType3 = new ServiceTypeData(3, "Intruder_alarm");
        $serviceTypes = array($serviceType1,$serviceType2,$serviceType3);
        
        return view('admin.unified.customers.single_customer', [
            'customer' => $customer1,'readOnly'=>0,'serviceTypes'=>$serviceTypes
        ]);
    }
    
    public function postEditCustomer(Request $request){
       //dd($request);
        
        alert()->success('Customer updated successfully');
        
        return redirect()->route('unified_getCustomersList', 'unified');
    }
}

class CustomerData
{

    public $id, $name, $serviceType, $contract, $location, $address, $contact, $email;

    public function __construct($id, $name, $serviceType, $contract, $location, $address, $contact, $email)
    {
        $this->id = $id;
        $this->name = $name;
        $this->serviceType = $serviceType;
        $this->contract = $contract;
        $this->location = $location;
        $this->address = $address;
        $this->contact = $contact;
        $this->email = $email;
    }
}

class ServiceTypeData{
   public  $id,$name;
    
   public function __construct($id,$name){
       $this->id = $id;
       $this->name = $name;
   }
    
}