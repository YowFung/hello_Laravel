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
        'name', 'email', 'password', 'gender', 'associations', 'college', 'address', 'avatar',
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
     * 用户-粉丝关联模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function fans()
    {
        return $this->belongsToMany(User::class, 'fans', 'master_id', 'follow_id');
    }


    /**
     * 用户-关注人关联模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::Class, 'fans', 'follow_id', 'master_id');
    }


    /**
     * 用户-微博动态关联模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(Note::class)->orderByDesc('created_at');
    }


    /**
     * 用户-消息关联模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class)->orderByDesc('created_at');
    }


    /**
     * 用户-关注人的微博动态关联模型
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function followersNotes()
    {
        return $this->hasManyThrough('App\Models\Note', 'App\Models\Fan', 'follow_id', 'user_id', 'id', 'master_id');
    }


    /**
     * 用户头像
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    public function avatar()
    {
        if (empty($this->attributes['avatar']))
            return config('app.default_avatar', '/img/photos/default.jpg');

        return $this->attributes['avatar'];
    }


    /**
     * 该用户最新发布的微博动态
     *
     * @return mixed
     */
    public function newNote()
    {
        $note = $this->notes()->orderByDesc('created_at')->first()['content'];
        return $note;
    }


    /**
     * 该用户的新消息数量
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
