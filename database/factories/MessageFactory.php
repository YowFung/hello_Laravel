<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Message::class, function (Faker $faker) {
    $created_at = $faker->date . $faker->time;

    $to_id = 1;
    $type = rand(1,3);
    $from_id = 0;
    $read = rand(0, 1);

    switch($type) {
        case 1:
            $type = 'system';
            break;
        case 2:
            $type = 'letter';
            $from_id = rand(2, 50);
            break;
        case 3:
            $type = 'replay';
            $from_id = rand(2, 50);
            break;
    }

    $passage = $faker->text();

    return [
        'from_id' => $from_id,
        'to_id' => $to_id,
        'type' => $type,
        'passage' => $passage,
        'created_at' => $created_at,
        'read' => $read,
    ];
});
