<?php

use Illuminate\Database\Seeder;
use App\Models\User;

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
        $user->name = '小峰峰';
        $user->email = '343101406@qq.com';
        $user->avatar = config('app.default_avatar');
        $user->save();
    }
}
