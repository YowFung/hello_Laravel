<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'associations', 'college', 'address'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * 获取用户的Gravatar头像
     *
     * @param string $size
     * @return string
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }


    /**
     * 获取该用户最新发布的微博动态
     *
     * @return mixed
     */
    public function newNote()
    {
        $note = $this->notes()->orderByDesc('created_at')->first()['content'];
        return $note;
    }


    /**
     * 微博动态列表
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class);
    }


    /**
     * 消息列表
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages($filtrate  = 'all')
    {
        switch ($filtrate) {
            case 'all'    : return $this->hasMany(Message::class)->orderByDesc('updated_at');
            case 'read'   : return $this->hasMany(Message::class)->where('read', true);
            case 'unread' : return $this->hasMany(Message::class)->where('read', false);
        }

    }


    /**
     * 建立用户-粉丝关系
     *
//     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fans()
    {
        return  $this->belongsToMany(User::class, 'fans', 'master_id', 'follow_id');
    }


    /**
     * 建立用户-关注人关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'fans', 'follow_id', 'master_id');
    }


    /**
     * 是否已关注该用户
     *
     * @return bool
     */
    public function isAttached()
    {
        return (Auth::check() && Auth::user()->followers->contains($this->attributes['id']));
    }
}
