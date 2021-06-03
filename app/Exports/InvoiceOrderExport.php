<?php

namespace App\Exports;

use App\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InvoiceOrderExport implements FromArray, WithHeadings
{
    private $from;
    private $to;

    public function __construct($form=null, $to=null)
    {
        $this->from = $form;
        $this->to = $to;
    }

    /**
     * @return \string[][]
     */
    public function array():array
    {
        $exportable_array = [];

        $invoices = Order::query();
        if ($this->from) {
            $invoices = $invoices->where('created_at', '>=', Carbon::parse($this->from)->toDateTimeString());
        }
        if ($this->to) {
            $invoices = $invoices->where('created_at', '<=', Carbon::parse($this->to)->toDateTimeString());
        }
        $invoices = $invoices->where('is_archived', false)->get();

        foreach ($invoices as $invoice) {
            $exportable_array[] = [
                Carbon::parse($invoice->created_at)->toDateTimeString(),
                $invoice->order_id,
                $invoice->retailer? $invoice->retailer->name: 'N/A',
                $invoice->status,
                $invoice->orderDriver ? $invoice->orderDriver->name: 'N/A',
                $invoice->pickup_address,
                $invoice->customer_address,
                '€10',
            ];
        }
        return $exportable_array;
    }

    public function headings(): array
    {
        return [
            'Date',
            'Order Number',
            'Retailer Name',
            'Status',
            'Deliverer',
            'Pickup Address',
            'Delivery Address',
            'Charge',
        ];
    }
}
