@extends('layouts._user')

@section('panel_title', '消息中心')

@section('active_messages', 'active')

@section('panel_content')
    <ul class="nav nav-tabs" role="tablist" id="lists">
        <li role="presentation" @if ($nav_type == 'new') class="active" @endif>
            <a href="{{ route('messages.index', [Auth::user()->id, 'new']) }}">新消息</a>
        </li>
        <li role="presentation" @if ($nav_type == 'all') class="active" @endif>
            <a href="{{ route('messages.index', [Auth::user()->id, 'all']) }}">全部</a>
        </li>
        <li role="presentation" @if ($nav_type == 'system') class="active" @endif>
            <a href="{{ route('messages.index', [Auth::user()->id, 'system']) }}">系统消息</a>
        </li>
        <li role="presentation" @if ($nav_type == 'interaction') class="active" @endif>
            <a href="{{ route('messages.index', [Auth::user()->id, 'interaction']) }}">互动消息</a>
        </li>
    </ul>

    <br><br>

    @include('shared._msgs', ['show_all' => false, 'title' => '提示', 'msg_type' => 'success'])

    @if ($messages->total())
        @foreach ($messages as $message)
            <div class="message-item">

                @if (!$message->read)
                    <span class="label label-danger" style="font-weight: normal">new</span>
                @endif

                <b>{{ $message->title() }}</b>
                <span class="label label-default label-note-show">{{ $message->created_at->diffForHumans() }}</span>
                <a href="{{ route('messages.show', $message->id) }}" class="btn btn-xs btn-primary">查看</a>

                @if (!$message->read)
                    <form action="{{ route('messages.update', $message->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <button type="submit" class="btn btn-xs btn-info">标为已读</button>
                    </form>
                @endif

                <form action="{{ route('messages.destroy', $message->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-xs btn-warning">删除记录</button>
                </form>

                <p class="message-passage">
                    {!! $message->content() !!}
                </p>

                <hr>
            </div>

        @endforeach
    @else
        <p class="tips">
            @switch ($nav_type)
                @case ('new')
                    暂无未读的新消息~
                @break;
                @case ('all')
                    你还未收到过任何消息~
                @break
                @case ('system')
                    无系统消息记录~
                @break;
                @case ('interaction')
                    暂无互动消息~
                @break
            @endswitch
        </p>
    @endif

    <br><br>
    <nav aria-label="..." class="page-split">
        {{ $messages->fragment('lists')->render() }}
    </nav>
@stop