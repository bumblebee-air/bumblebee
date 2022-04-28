<?php
namespace App\Http\Controllers\doorder;

use App\StripePaymentLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentLogsController extends Controller
{
    public function paymentLogsIndex(){
        $logs_data = StripePaymentLog::orderBy('id', 'desc')
            ->paginate(20);
        foreach ($logs_data as $a_log) {
            $a_log->date_time = $a_log->created_at->format('d M y H:i A');
        }
        return view('admin.doorder.stripe_payment_logs', compact('logs_data'));
    }
}
