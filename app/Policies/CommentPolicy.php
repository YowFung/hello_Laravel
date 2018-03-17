<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;


    /**
     * 评论删除权限
     *
     * @param User $currentUser
     * @param Comment $comment
     * @return bool
     */
    public function destroy(User $currentUser, Comment $comment)
    {
        return $currentUser->id === $comment->user_id;
    }
}
