<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Passenger;
use App\Models\Trip;
use App\Models\Driver;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Trip::class, function (Faker $faker) {
    $to = 11;
    $from = $faker->numberBetween(1, 20);
    while ($from == 11)
        $from = $faker->numberBetween(1, 20);

    $rand = $faker->numberBetween(1, 100);
    if ($rand & 1)
    {
        $temp = $to;
        $to = $from;
        $from = $temp;
    }

    return [
        'driver_id'                 => null,
        'origin_id'                 => $from,
        'destination_id'            => $to,
        'code'                      => $faker->regexify('[A-Z]{3}[0-9]{6}'),
        'driver_compliance_code'    => $faker->regexify('[a-z0-9]{8}'),
        'passenger_compliance_code' => $faker->regexify('[a-z0-9]{8}'),
        'departure_time'            => '22:00:00',
        'exclusive'                 => false,
        'guest_count'               => $faker->numberBetween(1,10),
        'created_at'                => $faker->dateTimeBetween('-12 days', '2 days'),
    ];
})->afterCreating(Trip::class, function ($trip) {
    $today = Carbon::now();
    if ($trip->created_at->lessThan($today))
    {
        $trip
            ->passengers()
            ->attach(Passenger::all()
                ->filter(function ($passenger) {
                    return !$passenger->hasTripToday();
                })
                ->random(rand(1, (15 - $trip->guest_count))));
        $hometown = ($trip->origin_id == 11) ? $trip->destination_id : $trip->origin_id;
        $trip->driver()->associate(Driver::whereTown($hometown)->get()->filter(function ($d) {
            return !$d->hasTripToday();
        })->random());
        $trip->driver_complied = true;
        $trip->save();
    }
});
