<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;


    /**
     * 留言回复授权策略
     *
     * @param User $user
     * @param Reply $reply
     * @return bool
     */
    public function reply(User $user, Reply $reply)
    {
        return $user->id === $reply->from_id;
    }
}
