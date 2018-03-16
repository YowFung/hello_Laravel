<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'from_id', 'to_id', 'type', 'read', 'passage'
    ];


    /**
     * 建立消息接受者-用户关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_id');
    }


    /**
     * 建立消息发送者-用户关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_id');
    }


    /**
     * 获取消息接受者用户对象
     *
     * @return array
     */
    public function toUserInfo()
    {
        if ($this->attributes['to_id'] == 0)
            $user = [];
        else
            $user = User::findOrFail($this->attributes['to_id']);

        return $user;
    }


    /**
     * 获取消息发送者用户对象
     *
     * @return array
     */
    public function fromUserInfo()
    {
        if ($this->attributes['from_id'] == 0)
            $user = [];
        else
            $user = User::findOrFail($this->attributes['from_id']);

        return $user;
    }


    /**
     * 设置为已读
     *
     * @return bool
     */
    public function setRead()
    {
        $this->attributes['read'] = true;
        return $this->save();
    }
}
