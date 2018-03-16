@extends('layouts._user')

@section('panel_title', '消息中心')

@section('active_messages', 'active')

@section('panel_content')
    <h5 class="message-item-key">
        <span class="label label-default label-note-show">消息类型：</span>&nbsp;
        @switch ($message->type)
            @case ('system')
                系统通知
            @break
            @case ('letter')
                留言
            @break
            @case ('replay_letter')
                留言回复
            @break
            @case ('comment')
                评论
            @break
            @case ('replay_comment')
                评论回复
        @endswitch
    </h5>

    <h5 class="message-item-key">
        <span class="label label-default label-note-show">消息状态：</span>&nbsp;
        @if ($message->read)
            已读
        @else
            未读
        @endif
    </h5>

    <h5 class="message-item-key">
        <span class="label label-default label-note-show">创建时间：</span>&nbsp;
        {{ $message->created_at }}
    </h5>
    <br>

    <div class="panel panel-default message-passage-panel">
        <div class="panel-body">
            <p class="message-passage">
                {{ $message->passage }}
            </p>
        </div>
    </div>


    <hr>
    <a  href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-md btn-default">返回</a>&nbsp;
    <form action="{{ route('messages.destroy', $message->id) }}" method="POST" style="display: inline-block">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <button class="btn btn-md btn-danger" type="submit">删除消息</button>
    </form>

    <nav aria-label="..." class="message-nav">
        <ul class="pager">
            <li><a href="#">上一条</a></li>
            <li><a href="#">下一条</a></li>
        </ul>
    </nav>

@stop