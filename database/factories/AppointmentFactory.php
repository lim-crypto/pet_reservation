<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Appointment;
use App\User;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return   User::all()->random();
        },
        'purpose' => $faker->word,
        'date' => $faker->dateTimeBetween('now', '+1 months'),
        'status' => $faker->randomElement(['pending', 'approved', 'cancelled']),

    ];
});
