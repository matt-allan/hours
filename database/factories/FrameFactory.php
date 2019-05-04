<?php

use App\Frame;
use App\Project;
use Illuminate\Database\Eloquent\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Date;

/** @var Factory $factory */

$factory->define(Frame::class, function (Faker $faker) {
    return [
        'started_at' => Date::instance($faker->dateTimeThisMonth()),
        'stopped_at' => Date::instance($faker->dateTimeThisMonth()),
        'project_id' => function () {
            return factory(Project::class)->create()->id;
        }
    ];
});
