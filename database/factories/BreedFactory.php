<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Breed;
use App\Type;
use Faker\Generator as Faker;

$factory->define(Breed::class, function (Faker $faker) {
    return [
        'type_id' => function () {
            return Type::all()->random();
        },
        'breed' => $faker->word,
    ];
});
