<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Status::class, function (Faker $faker) {
    $datetime = $faker->date() . ' ' . $faker->time();
    return [
        //
        'content' => $faker->text(),
        'created_at' => $datetime,
        'updated_at' => $datetime
    ];
});
