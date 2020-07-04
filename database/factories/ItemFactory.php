<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Item;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    $category = [
        "emas",
        "elektronik",
        "pertanian",
        "perikanan",
        "kendaraan",
        "sertifikat",
    ];
    return [
        'item_name' => $faker->name(),
        'deskripsi' => $faker->realText(),
        'category' => \App\Laravue\Faker::randomInArray([
            "emas",
            "elektronik",
            "pertanian",
            "perikanan",
            "kendaraan",
            "sertifikat",
        ]),
        'auction_date' => $faker->date(),
        'auction_time' => $faker->time(),
        'photo' => 'https://source.unsplash.com/random/400x200',
        'initial_price' => '1000000',
    ];
});
