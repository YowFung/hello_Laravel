<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    /**
     * 用户授权策略
     *
     * @param User $currentUser
     * @param User $user
     * @return bool
     */
    public function user(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
}
