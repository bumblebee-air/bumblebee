<?php
namespace App\Http\Controllers\doorder;

use App\Exports\InvoiceOrderExport;
use App\Order;
use App\Retailer;
use App\StripePaymentLog;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\InvoiceItem;

use Stripe\StripeClient;
use App\DriverProfile;

class InvoiceDriversController extends Controller
{
    
    public function getInvoiceList(Request $request)
    {
        //$invoiceList=[];
        
        $invoice1 = new InvoiceData(1, "sara", "N/A", "completed", '€100');
        $invoice2 = new InvoiceData(2, "mohamed", "20/09/2021", "not-completed", '€200');
        $invoice3 = new InvoiceData(3, "sara reda", "1/10/2021", "no-account", '€50');
        
        $invoiceList = array($invoice1,$invoice2,$invoice3);
       
        return view('admin.doorder.invoice_driver.list', [
            'invoiceList' => $invoiceList
        ]);
    }
    
    public function postUpdateLastPayoutDate   (Request $request) {
        //dd($request);
        
        alert()->success('Driver last payout date saved successfully');
        return redirect()->back();
    }
    
    public function getSingleInvoice( $client_name, $id)
    {
        $driver = DriverProfile::find($id);
        if (!$driver ) {
            abort(404);
        }
       
        $invoice=[];
        $subtotal = 50;//0;
        $invoice[] = ['name' => "Same Day Delivery",'date'=>'24/09/2021','data'=>"2 package for retailer name",'count'=>2 , 'charge' => 20];
        $invoice[] = ['name' => "Same Day Delivery",'date'=>'24/08/2021','data'=>"2 package for retailer name",'count'=>3 , 'charge' => 30];
               
        $vat = $subtotal * 0.23;
        $total = $subtotal + $vat;
        $invoice_number = '123456';
        $user = User::find($driver->user_id);
        
        $completed_stripe_account =true;
        
        return view('admin.doorder.invoice_driver.single_invoice', ["invoice"=>$invoice,'driver' => $driver,'user'=>$user,
            'subtotal' => $subtotal,'vat'=> $vat, 'total'=>$total,
            'invoice_number'=>$invoice_number,'completed_stripe_account'=>$completed_stripe_account]);
    }
    
    public function postSendNotificationDriver(Request $request){
        //dd($request);
        
        alert()->success('Notification has been sent successfully');
        return redirect()->back();
    }
    
    public function postSendDriverPayout(Request $request){
        //dd($request);
        
        alert()->success('Payout saved successfully');
        return redirect()->route('doorder_getDriversInvoiceList', 'doorder');
    }
}

class InvoiceData{
    public $driver_id, $driver_name,$last_payout_date, $status,$charges;
    
    public function __construct($driver_id, $driver_name,$last_payout_date, $status,$charges) {
        $this->driver_id=$driver_id;
        $this->driver_name = $driver_name;
        $this->last_payout_date = $last_payout_date;
        $this->status = $status;
        $this->charges = $charges;
    }
}