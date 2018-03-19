<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    /**
     * 显示主页
     *
     * @param string $category
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($category = 'recommend', Request $request)
    {
        if (isset($request->category) && in_array($request->category, ['recommend', 'concerned', 'newest']))
            $category = $request->category;

        switch ($category) {
            case 'newest' : $notes = $this->generateNewestNotes(); break;
            case 'concerned' : $notes = $this->generateAttachedNotes(); break;
            default : $notes = $this->generateRecommendNotes(); break;
        }

        $notes = $this->paginate($notes, $request, 10);
        $notes->url(route('home'));
        $followers = $this->followers();
        $follower_count = count($followers);

        $data = [
            'category' => $category,
            'notes' => $notes,
            'followers' => $followers,
            'follower_count' => $follower_count,
        ];

        return view('home.status', compact('data'));
    }


    /**
     * 获取首页关注人列表
     *
     * @return array
     */
    public static function followers()
    {
        $followers = [];
        if (Auth::check())
            $followers = Auth::user()->followers->take(40);

        return $followers;
    }


    /**
     * 产生推荐动态列表
     *
     * @return array|Collection|static
     */
    protected function generateRecommendNotes()
    {
        $twoYearsAgo = Carbon::now()->addYears(-2);
        $notes = Note::where('created_at', '>', $twoYearsAgo)->get();

        $arrs = [];
        foreach ($notes as $note) {
            $arrs[] = [
                'id' => $note->id,
                'count' => $note->commentsCount(),
            ];
        }

        $arrs = new Collection($arrs);
        $arrs = $arrs->sortByDesc('count');

        $notes = [];
        foreach ($arrs as $arr) {
            if ($arr['count'])
                $notes[] = Note::find($arr['id']);
        }

        $notes = new Collection($notes);
        $notes = $notes->take(80);

        return $notes;
    }


    /**
     * 产生最新动态列表
     *
     * @return Collection
     */
    protected function generateNewestNotes()
    {
        $notes = Note::where([])->orderBy('created_at', 'desc')->get()->take(80);
        $notes = new Collection($notes);

        return $notes;
    }


    /**
     * 产生关注动态列表
     *
     * @return array|Collection|null|static
     */
    protected function generateAttachedNotes()
    {
        if (!Auth::check())
            return null;

        $notes = Auth::user()->followersNotes()->get()->take(80);

        return $notes;
    }


    /**
     * 手动分页
     *
     * @param Collection $data
     * @param Request $request
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    protected function paginate(Collection $data, Request $request, $perPage = 10)
    {
        $page = 1;
        $total = count($data);

        if ($request->has('page')) {
            $page = $request->input('page');
            $page = $page <= 0 ? 1 :$page;
        }

        $items = [];
        for ($i = ($page-1)*$perPage; $i < $page*$perPage; $i++) {
            if ($i < $total)
                $items[] = $data[$i];
        }

        $paginator = new LengthAwarePaginator($items, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        return $paginator;
    }
}
