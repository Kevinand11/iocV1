<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use App\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(5, true),
        'price' => $faker->numberBetween(100, 10000),
        'user_id' => $faker->numberBetween(1, 20),
        'category_id' => $faker->numberBetween(1, 20),
    ];
});
