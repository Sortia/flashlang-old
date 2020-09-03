<?php

/** @var Factory $factory */

use App\Models\Deck;
use App\Models\Flashcard;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Flashcard::class, function (Faker $faker) {
    return [
        'front_text' => $faker->text(8),
        'back_text' => $faker->text(8),
        'deck_id' => factory(Deck::class)->create()->id
    ];
});
