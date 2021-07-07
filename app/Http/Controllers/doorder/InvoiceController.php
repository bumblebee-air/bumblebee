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
        $total = 0;
        for($i = 0; $i < $month_days; $i++) {
            $date = Carbon::parse($request->month)->startOfMonth()->addDays($i);
            $count = Order::where('retailer_id', $id)->with(['orderDriver', 'retailer'])->whereDate('created_at', $date)->where('is_archived', false)->where('status', 'delivered')->count();
            if ($count > 0) {
                $data = Carbon::parse($request->month)->startOfMonth()->addDays($i)->format('d/m/Y');
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
}
