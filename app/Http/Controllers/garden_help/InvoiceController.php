<?php

namespace App\Http\Controllers\garden_help;

use App\ClientSetting;
use App\Contractor;
use App\ContractorPayout;
use App\Customer;
use App\Helpers\GardenHelpUsersNotificationHelper;
use App\Helpers\StripePaymentHelper;
use App\Helpers\TwilioHelper;
use App\Http\Controllers\Controller;
use App\Managers\StripeManager;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function getInvoiceJobs(Request $request) {
        $contractors = Contractor::where('status', 'completed')->with(['payouts' => function($q) {
            $q->orderBy('created_at', 'desc')->first();
        }])->whereHas('user')->get();

        foreach ($contractors as $contractor) {
            $invoice = [
                'driver_id' => $contractor->id,
                'driver_name' => $contractor->user->name,
                'last_payout_date' => $contractor->payouts->first() ? $contractor->payouts->first()->created_at->toDateString() : ($contractor->last_payout_date ?: 'N/A'),
                'status' => $contractor->user->stripe_account ? ($contractor->user->stripe_account->onboard_status == 'complete' ? 'completed' : 'not-completed' ) : 'no-account',
            ];
            if ($invoice['last_payout_date'] != 'N/A') {
                $charges = 0;
                $jobs = Customer::where('contractor_id','=',$contractor->user_id)
                    ->whereDate('created_at', '>', $invoice['last_payout_date'])->get();
                foreach ($jobs as $job) {
                    $amount = $this->getServiceTotalHours($job->job_services_types_json, $job->property_size);
                    $charges += $this->getAmountAfterFee($request->user()->client->client_id, $amount, $contractor->experience_level_value);
                }

                $invoice['charges'] = $charges > 0 ? $charges: 'N/A';

            } else {
                $invoice['charges'] = 'N/A';
            }
            $invoiceList[] = $invoice;
        }

        return view('admin.garden_help.invoice.list', [
            'invoiceList' => $invoiceList
        ]);
    }

    public function viewInvoiceJob(Request $request, $client_name, $contractor_id) {
        $contractor = Contractor::find($contractor_id);
        if (!$contractor ) {
            alert()->info("There is no driver with this ID #$contractor_id");
            return redirect()->back();
        }
        $invoice = [];
        $latest_payout_date = $contractor->payouts->first() ? $contractor->payouts->first()->created_at->toDateString() : ($contractor->last_payout_date ?: '');
        if ($latest_payout_date == '') {
            alert()->info('You have to select date first.');
            return redirect()->back();
        }
        $jobs = Customer::where('contractor_id','=',$contractor->user_id)
            ->whereDate('created_at', '>', $latest_payout_date)->get();
        $jobs_grouped = $jobs->groupBy(function($item) {
            return $item->created_at->format('Y-m-d');
        });
        $subtotal = 0;

        foreach ($jobs_grouped as $key => $job_grouped) {
            $price = 0;
            foreach ($job_grouped as $job) {
                $amount = $this->getServiceTotalHours($job->job_services_types_json, $job->property_size);
                $price += $this->getAmountAfterFee($request->user()->client->client_id, $amount, $contractor->experience_level_value);
            }
            $invoice[] = [
                'name' => "Same Day Delivery",
                'date'=> $key,
                'count' => $job_grouped->count(),
                'charge' => $price,
                'data'=>$job_grouped->count()." package for retailer name"
            ];
            $subtotal += $price;
        }
//        dd($invoice);
        $vat = 0.00;
        $total = $subtotal;
        $invoice_number = '123456';
        $invoice_price = '€5';
        $user = User::find($contractor->user_id);
        $contractor_status = $contractor->user->stripe_account ? ($contractor->user->stripe_account->onboard_status == 'complete' ? 'completed' : 'not-completed' ) : 'no-account';
        $completed_stripe_account = $contractor_status == 'completed';
        $stripe_profile_status = $contractor_status; //'no-account'  or 'not-completed'

//        dd($invoice);
        return view('admin.garden_help.invoice.view', ["invoice"=>$invoice,'driver' => $contractor,'user'=>$user,
            'subtotal' => $subtotal,'vat'=> $vat, 'total'=>$total,
            'invoice_number'=>$invoice_number,'completed_stripe_account'=>$completed_stripe_account, 'stripe_profile_status' => $stripe_profile_status, 'invoice_price' => $invoice_price]);
    }

    public function postSendNotification(Request $request){
        $contractor = Contractor::find($request->contractor_id);
        if (!$contractor ) {
            alert()->info("There is no driver with this ID #$request->contractor_id");
            return redirect()->back();
        }
        $contractor_user = $contractor->user;
        $contractor_stripe_account = $contractor->user->stripe_account;

        if ($contractor_stripe_account) {
//            TwilioHelper::sendSMS('GardenHelp', $contractor_user->phone, "Hello $contractor_user->name, You have to complete your Stripe profile to be paid. Click on the following link to complete your profile: ". url('stripe-onboard/'.$contractor_stripe_account->onboard_code));
            $body = "Hello $contractor_user->name, You have to complete your Stripe profile to be paid. Click on the following link to complete your profile: ". url('stripe-onboard/'.$contractor_stripe_account->onboard_code);
            GardenHelpUsersNotificationHelper::notifyUser($contractor_user, $body, $contractor->contact_through);
        } else {
            $stripe_manager = new StripeManager();
            $stripe_account = $stripe_manager->createCustomAccount($contractor_user);
        }
        alert()->success('Notification has been sent successfully');
        return redirect()->back();
    }

    public function postPayout(Request $request){
        $contractor = Contractor::find($request->contractor_id);
        if (!$contractor ) {
            alert()->info("There is no driver with this ID #$request->contracotr_id");
            return redirect()->back();
        }
        $contractor_user = $contractor->user;
        $contractor_stripe_account = $contractor_user->stripe_account;
        if (!$contractor_stripe_account) {
            alert()->error('There is no Stripe account for this driver.');
            return redirect()->back();
        } else if ($contractor_stripe_account && $contractor_stripe_account->onboard_status != 'complete') {
            alert()->error('This driver has not a completed Stripe account.');
            return redirect()->back();
        }
        //Charge a driver
        $latest_payout_date = $contractor->payouts->first() ? $contractor->payouts->first()->created_at->toDateString() : ($contractor->last_payout_date ?: '');
        if ($latest_payout_date == '') {
            alert()->info('You have to select date first.');
            return redirect()->back();
        }
        $jobs_ids = Customer::whereDate('created_at', '>', $latest_payout_date)->get()->pluck('id')->toArray();
        if (count($jobs_ids) < 1) {
            alert()->error('There is no jobs for this user to payout.');
            return redirect()->back();
        }
        $payout_transaction = StripePaymentHelper::transferPaymentToConnectedAccount($contractor_stripe_account->account_id, $request->subtotal);
        if (!$payout_transaction) {
            alert()->error('Can\'t payout for this driver');
            return redirect()->back();
        }
        ContractorPayout::create([
            'contractor_id' => $contractor->id,
            'transaction_id' => $payout_transaction,
            'jobs_ids' => $jobs_ids,
            'subtotal' => $request->subtotal,
            'original_subtotal' => $request->subtotal,
            'charged_amount' => $request->subtotal,
            'additional' => 0,
            'notes' => $request->notes,
        ]);
        //Creating payout
        alert()->success('Payout saved successfully');
        return redirect()->route('garden_help_getInvoiceList', 'garden-help');
    }

    public function postUpdateLastPayoutDate(Request $request) {
        $contractor = Contractor::find($request->contractor_id);
        if (!$contractor ) {
            abort(404);
        }
        $contractor->last_payout_date = Carbon::parse($request->date)->toDateString();
        $contractor->save();
        alert()->success('Contractor last payout date saved successfully');
        return redirect()->back();
    }

    protected function getServiceTotalHours($job_services, $property_size) {
        $job_services = $job_services ? json_decode($job_services) : [];
        $property_size = str_replace(' Square Meters', '', $property_size);
        $price = 0;

        foreach ($job_services as $job_service) {
            if ($job_service->is_checked) {
                $rate_property_sizes = json_decode($job_service->rate_property_sizes);
                foreach ($rate_property_sizes as $rate_property_size) {
                    $size_from = $rate_property_size->max_property_size_from;
                    $size_to = $rate_property_size->max_property_size_to;
                    $rate_per_hour = $rate_property_size->rate_per_hour;
                    if ($property_size >= $size_from && $property_size <= $size_to) {
                        $service_price = $rate_per_hour * $job_service->min_hours;
                        $price += $service_price;
                    }
                }
            }
        }
        return $price;
    }

    protected function getAmountAfterFee($client_id, $subtotal, $level): float {
        $fee = ClientSetting::where('client_id', $client_id)->where('name', "lvl_".$level."_percentage")->first();
        return $subtotal - (($fee->the_value / 100) * $subtotal);
    }
}
