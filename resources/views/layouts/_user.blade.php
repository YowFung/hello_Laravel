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
                @if (Auth::check() && Auth::user()->id == $user->id)

                    <a href="#" class="title-info-link">
                        <span title="我的粉丝">
                            <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color: red"></span>
                            <b class="title-info-count">({{ $user->getFansCount() }})</b>
                        </span>
                    </a>
                    <a href="#" class="title-info-link">
                        <span title="我关注的">
                            <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: orange"></span>
                            <b class="title-info-count">({{ $user->getAttentionsCount() }})</b>
                        </span>
                    </a>

                @elseif ($user->isFocusOn())

                    <a href="#" class="btn btn-sm btn-primary active" type="submit">
                        <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color: red"></span>
                        <b class="title-info-count"></b>取消关注({{ $user->getFansCount() }})
                    </a>

                @else

                    <a href="#" class="btn btn-sm btn-info" type="submit">
                        <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color: red"></span>
                        <b class="title-info-count"></b>关注({{ $user->getFansCount() }})
                    </a>

                @endif
            </div>
        </div>
    </div>
    <div class="row"><hr/></div>
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
                    <a href="{{ route('users.attentions', $user->id) }}" class="list-group-item  @yield('active_attentions', '')">
                        <span class="glyphicon glyphicon-star" aria-hidden="true"></span>&nbsp;&nbsp;我关注的
                    </a>
                    <a href="{{ route('users.messages', $user->id) }}" class="list-group-item  @yield('active_messages', '')">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;&nbsp;消息中心@if ($user->getNewMessagesCount() ) <span class="badge">{{ $user->getNewMessagesCount }}</span>@endif </a>
                @endif
            </div>

            <div class="panel panel-default panel-fans">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color: red"></span>&nbsp;&nbsp;所有粉丝
                </div>
                <div class="panel-body">
                    Panel content
                </div>
            </div>
        </div>

        <div class="col-md-9">

            <div class="panel panel-default panel-content">
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