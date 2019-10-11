<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Passenger;
use App\Models\Trip;
use Faker\Generator as Faker;

$factory->define(Trip::class, function (Faker $faker) {
    return [
        'driver_id'                 => null,
        'origin_id'                 => $faker->numberBetween(1,20),
        'destination_id'            => $faker->numberBetween(1,20),
        'code'                      => $faker->regexify('[A-Z]{3}[0-9]{6}'),
        'driver_compliance_code'    => $faker->regexify('[a-z0-9]{8}'),
        'passenger_compliance_code' => $faker->regexify('[a-z0-9]{8}'),
        'departure_time'            => $faker->time(),
        'estimated_arrival_time'    => null,
        'exclusive'                 => false,
        'guest_count'               => $faker->numberBetween(1,10),
        'created_at'                => $faker->dateTimeBetween('-2 days'),
    ];
})->afterCreating(Trip::class, function ($trip) {
    $trip->passengers()->attach(Passenger::all()->random(rand(1, (15 - $trip->guest_count))));
});
