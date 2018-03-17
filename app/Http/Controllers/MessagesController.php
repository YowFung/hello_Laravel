<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['']
        ]);
    }


    /**
     * 用户消息列表页面
     *
     * @param User $user
     * @param string $nav_type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(User $user, $nav_type = 'new')
    {
        $this->authorize('index', $user);

        $messages = $user->messages();

        if ($nav_type == 'new')
            $messages = $messages->where('read', false);
        elseif ($nav_type == 'system')
            $messages = $messages->where('type', 'system');
        else
            $messages = $messages->where('type','!=', 'system');

        $messages = $messages->paginate(5);
        $messages->url(route('messages.index', [$user->id, $nav_type]));

        return view('users.messages', compact('user', 'messages', 'nav_type'));
    }


    /**
     * 消息详细内容页面
     *
     * @param Message $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Message $message)
    {
        $this->authorize('operation', $message);

        $read = $message->read;
        $message->update(['read' => true]);
        $user = Auth::user();
        $message->read = $read;

        return view('messages.show', compact( 'user', 'message'));
    }


    /**
     * 将消息标记为已读
     *
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Message $message)
    {
        $this->authorize('operation', $message);

        $message->update(['read' => true]);
        return redirect()->back();
    }


    /**
     * 删除消息记录
     *
     * @param Message $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Message $message)
    {
        $this->authorize('operation', $message);
        $message->delete();

        session()->flash('success', '已成功删除该条消息！');

        return redirect()->back();
    }


    /**
     * 创建新消息
     *
     * @param int $to
     * @param string $content
     * @param string $type
     * @param array $parameters
     * @return bool
     */
    public static function create($to, $content, $type = 'system', $parameters = [])
    {
        $sign_begin_count = substr_count($content, config('app.sign_begin'));
        $sign_end_count = substr_count($content, config('app.sign_end'));

        if (count($parameters) != $sign_begin_count || count($parameters) != $sign_end_count)
            return false;

        if (!in_array($type, ['system', 'letter', 'letter_replay', 'attach', 'comment', 'comment_replay']))
            return false;

        $parameters = implode(config('app.sign_separate'), $parameters);

        return Message::create([
            'user_id' => $to,
            'type' => $type,
            'parameters' => $parameters,
            'content' => $content
        ]);
    }
}
