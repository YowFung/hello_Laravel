<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    $date_time = $faker->date . ' ' . $faker->time;
    do {
        $name = $faker->unique()->name;
    } while (mb_strlen($name) > 20);

    static $password;

    return [
        'name' => $name,
        'email' => $faker->unique()->safeEmail,
        'remember_token' => str_random(10),
        'password' => $password ?: $password = bcrypt('123456'),
        'created_at' => $date_time,
        'updated_at' => $date_time,
    ];
});
