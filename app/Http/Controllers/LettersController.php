<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Letter;

class LettersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
           'except' => ['index']
        ]);
    }

    /**
     * 显示留言列表页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user)
    {
        $letters = $user->letters()->paginate(5);
        $letters->url(route('letters.index', $user->id));

        return view('letters.index', compact('user', 'letters'));
    }


    /**
     * 发表留言
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(User $user, Request $request)
    {
        $this->validate($request, [
            'passage' => 'required|min:3|max:1000',
            'involved_id' => 'nullable',
        ]);

        Letter::create([
            'from_id' => Auth::user()->id,
            'user_id' => $user->id,
            'involved_id' => $request->involved_id,
            'content' => $request->passage,
        ]);

        if ($user->id != Auth::user()->id) {
            $msg_content = "留言留言留言。。。。。。。";
            $parameters = "";
            MessagesController::create($user->id, $msg_content, 'letter', $parameters);
        }

        session()->flash('success', '发表留言成功！');
        return redirect()->back();
    }


    public function destory(Letter $letter)
    {
        $this->authorize('destroy', $letter);


    }
}
