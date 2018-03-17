<?php

use Illuminate\Database\Seeder;
use App\Models\Reply;

class RepliesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $replies = factory(Reply::class)->times(10)->make();

        Reply::insert($replies->toArray());
    }
}
