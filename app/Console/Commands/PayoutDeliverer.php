<?php

namespace App\Console\Commands;

use App\Helpers\EnvClientsHelper;
use App\Order;
use App\StripeAccount;
use App\StripePaymentLog;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe;

class PayoutDeliverer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payoutdeliverer:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payout to Deliverers';

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
        $startOfMonth = Carbon::now()->subMonth()->startOfMonth()->toDateTimeString();
        $endOfMonth = Carbon::now()->subMonth()->endOfMonth()->toDateTimeString();
        /*$startOfMonth = Carbon::parse('2020-12-01')->subMonth()->startOfMonth()->toDateTimeString();
        $endOfMonth = Carbon::parse('2020-12-01')->subMonth()->endOfMonth()->toDateTimeString();*/

        $delivered_orders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'delivered')->get();
        $deliverers_to_be_paid = [];
        foreach($delivered_orders as $order){
            $driver_id = $order->driver;
            if(isset($deliverers_to_be_paid[$driver_id])){
                $deliverers_to_be_paid[$driver_id] = $deliverers_to_be_paid[$driver_id]+1;
            } else {
                $deliverers_to_be_paid[$driver_id] = 1;
            }
        }
        $deliverers_data = [];
        foreach($deliverers_to_be_paid as $deliverer_id=>$order_count){
            $deliverer = User::find($deliverer_id);
            if($deliverer!=null){
                $stripe_account = StripeAccount::where('user_id','=',$deliverer_id)->first();
                if($stripe_account!=null) {
                    $stripe_account_id = $stripe_account->account_id;
                    $deliverer_name = $deliverer->name;
                    $order_charge = $order_count * 5;
                    $the_order_count = (string)$order_count;
                    $deliverers_data[] = [
                        'id' => $deliverer_id,
                        'name' => $deliverer_name,
                        'order_count' => $the_order_count,
                        'order_charge' => $order_charge,
                        'order_charge_text' => '€' . (string)$order_charge,
                        'stripe_account_id' => $stripe_account_id
                    ];
                }
            }
        }
        $this->info(json_encode($deliverers_data));
        foreach($deliverers_data as $deliverer){
            $amount = $deliverer['order_charge'] * 100;
            $currency = 'eur';
            $description = 'Payed out deliverer: ' . $deliverer['name'] . ' for ' . $deliverer['order_count'] . ' orders.';
            if (isset($deliverer['stripe_account_id']) && $deliverer['stripe_account_id']!=null &&  $amount > 0) {
                try {
                    Stripe\Stripe::setApiKey(EnvClientsHelper::getEnvDataFunction(2, 'STRIPE_SECRET'));
                    $stripe_payout = Stripe\Transfer::create ([
                        "amount" => $amount,
                        "currency" => $currency,
                        "destination" => $deliverer['stripe_account_id'],
                        "description" => $description
                    ]);
                    $this->info(json_encode($stripe_payout));

                    StripePaymentLog::create([
                        'model_id' => $deliverer['id'],
                        'model_name' => 'deliverer',
                        'description' => 'Payed out deliverer: ' . $deliverer['name'] . ' for ' . $deliverer['order_count'] . ' orders with amount: ' . $deliverer['order_charge'] . ' ' . $currency,
                        'status' => ($stripe_payout->reversed==false)? 'succeeded' : 'failed',
                        'operation_id' => $stripe_payout->id,
                        'operation_type' => 'payout',
                        'fail_message' => null
                    ]);
                } catch (\Exception $e) {
                    StripePaymentLog::create([
                        'model_id' => $deliverer['id'],
                        'model_name' => 'deliverer',
                        'description' => 'Payed out deliverer: ' . $deliverer['name'] . ' for ' . $deliverer['order_count'] . ' orders with amount: ' . $deliverer['order_charge'] . ' ' . $currency,
                        'status' => 'failed',
                        'operation_id' => null,
                        'operation_type' => 'payout',
                        'fail_message' => $e->getMessage()
                    ]);
                    $this->error($e->getMessage());
                }
            }
        }
        $this->info('finished');
        return true;
    }
}
