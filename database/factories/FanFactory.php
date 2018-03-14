<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Fan::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;

    $from_id = rand(1, 50);

    do {
        $to_id = rand(1, 50);
    } while ($to_id == $from_id);

    return [
        'from_id' => $from_id,
        'to_id' => $to_id,
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
