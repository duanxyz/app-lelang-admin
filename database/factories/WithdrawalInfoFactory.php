<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Withdrawal_info;
use Faker\Generator as Faker;

$factory->define(Withdrawal_info::class, function (Faker $faker) {
    return [
        'receiver' => $faker->name(),
        'account_number' => $faker->creditCardNumber(),
        'withdraw_amount' => '20000',
    ];
});
