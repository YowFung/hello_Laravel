<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Letter;
use Illuminate\Auth\Access\HandlesAuthorization;

class LetterPolicy
{
    use HandlesAuthorization;


    /**
     * 留言授权策略
     *
     * @param User $user
     * @param Letter $letter
     * @return bool
     */
    public function letter(User $user, Letter $letter)
    {
        return $user->id === $letter->user_id || $user->id === $letter->from_id;
    }
}
