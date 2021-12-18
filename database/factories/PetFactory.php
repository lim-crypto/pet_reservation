<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Breed;
use App\Pet;
use Faker\Generator as Faker;

$factory->define(Pet::class, function (Faker $faker) {
    return [
        'breed_id' => function () {
            return Breed::all()->random();
        },
        'name' => $faker->name,
        'age' => $faker->numberBetween(0, 20),
        'weight' => $faker->numberBetween(0, 20),
        'height' => $faker->numberBetween(0, 20),
        'description' => $faker->paragraph,
    ];
});
