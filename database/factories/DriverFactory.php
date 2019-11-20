<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Driver;

$factory->define(Driver::class, function (Faker $faker) {
    return [
        'plate_number'      => $faker->regexify('[A-Z]{3}-[0-9]{3,4}'),
        'license_number'    => $faker->regexify('D0[1-9]-[0-9]{2}-[0-9]{6}'),
        'license_expiry'    => $faker->dateTimeBetween('1 year', '3 years'),
    ];
});
