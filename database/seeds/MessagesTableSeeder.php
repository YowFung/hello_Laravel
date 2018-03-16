<?php

use Illuminate\Database\Seeder;
use App\Models\Message;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = factory(Message::class)->times(10)->make();
        $messages = $messages->makeVisible(['content', 'parameters'])->toarray();

        Message::insert($messages);
    }
}
