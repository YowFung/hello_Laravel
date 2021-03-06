<?php

use Faker\Generator as Faker;


$factory->define(App\Models\Note::class, function (Faker $faker) {
    $date_time = \Carbon\Carbon::today()->addDay(-1)->toDateString() . ' ' . $faker->time;
    $user_id = rand(1, 10);

    return [
        'user_id' => $user_id,
        'content'    => $faker->text(200),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});