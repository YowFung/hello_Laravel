<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Letter::class, function (Faker $faker) {
    $from_id = rand(1, 10);
    $user_id = 1;
    $involved_id = rand(0, 10);
    $content = $faker->text(1000);
    $created_at = \Carbon\Carbon::today()->toDateString() . $faker->time;

    $data = [
        'from_id' => $from_id,
        'user_id' => $user_id,
        'involved_id' => $involved_id,
        'content' => $content,
        'created_at' => $created_at,
    ];

    return $data;
});
