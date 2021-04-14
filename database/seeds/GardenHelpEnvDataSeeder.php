<?php

use Illuminate\Database\Seeder;

class GardenHelpEnvDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\EnvData::create([
            'client_id' => 1,
            'key' => 'STRIPE_SECRET',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 1,
            'key' => 'STRIPE_PUBLIC_KEY',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 1,
            'key' => 'GOOGLE_API_KEY',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 1,
            'key' => 'FCM_KEY',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 1,
            'key' => 'TWILIO_SID',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 1,
            'key' => 'TWILIO_AUTH',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 1,
            'key' => 'GH_NOTIF_EMAIL',
            'value' => ''
        ]);
    }
}
