<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $note_id = rand(1, 100);
    $from_id = 1;
    $involved_id = rand(0, 10);
    $content = $faker->text(200);
    $created_at = \Carbon\Carbon::today()->toDateString() . $faker->time;

    $data =  [
        'note_id' => $note_id,
        'from_id' => $from_id,
        'involved_id' => $involved_id,
        'content' => $content,
        'created_at' => $created_at,
    ];

    return $data;
});
