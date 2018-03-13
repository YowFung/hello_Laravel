@extends('layouts._master')

@section('title', $user->name)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <img src="/img/bg/user-info-bg.jpg" alt="bg" style="height: 256px; width: 100%;">
            <section class="photo-img">
                @include('shared._user_photo', ['users' => $user, 'size' => 144])
            </section>
            <div class="title-username">{{ $user->name }}</div>
            <div class="title-info">
                <a href="" class="title-info-link">
                    <span title="我关注的">
                        <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: orange"></span>
                        <b class="title-info-count">({{ $user->getAttentionsCount() }})</b>
                    </span>
                </a>
                <a href="" class="title-info-link">
                    <span title="我的粉丝">
                        <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color: red"></span>
                        <b class="title-info-count">({{ $user->getFansCount() }})</b>
                    </span>
                </a>
                <a href="" class="title-info-link">
                    <span title="新的私信">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true" style="color: deepskyblue"></span>
                        <b class="title-info-count">({{ $user->getNewMessagesCount() }})</b>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row"><hr/></div>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('users.show', $user->id) }}" class="list-group-item @yield('active_show', '')">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;
                    @if (Auth::check() && Auth::user()->id == $user->id)
                        {{ $call = '我' }}的资料
                    @elseif($user->gender == 'male')
                        {{ $call = '他' }}的资料
                    @else
                        {{ $call = '她' }}的资料
                    @endif
                </a>
                <a href="{{ route('notes.show', $user->id) }}" class="list-group-item  @yield('active_notes', '')">
                    <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;&nbsp;{{ $call }}的日志
                </a>
                <a href="{{ route('fans.to', $user->id) }}" class="list-group-item  @yield('active_fans', '')">
                    <span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp;&nbsp;{{ $call }}的粉丝
                </a>

                @if(Auth::check() && Auth::user()->id == $user->id)
                    <a href="{{ route('fans.from', $user->id) }}" class="list-group-item  @yield('active_attentions', '')">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>&nbsp;&nbsp;我关注的
                    </a>
                    <a href="{{ route('messages.show', $user->id) }}" class="list-group-item  @yield('active_messages', '')">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;&nbsp;消息中心<span class="badge">4</span></a>
                    <a href="{{ route('users.password', $user->id) }}" class="list-group-item  @yield('active_password', '')">
                        <span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;&nbsp;修改密码
                    </a>
                @endif
            </div>
        </div>

        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">个人中心&nbsp;&gt;&nbsp;@yield('panel_title', '')</h3>
                </div>
                <div class="panel-body user-panel">

                    @yield('panel_content')

                </div>
            </div>

        </div>
    </div>
@stop