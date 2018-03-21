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
            'keyword' => 'required|max:80',
        ]);

        $keyword = $request->keyword;
        $data = [
            'followers' => HomeController::followers(),
            'follower_count' => count(HomeController::followers()),
        ];

        if(empty(session('backUrl')))
            session(['backUrl' => redirect()->back()->getTargetUrl()]);

        $currentUser = Auth::check() ? Auth::user()->id : 0;
        $users = User::where('name', 'like', '%' . $keyword . '%')
            ->orWhere('email', 'like', '%' . $keyword . '%')
            ->where('id', '!=', $currentUser)
            ->paginate(12);

        $users->url(route('search.index'));

        return view('home.search', compact('users', 'keyword', 'data'));
    }
}
