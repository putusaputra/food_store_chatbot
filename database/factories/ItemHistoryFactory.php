<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\ItemHistory::class, function (Faker $faker) {
    return [
        'id' => Str::random(32),
        'item_id' => Str::random(32),
        'beginning_balance' => $faker->randomDigit,
        'in' => $faker->randomDigit,
        'out' => $faker->randomDigit,
        'ending_balance' => $faker->randomDigit,
        'base_price' => $faker->randomFloat(2, 0, 99999),
        'sale_price' => $faker->randomFloat(2, 0, 99999)
    ];
});
