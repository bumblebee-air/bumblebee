<?php

use Illuminate\Database\Seeder;

class DoOrderEnvDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\EnvData::create([
            'client_id' => 2,
            'key' => 'STRIPE_SECRET',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 2,
            'key' => 'STRIPE_PUBLIC_KEY',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 2,
            'key' => 'GOOGLE_API_KEY',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 2,
            'key' => 'FCM_KEY',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 2,
            'key' => 'TWILIO_SID',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 2,
            'key' => 'TWILIO_AUTH',
            'value' => ''
        ]);
        \App\EnvData::create([
            'client_id' => 2,
            'key' => 'GH_NOTIF_EMAIL',
            'value' => ''
        ]);
    }
}
