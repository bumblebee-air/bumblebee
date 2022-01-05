<?php

namespace App\Console\Commands;

use App\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateOrderStatusJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:order';

    /**
     * The console Update Order Staus on fullfillment.
     *
     * @var string
     */
    protected $description = 'Update Order Staus on fullfillment time ';

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
     * @return int
     */
    public function handle()
    {
        $orders = Order::where('status', 'pending')->whereNotNull('fulfilment')->whereDate('fulfilment', '<=', Carbon::now()->toDateTimeString())->get();

        foreach ($orders as $order) {
            $order->status = 'ready';
            $order->save();
        }

    }
}
