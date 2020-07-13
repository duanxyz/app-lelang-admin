<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'balance' => \App\Laravue\Faker::randomInArray([
            "balance" => $faker->numberBetween($min = 1000000, $max = 9000000)
        ]),
    ];
});
