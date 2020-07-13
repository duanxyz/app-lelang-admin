<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Withdrawal_info;
use Faker\Generator as Faker;

$factory->define(Withdrawal_info::class, function (Faker $faker) {
    return [
        'receiver' => $faker->name(),
        'account_number' => $faker->creditCardNumber(),
        'withdraw_amount' => $faker->numberBetween($min = 50000, $max = 2000000),
        'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null),
        'status' => \App\Laravue\Faker::randomInArray(["not approved", "approved"]),

    ];
});
