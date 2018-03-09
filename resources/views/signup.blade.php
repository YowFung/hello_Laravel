@extends('layouts._master')

@section('style')
    .radio-photo-img:hover {
        border: 1px solid #08F;
        box-shadow: 0px 0px 1px 1px;
    }
@stop

@section('title', '注册')

@section('content')

    <br/><br/>

    <form class="form-signin">
        <div class="row">
            <div class="text-center mb-4">
                <img class="mb-4" src="{{ URL::asset('img/sign/login.jpg') }}" alt="" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">用户注册</h1>
                <br/>
            </div>
            <hr/><br/>

            <div class="col-md-1"></div>

            <div class="col-md-4">
                <div class="form-label-group">
                    <label for="inputUsername">用户名</label>
                    <input type="text" id="inputUsername" class="form-control" placeholder="例：Jerry Bool" maxlength="16" required autofocus>
                </div>

                <br/>

                <div class="form-label-group">
                    <label for="inputEmail">邮箱</label>
                    <input type="email" id="inputEmail" class="form-control" placeholder="例：someone@gmail.com" maxlength="200" required autofocus>
                </div>

                <br/>

                <div class="form-label-group">
                    <label for="inputPassword">密码</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="例：Abc123#@" maxlength="16" required>
                </div>

                <br/>

                <div class="form-label-group">
                    <label for="inputValidate">确认密码</label>
                    <input type="password" id="inputValidate" class="form-control" placeholder="例：Abc123#@" maxlength="16" required>
                </div>

                <br/>

                <div class="form-label-group">
                    <label>性别</label>
                    &nbsp;&nbsp;
                    <input type="radio" value="gender-male" name="gender" id="gender-male" checked="checked">
                    <label for="gender-male">帅哥</label>
                    &nbsp;
                    <input type="radio" value="gender-female" name="gender" id="gender-female">
                    <label for="gender-female">美女</label>
                </div>

                <br/>
            </div>

            <div class="col-md-1"></div>

            <div class="col-md-4">
                <div class="form-label-group">
                    <label>头像</label>
                    <br/>
                    @for($i = 1; $i <= 10; $i++)
                        <input type="radio" value="photo-{{ $i }}" class="radio-photo" style="display: none;" name="photo" id="photo-{{ $i }}"
                           @if($i == 1)
                            checked="checked"
                           @endif
                        >
                        <label for="photo-{{ $i }}" class="radio-photo-img" style="background: url('{{ URL::asset('img/photo/48/photo-group-48.jpg') }}') no-repeat;width: 48px;height: 48px;cursor: pointer;border-radius: 6px;background-position: {{ -($i-1) * 48}}px 0;
                            @if($i == 1)
                                border: 1px solid #08F;
                                box-shadow: 0px 0px 1px 1px;
                            @else
                                border: 1px solid #CCC;
                            @endif
                        "></label>
                    @endfor
                </div>

                <br/>

                <div class="form-label-group">
                    <label for="inputCollege">院系</label>
                    <input type="text" id="inputValidate" class="form-control" placeholder="例：信息科学与工程学院" maxlength="200">
                </div>

                <br/>

                <div class="form-label-group">
                    <label for="inputAssociations">社团</label>
                    <input type="text" id="inputAssociations" class="form-control" placeholder="例：网园资讯工作室" maxlength="200">
                </div>

                <br/>

                <div class="form-label-group">
                    <label for="inputAddress">籍贯</label>
                    <input type="text" id="inputAddress" class="form-control" placeholder="例：广东韶关浈江区" maxlength="200">
                </div>

                <br/>
            </div>

            <div class="col-md-1"></div>
        </div>

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-4">
                <br/><br/>
                <p>已有账号？现在去<a href="/login">登录</a>！</p>
                <button class="btn btn-lg btn-primary btn-block" type="submit">立即注册</button>
            </div>
        </div>
    </form>

    <br/><br/>
@stop

@section('javascript')

    $(document).ready(function () {
        $('.radio-photo-img').click(function() {
            $('.radio-photo').removeAttr('checked');
            $('#'+$(this).attr('for')).attr('checked', 'checked');
            $('.radio-photo-img').css('boxShadow', '');
            $('.radio-photo-img').css('border', '1px solid #CCC');
            $(this).css('boxShadow', '0px 0px 1px 1px');
            $(this).css('border', '1px solid #08F');
        });
    });

@stop
