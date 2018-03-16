<?php

use Illuminate\Database\Seeder;
use App\Models\Fan;
use App\Models\Message;
use App\Models\User;

class FansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Faker\Generator::class);

        for ($master_id = 1; $master_id < 20; $master_id++) {
            $times = rand(0, 7);
            $except_ids = [$master_id];
            for ($i = 1; $i <= $times; $i++) {
                do {
                    $follow_id = rand(1, 20);
                } while (in_array($follow_id, $except_ids));

                $datetime = $faker->date . ' ' . $faker->time;

                Fan::insert([
                    'master_id' => $master_id,
                    'follow_id' => $follow_id,
                    'created_at' => $datetime,
                ]);

                Message::create([
                    'user_id' => $master_id,
                    'type' => 'attach',
                    'parameters' => route('users.show', $follow_id),
                    'content' => '用户「' . config('app.sign_begin') . User::find($follow_id)->name . config('app.sign_end') . '」关注了您！你可以在「我的粉丝」列表中查看TA的信息。',
                ]);
            }
        }
    }
}
