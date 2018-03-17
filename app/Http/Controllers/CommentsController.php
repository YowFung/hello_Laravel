<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'expect' => []
        ]);
    }


    /**
     * 发表评论
     *
     * @param Note $note
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Note $note, Request $request)
    {
        $this->validate($request, [
            'passage' => 'required|max:140',
            'involved_id' => 'nullable',
        ]);

        Comment::create([
            'note_id' => $note->id,
            'from_id' => Auth::user()->id,
            'involved_id' => $request->involved_id,
            'content' => $request->passage,
        ]);

        return redirect()->back();
    }


    /**
     * 删除评论
     *
     * @param Comment $comment
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('comment', $comment);
        $comment->delete();

        return redirect()->back();
    }
}
