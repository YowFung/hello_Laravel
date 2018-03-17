<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Letter;
use Illuminate\Auth\Access\HandlesAuthorization;

class LetterPolicy
{
    use HandlesAuthorization;


    /**
     * 留言删除权限
     *
     * @param User $currentUser
     * @param Letter $letter
     * @return bool
     */
    public function destroy(User $currentUser, Letter $letter)
    {
        return $currentUser->id === $letter->user_id || $currentUser->id === $letter->from_id;
    }
}
