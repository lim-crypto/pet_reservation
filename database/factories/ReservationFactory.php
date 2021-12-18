<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pet;
use App\Reservation;
use App\User;
use Faker\Generator as Faker;

$factory->define(Reservation::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return   User::all()->random();
        },
        'pet_id' => function () {
            return Pet::all()->random();
        },
        'date' => $faker->dateTimeBetween('-1 years', '+1 years'),
        'status' => $faker->randomElement(['pending', 'approved', 'cancelled']),

    ];
});
