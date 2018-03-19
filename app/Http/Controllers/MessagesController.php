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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $category = $request->get('category') ?: 'new';
        if (!in_array($category, ['new', 'all', 'notice', 'letter', 'follow', 'comment']))
            return redirect(route('messages.index'));

        $user = Auth::user();
        $messages = $user->messages();

        if ($category == 'new')
            $messages = $messages->where('read', false);
        elseif ($category != 'all')
            $messages = $messages->where('type', $category);

        $messages = $messages->paginate(5);
        $messages->url(route('messages.index'));

        $empty_tips = [
            'new' => '暂无未读的新消息~',
            'all' => '暂时还未收到过任何消息~',
            'notice' => '暂无系统通知~',
            'letter' => '暂无私信消息~',
            'follow' => '暂无关注消息~',
            'comment' => '暂无评论消息~',
        ];

        return view('users.messages', compact('user', 'messages', 'category', 'empty_tips'));
    }


    /**
     * 消息详细内容页面
     *
     * @param Message $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Message $message)
    {
        $this->authorize('message', $message);

        $read = $message->read;
        $message->update(['read' => true]);
        $user = Auth::user();
        $message->read = $read ? '已读' : '未读';

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
        $this->authorize('message', $message);

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
        $this->authorize('message', $message);
        $message->delete();

        session()->flash('success', '已成功删除该条消息！');

        return redirect()->back();
    }


    /**
     * 创建新消息
     *
     * @param $user_id
     * @param $content
     * @param string $type
     * @return bool
     */
    public static function create($user_id, $content, $type)
    {
        if (!in_array($type, ['notice', 'letter', 'follow', 'comment']))
            return false;

        $content = htmlspecialchars($content);

        return Message::create([
            'user_id' => $user_id,
            'type' => $type,
            'content' => $content
        ]);
    }


    /**
     * 创建系统通知消息
     *
     * @param $user_id
     * @param $content
     * @return bool
     */
    public static function createNoticeMessage($user_id, $content)
    {
        return true;
    }


    /**
     * 创建私信消息
     *
     * @param $user_id
     * @param $from_id
     * @param $content
     * @return bool
     */
    public static function createLetterMessage($user_id, $from_id, $content)
    {
        return true;
    }


    /**
     * 创建关注消息
     *
     * @param $user_id
     * @param $from_id
     * @param $content
     * @return bool
     */
    public static function createFollowMessage($user_id, $from_id, $content)
    {
        return true;
    }


    /**
     * 创建评论消息
     *
     * @param $user_id
     * @param $from_id
     * @param $note_id
     * @param $content
     * @return bool
     */
    public static function createCommentMessage($user_id, $from_id, $note_id, $content )
    {
        return true;
    }


}
