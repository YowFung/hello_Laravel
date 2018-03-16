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
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * 消息查看权限
     *
     * @param User $currentUser
     * @param Message $message
     * @return bool
     */
    public function show(User $currentUser, Message $message)
    {
        return $currentUser->id === $message->to_id;
    }
}
