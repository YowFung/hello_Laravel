<?php

use Faker\Generator as Faker;
use App\Models\User;

$factory->define(App\Models\Message::class, function (Faker $faker) {
    $created_at = \Carbon\Carbon::today()->toDateString() . $faker->time;
    $user_id = 1;
    $type = rand(1, 5);
    $read = rand(0, 1);
    $content = "";

    switch($type) {
        case 1:
            $type = 'system';
            $content = $faker->text(2000);
            break;
        case 2:
            $type = 'letter';
            $from_id = rand(2, 20);
            $content = '用户「' . config('app.sign_begin') . User::find($from_id)->name . config('app.sign_end') .
                '」逛了你的主页，并给你留下了一段话，' . config('app.sign_begin') . '点击查看' . config('app.sign_end') . '。';
            break;
        case 3:
            $type = 'attach';
            $from_id = rand(2, 20);
            $content = '用户「' . config('app.sign_begin') . User::find($from_id)->name . config('app.sign_end') .
                '」已经阅读你的留言，并给你回了一段话，' . config('app.sign_begin') . '点击查看' . config('app.sign_end') . '。';
            break;
        case 4:
            $type = 'comment';
            $from_id = rand(2, 20);
            $content = '用户「' . config('app.sign_begin') . User::find($from_id)->name . config('app.sign_end') .
                '」查看了你发表的微博动态，并评论了一段话，' . config('app.sign_begin') . '点击查看' . config('app.sign_end') . '。';
            break;
    }

    $data =  [
        'user_id' => $user_id,
        'type' => $type,
        'content' => $content,
        'created_at' => $created_at,
        'read' => $read,
    ];

    return $data;
});
