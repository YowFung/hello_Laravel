<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }

    /**
     * 显示登录页面
     */
    public function create()
    {
        return view('users.login');
    }

    /**
     * 创建新会话（登录）
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect(route('users.show', [Auth::user()]));
        } else {
            session()->flash('danger', '邮箱或密码不正确。');
            return redirect()->back();
        }
    }

    /**
     * 销毁会话（退出登录）
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy()
    {
        Auth::logout();
        return redirect('/login');
    }
}
