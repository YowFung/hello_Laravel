<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    protected $fillable = [
        'note_id', 'from_id', 'content', 'created_at',
    ];


    /**
     * 评论-发布者用户关联模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'from_id');
    }


    /**
     * 该评论是否有操作权限
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
