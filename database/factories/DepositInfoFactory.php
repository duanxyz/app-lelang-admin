<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Deposit_info;
use Faker\Generator as Faker;

$factory->define(Deposit_info::class, function (Faker $faker) {
    return [
        'sender' => $faker->name(),
        'account_number' => $faker->creditCardNumber(),
        'deposit_amount' => '1000000',
        // 'proof' => $faker->image('cats', true, true, 'Faker'),
        'sent_date' => now(),
    ];
});
