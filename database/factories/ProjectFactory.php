<?php

use App\Project;
use Illuminate\Database\Eloquent\Factory;
use Faker\Generator as Faker;

/** @var Factory $factory */

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
