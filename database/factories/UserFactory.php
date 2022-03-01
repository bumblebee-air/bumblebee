<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'phone' => '+353'.$faker->numerify('########'),
        'user_role' => 'customer',
        'password' => bcrypt(\Illuminate\Support\Str::random(8))
    ];
});

$factory->state(App\User::class, 'customer', function (Faker $faker) {
    return [
        'user_role' => 'customer',
    ];
});

$factory->state(App\User::class, 'contractor', function (Faker $faker) {
    return [
        'user_role' => 'contractor',
    ];
});
