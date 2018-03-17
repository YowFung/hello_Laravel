<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Letter extends Model
{
    protected $fillable = [
        'from_id', 'user_id', 'involved_id', 'content', 'created_at'
    ];


    /**
     * 该留言是否有操作权限
     *
     * @return bool
     */
    public function hasAccess()
    {
        if (!Auth::check())
            return false;

        $currentUser = Auth::user()->id;
        $targetUser = $this->attributes['user_id'];
        $sourceUser = $this->attributes['from_id'];

        return $currentUser === $targetUser || $currentUser === $sourceUser;
    }
}
