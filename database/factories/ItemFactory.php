<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Item::class, function (Faker $faker) {
    return [
        'id' => Str::random(32),
        'name' => $faker->name,
        'categories_id' => Str::random(32),
        'image_path' => $faker->imageUrl(640, 480),
        'stock' => $faker->randomDigit,
        'base_price' => $faker->randomFloat(2, 0, 99999),
        'sale_price' => $faker->randomFloat(2, 0, 99999)
    ];
});
