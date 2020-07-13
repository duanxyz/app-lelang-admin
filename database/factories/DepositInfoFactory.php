<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\dummy;
use App\Laravue\Models\Deposit_info;
use Faker\Generator as Faker;

$factory->define(Deposit_info::class, function (Faker $faker) {
    return [
        'sender' => $faker->name(),
        'account_number' => $faker->creditCardNumber(),
        'deposit_amount' => $faker->numberBetween($min = 50000, $max = 100000000),
        'proof' => \App\Laravue\Faker::randomInArray(dummy::proof()),
        'sent_date' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null),
        'status' => \App\Laravue\Faker::randomInArray(["not approved", "approved"]),
    ];
});
