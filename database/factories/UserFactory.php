<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;
use Illuminate\Support\Carbon;

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

$factory->define(User::class, function (Faker $faker) {
    $firstName = $faker->firstName;
    $lastName = $faker->lastName;
    return [
        'role_id'           => 4,
        'town_id'           => $faker->numberBetween(1, 20),
        'first_name'        => $firstName,
        'middle_name'       => $faker->lastName,
        'last_name'         => $lastName,
        'email'             => Str::lower($firstName) . "." . Str::lower($lastName) . '@comhub.com',  // $faker->unique()->safeEmail,
        'password'          => Hash::make('asdfasdf'),
        'phone'             => $faker->regexify('\+639[0-9]{9}'),
        'birthday'          => $faker->dateTimeBetween('-45 years', '-18 years')->format('m/d/Y'),
        'email_verified_at' => now(),
        'remember_token'    => Str::random(10),
    ];
});
