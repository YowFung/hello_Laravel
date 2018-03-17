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
     * 建立用户-粉丝关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fans()
    {
        return $this->belongsToMany(User::class, 'fans', 'master_id', 'follow_id');
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
     * 建立用户-微博动态关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class)->orderByDesc('created_at');
    }


    /**
     * 建立用户-消息关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderByDesc('created_at');
    }


    /**
     * 建立留言接受者用户-留言关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function letters()
    {
        return $this->hasMany(Letter::class)->orderByDesc('created_at');
    }


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
     * 获取该用户的新消息数量
     *
     * @return int
     */
    public function newMessagesCount()
    {
        return count($this->messages->where('read',false));
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
