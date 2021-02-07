<?php

namespace Database\Factories;

use Faker\Generator;
use App\Entities\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @var \LaravelDoctrine\ORM\Testing\Factory $factory */
$factory->define(Customer::class, function (Generator $faker, array $attributes = []) {
    return [
        'firstName' => $attributes['first_name'] ?? $faker->firstName,
        'lastName' => $attributes['last_name'] ?? $faker->lastName,
        'username' => $attributes['username'] ?? $faker->userName,
        'gender' => $attributes['gender'] ?? $faker->randomElement([0,1]),
        'country' => $attributes['country'] ?? $faker->country,
        'city' => $attributes['city'] ?? $faker->city,
        'phone' => $attributes['phone'] ?? $faker->phoneNumber,
        'password' => $attributes['password'] ?? $faker->md5,
        'email' => $attributes['email'] ?? $faker->unique()->email,
    ];
});
