<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Attention;
use App\Models\Message;

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
     * 获取当前用户的粉丝总数
     *
     * @return int
     */
    public function getFansCount()
    {
        return count(Attention::all()->where('to_id', $this->attributes['id']));
    }

    /**
     * 获取当前用户的关注总数
     *
     * @return int
     */
    public function getAttentionsCount()
    {
        return count(Attention::all()->where('from_id', $this->attributes['id']));
    }

    /**
     * 获取当前用户的新消息总数
     *
     * @return int
     */
    public function getNewMessagesCount()
    {
        return count(Attention::all()->where('to_id', $this->attributes['id'])->where('read', 'False'));
    }

    /**
     * 获取当前用户的Gravatar头像
     *
     * @param string $size
     * @return string
     */
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
