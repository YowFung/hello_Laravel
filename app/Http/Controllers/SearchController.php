<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * 搜索结果列表
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->validate($request, [
            'keyword' => 'required|max:255',
        ]);

        $keyword = $request->keyword;

        $currentUser = Auth::check() ? Auth::user()->id : 0;
        $users = User::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->where('id', '!=', $currentUser)
            ->paginate(5);

        $users->url(route('search.index', $keyword));

        return view('search', compact('users', 'keyword'));
    }
}
