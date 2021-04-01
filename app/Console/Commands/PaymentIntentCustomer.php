<?php

namespace App\Console\Commands;

use App\Customer;
use App\Helpers\ServicesTypesHelper;
use App\Helpers\StripePaymentHelper;
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
            ->where('is_paid', false)
            ->get();

        foreach ($customers as $customer) {
            //Get Amount
            if ($customer->services_types_json && $customer->stripe_customer) {
                $amount = ServicesTypesHelper::getJobServicesTypesAmount($customer);
                $payment_intent = StripePaymentHelper::paymentIntent($amount, $customer->stripe_customer->stripe_customer_id);
                if($payment_intent) {
                    $customer->payment_intent_id = $payment_intent->id;
                    $customer->save();
                }
            }
        }
    }
}
