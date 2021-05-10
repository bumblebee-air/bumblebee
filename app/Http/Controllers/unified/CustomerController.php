<?php
namespace App\Http\Controllers\unified;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function getCustomersList()
    {
        $customer1 = new CustomerData(1, "ACCA Ireland", "hosted_/_pbx", true, "The Liberties", "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com");
        $customer2 = new CustomerData(2, "ACCA Ireland", "cctv/Fire Alar..", false, "The Liberties", "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com");

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

        return redirect()->route('getCustomersListUnified', 'unified');
    }

    public function getSingleCustomer($client_name, $id)
    {
        $customer1 = new CustomerData($id, "ACCA Ireland", "hosted_/_pbx", true, "The Liberties", "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com");
        $customer1->postcode = "D01 R5P3";
        $customer1->phone = "01234567899";
        $customer1->mobile = "01234567899";
        //dd($customer1);
        return view('admin.unified.customers.single_customer', [
            'customer' => $customer1,'readOnly'=>1
        ]);
    }

    public function getSingleCustomerEdit($client_name, $id)
    {
        $customer1 = new CustomerData($id, "ACCA Ireland", "hosted_/_pbx", true, "The Liberties", "52 Dolphins Barn Street, The Liberties", "Shane Martin", "shane.martin@accaglobal.com");
        $customer1->postcode = "D01 R5P3";
        $customer1->phone = "01234567888";
        $customer1->mobile = "01234567899";
       // dd($customer1);
        return view('admin.unified.customers.single_customer', [
            'customer' => $customer1,'readOnly'=>0
        ]);
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