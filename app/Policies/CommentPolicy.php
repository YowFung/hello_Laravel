<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;


    /**
     * 评论授权策略
     *
     * @param User $user
     * @param Comment $comment
     * @return bool
     */
    public function comment(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
    }
}
