<?php
namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Stripe\InvoiceItem;

class InvoiceController extends Controller
{

    public function getInvoiceList()
    {
        $invoiceData1 = new InvoiceData(1, "5/25/2021", "#64515", "Nike", "delivered", "Peter Adam", " 18-21 Patrick Street, Cork Ireland ", 
            "12 Brook Lawn, Lehenagh More, Cork, Ireland", 100);
        $invoiceData2 = new InvoiceData(2, "3/14/2021", "#5546", "Brown Thomas", "delivered", "Peter Adam", " 18-21 Patrick Street, Cork Ireland ", 
            "12 Brook Lawn, Lehenagh More, Cork, Ireland", 200);
        $invoiceData3 = new InvoiceData(3, "1/13/2021", "#57878", "Tommy Hilfiger", "delivered", "Peter Adam", " 18-21 Patrick Street, Cork Ireland ", 
            "12 Brook Lawn, Lehenagh More, Cork, Ireland", 300);
        $invoiceList = array(
            $invoiceData1,
            $invoiceData2,
            $invoiceData3
        );

        return view('admin.doorder.invoice.list', [
            'invoiceList' => $invoiceList
        ]);
    }

    public function getSingleInvoice($client_name, $id)
    {
        $invoice = new SingleInvoiceData(1, "#526378", 2, "Brown Thomas", "John", "Dow", "johndow@gmail.com", "+35390580309", 
            "Stephen Court, GF1, St Stephen's Green, Dublin 2, D02 N960, Ireland", "768594", "88 - 95 Grafton Street Dublin , Dublin Ireland ", 
            4, "ss", 0, "30 mins", "15x15x10");
        
        $invoiceItem1  =new ItemData('SAME DAY DELIVERY 05.12.2020 One package for', 10);
        $invoiceItem2  =new ItemData('SAME DAY DELIVERY 05.12.2020 One package for', 20);
        $invoiceDetails = array($invoiceItem1,$invoiceItem2);
        $total=30;

        return view('admin.doorder.invoice.single_invoice', ["invoice"=>$invoice,'invoiceDetails'=>($invoiceDetails),'total'=>$total]);
    }
    
    public function postSendInvoice(Request $request,$client_name, $id ) {
        //dd("send invoice ".$id);
        alert()->success('Invoiced successfully');
    
        return redirect()->route('doorder_getInvoiceList', 'doorder');
    }
}

class InvoiceData
{

    public $id, $date, $orderNumber, $retailerName, $status, $stage, $deliverer, $pickupLocation, $deliveryLocation;

    public function __construct($id, $date, $orderNumber, $retailerName, $status, $deliverer, $pickupLocation, $deliveryLocation, $charges)
    {
        $this->id = $id;
        $this->date = $date;
        $this->orderNumber = $orderNumber;
        $this->retailerName = $retailerName;
        $this->status = $status;
        $this->deliverer = $deliverer;
        $this->pickupLocation = $pickupLocation;
        $this->deliveryLocation = $deliveryLocation;
        $this->charges = $charges;
    }
}

class SingleInvoiceData
{

    public $id, $orderNumber, $retailerId, $retailerName, $customerFirstName, $customerLastName, $customerEmail, $customerContactNumber,
    $customerAddress, $postcode, $pickupAddress, $packageWeightKg, $otherDetails, $isFragile, $orderFulfilment, $packageDimensionsCm;

    public function __construct($id, $orderNumber, $retailerId, $retailerName, $customerFirstName, $customerLastName, $customerEmail,
        $customerContactNumber, $customerAddress, $postcode, $pickupAddress, $packageWeightKg, $otherDetails, $isFragile, $orderFulfilment, 
        $packageDimensionsCm)
    {
        $this->id = $id;
        $this->orderNumber = $orderNumber;
        $this->retailerId = $retailerId;
        $this->retailerName = $retailerName;
        $this->customerFirstName = $customerFirstName;
        $this->customerLastName = $customerLastName;
        $this->customerEmail = $customerEmail;
        $this->customerContactNumber = $customerContactNumber;
        $this->customerAddress = $customerAddress;
        $this->postcode = $postcode;
        $this->pickupAddress = $pickupAddress;
        $this->packageWeightKg = $packageWeightKg;
        $this->otherDetails = $otherDetails;
        $this->isFragile = $isFragile;
        $this->orderFulfilment = $orderFulfilment;
        $this->packageDimensionsCm = $packageDimensionsCm;
    }
}

class ItemData{
    public $name,$charge;
    
    public function __construct($name,$charge) {
        $this->name=$name;
        $this->charge=$charge;
        ;
    }
}
