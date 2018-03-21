<?php

use Faker\Generator as Faker;
use App\Models\Note;
use App\Http\Controllers\MessagesController;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    $note_id = rand(1, 100);
    $user_id = Note::findOrFail($note_id)->user_id;
    $from_id = rand(1, 10);
    $content = $faker->text(200);
    $created_at = \Carbon\Carbon::today()->toDateString() . $faker->time;

    MessagesController::createCommentMessage($user_id, $from_id, $note_id, $content);

    $data =  [
        'note_id' => $note_id,
        'from_id' => $from_id,
        'content' => $content,
        'created_at' => $created_at,
    ];

    return $data;
});
