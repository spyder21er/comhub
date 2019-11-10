<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Admin;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'org_acronym'   => $faker->regexify('[A-Z]{4,9}'),
        'org_name'      => $faker->sentence($faker->numberBetween(4,9)),
    ];
});
