<?php

namespace App\Console\Commands;

use App\ContractorBidding;
use App\Customer;
use App\Helpers\ServicesTypesHelper;
use App\Helpers\StripePaymentHelper;
use Carbon\Carbon;
use Illuminate\Console\Command;

class PaymentIntentCustomer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gardenhelpcustomerpaymentintent:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Customer payment intent';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $customers = Customer::where('type', 'job')
            ->whereNull('payment_intent_id')
            ->whereNotNull('contractor_id')
            ->where('status', 'matched')
            ->where('is_paid', false)
            ->whereDate('available_date_time', '>=' ,Carbon::now())
            ->whereDate('available_date_time', '<=' ,Carbon::now()->addDays(6))
            ->get();

        foreach ($customers as $customer) {
            //Get Amount
//            dd(Carbon::now()->getTimestamp() <= Carbon::parse($customer->available_date_time)->getTimestamp() && Carbon::now()->getTimestamp() >= Carbon::parse($customer->available_date_time)->subDays(6)->getTimestamp());
//            dd(Carbon::parse($customer->available_date_time)->toDateTimeString(), Carbon::now()->toDateTimeString(), Carbon::parse($customer->available_date_time)->addDays(6)->toDateTimeString());
//            if ($customer->available_date_time && (Carbon::now()->getTimestamp() <= Carbon::parse($customer->available_date_time)->getTimestamp() && Carbon::now()->getTimestamp() >= Carbon::parse($customer->available_date_time)->subDays(6)->getTimestamp())) {
                if ($customer->stripe_customer) {
                    $customer_bidding = ContractorBidding::where()->orderBy('id', 'desc')->first();
                    $amount = $customer_bidding->estimated_quote + ServicesTypesHelper::getVat(13.5, $customer_bidding->estimated_quote);
                    if ($customer->stripe_customer->payment_method_type == 'sepa_debit') {
                        $payment_intent = StripePaymentHelper::paymentIntent($amount, $customer->stripe_customer->stripe_customer_id, 'eur', ['sepa_debit'], 'automatic');
                    } else {
                        $payment_intent = StripePaymentHelper::paymentIntent($amount, $customer->stripe_customer->stripe_customer_id);
                    }
                    if($payment_intent) {
                        $customer->payment_intent_id = $payment_intent->id;
                        $customer->save();
                    }
                }
//            }
        }
    }
}
