<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Note;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotePolicy
{
    use HandlesAuthorization;

    /**
     * 微博动态授权策略
     *
     * @param User $user
     * @param Note $note
     * @return bool
     */
    public function note(User $user, Note $note)
    {
        return $user->id === $note->user_id;
    }
}
