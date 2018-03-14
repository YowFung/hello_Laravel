@extends('layouts._user')

@section('panel_title', '个人资料')

@section('active_show', 'active')

@section('panel_content')
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <br/>

        <table class="table">
            <thead>
            <tr>
                <th>昵称</th>
                <th class="foundation-info-label">{{ $user->name }}</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>邮箱</td>
                <td class="foundation-info-label">{{ $user->email }}</td>
            </tr>
            <tr>
                <td>性别</td>
                <td class="foundation-info-label">@if($user->gender == 'male') 帅哥 @else 美女 @endif</td>
            </tr>
            <tr>
                <td>社团</td>
                <td class="foundation-info-label">@if($user->associations) {{ $user->associations }} @else 未填写 @endif</td>
            </tr>
            <tr>
                <td>院系</td>
                <td class="foundation-info-label">@if($user->college) {{ $user->college }} @else 未填写 @endif</td>
            </tr>
            <tr>
                <td>籍贯</td>
                <td class="foundation-info-label">@if($user->address) {{ $user->address }} @else 未填写 @endif</td>
            </tr>
            </tbody>
        </table>

        @include('shared._msgs', ['show_all' => false, 'title' => '提示', 'msg_type' => 'success'])

        @if(Auth::check() && Auth::user()->id == $user->id)
            <div class="user-show-btn">
                <a class="btn btn-md btn-default" href="{{ route('users.edit', $user->id) }}">修改资料</a>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn-md btn-default" href="{{ route('users.safety', $user->id) }}">修改密码</a>
            </div>
        @endif

    </div>

@stop