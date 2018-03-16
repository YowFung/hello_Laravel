@extends('layouts._user')

@section('panel_title', '消息中心')

@section('active_messages', 'active')

@section('panel_content')
    <ul class="nav nav-tabs" role="tablist" id="lists">
        <li role="presentation" @if ($nav_type == 'new') class="active" @endif><a href="{{ route('users.messages', [Auth::user()->id, 'new']) }}">新消息</a></li>
        <li role="presentation" @if ($nav_type == 'all') class="active" @endif><a href="{{ route('users.messages', [Auth::user()->id, 'all']) }}">全部消息</a></li>
        <li role="presentation" @if ($nav_type == 'system') class="active" @endif><a href="{{ route('users.messages', [Auth::user()->id, 'system']) }}">系统消息</a></li>
        <li role="presentation" @if ($nav_type == 'letter') class="active" @endif><a href="{{ route('users.messages', [Auth::user()->id, 'letter']) }}">留言</a></li>
        <li role="presentation" @if ($nav_type == 'replay') class="active" @endif><a href="{{ route('users.messages', [Auth::user()->id, 'replay']) }}">回复</a></li>
    </ul>

    <br><br>

    @if ($messages->total())
        @foreach ($messages as $message)
            @if (!$message->read)
                <span class="label label-danger" style="font-weight: normal">new</span>
            @endif

            @switch ($message->type)
                @case('system')
                    <b>来自系统的消息：</b>
                @break
                @case('letter')
                    <b>
                        <a href="{{ route('users.show', $message->fromUserInfo()->id) }}">{{ $message->fromUserInfo()->name }}</a>
                        给你留言了：
                    </b>
                @break
                @case('replay')
                    <b>
                        <a href="{{ route('users.show', $message->fromUserInfo()->id) }}">{{ $message->fromUserInfo()->name }}</a>
                        回复了你的留言：
                    </b>
                @break
            @endswitch

            <span class="label label-default label-note-show">{{ $message->created_at->diffForHumans() }}</span>

            <p class="message-passage">{{ $message->passage }}</p>
            <br><br>

        @endforeach
    @else
        <p class="tips">暂无任何消息~</p>
    @endif

    <br><br>
    <nav aria-label="..." class="page-split">
        {{ $messages->fragment('lists')->render() }}
    </nav>
@stop