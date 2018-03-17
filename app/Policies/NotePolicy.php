<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Note;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * 微博动态删除权限
     *
     * @param User $user
     * @param Note $note
     * @return bool
     */
    public function destroy(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }
}
