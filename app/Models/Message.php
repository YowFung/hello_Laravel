<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'type', 'content', 'read'
    ];


    /**
     * 当前消息的标题
     *
     * @return string
     */
    public function title()
    {
        switch ($this->attributes['type']) {
            case 'notice' : return '您收到一条系统通知';
            case 'letter' : return '您收到一封私信';
            case 'follow' : return '有人关注了您';
            case 'comment' : return '您收到一条评论';
        }
    }


    /**
     * 当前消息的类别
     *
     * @return string
     */
    public function category()
    {
        switch ($this->attributes['type']) {
            case 'notice' : return '通知';
            case 'letter' : return '私信';
            case 'follow' : return '关注';
            case 'comment' : return '评论';
        }
    }


    /**
     * 消息-接收用户关联模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
