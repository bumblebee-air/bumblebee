<?php
namespace App\Http\Controllers\doorder;

use App\Exports\InvoiceOrderExport;
use App\Order;
use App\Retailer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\InvoiceItem;

class InvoiceController extends Controller
{

    public function getInvoiceList(Request $request)
    {
//        $start_of_month = Carbon::now()->startOfMonth();
//        $end_of_month = Carbon::now()->endOfMonth();
//        $invoiceList = Retailer::whereHas('orders', function ($q) use ($start_of_month, $end_of_month) {
//            $q->whereDate('created_at','>=', $start_of_month)
//              ->whereDate('created_at','<=', $end_of_month)
//              ->where('is_archived', false)->where('status', 'delivered');
//        })->withCount(['orders' => function ($q) use($start_of_month, $end_of_month) {
//            $q->whereDate('created_at','>=', $start_of_month)
//                ->whereDate('created_at','<=', $end_of_month)
//                ->where('is_archived', false)->where('status', 'delivered');
//        }])->orderBy('id', 'desc')->get();

        $invoiceList=[];
        $retailers = Retailer::whereHas('orders', function ($q) {
            $q->where('is_archived', false)->where('status', 'delivered');
        })->get();

        foreach ($retailers as $retailer) {
            for ($i=0;$i<12;$i++) {
                $month = Carbon::now()->startOfYear()->addMonths($i);
                $orders_count = Order::where('retailer_id', $retailer->id)->whereMonth('created_at',$month)
                    ->where('is_archived', false)->where('status', 'delivered')->count();
                if ($orders_count > 0) {
                    array_push($invoiceList, [
                        'id' => $retailer->id,
                        'name' => $retailer->name,
                        'orders_count' => $orders_count,
                        'month' => $i,
                        'date' => $month->format('M Y')
                    ]);
                }
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

    public function getSingleInvoice($client_name, $id)
    {
        $retailer = Retailer::find($id);
        if (!$retailer) {
            abort(404);
        }
//        $start_of_month = Carbon::now()->startOfMonth();
//        $end_of_month = Carbon::now()->endOfMonth();
        $month_days = Carbon::now()->daysInMonth + 1;
        $invoice=[];
        $total = 0;
        for($i = 1; $i < $month_days; $i++) {
            $count = Order::whereHas('retailer', function ($q) use ($id) {
                $q->where('id', $id);
            })->with(['orderDriver', 'retailer'])->whereDay('created_at', $i)->where('is_archived', false)->where('status', 'delivered')->count();

            if ($count > 0) {
                $data = Carbon::now()->startOfMonth()->addDays($i)->format('d/m/Y');
                $invoice[] = ['name' => "$data $count package for ". $count * 10 . "€", 'charge' => $count * 10];
                $total += $count * 10;
            }
        }
        return view('admin.doorder.invoice.single_invoice', ["invoice"=>$invoice,'retailer' => $retailer, 'total' => $total]);
    }
    
    public function postSendInvoice(Request $request,$client_name, $id) {
        $invoice = Retailer::find($id);
        if (!$invoice) {
            abort(404);
        }
        $current_month = date('m');
        $orders = Order::whereHas('retailer', function ($q) use ($id) {
            $q->where('id', $id);
        })->with(['orderDriver', 'retailer'])->whereMonth('created_at', $current_month)->where('is_archived', false)->where('status', 'delivered')->get();
        foreach ($orders as $order) {
            $order->update([
                'is_archived' => true
            ]);
        }
        alert()->success('Invoiced successfully');
        return redirect()->route('doorder_getInvoiceList', 'doorder');
    }
}
