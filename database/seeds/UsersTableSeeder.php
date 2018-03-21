<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Http\Controllers\MessagesController;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(10)->make();
        $users = $users->makeVisible(['password', 'remember_token'])->toArray();
        User::insert($users);

        $user = User::find(1);
        $user->name = 'yowfung';
        $user->email = 'yowfung@outlook.com';
        $user->avatar = config('app.default_avatar');
        $user->save();
    }
}
