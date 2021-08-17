<?php

namespace App\Console\Commands;

use App\Client;
use App\ClientSetting;
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
        $startOfMonth = Carbon::now()->subDays(30)->toDateTimeString();
        $endOfMonth = Carbon::now()->toDateTimeString();
        /*$startOfMonth = Carbon::parse('2020-12-01')->subMonth()->startOfMonth()->toDateTimeString();
        $endOfMonth = Carbon::parse('2020-12-01')->subMonth()->endOfMonth()->toDateTimeString();*/

        $doorder_client = Client::where('name','like','doorder')->first();
        if(!$doorder_client){
            $this->error('DoOrder client entry not found, exiting!');
            return false;
        }
        $day_time_of_deliverer_charging = ClientSetting::where('client_id',$doorder_client->id)
            ->where('name','day_time_of_driver_charging')->first();
        if (!$day_time_of_deliverer_charging) {
            $this->info('The schedule charge is off!');
            return false;
        }

        $this->info("Currently date time of charging: and time: $day_time_of_deliverer_charging");
        $current_day_time = Carbon::now();
        $charge_day_time = Carbon::parse($day_time_of_deliverer_charging->the_value);
        if ($current_day_time->format('D') == $charge_day_time->format('D')) {
            if ($current_day_time->hour != $charge_day_time->hour) {
                $this->info('The Datetime is not the deliverer charging day, exiting!');
                return false;
            }
        } else {
            $this->info('The Datetime is not the deliverer charging day, exiting!');
            return false;
        }

        $delivered_orders = Order::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'delivered')
            ->where('is_paidout_retailer', true)
            ->where('is_paidout_driver', false)
            ->get();
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
                    Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
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
        foreach ($delivered_orders as $order) {
            $order->update([
                'is_paidout_driver' => true
            ]);
        }
        $this->info('finished');
        return true;
    }
}
