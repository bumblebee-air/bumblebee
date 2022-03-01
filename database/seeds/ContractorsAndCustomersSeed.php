<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class ContractorsAndCustomersSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customers = factory(App\User::class, 20)->state('customer')->create();
        $contractors = factory(App\Contractor::class, 20)->create();
    }
}
