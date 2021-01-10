<?php

use Illuminate\Database\Seeder;

class UpdateDoordersUsersClients extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Get Doorder Users
        $users = \App\User::where('user_role', 'client')->orWhere('user_role', 'retailer')->get();
        //Get Doorder Client
        $client = \App\Client::where('name', 'DoOrder')->first();
        //Update Users Client relations
        foreach ($users as $user) {
            \App\UserClient::create([
                'user_id' => $user->id,
                'client_id' => $client->id
            ]);
        }
    }
}
