@extends('layouts._user')

@section('panel_title', '瓜瓜信箱')

@section('active_messages', 'active')

@section('panel_content')
    @if ($messages->currentPage() <= 0 || $messages->currentPage() > $messages->lastPage())
        <script>
            window.location.href = '{{ $messages->url(1) }}';
        </script>
    @endif

    <ul class="nav nav-tabs" role="tablist" id="lists">
        <li role="presentation" @if ($category == 'new') class="active" @endif>
            <a href="{{ route('messages.index') . '?category=new' }}">新消息</a>
        </li>
        <li role="presentation" @if ($category == 'all') class="active" @endif>
            <a href="{{ route('messages.index') . '?category=all' }}">全部</a>
        </li>
        <li role="presentation" @if ($category == 'notice') class="active" @endif>
            <a href="{{ route('messages.index') . '?category=notice' }}">通知</a>
        </li>
        <li role="presentation" @if ($category == 'follow') class="active" @endif>
            <a href="{{ route('messages.index') . '?category=follow' }}">关注</a>
        </li>
        <li role="presentation" @if ($category == 'comment') class="active" @endif>
            <a href="{{ route('messages.index') . '?category=comment' }}">评论</a>
        </li>
        <li role="presentation" @if ($category == 'letter') class="active" @endif>
            <a href="{{ route('messages.index') . '?category=letter' }}">私信</a>
        </li>
    </ul>

    <br><br>

    @include('shared._msgs', ['show_all' => false, 'title' => '提示', 'msg_type' => 'success'])

    @if ($messages->total())
        @foreach ($messages as $message)
            <div class="message-item">

                <span class="label label-default label-note-show">{{ $message->created_at->diffForHumans() }}</span>
                <b>{{ $message->title() }}</b>

                <p class="message-passage">
                    {!! $message->content !!}
                </p>

                <a href="{{ route('messages.show', $message->id) }}" class="btn btn-xs btn-info">查看</a>

                <form action="{{ route('messages.destroy', $message->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button type="button" class="btn btn-xs btn-danger status-delete-btn" data-toggle="modal" data-target="#myModal{{ $message->id }}">删除</button>

                    <div class="modal fade" id="myModal{{ $message->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $message->id }}">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel{{ $message->id }}">确定要删除这条消息吗？</h4>
                                </div>
                                <div class="modal-body">
                                    {!! $message->content !!}
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-lg btn-danger">确认</button>
                                    <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">取消</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                @if (!$message->read)
                    <form action="{{ route('messages.update', $message->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('PATCH') }}

                        <button type="submit" class="btn btn-xs btn-info">标为已读</button>
                    </form>
                @endif


                <hr>
            </div>

        @endforeach
    @else
        <p class="tips">
            {{ $empty_tips[$category] }}
        </p>
    @endif

    <br><br>
    <nav aria-label="..." class="page-split">
        {{ $messages->appends(['category' => $category])->fragment('lists')->render() }}
    </nav>
@stop