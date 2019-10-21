<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use App\Models\Driver;
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

$factory->define(Driver::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'role_id'           => 3,
        'email_verified_at' => now(),
        'password'          => Hash::make('asdfasdf'),
        'remember_token'    => Str::random(10),
    ];
})->afterCreating(Driver::class, function ($driver) {
    $driver
        ->admin()
        ->associate(Admin::all()->random());
    $driver->save();
});
