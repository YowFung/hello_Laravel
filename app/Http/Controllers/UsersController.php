<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'notes']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


    /**
     * 用户资料页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }


    /**
     * 用户注册页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('users.create');
    }


    /**
     * 用户注册
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|min:3|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6|max:16'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('users.show', [$user]);
    }


    /**
     * 用户信息编辑页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', compact('user'));
    }


    /**
     * 用户信息更新
     *
     * @param User $user
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);

        if (array_key_exists('password_new', $request->all())) {
            $this->validate($request, [
                'password_old' => 'required',
                'password_new' => 'required|confirmed|min:6|max:16',
            ]);

            if (!Hash::check($request->password_old, $user->password)) {
                session()->flash('danger', '原密码不正确。');
                return redirect()->back();
            } elseif ($request->password_old == $request->password_new) {
                session()->flash('danger', '新密码不能跟原密码一样。');
                return redirect()->back();
            }

            $data = ['password' => bcrypt($request->password_new)];
        }
        else {
            $this->validate($request, [
                'name' => 'required|min:3|max:50',
                'gender' => 'in:male,female',
                'associations' => 'nullable|max:200',
                'college' => 'nullable|max:200',
                'address' => 'nullable|max:200',
            ]);

            if ($request->name != $user->name) {
                $this->validate($request, ['name' => 'unique:users']);
            }

            $data = [
                'name' => $request->name,
                'gender' => $request->gender,
                'associations' => $request->associations,
                'college' => $request->college,
                'address' => $request->address,
            ];
        }

        $user->update($data);
        session()->flash('success', '修改成功！');

        return redirect()->route('users.show', $user->id);
    }


    /**
     * 用户密码修改页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function safety(User $user)
    {
        $this->authorize('update', $user);

        return view('users.safety', compact('user'));
    }


    /**
     * 获取用户头像链接
     *
     * @param User $user
     * @param $hash
     * @param int $size
     * @return string
     */
    public function photo(User $user, $hash, $size = 64)
    {

        $url = '';
        return $url;
    }


    /**
     * 用户微博动态列表页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function notes(User $user)
    {
        $notes = $user->notes()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $notes->url(route('users.notes', $user->id));

        return view('users.notes', compact('user', 'notes'));
    }


    /**
     * 用户关注列表页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function followers(User $user)
    {
        $this->authorize('update', $user);

        $followers = Auth::user()->followers()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $followers->url(route('users.followers', Auth::user()->id));

        return view('users.followers', compact('followers', 'user'));
    }


    /**
     * 用户消息列表页面
     *
     * @param User $user
     * @param string $nav_type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function messages(User $user, $nav_type = 'new')
    {
        $this->authorize('update', $user);

        $messages = $user->messages();

        if ($nav_type != 'all' && $nav_type != 'new')
            $messages = $messages->where('type', $nav_type);
        elseif ($nav_type == 'new')
            $messages = $messages->where('read', false);

        $messages = $messages->paginate(5);
        $messages->url(route('users.messages', [$user->id, $nav_type]));

        return view('users.messages', compact('user', 'messages', 'nav_type'));
    }


    /**
     * 关注/取消关注该用户
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function attachOrDetach(User $user)
    {
        if (!Auth::check())
            return view('login');

        if ($user->isAttached()) {
            Auth::user()->followers()->detach([$user->id]);
        } else {
            Auth::user()->followers()->sync([$user->id], false);
        }

        return redirect()->back();
    }
}
