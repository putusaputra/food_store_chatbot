<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'id' => Str::random(32),
        'name' => $faker->name,
        'description' => $faker->realText(20)
    ];
});
