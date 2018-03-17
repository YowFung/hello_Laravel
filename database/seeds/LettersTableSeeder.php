<?php

use Illuminate\Database\Seeder;
use App\Models\Letter;

class LettersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $letters = factory(Letter::class)->times(20)->make();
        Letter::insert($letters->toArray());
    }
}
