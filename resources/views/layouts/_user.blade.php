@extends('layouts._master')

@section('title', $user->name)

@section('content')
    <div class="row user-show-bg">

        <div class="col-md-2">
            <section class="photo-img">
                @include('shared._user_photo', ['user' => $user, 'size' => 144])
            </section>
        </div>

        <div class="col-md-4">
            <div class="title-name">{{ $user->name }}</div>
            <div class="title-attach">
                @if (Auth::check() && Auth::user()->id == $user->id)

                    <span title="我的粉丝" class="label label-info">
                        <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color: red"></span>
                        <b class="title-count">{{ count($user->fans) }}</b>
                    </span>
                    &nbsp;&nbsp;
                    <span title="我关注的" class="label label-info">
                        <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: orange"></span>
                        <b class="title-count">{{ count($user->followers) }}</b>
                    </span>

                @else

                    <form method="POST" action="{{ route('users.attach', $user->id) }}">
                        {{ csrf_field() }}

                        @if ($user->isAttached())
                            <button class="btn btn-xs btn-danger" type="submit"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> {{ count($user->fans) }}&nbsp;&nbsp;已关注</button>
                        @else
                            <button @if (Auth::check()) type="submit" @else type="button" data-toggle="popover" data-content="登录后才可以关注TA哦，快去登录吧！" data-placement="bottom" data-container="body" @endif class="btn btn-xs btn-info" type="submit"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span> {{ count($user->fans) }}&nbsp;&nbsp;关注TA</button>
                        @endif

                    </form>

                @endif
            </div>
        </div>

        <div class="col-md-6"></div>

    </div>

    <hr/>

    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('users.show', $user->id) }}" class="list-group-item @yield('active_show', '')">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;&nbsp;个人资料
                </a>
                <a href="{{ route('users.notes', $user->id) }}" class="list-group-item  @yield('active_notes', '')">
                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;&nbsp;微博动态
                </a>

                @if(Auth::check() && Auth::user()->id == $user->id)
                    <a href="{{ route('users.followers', $user->id) }}" class="list-group-item  @yield('active_followers', '')">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>&nbsp;&nbsp;我关注的
                    </a>
                    <a href="{{ route('messages.index', [$user->id, 'new']) }}" class="list-group-item  @yield('active_messages', '')">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;
                        消息中心
                        @if (Auth::user()->newMessagesCount() )
                            <span class="badge">{{ Auth::user()->newMessagesCount() }}</span>
                        @endif
                    </a>
                @else
                    <a href="{{ route('letters.create') . '?user=' . $user->id }}" class="list-group-item  @yield('active_letters', '')">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;&nbsp;给TA私信
                    </a>
                @endif
            </div>

            <div class="panel panel-default panel-fans">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp;
                    @if (Auth::check() && Auth::user()->id == $user->id)
                        我的粉丝
                    @else
                        TA的粉丝
                    @endif
                </div>
                <div class="panel-body fans-panel-body">
                    @if (!count($user->fans))
                        @if (Auth::check() && Auth::user()->id == $user->id)
                            <p class="tips">暂时还没有人关注你哦~</p>
                        @else
                            <p class="tips">TA暂时还没有粉丝呢~</p>
                        @endif
                    @else
                        @for($i = 0; $i < count($user->fans); $i += 4)
                            <div class="row">
                                @for($j = $i; $j < $i+4 && $j < count($user->fans); $j++)
                                    <div class="col-md-3 fans-list" title="{{ $user->fans[$j]->name }}">
                                        <a href="{{ route('users.show', $user->fans[$j]->id) }}" class="thumbnail">
                                            <img alt="{{ $user->fans[$j]->name }}" src="{{ $user->fans[$j]->gravatar('64') }}">
                                        </a>
                                    </div>
                                @endfor
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-9">

            <div class="panel panel-default panel-content">
                <div class="panel-heading">
                    <h3 class="panel-title">@yield('panel_title', '')</h3>
                </div>
                <div class="panel-body user-panel">

                    @yield('panel_content')

                </div>
            </div>

        </div>
    </div>
@stop