<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Entities\Employee::class, function (Faker $faker) {
    return [
        'cpfcnpj' => $faker->numberBetween(100000000, 999999999),
        'name'  => $faker->numberBetween(1000, 9999),
        'code'  => $faker->postcode,
        'address' => $faker->address(),
        'zip_code' => $faker->postcode,
        'neighborhood' => $faker->word,
        'city' => $faker->city,
        'state' => $faker->stateAbbr,
        'phone' => $faker->numberBetween(51320000000, 51399999999),
        'mobile' => $faker->numberBetween(51900000000, 51999999999),
        'email' => $faker->freeEmail,
        'comments'=> ''
    ];
});