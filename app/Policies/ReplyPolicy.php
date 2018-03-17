<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;


    /**
     * 留言回复删除权限
     *
     * @param User $currentUser
     * @param Reply $reply
     * @return bool
     */
    public function destroy(User $currentUser, Reply $reply)
    {
        return $currentUser->id === $reply->from_id;
    }
}
