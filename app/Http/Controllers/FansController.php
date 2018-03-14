<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fan;
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
        $attentions = Fan::all()->where('from_id', $user->id);

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
        $fans = Fan::all()->where('to_id', $user->id);
        return view('fans.to_user', compact('fans', 'user'));
    }

    /**
     * 关注/取消关注
     *
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function focusOn(User $user)
    {
//        if ($user->isFocusOn())
////            Fan::deleted();
//        else
////            Fan::insert();

        dd(11111);
        return redirect()->back();
    }
}
