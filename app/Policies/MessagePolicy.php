<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Message;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class MessagePolicy
{
    use HandlesAuthorization;


    /**
     * 消息的查看/更新/删除权限
     *
     * @param User $currentUser
     * @param Message $message
     * @return bool
     */
    public function operation(User $currentUser, Message $message)
    {
        return $currentUser->id === $message->user_id;
    }


    /**
     * 消息列表显示权限
     *
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function index(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
