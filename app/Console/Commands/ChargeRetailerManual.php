<?php

namespace App\Console\Commands;

use App\Client;
use App\ClientSetting;
use App\StripePaymentLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Retailer;
use Stripe;

class ChargeRetailerManual extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chargeretailer:manual';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manually Charge Retailers';
    /**
     * Custom variables
     */
    private $input_retailer_ids;
    private $input_month;
    private $override_charging_day;
    private $input_vat_only;
    private $recharge_all_orders;
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
        $this->input_retailer_ids = $this->ask('Specific retailers? (IDs comma separated, default is all)');
        $this->input_month = $this->ask('Specific month? (Integer, default is last month)');
        $this->override_charging_day = $this->confirm('Override the charging day?');
        $this->input_vat_only = $this->confirm('Charge for VAT only?');
        $this->recharge_all_orders = $this->confirm('Charge all orders including ones that have already been charged for?');
        $doorder_client = Client::where('name','like','doorder')->first();
        if(!$doorder_client){
            $this->error('DoOrder client entry not found, exiting!');
            return false;
        }
        $day_of_retailer_charging = ClientSetting::where('client_id',$doorder_client->id)
            ->where('name','day_of_retailer_charging')->first();
        $day_of_charge = 1;
        if(!$day_of_retailer_charging){
            $this->info('Day of Retailer charging setting not found, aborting!');
            return false;
        } else {
            $day_of_charge = $day_of_retailer_charging->the_value ?? 1;
        }
        $this->info('Currently set day of charging: '.$day_of_charge);
        $current_day_time = Carbon::now();
        if($current_day_time->daysInMonth < $day_of_charge){
            $day_of_charge = $current_day_time->daysInMonth;
        }
        if($this->override_charging_day===true){
            $day_of_charge = $current_day_time->day;
        }
        $current_day = $current_day_time->day;
        if($this->input_retailer_ids!='' && $this->input_retailer_ids!=null){
            $retailer_ids = explode(',',$this->input_retailer_ids);
            $retailers = Retailer::whereIn('id',$retailer_ids)->get();
        } else {
            $retailers = Retailer::all();
        }
        if($this->input_month!='' && $this->input_month!=null){
            try {
                $month_c = Carbon::createFromDate(null, intval($this->input_month), 1);
                $prev_month = clone $month_c;
                $startOfMonth = $prev_month->startOfMonth()->toDateTimeString();
                $endOfMonth = $prev_month->endOfMonth()->toDateTimeString();
                $prev_month = $prev_month->startOfMonth();
            } catch (\Exception $exception){
                $this->error($exception->getMessage());
                return true;
            }
        } else {
            $prev_month = $current_day_time->subMonth()->startOfMonth();
            $startOfMonth = Carbon::now()->startOfMonth()->subMonth()->startOfMonth()->toDateTimeString();
            $endOfMonth = Carbon::now()->startOfMonth()->subMonth()->endOfMonth()->toDateTimeString();
        }
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        if($current_day != $day_of_charge){
            $retailers_override_count = 0;
            foreach($retailers as $retailer) {
                $retailer_charging_day = $retailer->charging_day;
                if($retailer_charging_day!=null && $retailer_charging_day==$day_of_charge) {
                    if ($retailer->stripe_customer_id) {
                        $charge_status = $this->chargeRetailer($retailer, $startOfMonth, $endOfMonth, $prev_month);
                        if($charge_status) $retailers_override_count++;
                    }
                }
            }
            if($retailers_override_count > 0){
                \Log::info('Today is not the retailer charging day but successfully charged '.
                    strval($retailers_override_count).' retailers as they have today as the override charging day');
                return true;
            }
            $log_text = 'Today is not the retailer charging day, '.
                'and no retailers have today as an override charging day';
            $this->info($log_text.', exiting!');
            \Log::info($log_text);
            return false;
        }
        foreach($retailers as $retailer) {
            $retailer_charging_day = $retailer->charging_day;
            if($retailer_charging_day==null || $retailer_charging_day==$day_of_charge) {
                if ($retailer->stripe_customer_id) {
                    $this->chargeRetailer($retailer, $startOfMonth, $endOfMonth, $prev_month);
                }
            }
        }
        $this->info('Finished automatic charge retailer function');
        return true;
    }

    private function chargeRetailer($retailer,$startOfMonth,$endOfMonth,$prev_month){
        $retailer_orders = $retailer->orders->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->where('status', 'delivered')->where('is_archived', 0);
        if($this->recharge_all_orders===false) {
            $retailer_orders = $retailer_orders->where('is_paidout_retailer', false);
        }
        /*if (env('APP_ENV') == 'local' || env('APP_ENV') == 'development') {
            $stripetoken = 'tok_visa';
        } else{
            $stripetoken = $retailer->stripe_token?? null;
        }*/
        $vat_only_txt = '';
        $retailer_orders_count = count($retailer_orders);
        $amount = $retailer_orders_count * 1000;
        $vat = $amount * 0.23;
        $total = $amount + $vat;
        if($this->input_vat_only===true){
            $total = $vat;
            $vat_only_txt = ' with the VAT only';
        }
        $currency = 'eur';
        $charge_description = 'Charged retailer: ' . $retailer->name . $vat_only_txt . ' for ' . $retailer_orders_count .
            ' orders of month '.$prev_month->monthName;
        $stripe_charge_status = '';
        if ($amount > 0) {
            try {
                if($retailer->payment_method == 'sepa'){
                    //SEPA Direct Debit payment
                    $payment_intent = Stripe\PaymentIntent::create([
                        'amount' => $total,
                        'currency' => 'eur',
                        'customer' => $retailer->stripe_customer_id,
                        'payment_method' => $retailer->stripe_payment_id,
                        'payment_method_types' => ['sepa_debit'],
                        'off_session' => true,
                        'confirm' => true,
                        'description' => $charge_description
                    ]);
                    StripePaymentLog::create([
                        'model_id' => $retailer->id,
                        'model_name' => 'retailer',
                        'description' => 'charged retailer: ' . $retailer->name . $vat_only_txt . ' for ' . $retailer_orders_count .
                            ' orders with amount: ' . ($total / 100) . ' ' . $currency . ' for month ' . $prev_month->monthName,
                        'status' => $payment_intent->status,
                        'operation_id' => $payment_intent->id,
                        'operation_type' => 'charge debit',
                        'fail_message' => 'N/A'
                    ]);
                    $this->info($charge_description.' (Direct Debit)');
                } else {
                    //Card payment
                    $stripe_charge = Stripe\Charge::create([
                        "amount" => $total,
                        "currency" => $currency,
                        "customer" => $retailer->stripe_customer_id,
                        "description" => $charge_description
                    ]);

                    StripePaymentLog::create([
                        'model_id' => $retailer->id,
                        'model_name' => 'retailer',
                        'description' => 'charged retailer: ' . $retailer->name . $vat_only_txt . ' for ' . $retailer_orders_count .
                            ' orders with amount: ' . ($total / 100) . ' ' . $currency . ' for month ' . $prev_month->monthName,
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
                    $this->info($charge_description);
                }
                return true;
            } catch (\Exception $e) {
                StripePaymentLog::create([
                    'model_id' => $retailer->id,
                    'model_name' => 'retailer',
                    'description' => 'Failed to charge retailer: ' . $retailer->name . $vat_only_txt .' for ' . $retailer_orders_count . ' orders with amount: ' . ($total / 100) . ' ' . $currency,
                    'status' => 'failed',
                    'operation_id' => null,
                    'operation_type' => 'charge',
                    'fail_message' => $e->getMessage()
                ]);
                $this->info('Failed to charge retailer: ' . $retailer->name . $vat_only_txt . ' for ' . $retailer_orders_count . ' orders');
                return false;
            }
        }
        return false;
    }
}
