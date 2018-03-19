@extends('layouts._home')

@section('col-left')

    {{--导航栏--}}
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">
                    <a href="{{ route('home') }}" class="btn btn-default" style="margin-top: -8px">返回</a>
                    &nbsp;
                    动态详情
                </span>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <form class="navbar-form navbar-right" @if (Auth::check()) action="{{ route('users.notes', Auth::user()->id) }}" method="GET" @endif style="margin-right: -32px">
                    <button @if (Auth::check()) type="submit" @else type="button" data-toggle="popover" data-content="登录后才可以发微博，快去登录吧！" data-placement="left" data-container="body" @endif class="btn btn-primary">
                        <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;&nbsp;发微博
                    </button>
                    &nbsp;
                </form>
            </div>
        </div>
    </nav>

    {{--动态详情--}}
    <div class="panel panel-default">
        <div class="panel-body note-comment-panel">
            <div class="row">
                <div class="col-md-2">
                    <section class="photo-img">
                        @include('shared._user_photo', ['user' => $data['user'], 'size' => 144])
                    </section>
                </div>
                <div class="col-md-10">
                    <h4>
                        <a href="{{ route('users.show', $data['user']->id) }}">{{ $data['user']->name }}</a>
                    </h4>
                    <p class="tips" style="text-align: left">
                        发表于：
                        {{ $data['note']->created_at }}
                    </p>

                    <hr>

                    <h3>
                        {{ $data['note']->content }}
                    </h3>

                    <br><hr>

                    <h4>评论({{ $data['note']->commentsCount() }})：</h4>
                    <br>


                    <div class="row">

                        <form action="{{ route('comments.store') }}" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" name="note_id" value="{{ $data['note']->id }}">
                            <input type="hidden" name="user_id" value="{{ $data['note']->user_id }}">
                            <textarea name="content" cols="30" class="form-control" rows="3" placeholder="你有什么别的看法吗？" style="resize: none;">{{ old('content') }}</textarea>
                            <button class="btn btn-primary" type="submit" style="float: right;">发表评论</button>
                            <br><br><br><br>
                        </form>

                        <div class="note-comments">
                            @if (!$data['note']->commentsCount() )
                                <p class="tips">暂时还没有人评论这条动态，你可以抢沙发了~</p>
                            @else
                                @foreach( $data['note']->comments as $comment)
                                        <div class="col-sm-1 fans-list" title="{{ $comment->user->name }}">
                                            <a href="{{ route('users.show', $comment->user->id) }}" class="thumbnail">
                                                <img alt="{{ $comment->user->name }}" src="{{ $comment->user->gravatar('64') }}">
                                            </a>

                                        </div>
                                        <div class="col-sm-11">
                                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                            <strong><a href="{{ route('users.show', $comment->user->id) }}">{{ $comment->user->name }}</a> :</strong>
                                            <p>
                                                {{ $comment->content }}
                                            </p>
                                            <hr>

                                        </div>
                                @endforeach
                            @endif
                        </div>

                        
                        <br><br>
                    </div>

                </div>
            </div>

        </div>
    </div>

@stop