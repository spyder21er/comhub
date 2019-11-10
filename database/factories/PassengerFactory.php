<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Passenger;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
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

$factory->define(Passenger::class, function (Faker $faker) {
    return [
        'first_name'        => $faker->firstName,
        'middle_name'       => $faker->lastName,
        'last_name'         => $faker->lastName,
        'email'             => $faker->unique()->safeEmail,
        'role_id'           => 4,
        'email_verified_at' => now(),
        'password'          => Hash::make('asdfasdf'),
        'remember_token'    => Str::random(10),
    ];
});
