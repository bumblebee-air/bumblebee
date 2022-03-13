<?php

namespace App\Console\Commands;

use App\Client;
use App\ClientSetting;
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
        $doorder_client = Client::where('name','like','doorder')->first();
        if(!$doorder_client){
            $this->error('DoOrder client entry not found, exiting!');
            return false;
        }
        $day_of_retailer_charging = ClientSetting::where('client_id',$doorder_client->id)
            ->where('name','day_of_retailer_charging')->first();
        $day_of_charge = 1;
        if(!$day_of_retailer_charging){
            $this->info('Day of Retailer charging setting not found, defaulting to first day of month');
            return false;
        } else {
            $day_of_charge = $day_of_retailer_charging->the_value ?? 1;
        }
        $this->info('Currently set day of charging: '.$day_of_charge);
        $current_day_time = Carbon::now();
        if($current_day_time->daysInMonth < $day_of_charge){
            $day_of_charge = $current_day_time->daysInMonth;
        }
        $current_day = $current_day_time->day;
        if($current_day != $day_of_charge){
            $this->info('Today is not the retailer charging day, exiting!');
            return false;
        }
        $startOfMonth = Carbon::now()->subMonth()->startOfMonth()->toDateTimeString();
        $endOfMonth = Carbon::now()->subMonth()->endOfMonth()->toDateTimeString();
        $retailers = Retailer::all();
        foreach($retailers as $retailer) {
            if ($retailer->stripe_customer_id) {
                $retailer_orders = $retailer->orders->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->where('status', 'delivered')->where('is_archived', 0)->where('is_paidout_retailer', false);
                /*if (env('APP_ENV') == 'local' || env('APP_ENV') == 'development') {
                    $stripetoken = 'tok_visa';
                } else{
                    $stripetoken = $retailer->stripe_token?? null;
                }*/
                $retailer_orders_count = count($retailer_orders);
                $amount = $retailer_orders_count * 1000;
                $currency = 'eur';
                $description = 'Charged retailer: ' . $retailer->name . ' for ' . $retailer_orders_count . ' orders.';
                $stripe_charge_status = '';
                if ($amount > 0) {
                    try {
                        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                        $stripe_charge = Stripe\Charge::create([
                            "amount" => $amount,
                            "currency" => $currency,
                            "customer" => $retailer->stripe_customer_id,
                            "description" => $description
                        ]);

                        StripePaymentLog::create([
                            'model_id' => $retailer->id,
                            'model_name' => 'retailer',
                            'description' => 'charged retailer: ' . $retailer->name . ' for ' . $retailer_orders_count . ' orders with amount: ' . ($amount / 100) . ' ' . $currency,
                            'status' => $stripe_charge->status,
                            'operation_id' => $stripe_charge->id,
                            'operation_type' => 'charge',
                            'fail_message' => $stripe_charge->failure_message
                        ]);
                        foreach ($retailer_orders as $order) {
                            $order->is_archived = 1;
                            $order->is_paidout_retailer = true;
                            $order->save();
                        }
                        $this->info('charged retailer: ' . $retailer->name . ' for ' . $retailer_orders_count . ' orders');
                    } catch (\Exception $e) {
                        StripePaymentLog::create([
                            'model_id' => $retailer->id,
                            'model_name' => 'retailer',
                            'description' => 'Failed to charge retailer: ' . $retailer->name . ' for ' . $retailer_orders_count . ' orders with amount: ' . ($amount / 100) . ' ' . $currency,
                            'status' => 'failed',
                            'operation_id' => null,
                            'operation_type' => 'charge',
                            'fail_message' => $e->getMessage()
                        ]);
                        $this->info('Failed to charge retailer: ' . $retailer->name . ' for ' . $retailer_orders_count . ' orders');
                    }
                }
            }
        }
        $this->info('Finished automatic charge retailer function');
        return true;
    }
}
