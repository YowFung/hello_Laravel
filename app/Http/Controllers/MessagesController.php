<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;

class MessagesController extends Controller
{
    /**
     * 消息列表的页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $msgs = Message::all()->where('to_id', $user->id);
        return view('messages.list', compact('msgs', 'user'));
    }
}
