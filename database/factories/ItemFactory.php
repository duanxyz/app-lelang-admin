<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Item;
use App\Model;
use Faker\Generator as Faker;
use App\Laravue\dummy;

$factory->define(Item::class, function (Faker $faker) {
    // return [
    //     'item_name' => \App\Laravue\Faker::randomInArray(dummy::nameEmas()),
    //     'deskripsi' => \App\Laravue\Faker::randomInArray(dummy::deskripsiEmas()),
    //     'category' => 'perhiasan',
    //     'auction_date' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now')->format('Y-m-d'),
    //     'auction_time' => $faker->time(),
    //     'photo' => \App\Laravue\Faker::randomInArray(dummy::photoEmas()),
    //     'initial_price' => $faker->numberBetween($min = 500000, $max = 1000000),
    //     'status' => \App\Laravue\Faker::randomInArray([
    //         "belum dimulai",
    //         "selesai",
    //     ]),
    //     'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
    // ];
    // return [
    //     'item_name' => \App\Laravue\Faker::randomInArray(dummy::nameElektronik()),
    //     'deskripsi' => \App\Laravue\Faker::randomInArray(dummy::deskripsiElektronik()),
    //     'category' => 'elektronik',
    //     'auction_date' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now')->format('Y-m-d'),
    //     'auction_time' => $faker->time(),
    //     'photo' => \App\Laravue\Faker::randomInArray(dummy::photoElektronik()),
    //     'initial_price' => $faker->numberBetween($min = 2000000, $max = 15000000),
    //     'status' => \App\Laravue\Faker::randomInArray([
    //         "belum dimulai",
    //         "selesai",
    //     ]),
    //     'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
    // ];
    // return [
    //     'item_name' => \App\Laravue\Faker::randomInArray(dummy::nameKendaran()),
    //     'deskripsi' => \App\Laravue\Faker::randomInArray(dummy::deskripsiKendaraan()),
    //     'category' => 'kendaraan',
    //     'auction_date' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now')->format('Y-m-d'),
    //     'auction_time' => $faker->time(),
    //     'photo' => \App\Laravue\Faker::randomInArray(dummy::photoKendaraan()),
    //     'initial_price' => $faker->numberBetween($min = 20000000, $max = 150000000),
    //     'status' => \App\Laravue\Faker::randomInArray([
    //         "belum dimulai",
    //         "selesai",
    //     ]),
    //     'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
    // ];
    return [
        'item_name' => \App\Laravue\Faker::randomInArray(dummy::nameSertifikat()),
        'deskripsi' => \App\Laravue\Faker::randomInArray(dummy::deskripsiSertifikat()),
        'category' => 'sertifikat',
        'auction_date' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now')->format('Y-m-d'),
        'auction_time' => $faker->time(),
        'photo' => \App\Laravue\Faker::randomInArray(dummy::photoSertefikat()),
        'initial_price' => $faker->numberBetween($min = 2000000, $max = 15000000),
        'status' => \App\Laravue\Faker::randomInArray([
            "belum dimulai",
            "selesai",
        ]),
        'created_at' => $faker->dateTimeBetween($startDate = '-3 years', $endDate = 'now', $timezone = null)
    ];
});
