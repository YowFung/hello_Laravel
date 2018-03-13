<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|min:3|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6|max:16'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('users.show', [$user]);
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'gender' => 'in:male,female',
            'associations' => 'nullable|max:200',
            'college' => 'nullable|max:200',
            'address' => 'nullable|max:200',
        ]);

        if ($request->name != $user->name) {
            $this->validate($request, ['name' => 'unique:users']);
        }

        $user->update([
            'name' => $request->name,
            'gender' => $request->gender,
            'associations' => $request->associations,
            'college' => $request->college,
            'address' => $request->address,
        ]);

        session()->flash('success', '修改成功！');

        return redirect()->route('users.show', $user->id);
    }

    public function destroy()
    {
        return;
    }

    /**
     * 修改用户登录密码的页面
     */
    public function password()
    {

    }

    /**
     * 保存修改密码
     */
    public function storePassword()
    {

    }

}
