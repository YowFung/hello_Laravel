<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        return view('users.notes', compact('user', 'notes'));
    }


    /**
     * 用户关注列表页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function attentions(User $user)
    {
        $this->authorize('update', $user);

        return view('users.attentions', compact('user'));
    }


    /**
     * 用户消息列表页面
     *
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function messages(User $user)
    {
        $this->authorize('update', $user);

        $messages = $user->messages()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('users.messages', compact('user', 'messages'));
    }
}
