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
        'phone' => ['phone'=>$faker->phoneNumber, 'phone_country'=>$faker->countryCode],
        'link' => $faker->url,
        'user_id' => $faker->unique()->numberBetween(1,20),
    ];
});
