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
        $user_ids = ['1','2','3'];
        $faker = app(Faker\Generator::class);

        $notes = factory(Note::class)->times(100)->make()->each(function ($note) use ($faker, $user_ids) {
            $note->user_id = $faker->randomElement($user_ids);
        });

        Note::insert($notes->toArray());
    }
}
