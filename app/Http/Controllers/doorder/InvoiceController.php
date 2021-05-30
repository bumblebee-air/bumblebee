<?php
namespace App\Http\Controllers\doorder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{

    public function getInvoiceList()
    {
        $invoiceData1 = new InvoiceData(1, "5/25/2021", "#64515", "Nike", "delivered", "Peter Adam", 
            " 18-21 Patrick Street, Cork Ireland ", "12 Brook Lawn, Lehenagh More, Cork, Ireland");
        $invoiceData2 = new InvoiceData(2, "3/14/2021", "#5546", "Nike", "delivered", "Peter Adam",
            " 18-21 Patrick Street, Cork Ireland ", "12 Brook Lawn, Lehenagh More, Cork, Ireland");
        $invoiceData3 = new InvoiceData(3, "1/13/2021", "#57878", "Nike", "delivered", "Peter Adam",
            " 18-21 Patrick Street, Cork Ireland ", "12 Brook Lawn, Lehenagh More, Cork, Ireland");
        $invoiceList = array($invoiceData1,$invoiceData2,$invoiceData3);

        return view('admin.doorder.invoice', [
            'invoiceList' => $invoiceList
        ]);
    }
}

class InvoiceData
{

    public $id, $date, $orderNumber, $retailerName, $status, $stage, $deliverer, $pickupLocation, $deliveryLocation;

    public function __construct($id, $date, $orderNumber, $retailerName, $status, $deliverer, $pickupLocation, $deliveryLocation)
    {
        $this->id = $id;
        $this->date = $date;
        $this->orderNumber = $orderNumber;
        $this->retailerName = $retailerName;
        $this->status = $status;
        $this->deliverer = $deliverer;
        $this->pickupLocation = $pickupLocation;
        $this->deliveryLocation = $deliveryLocation;
    }
}