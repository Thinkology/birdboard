<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
        'body' => $faker->sentence,
        //option 1
        /*'project_id' => function(){
            return factory(\App\Project::class)->create()->id;
        */
        //option 2
        'project_id' => factory(\App\Project::class)
    ];
});
