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
     * 消息授权策略
     *
     * @param User $user
     * @param Message $message
     * @return bool
     */
    public function message(User $user, Message $message)
    {
        return $user->id === $message->user_id;
    }
}
