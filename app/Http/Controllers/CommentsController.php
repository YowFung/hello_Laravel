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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140',
            'note_id' => 'required|exists:notes',
            'user_id' => 'required|exists:users',
        ]);

        $content = $request->get('content');

        Comment::create([
            'note_id' => $request->get('note'),
            'from_id' => Auth::user()->id,
            'content' => $content,
        ]);

        MessagesController::createCommentMessage($request->get('user_id'), Auth::user()->id, $request->get('note_id'), $content);

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
