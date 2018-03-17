<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Models\Letter;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => []
        ]);
    }


    /**
     * 发表留言回复
     *
     * @param Letter $letter
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Letter $letter, Request $request)
    {
        $this->validate($request, [
            'passage' => 'required|max:140',
            'involved_id' => 'nullable',
        ]);

        Letter::create([
            'letter_id' => $letter->id,
            'from_id' => Auth::user()->id,
            'involved_id' => $request->involved_id,
            'content' => $request->gassage,
        ]);

        return redirect()->back();
    }


    /**
     * 删除留言回复
     *
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('reply', $reply);
        $reply->delete();

        return redirect()->back();
    }
}
