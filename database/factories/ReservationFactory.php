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
        'date' => $faker->dateTimeBetween('now', '+1 weeks'),
        'status' => $faker->randomElement(['pending', 'approved', 'cancelled']),

    ];
});
