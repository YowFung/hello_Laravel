<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
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

        $msg_content = '亲爱的「' . $user->name . '」您好！恭喜你成功注册微博账号，您可以通过发表微博动态来分享您的想法，也可以关注其他用户、查看其他人的动态、与其他人互动等。祝您微博生活愉快！';
        MessagesController::create($user->id, $msg_content);

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
        $this->authorize('user', $user);

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
        $this->authorize('user', $user);

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

            $msg_content = '亲爱的「' . $user->name . '」！您已成功修改了密码，请牢记您的新密码！';
            MessagesController::create($user->id, $msg_content);
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
        $this->authorize('user', $user);

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
        $this->authorize('user', $user);

        $followers = Auth::user()->followers()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $followers->url(route('users.followers', Auth::user()->id));

        return view('users.followers', compact('followers', 'user'));
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

            $msg_content = '用户「' . config('app.sign_begin') . Auth::user()->name . config('app.sign_end') . '」关注了您！你可以在「我的粉丝」列表中查看TA的信息。';
            $msg_parameters = [route('users.show', Auth::user()->id)];
            MessagesController::create($user->id, $msg_content, 'attach', $msg_parameters);
        }

        $backUrl = redirect()->back()->getTargetUrl();
        if ($backUrl != route('users.show', $user->id) && $backUrl != route('users.notes', $user->id))
            session()->flash('success', '已成功取消关注「' . $user->name . '」');

        return redirect()->back();
    }
}
