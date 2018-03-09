@extends('layouts._master')

@section('title', '登录')

@section('content')
    <br/><br/>

    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <form class="form-signin">
                <div class="text-center mb-4">
                    <img class="mb-4" src="{{ URL::asset('img/sign/login.jpg') }}" alt="" width="72" height="72">
                    <h1 class="h3 mb-3 font-weight-normal">用户登录</h1>
                    <br/>
                </div>

                <div class="form-label-group">
                    <label for="inputEmail">用户名/邮箱</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="Username/Email" required autofocus>
                </div>

                <br/>

                <div class="form-label-group">
                    <label for="inputPassword">登录密码</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> 记住登录状态
                    </label>
                </div>

                <br/>

                <p>没有账号？赶紧去<a href="/sign">注册</a>！</p>
                <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>

    <br/><br/>
@stop