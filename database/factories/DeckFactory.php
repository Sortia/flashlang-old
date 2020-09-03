<?php

/** @var Factory $factory */

use App\Models\Deck;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Deck::class, function (Faker $faker) {
    return [
        'name' => $faker->text(10),
        'user_id' => 1,
        'access' => 'public',
        'description' => $faker->text(50),
    ];
});
