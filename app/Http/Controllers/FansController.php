<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attention;
use App\Models\User;


class FansController extends Controller
{
    /**
     * 关注列表的页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function fromList(User $user)
    {
        $attentions = Attention::all()->where('from_id', $user->id);

        return view('fans.from_user', compact('attentions', 'user'));
    }

    /**
     * 粉丝列表的页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function toList(User $user)
    {
        $fans = Attention::all()->where('to_id', $user->id);
        return view('fans.to_user', compact('fans', 'user'));
    }
}
