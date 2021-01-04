<?php

namespace App\Console\Commands;

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
            if (env('APP_ENV') == 'local') {
                $stripetoken = 'tok_visa';
            } else{
                $stripetoken = $retailer['stripe_token'];
            }
            $amount = '1000';
            $currency = 'usd';
            $description = 'Testing Payment Reason';
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            $stripe_charge = Stripe\Charge::create ([
                    "amount" => $amount,
                    "currency" => $currency,
                    "source" => $stripetoken,
                    "description" => $description 
            ]);
            if($stripe_charge)
            {
                $this->info('Working');
            } else{
                $this->info('Error');
            }
        }
    }
}
