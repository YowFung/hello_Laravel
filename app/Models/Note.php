<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $fillable = [
        'content', 'user_id', 'created_at'
    ];

    /**
     * 建立微博动态-所属用户关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * 建立微博动态-评论关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->orderByDesc('created_at');
    }


    /**
     * 获取该动态的评论条数
     *
     * @return int
     */
    public function commentsCount()
    {
        return count($this->comments);
    }
}
