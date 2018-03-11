@extends('layouts._master')

@section('file_links')

@stop

@section('title', '用户注册')

@section('content')

    <br/><br/>

    <form method="POST" action="{{ route('users.store') }}">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">

                <div class="text-center mb-4">
                    <img class="mb-4" src="/img/sign/login.jpg" alt="" width="72" height="72">
                    <h1 class="h3 mb-3 font-weight-normal">用户注册</h1>
                    <br/>
                </div>

                <hr/><br/>

                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">昵称</span>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name" aria-describedby="basic-addon1" autofocus>
                </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon2">邮箱</span>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail" aria-describedby="basic-addon2">
                </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">登录密码</span>
                    <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" aria-describedby="basic-addon3">
                </div>
                <br/>

                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon4">确认密码</span>
                    <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Password Confirmation" aria-describedby="basic-addon4">
                </div>
                <br/><br/>

                @include('shared._errors', ['show_all' => false, 'title' => '注册失败'])

                <br/>
                <p>已有账号？现在去<a href="{{ route('users.login') }}">登录</a>！</p>
                <button class="btn btn-lg btn-primary btn-block" type="submit">立即注册</button>

            </div>
        </div>
    </form>

    <br/><br/>
@stop
