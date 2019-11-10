<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Passenger;
use App\Models\Trip;
use App\Models\Driver;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Trip::class, function (Faker $faker) {
    $origin_id = $faker->numberBetween(1, 20);
    $destination_id = 11;
    if ($origin_id == 11)
        while($destination_id == 11)
            $destination_id = $faker->numberBetween(1, 20);
    return [
        'driver_id'                 => null,
        'origin_id'                 => $origin_id,
        'destination_id'            => $destination_id,
        'code'                      => $faker->regexify('[A-Z]{3}[0-9]{6}'),
        'driver_compliance_code'    => $faker->regexify('[a-z0-9]{8}'),
        'passenger_compliance_code' => $faker->regexify('[a-z0-9]{8}'),
        'departure_time'            => '22:00:00',
        'exclusive'                 => false,
        'driver_complied'           => false,
        'guest_count'               => $faker->numberBetween(1,10),
        'created_at'                => $faker->dateTimeBetween('-12 days', '12 days'),
    ];
})->afterCreating(Trip::class, function ($trip) {
    $trip
        ->passengers()
        ->attach(
            Passenger::all()->filter(function ($passenger) {
            return !$passenger->hasTripToday();
        })
        ->random(rand(1, (15 - $trip->guest_count))));
    $today = Carbon::now();
    if ($trip->created_at->lessThan($today))
    {
        $hometown = ($trip->origin_id == 11) ? $trip->destination_id : $trip->origin_id;
        $trip->driver()->associate(Driver::whereTown($hometown)->get()->random());
        $trip->save();
    }
});
