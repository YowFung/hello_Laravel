<?php

namespace App\Http\Controllers;

use App\Models\Note;
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
     * 创建系统通知消息
     *
     * @param $user_id
     * @param $type
     * @return bool
     */
    public static function createNoticeMessage($user_id, $type)
    {
        if (!in_array($type, ['sign_up', 'change_pwd']))
            return false;

        if (!User::find($user_id))
            return false;
        else
            $name = User::find($user_id)->name;

        switch ($type) {
            case 'sign_up' : $content = '亲爱的「' . $name . '」，恭喜您成功注册微博账号，现在请开始您的微博人生吧！'; break;
            case 'change_pwd' : $content = '亲爱的「' . $name . '」，您的密码已成功修改，请牢记您的新密码，打死都不要告诉别人您的密码哦！'; break;
            default : return false;
        }

        return Message::create([
            'user_id' => $user_id,
            'type' => 'notice',
            'content' => $content,
        ]);
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
        if (!User::find($user_id) || !User::find($from_id))
            return false;

        $name = User::find($from_id)->name;
        $path = parse_url(route('users.show', $from_id))['path'];
        $content = htmlspecialchars($content);
        $content = '<p>用户「<a target="_blank" href="' . $path . '">' . $name . '</a>」查看您的微博主页，并给您留下了一段话：</p><p>' . $content . '</p>';

        return Message::create([
            'user_id' => $user_id,
            'type' => 'letter',
            'content' => $content,
        ]);
    }


    /**
     * 创建关注消息
     *
     * @param $user_id
     * @param $from_id
     * @return bool
     */
    public static function createFollowMessage($user_id, $from_id)
    {
        if (!User::find($user_id) || !User::find($from_id))
            return false;

        $name = User::find($from_id)->name;
        $path = parse_url(route('users.show', $from_id))['path'];
        $content = '用户「<a target="_blank" href="' . $path . '">' . $name . '</a>」关注了您，现在您又多了一个粉丝啦，赶紧去了解一下TA吧！';

        return Message::create([
            'user_id' => $user_id,
            'type' => 'follow',
            'content' => $content,
        ]);
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
        if (!User::find($user_id) || !User::find($from_id) || !Note::find($note_id))
            return false;

        $name = User::find($from_id)->name;
        $note_content = htmlspecialchars(Note::find($note_id)->content);
        $user_path = parse_url(route('users.show', $from_id))['path'];
        $note_path = parse_url(route('notes.show', $note_id))['path'];
        $content = '用户「<a target="_blank" href="' . $user_path . '">' . $name . '</a>」评论了您的动态[<a target="_blank" href="' . $note_path . '">' . $note_content . '</a>]，赶紧去看看吧！';

        return Message::create([
            'user_id' => $user_id,
            'type' => 'comment',
            'content' => $content,
        ]);
    }
}
