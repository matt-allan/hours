<?php

declare(strict_types=1);

use App\Tag;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var Factory $factory */

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
