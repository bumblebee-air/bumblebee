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

class InvoiceController extends Controller
{

    public function getInvoiceList(Request $request)
    {
        $invoiceList=[];
        $retailers = Retailer::whereHas('orders', function ($q) {
            $q->where('is_archived', false)->where('status', 'delivered');
        })->with(['orders' => function ($q) {
            $q->where('is_archived', false)->where('status', 'delivered');
        }])->get();

        foreach ($retailers as $retailer) {
            $orders_groups = $retailer->orders->groupBy(function($val) {
                return Carbon::parse($val->created_at)->format('M Y');
            });
            foreach ($orders_groups as $key => $orders_group) {
                array_push($invoiceList, [
                    'id' => $retailer->id,
                    'name' => $retailer->name,
                    'orders_count' => count($orders_group),
                    'month' => Carbon::parse($key)->format('M Y'),
                    'date' => Carbon::parse($key)->format('M Y'),
                    'invoiced'=>true
                ]);
            }
        }
        return view('admin.doorder.invoice.list', [
            'invoiceList' => $invoiceList
        ]);
    }

    public function exportInvoiceList(Request $request)
    {
        return Excel::download(new InvoiceOrderExport($request->from, $request->to), "invoices_$request->from-$request->to.xlsx");
    }

    public function getSingleInvoice(Request $request, $client_name, $id)
    {
        $retailer = Retailer::find($id);
        if (!$retailer || !$request->has('month')) {
            abort(404);
        }
        $start_of_month = Carbon::parse($request->month)->startOfMonth();
//        $start_of_month = Carbon::now()->startOfMonth();
//        $end_of_month = Carbon::now()->endOfMonth();
        $month_days = Carbon::now()->startOfYear()->addMonths($request->month)->daysInMonth;
        $invoice=[];
        $subtotal = 0;
        for($i = 0; $i < $month_days; $i++) {
            $date = Carbon::parse($request->month)->startOfMonth()->addDays($i);
            $count = Order::where('retailer_id', $id)->with(['orderDriver', 'retailer'])->whereDate('created_at', $date)->where('is_archived', false)->where('status', 'delivered')->count();
            if ($count > 0) {
                $data = Carbon::parse($request->month)->startOfMonth()->addDays($i)->format('d/m/Y');
                //$invoice[] = ['name' => "$data $count package for ". $count * 10 . "€",'count'=>$count , 'charge' => $count * 10];
                $invoice[] = ['name' => "Same Day Delivery",'date'=>$data,'data'=>"$count package for $retailer->name",'count'=>$count , 'charge' => $count * 10];
                $subtotal += $count * 10;
            }
        }
        $vat = $subtotal * 0.23;
        $total = $subtotal + $vat;
        $user = User::find($retailer->user_id);
        //dd($user);
        //$retailer->invoice_number = '1234569';
        $carbon_invoice_date = Carbon::parse($request->month);
        $invoice_number = $retailer->id.'-'.$carbon_invoice_date->format('mY');
        
        return view('admin.doorder.invoice.single_invoice', ["invoice"=>$invoice,'retailer' => $retailer,'user'=>$user, 
            'subtotal' => $subtotal,'vat'=> $vat, 'total'=>$total,'month'=>$request->month,
            'invoice_number'=>$invoice_number]);
    }
    
    public function postSendInvoice(Request $request,$client_name, $id) {
        $invoice = Retailer::find($id);
        if (!$invoice) {
            abort(404);
        }
        $retailer = Retailer::find($id);
        if (!$retailer || !$request->has('month')) {
            abort(404);
        }
        $start_of_month = Carbon::parse($request->month)->startOfMonth();
        $month_days = Carbon::now()->startOfYear()->addMonths($request->month)->daysInMonth;
        for($i = 0; $i < $month_days; $i++) {
            $date = Carbon::parse($request->month)->startOfMonth()->addDays($i);
            $orders = Order::where('retailer_id', $id)->with(['orderDriver', 'retailer'])->whereDate('created_at', $date)->where('is_archived', false)->where('status', 'delivered')->get();
            foreach ($orders as $order) {
                $order->update([
                    'is_archived' => true
                ]);
            }
        }
        alert()->success('Invoice has been sent succesfully');
        return redirect()->route('doorder_getInvoiceList', 'doorder');
    }
    
    public function postSendInvoiceEmail(Request $request) {
        //dd($retailer_id.'  '.$invoice_number);
        $retailer_id = $request->get('retailer_id');
        $month = $request->get('month');
        $retailer = Retailer::find($retailer_id);
        if(!$retailer){
            alert()->error('No retailer found with this ID!');
            return redirect()->back();
        }
        $contact_details = json_decode($retailer->contacts_details);
        $main_contact = $contact_details[0];
        $retailer_email = $main_contact->contact_email;
        $retailer_name = $retailer->name;
        $month = str_replace(' ', '%20', $month);
        try {
            Mail::send('email.doorder_invoice_retailer', [
                'retailer_name' => $retailer_name,
                'url' => url('doorder/invoice_view/' . $retailer->id . '?month=' . $month)
            ],
                function ($message) use ($retailer_email, $retailer_name) {
                    $message->from('no-reply@doorder.eu', 'DoOrder platform');
                    $message->to($retailer_email, $retailer_name)->subject('New invoice generated');
                });
        } catch (\Exception $exception){
            alert()->error('There was an error with sending the invoice email to the retailer');
            return redirect()->back();
        }
        alert()->success('Invoice email has been sent successfully');
        return redirect()->back();
    }
    
