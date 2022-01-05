<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'unitsInStock' => rand(1,100),
        'unitPrice' => rand(100,1000),
        'categoryId' => App\Category::all()->random()->id,
        'description' => $faker->text,
    ];
});
