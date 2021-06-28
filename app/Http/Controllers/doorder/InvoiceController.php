<?php
namespace App\Http\Controllers\doorder;

use App\Exports\InvoiceOrderExport;
use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Stripe\InvoiceItem;

class InvoiceController extends Controller
{

    public function getInvoiceList(Request $request)
    {
        $invoiceList = Order::with(['orderDriver', 'retailer'])->where('is_archived', false)->where('status', 'delivered')->orderBy('id', 'desc')->get();
        return view('admin.doorder.invoice.list', [
            'invoiceList' => $invoiceList
        ]);
    }

    public function exportInvoiceList(Request $request)
    {
        return Excel::download(new InvoiceOrderExport($request->from, $request->to), 'invoices.xlsx');
    }

    public function getSingleInvoice($client_name, $id)
    {
        $invoiceItem  = collect([
            'name' => 'SAME DAY DELIVERY 05.12.2020 One package for',
            'charge' => 10
        ]);
        $total=10;

        $invoice = Order::with(['orderDriver', 'retailer'])->where('is_archived', false)->where('status', 'delivered')->where('id', $id)->first();
        if (!$invoice) {
            abort(404);
        }
        $customer_name = explode(' ',$invoice->customer_name,2);
        $invoice->first_name = $customer_name[0];
        $invoice->last_name = $customer_name[1] ?? '';
        return view('admin.doorder.invoice.single_invoice', ["invoice"=>$invoice,'invoiceDetails'=>$invoiceItem,'total'=>$total]);
    }
    
    public function postSendInvoice(Request $request,$client_name, $id) {
        $invoice = Order::find($id);
        if (!$invoice) {
            abort(404);
        }
        $invoice->is_archived = true;
        $invoice->save();
        alert()->success('Invoiced successfully');
        return redirect()->route('doorder_getInvoiceList', 'doorder');
    }
}