    public function getPayInvoice($client_name, $retailer_id, $invoice_number) {
        //dd('pay invoice '.$retailer_id.' '.$invoice_number);
        $retailer = Retailer::find($retailer_id);
        $invoice_number_split = explode('-',$invoice_number);
        $invoice_date = $invoice_number_split[1] ?? $invoice_number_split[0];
        $invoice_month = substr($invoice_date,0,2);
        $invoice_year = substr($invoice_date,2);
        //$the_month_datetime = Carbon::now()->startOfYear()->addMonths($invoice_month);
        try {
            $the_month_datetime = Carbon::createFromDate($invoice_year, $invoice_month, 1);
            $month_days = $the_month_datetime->daysInMonth;
        } catch (\Exception $exception){
            die('The invoice number is incorrect!');
        }
        $invoice=[];
        $subtotal = 0;
        for($i = 0; $i < $month_days; $i++) {
            $date = $the_month_datetime->startOfMonth()->addDays($i);
            $count = Order::where('retailer_id', $retailer_id)->with(['orderDriver', 'retailer'])->whereDate('created_at', $date)->where('is_archived', false)->where('status', 'delivered')->count();
            if ($count > 0) {
                $subtotal += $count * 10;
            }
        }
        $vat = $subtotal * 0.23;
        $total = $subtotal + $vat;
        return view('admin.doorder.pay_invoice',["customer_name"=>$retailer->name,
            "id"=>$retailer_id, "invoice_number"=>$invoice_number, "amount"=>$total]);
    }

    public function postPayInvoice(Request $request){
        $retailer_id = $request->get('retailer_id');
        $retailer = Retailer::find($retailer_id);
        $invoice_number = $request->get('invoice_number');
        $charge_id = $request->get('charge_id');
        $charge_status = $request->get('charge_status');
        $charge_failure_message = $request->get('charge_failure_message')?? '';
        //Archive the orders
        $invoice_number_split = explode('-',$invoice_number);
        $invoice_date = $invoice_number_split[1] ?? $invoice_number_split[0];
        $invoice_month = substr($invoice_date,0,2);
        $invoice_year = substr($invoice_date,2);
        try {
            $the_month_datetime = Carbon::createFromDate($invoice_year, $invoice_month, 1);
            $month_days = $the_month_datetime->daysInMonth;
        } catch (\Exception $exception){
            die('The invoice number is incorrect!');
        }
        for($i = 0; $i < $month_days; $i++) {
            $date = $the_month_datetime->startOfMonth()->addDays($i);
            $orders = Order::where('retailer_id', $retailer_id)->with(['orderDriver', 'retailer'])->whereDate('created_at', $date)->where('is_archived', false)->where('status', 'delivered')->get();
            foreach ($orders as $order) {
                $order->update([
                    'is_archived' => true
                ]);
            }
        }

        StripePaymentLog::create([
            'model_id' => $retailer_id,
            'model_name' => 'retailer',
            'description' => 'charged retailer: ' . $retailer->name . ' for invoice number: '.$invoice_number,
            'status' => $charge_status,
            'operation_id' => $charge_id,
            'operation_type' => 'charge',
            'fail_message' => $charge_failure_message
        ]);
        return response()->json(['error'=>0, 'message'=>'Orders invoiced successfully']);
    }
    
    public function getEditSingleInvoice(Request $request, $client_name, $id)
    {
        $retailer = Retailer::find($id);
        if (!$retailer || !$request->has('month')) {
            abort(404);
        }
        $start_of_month = Carbon::parse($request->month)->startOfMonth();
        //        $start_of_month = Carbon::now()->startOfMonth();
        //        $end_of_month = Carbon::now()->endOfMonth();
        $month_days = Carbon::now()->startOfYear()->addMonths($request->month)->daysInMonth;
        $invoice=[];
        $subtotal = 0;
        for($i = 0; $i < $month_days; $i++) {
            $date = Carbon::parse($request->month)->startOfMonth()->addDays($i);
            $count = Order::where('retailer_id', $id)->with(['orderDriver', 'retailer'])->whereDate('created_at', $date)->where('is_archived', false)->where('status', 'delivered')->count();
            if ($count > 0) {
                $data = Carbon::parse($request->month)->startOfMonth()->addDays($i)->format('d/m/Y');
                //$invoice[] = ['name' => "$data $count package for ". $count * 10 . "€",'count'=>$count , 'charge' => $count * 10];
                $invoice[] = ['name' => "Same Day Delivery",'date'=>$data,'data'=>"$count package for $retailer->name",'count'=>$count , 'charge' => $count * 10];
                $subtotal += $count * 10;
            }
        }
        $vat = $subtotal * 0.23;
        $total = $subtotal + $vat;
        $user = User::find($retailer->user_id);
        //dd($user);
        //$retailer->invoice_number = '1234569';
        $carbon_invoice_date = Carbon::parse($request->month);
        $invoice_number = $retailer->id.'-'.$carbon_invoice_date->format('mY');
        
        return view('admin.doorder.invoice.single_invoice_edit', ["invoice"=>$invoice,'retailer' => $retailer,'user'=>$user,
            'subtotal' => $subtotal,'vat'=> $vat, 'total'=>$total,'month'=>$request->month,
            'invoice_number'=>$invoice_number]);
    }
}
