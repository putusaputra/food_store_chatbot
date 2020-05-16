<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\OrderItem::class, function (Faker $faker) {
    return [
        'id' => Str::random(32),
        'order_id' => Str::random(32),
        'item_id' => Str::random(32),
        'qty' => $faker->randomDigit,
        'total' => $faker->randomFloat(2, 0, 99999),
        'base_price' => $faker->randomFloat(2, 0, 99999),
        'sale_price' => $faker->randomFloat(2, 0, 99999)
    ];
});
