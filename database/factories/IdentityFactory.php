<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\dummy;
use App\Laravue\Models\Identity;
use Faker\Generator as Faker;

$factory->define(Identity::class, function (Faker $faker) {
    return [
        'photoID' => \App\Laravue\Faker::randomInArray(dummy::photoID()),
        'selfieID' => \App\Laravue\Faker::randomInArray(dummy::selfID()),
        'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
    ];
});
