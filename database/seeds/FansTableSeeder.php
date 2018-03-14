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
        $fans = factory(Fan::class)->times(300)->make();
        Fan::insert($fans->toArray());
    }
}
