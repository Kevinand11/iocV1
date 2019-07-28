<?php

/* @var $factory Factory */

use App\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Category::class, static function (Faker $faker) {
    return [
        'name' => $faker->word,
        'parent_id' => $faker->numberBetween(0,5)
    ];
});
