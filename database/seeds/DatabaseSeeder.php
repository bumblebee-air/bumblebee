<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker\Factory::create();

        // Users
        DB::table('users')->delete();
        \App\User::create([
            'name' => 'test user',
            'email' => 'test@example.com',
            'phone' => '+123456789',
            'password' => bcrypt('test123'),
            'user_role' => 'admin',
            'is_profile_completed' => true,
        ]);

        // Profiles
        DB::table('profiles')->delete();
        \App\Profile::create([
            'user_id' => DB::table('users')->first()->id,
            'vehicle_reg' => $faker->text(5),
            'vehicle_make' => $faker->uuid ,
            'vehicle_model' => $faker->name ,
            'vehicle_version' => $faker->macAddress ,
            'vehicle_fuel' => $faker->uuid ,
            'vehicle_colour' => $faker->colorName ,
            'vehicle_external_id' => $faker->uuid ,
            'address' => $faker->address,
            'lat' => $faker->latitude,
            'lon' => $faker->longitude,
            'vat_number' => $faker->numberBetween(100, 123456),
            'communication_method' => ['whatsapp', 'sms', 'email', 'phone_call'][array_rand(['whatsapp', 'sms', 'email', 'phone_call'])],
            'notes' => $faker->text
        ]);

        // Orders
        DB::table('orders')->delete();
        for ($i=0; $i<15; $i++){
            \App\Order::create([
                'order_id' => $faker->uuid,
                'customer_name' => $faker->name,
                'customer_email' => $faker->email,
                'customer_phone' => $faker->phoneNumber,
                'customer_address' => $faker->address,
                'customer_address_lat' => $faker->latitude,
                'customer_address_lon' => $faker->longitude,
                'eircode' => $faker->uuid,
                'pickup_address' => $faker->address,
                'pickup_lat' => $faker->latitude,
                'pickup_lon' => $faker->longitude,
                'fulfilment' => $faker->boolean,
                'notes' => $faker->text,
                'retailer_name' => $faker->name,
                'dimensions' => $faker->numberBetween(1, 1000) . 'x' . $faker->numberBetween(1, 1000),
                'weight' => $faker->numberBetween(1, 1000),
                'description' => $faker->text(150),
                'deliver_by' => DB::table('users')->first()->id
            ]);
        }
    }
}