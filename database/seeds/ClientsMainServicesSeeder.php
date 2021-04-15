<?php

use Illuminate\Database\Seeder;

class ClientsMainServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //DoOrder Services
        $doorder_client = \App\Client::where('name', 'DoOrder')->first();
        if ($doorder_client) {
            $orders = \App\Order::all();
            foreach ($orders as $order) {
                \App\ClientsMainService::create([
                    'client_id' => $doorder_client->id,
                    'service_id' => $order->id,
                    'service_type' => 'App\Order',
                ]);
            }
        }
        //Garden Help Services
        $gh_client = \App\Client::where('name', 'GardenHelp')->first();
        if ($gh_client) {
            $customer_registrations = \App\Customer::all();
            foreach ($customer_registrations as $registration) {
                \App\ClientsMainService::create([
                    'client_id' => $gh_client->id,
                    'service_id' => $registration->id,
                    'service_type' => 'App\Customer',
                ]);
            }
        }
    }
}
