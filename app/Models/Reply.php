<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Reply extends Model
{
    protected $fillable = [
        'from_id', 'letter_id', 'involved_id', 'content'
    ];


    /**
     * 建立留言回复者用户-留言回复关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class, 'from_id');
    }


    /**
     * 该留言回复是否有操作权限
     *
     * @return bool
     */
    public function hasAccess()
    {
        if (!Auth::check())
            return false;

        $currentUser = Auth::user()->id;
        $sourceUser = $this->attributes['from_id'];

        return $currentUser === $sourceUser;
    }
}
