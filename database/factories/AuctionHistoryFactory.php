<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Laravue\Models\Auction_history;
use App\Laravue\Models\Item;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Auction_history::class, function (Faker $faker) {
    return [
        'item_id' => $faker->numberBetween($min="1", $max="10"),
        'final_price' => $faker->numberBetween($min="500000", $max="10000000"),
        'auction_winner' => $faker->name(),
    ];
});
