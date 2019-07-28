<?php /** @noinspection ClassConstantCanBeUsedInspection */

/* @var $factory Factory */

use Faker\Generator as Faker;use Illuminate\Database\Eloquent\Factory;

$factory->define(App\Picture::class, static function (Faker $faker) {
    return [
        'imageable_type' => $faker->randomElement(['App\User','App\Store','App\Post']),
        'imageable_id' => $faker->numberBetween(1,100),
        'filename' => 'img/'.time().'.png',
    ];
});
