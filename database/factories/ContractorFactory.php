<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Contractor::class, function (Faker $faker) {
    $contractor = factory(App\User::class)->state('contractor')->create();
    return [
        'user_id' => $contractor->id,
        'name' => $contractor->name,
        'email' => $contractor->email,
        'phone_number' => $contractor->phone,
        'experience_level' => 'Level 2 (2-5 Years)',
        'experience_level_value' => '2',
        'age_proof' => 'https://www.learningcontainer.com/wp-content/uploads/2020/08/Sample-png-Image-for-Testing.png',
        'type_of_work_exp' => 'Garden Design, Garden Maintenance, Grass Cutting',
        'address' => $faker->address(),
        'address_coordinates' => '{"lat": 53.34981, "lon": -6.26031}',
        'cv' => 'https://www.learningcontainer.com/wp-content/uploads/2020/08/Sample-png-Image-for-Testing.png',
        'available_equipments' => 'Hedge cutters, Hand fork, Hoe, Paving knife, Edging knife',
        'insurance_document' => 'https://www.learningcontainer.com/wp-content/uploads/2020/08/Sample-png-Image-for-Testing.png',
        'has_smartphone' => $faker->boolean,
        'type_of_transport' => 'Van',
        'status' => 'completed',
        'contact_through' => $faker->randomElement(['email', 'sms'])
    ];
});
