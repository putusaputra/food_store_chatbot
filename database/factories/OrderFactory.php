<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'id' => Str::random(32),
        'date' => $faker->date(),
        'status' => $faker->randomElement(array('cash', 'kredit')),
        'grand_total' => $faker->randomFloat(2, 0, 99999)
    ];
});
