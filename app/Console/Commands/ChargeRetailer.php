<?php

namespace App\Console\Commands;

use App\Helpers\EnvClientsHelper;
use App\StripePaymentLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Retailer;
use Stripe;

class ChargeRetailer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chargeretailer:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charge Retailer';

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
        $retailers = Retailer::get();
        foreach($retailers as $retailer)
        {
            $startOfMonth = Carbon::now()->subMonth()->startOfMonth()->toDateTimeString();
            $endOfMonth = Carbon::now()->subMonth()->endOfMonth()->toDateTimeString();
            $retailer_orders = $retailer->orders->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('status', 'delivered');


            if (env('APP_ENV') == 'local') {
                $stripetoken = 'tok_visa';
            } else{
                $stripetoken = $retailer['stripe_token'];
            }
            $amount = count($retailer_orders) * 1000;
            $currency = 'eur';
            $description = 'Charged retailer: ' . $retailer->name . ' for ' . count($retailer_orders) . ' orders.';
            $stripe_charge_status = '';
            if ($retailer->stripe_customer_id &&  $amount > 0) {
                try {
                    Stripe\Stripe::setApiKey(EnvClientsHelper::getEnvDataFunction(2, 'STRIPE_SECRET'));
                    $stripe_charge = Stripe\Charge::create ([
                        "amount" => $amount,
                        "currency" => $currency,
                        "customer" => $retailer->stripe_customer_id,
                        "description" => $description
                    ]);

                    StripePaymentLog::create([
                        'model_id' => $retailer->id,
                        'model_name' => 'retailer',
                        'description' => 'charged retailer: ' . $retailer->name . ' for ' . count($retailer_orders) . ' orders with amount: ' . ($amount / 100) . ' ' . $currency,
                        'status' => $stripe_charge->status,
                        'operation_id' => $stripe_charge->id,
                        'operation_type' => 'charge',
                        'fail_message' => $stripe_charge->failure_message
                    ]);
                } catch (\Exception $e) {
                    StripePaymentLog::create([
                        'model_id' => $retailer->id,
                        'model_name' => 'retailer',
                        'description' => 'charged retailer: ' . $retailer->name . ' for ' . count($retailer_orders) . ' orders with amount: ' . ($amount / 100) . ' ' . $currency,
                        'status' => 'failed',
                        'operation_id' => null,
                        'operation_type' => 'charge',
                        'fail_message' => $e->getMessage()
                    ]);
                }
            }
        }
    }
}
