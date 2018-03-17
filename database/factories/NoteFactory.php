<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Note::class, function (Faker $faker) {
    $date_time = \Carbon\Carbon::today()->toDateString() . ' ' . $faker->time;

    return [
        'content'    => $faker->text(200),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});