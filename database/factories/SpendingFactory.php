<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Spending;
use Faker\Generator as Faker;

$factory->define(Spending::class, function (Faker $faker) {
    return [
        'spending_amount' => $faker->numberBetween($min = 5000, $max = 100000),
        'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null),
    ];
});
