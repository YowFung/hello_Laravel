<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'user_id', 'type', 'content', 'parameters', 'read'
    ];

    protected $hidden = [
        'content', 'parameters'
    ];


    /**
     * 获取当前消息的标题
     *
     * @return string
     */
    public function title()
    {
        switch ($this->attributes['type']) {
            case 'system' : return '您收到一条系统通知';
            case 'letter' : return '您收到一条留言';
            case 'letter_replay' : return '您收到一条留言回复';
            case 'attach' : return '您多了一个粉丝';
            case 'comment' : return '您收到一条评论';
            case 'comment_replay' : return '您收到一条评论回复';
        }
    }


    /**
     * 获取当前消息的类别
     *
     * @return string
     */
    public function category()
    {
        switch ($this->attributes['type']) {
            case 'system' : return '系统通知';
            case 'letter' : return '留言通知';
            case 'letter_replay' : return '留言回复通知';
            case 'attach' : return '关注通知';
            case 'comment' : return '评论通知';
            case 'comment_replay' : return '评论回复通知';
        }
    }


    /**
     * 获取经过格式处理后的消息内容
     *
     * @return mixed
     */
    public function content()
    {
        $text = $this->attributes['content'];
        $content = "";
        $parameters = explode(config('app.sign_separate'), $this->attributes['parameters']);                                         //参数链接
        $times = substr_count($content, '|+)p--b(+|');

        for ($i = 0; $i < $times; $i++) {
            $position_begin = strpos($text, config('app.sign_begin'));                                                 //参数开始位置
            $position_end = strpos($text, config('app.sign_end'));                                                     //参数结束位置

            $value = substr($text, $position_begin+10, $position_end - $position_begin - 10);              //参数内容
            $str_replace = '<a href="' . $parameters[$i] . '">' . $value . '</a>';                                      //替换后的参数内容

            $content .= substr($text, 0, $position_begin) . $str_replace;

            $text = substr($text, $position_end+10);
        }

        return $content;
    }


    /**
     * 建立消息-接收用户关系
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
