<?php

use Illuminate\Database\Seeder;
use App\Models\Fan;

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

        for ($master_id = 1; $master_id < 50; $master_id++) {
            $times = rand(0, 7);
            $except_ids = [$master_id];
            for ($i = 1; $i <= $times; $i++) {
                do {
                    $follow_id = rand(1, 50);
                } while (in_array($follow_id, $except_ids));

                $datetime = $faker->date . ' ' . $faker->time;

                Fan::insert([
                    'master_id' => $master_id,
                    'follow_id' => $follow_id,
                    'created_at' => $datetime,
                ]);
            }
        }
    }
}
