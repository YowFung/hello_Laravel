<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;

class NotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => 'show',
        ]);
    }


    /**
     * 动态详情页面
     *
     * @param Note $note
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Note $note)
    {
        $followers = HomeController::followers();
        $follower_count = count($followers);

        $data = [
            'note' => $note,
            'followers' => $followers,
            'follower_count' => $follower_count,
        ];

        return view('home.note', compact('data'));
    }

    /**
     * 发表微博动态
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'notes_content' => 'required|min:3|max:200'
        ]);

        Auth::user()->notes()->create([
            'content' => $request->notes_content,
        ]);

        return redirect(route('users.notes', Auth::user()->id));
    }

    /**
     * 删除微博记录
     *
     * @param Note $note
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Note $note)
    {
        $this->authorize('note', $note);
        $note->delete();

        session()->flash('success', '该条微博已被成功删除！');

        return redirect()->back();
    }
}
