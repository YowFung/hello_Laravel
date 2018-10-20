@extends('layouts._home')

@section('col-left')
    {{--动态详情--}}
    <div class="panel panel-default">
        <div class="panel-body note-comment-panel">
            <div class="row">
                <div class="col-md-2">
                    <section class="photo-img thumbnail">
                        @include('shared._user_photo', ['user' => $data['user']])
                    </section>

                    <form method="POST" action="{{ route('users.attach', $data['note']->user->id) }}" style="margin-top: -8px">
                        {{ csrf_field() }}

                        @if (Auth::check() && Auth::user()->id == $data['note']->user_id)
                            {{--<h4>--}}
                                <span class="label-default form-control" style="background-color: #e8e8e8; text-align: center">我自己</span>
                            {{--</h4>--}}
                        @elseif ($data['note']->user->isAttached())
                            <button class="btn btn-danger form-control" type="submit">已关注</button>
                        @else
                            <button class="btn btn-info form-control" @if (Auth::check()) type="submit" @else
                                type="button" data-trigger="focus" data-placement="bottom" data-toggle="popover" data-content="登录后才可以关注这位瓜友哦，快去登录吧！" title="您还没有登录" @endif>
                                关注该瓜友
                            </button>
                        @endif
                    </form>

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

                    <div class="row">
                        <br><hr>
                        <h4 id="comment">评论({{ $data['note']->commentsCount() }})：</h4>
                        <br>

                        <form action="{{ route('comments.store') }}" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" name="note_id" value="{{ $data['note']->id }}">
                            <input type="hidden" name="user_id" value="{{ $data['note']->user_id }}">
                            <textarea name="content" cols="30" class="form-control" rows="3" placeholder="你有什么别的看法吗？" style="resize: none;" autofocus>{{ old('content') }}</textarea>
                            <button class="btn btn-primary" @if (Auth::check()) type="submit" @else
                                type="button" data-trigger="focus" data-placement="left" data-toggle="popover" data-content="登录后才可以关注TA哦，快去登录吧！" title="您还没有登录" @endif>
                                发表评论
                            </button>
                            @if (count($errors) > 0)
                                <span class="label label-warning" style="float: right">{{ $errors->first() }}</span>
                            @endif
                            <br><br>
                        </form>

                        @include('shared._msgs', ['show_all' => false, 'title' => '提示', 'msg_type' => 'success'])

                        <br><br>
                        <div class="note-comments">
                            @if (!$data['note']->commentsCount() )
                                <p class="tips" style="text-align: left">暂时还没有人评论过这条动态，你可以抢沙发了~</p>
                            @else
                                @foreach( $data['note']->comments as $comment)
                                        <div class="col-sm-1 fans-list" title="{{ $comment->user->name }}">
                                            <a href="{{ route('users.show', $comment->user->id) }}" class="thumbnail">
                                                <img alt="{{ $comment->user->name }}" src="{{ $comment->user->avatar() }}">
                                            </a>

                                        </div>
                                        <div class="col-sm-11">
                                            <span class="comment-time">{{ $comment->created_at->diffForHumans() }}</span>
                                            <strong><a href="{{ route('users.show', $comment->user->id) }}">{{ $comment->user->name }}</a> :</strong>
                                            <p style="margin-top: 8px;">
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