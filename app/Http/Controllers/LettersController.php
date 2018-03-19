<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class LettersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['create'],
        ]);
    }


    /**
     * 创建私信的页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $user = User::findOrFail($request->get('user'));

        return view('users.letters', compact('user'));
    }


    /**
     * 创建私信消息
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user' => 'exists:users,id',
            'content' => 'mix:3|max:500',
        ]);

        MessagesController::create($request->get('user'), $request->get('content'), 'letter');

        return redirect()->back();
    }
}
