<?php
/** @var Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(App\Store::class, static function (Faker $faker) {
    return [
        'name' => $faker->company,
        'description' => $faker->sentence(10),
        'email' => $faker->unique()->companyEmail,
        'email_verified_at' => now(),
        'phone' => $faker->phoneNumber,
        'link' => $faker->domainName,
        'user_id' => $faker->unique()->numberBetween(1,20),
    ];
});
