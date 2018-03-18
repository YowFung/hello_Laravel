<?php

use Illuminate\Database\Seeder;
use App\Models\Note;

class NotesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $notes = factory(Note::class)->times(100)->make();

        Note::insert($notes->toArray());
    }
}
