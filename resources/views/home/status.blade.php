@extends('layouts._home')

@section('col-left')

    @if ($data['notes']->currentPage() <= 0 || $data['notes']->currentPage() > $data['notes']->lastPage())
        <script>
            window.location.href = '{{ $data['notes']->url(1) }}';
        </script>
    @endif

    {{--动态导航栏--}}
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">动态列表</span>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li @if ($data['category'] == 'recommend') class="active" @endif>
                        <a href="{{ route('home', 'recommend') }}">推荐 <span class="sr-only">(current)</span></a>
                    </li>
                    <li @if ($data['category'] == 'concerned') class="active" @endif>
                        <a href="{{ route('home', 'concerned') }}">关注</a>
                    </li>
                    <li @if ($data['category'] == 'newest') class="active" @endif>
                        <a href="{{ route('home', 'newest') }}">最新</a>
                    </li>
                </ul>
                <form class="navbar-form navbar-right" @if (Auth::check()) action="{{ route('users.notes', Auth::user()->id) }}" method="GET" @endif style="margin-right: -24px">
                    <button @if (Auth::check()) type="submit" @else type="button" data-toggle="popover" data-content="登录后才可以发微博，快去登录吧！" data-placement="left" data-container="body" @endif class="btn btn-primary">
                        <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;&nbsp;发微博
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- 动态列表 -->
    <div class="panel panel-default">
        <div class="panel-body">

            @foreach( $data['notes'] as $note)
                <div class="media" id="note{{ $note->id }}">
                    {{--用户头像--}}
                    <div class="media-left">
                        <a href="{{ route('users.show', $note->user->id) }}">
                            <img class="media-object" src="{{ $note->user->gravatar(48) }}" alt="{{ $note->user->name }}"/>
                        </a>
                    </div>
                    <div class="media-body">
                        {{--用户名--}}
                        <strong>
                            <a href="{{ route('users.show', $note->user->id) }}">{{ $note->user->name }}</a>
                        </strong>
                        {{--发布时间、查看、评论--}}
                        <span class="note-info">
                                    <span class="note-info-datetime" title="{{ $note->created_at }}">{{ $note->created_at->diffForHumans() }}</span>
                                    <a title="查看" href="{{ route('notes.show', $note->id) }}">
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </a>
                                    &nbsp;
                                    <a title="评论" href="javascript:" role="button" data-toggle="collapse" aria-expanded="false" aria-controls="collapse{{ $note->id }}" data-target="#collapse{{ $note->id }}">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>
                                </span>
                        <br>
                        {{--动态内容--}}
                        <p class="note-content">
                            <a class="home-note-link" href="{{ route('notes.show', $note->id) . '?category=' . $data['category'] }}">
                                {{ $note->content }}
                            </a>
                        </p>

                        {{--评论框--}}
                        <div class="collapse comment-div" id="collapse{{ $note->id }}">
                            <hr>

                            <form action="{{ route('comments.store') }}" method="POST">
                                {{ csrf_field() }}

                                <input type="hidden" name="note" value="{{ $note->id }}">
                                <div class="input-group">
                                    <textarea name="passage" class="form-control" placeholder="你有什么看法吗？"></textarea>
                                    <span class="input-group-btn">
                                                <button type="submit" class="btn btn-default">发表评论</button>
                                            </span>
                                </div>
                            </form>
                        </div>

                        @can('destroy', $note)
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display: inline-block">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="button" class="btn btn-xs btn-danger status-delete-btn" data-toggle="modal" data-target="#myModal">删除</button>

                                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">确定要删除该条动态吗？</h4>
                                            </div>
                                            <div class="modal-body">
                                                {{ $note->content }}
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">确认</button>
                                                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        @endcan
                    </div>
                </div>
                <hr>
            @endforeach

            {{--分页栏--}}
            <nav aria-label="..." class="page-split">
                {{ $data['notes']->render() }}
            </nav>

        </div>
    </div>
@stop