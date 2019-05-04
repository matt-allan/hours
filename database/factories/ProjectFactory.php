<?php

declare(strict_types=1);

use App\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var Factory $factory */

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});
