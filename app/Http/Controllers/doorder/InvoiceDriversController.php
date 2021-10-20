<?php
namespace App\Http\Controllers\doorder;

use App\DriverPayout;
use App\Exports\InvoiceOrderExport;
use App\Helpers\StripePaymentHelper;
use App\Helpers\TwilioHelper;
use App\Managers\StripeManager;
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

//        $invoice1 = new InvoiceData(1, "sara", "N/A", "completed", '€100');
//        $invoice2 = new InvoiceData(2, "mohamed", "20/09/2021", "not-completed", '€200');
//        $invoice3 = new InvoiceData(3, "sara reda", "1/10/2021", "no-account", '€50');
//
//        $invoiceList = [];

        $drivers = DriverProfile::with(['payouts' => function($q) {
            $q->orderBy('created_at', 'desc')->first();
        }])->whereHas('user')->get();

        foreach ($drivers as $driver) {
            $invoice = [
                'driver_id' => $driver->id,
                'driver_name' => $driver->user->name,
                'last_payout_date' => $driver->payouts->first() ? $driver->payouts->first()->created_at->toDateString() : ($driver->last_payout_date ?: 'N/A'),
                'status' => $driver->user->stripe_account ? ($driver->user->stripe_account->onboard_status == 'complete' ? 'completed' : 'not-completed' ) : 'no-account',
            ];
            if ($invoice['last_payout_date'] != 'N/A') {
                $orders_count = Order::whereDate('created_at', '>', $invoice['last_payout_date'])->count();
                $invoice['charges'] = $orders_count * 5 . '€';

            } else {
                $invoice['charges'] = 'N/A';
            }
            $invoiceList[] = $invoice;
        }

        return view('admin.doorder.invoice_driver.list', [
            'invoiceList' => $invoiceList
        ]);
    }
    
    public function postUpdateLastPayoutDate(Request $request) {
        $driver = DriverProfile::find($request->driver_id);
        if (!$driver ) {
            abort(404);
        }
        $driver->last_payout_date = Carbon::parse($request->date)->toDateString();
        $driver->save();
        alert()->success('Driver last payout date saved successfully');
        return redirect()->back();
    }
    
    public function getSingleInvoice( $client_name, $id)
    {
        $driver = DriverProfile::find($id);
        if (!$driver ) {
            alert()->info("There is no driver with this ID #$id");
            return redirect()->back();
        }
        $invoice = [];
        $latest_payout_date = $driver->payouts->first() ? $driver->payouts->first()->created_at->toDateString() : ($driver->last_payout_date ?: '');
        if ($latest_payout_date == '') {
            alert()->info('You have to select date first.');
            return redirect()->back();
        }
        $orders = Order::whereDate('created_at', '>', $latest_payout_date)->get();
        $orders_grouped = $orders->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });
        $subtotal = $orders->count() * 5;//0;
        foreach ($orders_grouped as $key => $order_grouped) {
            $invoice[] = [
                'name' => "Same Day Delivery",
                'date'=> $key,
                'count' => $order_grouped->count(),
                'charge' => $order_grouped->count() * 5,
                'data'=>$order_grouped->count()." package for retailer name"
            ];
        }
        $vat = 0.00;
        $total = $subtotal;
        $invoice_number = '123456';
        $invoice_price = '€5';
        $user = User::find($driver->user_id);
        $driver_status = $driver->user->stripe_account ? ($driver->user->stripe_account->onboard_status == 'complete' ? 'completed' : 'not-completed' ) : 'no-account';
        $completed_stripe_account = $driver_status == 'completed';
        $stripe_profile_status = $driver_status; //'no-account'  or 'not-completed'


        
        return view('admin.doorder.invoice_driver.single_invoice', ["invoice"=>$invoice,'driver' => $driver,'user'=>$user,
            'subtotal' => $subtotal,'vat'=> $vat, 'total'=>$total,
            'invoice_number'=>$invoice_number,'completed_stripe_account'=>$completed_stripe_account, 'stripe_profile_status' => $stripe_profile_status, 'invoice_price' => $invoice_price]);
    }
    
    public function postSendNotificationDriver(Request $request){
        $driver = DriverProfile::find($request->driver_id);
        if (!$driver ) {
            alert()->info("There is no driver with this ID #$request->driver_id");
            return redirect()->back();
        }
        $driver_user = $driver->user;
        $driver_stripe_account = $driver->user->stripe_account;

        if ($driver_stripe_account) {
            TwilioHelper::sendSMS('DoOrder', $driver_user->phone, "Hello $driver_user->name, You have to complete your Stripe profile to be paid. Click on the following link to complete your profile: ". url('stripe-onboard/'.$driver_stripe_account->onboard_code));
        } else {
            $stripe_manager = new StripeManager();
            $stripe_account = $stripe_manager->createCustomAccount($driver_user);
        }
        alert()->success('Notification has been sent successfully');
        return redirect()->back();
    }
    
    public function postSendDriverPayout(Request $request){
//        dd($request->all());
        $driver = DriverProfile::find($request->driver_id);
        if (!$driver ) {
            alert()->info("There is no driver with this ID #$request->driver_id");
            return redirect()->back();
        }
        $driver_user = $driver->user;
        $driver_stripe_account = $driver_user->stripe_account;
        if (!$driver_stripe_account) {
            alert()->error('There is no Stripe account for this driver.');
            return redirect()->back();
        } else if ($driver_stripe_account && $driver_stripe_account->onboard_status != 'complete') {
            alert()->error('This driver has not a completed Stripe account.');
            return redirect()->back();
        }
        //Charge a driver
        $latest_payout_date = $driver->payouts->first() ? $driver->payouts->first()->created_at->toDateString() : ($driver->last_payout_date ?: '');
        if ($latest_payout_date == '') {
            alert()->info('You have to select date first.');
            return redirect()->back();
        }
        $orders_ids = Order::whereDate('created_at', '>', $latest_payout_date)->get()->pluck('id')->toArray();
        if (count($orders_ids) < 1) {
            alert()->error('There is no orders for this user to payout.');
            return redirect()->back();
        }
        $payout_transaction = StripePaymentHelper::transferPaymentToConnectedAccount($driver_stripe_account->account_id, $request->total);
        if (!$payout_transaction) {
            alert()->error('Can\'t payout for this driver');
            return redirect()->back();
        }
        DriverPayout::create([
            'driver_id' => $driver->id,
            'transaction_id' => $payout_transaction,
            'orders_ids' => $orders_ids,
            'subtotal' => $request->subtotal,
            'original_subtotal' => count($orders_ids) * 5,
            'charged_amount' => $request->total,
            'additional' => $request->additional,
            'notes' => $request->total,
        ]);
        //Creating payout
        alert()->success('Payout saved successfully');
        return redirect()->route('doorder_getDriversInvoiceList', 'doorder');
    }
}
