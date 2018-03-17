<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Reply::class, function (Faker $faker) {
    $letter_id = rand(1, 20);
    $from_id = 1;
    $involved_id = rand(0, 10);
    $content = $faker->text(200);
    $created_at = \Carbon\Carbon::today()->toDateString() . $faker->time;

    return [
        'letter_id' => $letter_id,
        'from_id' => $from_id,
        'involved_id' => $involved_id,
        'content' => $content,
        'created_at' => $created_at,
    ];
});
