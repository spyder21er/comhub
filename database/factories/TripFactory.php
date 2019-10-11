<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Trip;
use Faker\Generator as Faker;

$factory->define(Trip::class, function (Faker $faker) {
    return [
        'driver_id'                 => null,
        'origin_id'                 => $faker->numberBetween(1,20),
        'destination_id'            => $faker->numberBetween(1,20),
        'trip_code'                 => $faker->regexify('[A-Z]{4}[0-9]{5}'),
        'driver_compliance_code'    => $faker->regexify('[a-zA-Z0-9]{20}'),
        'passenger_compliance_code' => $faker->regexify('[a-zA-Z0-9]{20}'),
        'departure_time'            => $faker->time(),
        'estimated_arrival_time'    => null,
        'exclusive'                 => false,
        'guest_count'               => $faker->numberBetween(1,15),
    ];
});
