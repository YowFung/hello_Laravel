<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Message;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(20)->make();
        User::insert($users->makeVisible(['password', 'remember_token'])->toArray());

        $user = User::find(1);
        $user->name = 'yowfung';
        $user->email = 'yowfung@outlook.com';
        $user->save();

        foreach (User::all() as $user) {
            Message::create([
                'user_id' => $user->id,
                'type' => 'system',
                'content' => '亲爱的「' . $user->name . '」您好！感谢您注册我们的微博账户，祝您微博生活愉快！',
            ]);
        }
    }
}
