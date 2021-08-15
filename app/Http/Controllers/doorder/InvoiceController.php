<?php
namespace App\Http\Controllers\doorder;

use App\Exports\InvoiceOrderExport;
use App\Order;
use App\Retailer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
                    'date' => Carbon::parse($key)->format('M Y')
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
        
        $retailer->invoice_number = '1234569';
        
        return view('admin.doorder.invoice.single_invoice', ["invoice"=>$invoice,'retailer' => $retailer,'user'=>$user, 
            'subtotal' => $subtotal,'vat'=> $vat, 'total'=>$total,'month'=>$request->month]);
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
        alert()->success('Invoiced successfully');
        return redirect()->route('doorder_getInvoiceList', 'doorder');
    }
    
    public function getSendInvoiceEmail($client_name, $retailer_id, $invoice_number) {
       // dd($retailer_id.'  '.$invoice_number);
        $retailer = Retailer::find($retailer_id);
        return view('email.doorder_invoice_retailer',["retailer_name"=>$retailer->name, "url"=>url('doorder/invoice_view/1?month=Jul%202021')]);
    }
    
    public function getPayInvoice($client_name, $retailer_id, $invoice_number) {
        //dd('pay invoice '.$retailer_id.' '.$invoice_number);
        $retailer = Retailer::find($retailer_id);
        return view('admin.doorder.pay_invoice',["customer_name"=>$retailer->name,"id"=>$retailer_id,"invoice_number"=>'12234545',"amount"=>100.0]);
        
        
    }
    public function postPaymentDetails(Request $request)
    {
        dd("post payment details");
//         $this->validate($request, [
//             'invoice_number' => 'required',
//             'amount' => 'required|integer',
//             'stripeToken' => 'required',
//             'customer_name' => 'required|string',
//         ]);
        
//         //Creating new class from Stripe Client
//         $stripe = new StripeClient(env('STRIPE_SECRET'));
//         //Creating Stripe Charge
//         $charge = $stripe->charges->create([
//             'amount' => $request->amount*100,
//             'currency' => env('STRIPE_CURRENCY','eur'),
//             'source' => $request->stripeToken,
//             'description' => 'Name: '.$request->customer_name.' , Invoice No.: '.$request->invoice_number
//         ]);
        
//         #Check if succeed
//         if ($charge->status == "succeeded") {
//             Transaction::create([
//                 'transaction_id' => $charge->id,
//                 'amount' => $request->amount,
//                 'invoice_number' => $request->invoice_number,
//                 'customer_name' => $request->customer_name,
//                 'payment_amount' => $request->amount,
//                 'stripe_response' => json_encode($charge),
//             ]);
//         }
        flashy()->success('Payment has been processed successfully');
        return redirect()->back();
    }
}
