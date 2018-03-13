<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Note;

class NotesController extends Controller
{
    /**
     * 日志列表的页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        $notes = Note::all()->where('published_id', $user->id);
        return view('notes.list', compact('user', 'notes'));
    }
}
