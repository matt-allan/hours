<?php

declare(strict_types=1);

use App\Tag;
use App\Frame;
use App\Project;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/* @var Factory $factory */

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'frame_id' => function () {
            return factory(Frame::class)->create()->id;
        },
        'project_id' => function () {
            return factory(Project::class)->create()->id;
        },
    ];
});
