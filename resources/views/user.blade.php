@extends('layouts._master')

@section('style')
    .photo-img {
        background: url('{{ URL::asset('img/photo/256/001.jpg') }}') no-repeat;
        position: absolute;
        top: 28px;
        left: 28px;
        border-radius: 50%;
        width: 200px;
        height: 200px;
        border: 3px solid #FFF;
    }
    .title-username {
        position: absolute;
        top: 124px;
        left: 248px;
        font-size: 28px;
        font-weight: bold;
        padding: 4px 8px;
        border-bottom: 4px solid #66aaff;
        min-width: 172px;
        text-shadow: #666 1px 1px 8px ;
    }
    .title-info {
        position: absolute;
        top: 182px;
        left: 248px;
        padding: 2px;
    }
    .title-info .title-info-count {
        color: #666;
        margin-left: 4px;
        font-weight: normal;
        font-size: 13px;
    }
    .title-info .title-info-link {
        text-decoration: none;
        margin-right: 12px;
    }
    .panel-body {
        min-height: 420px;
    }
    .panel-title {
        font-size: 14px;
    }
@stop

@section('title', '用户中心')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <img src="{{ URL::asset('img/bg/user-info-bg.jpg') }}" alt="bg" style="height: 256px; width: 100%;">
            <div class="photo-img"></div>
            <div class="title-username">YowFung</div>
            <div class="title-info">
                <a href="" class="title-info-link">
                    <span title="我关注的">
                        <span class="glyphicon glyphicon-star" aria-hidden="true" style="color: orange"></span>
                        <b class="title-info-count">(78)</b>
                    </span>
                </a>
                <a href="" class="title-info-link">
                    <span title="我的粉丝">
                        <span class="glyphicon glyphicon-heart" aria-hidden="true" style="color: red"></span>
                        <b class="title-info-count">(99+)</b>
                    </span>
                </a>
                <a href="" class="title-info-link">
                    <span title="新的私信">
                        <span class="glyphicon glyphicon-envelope" aria-hidden="true" style="color: deepskyblue"></span>
                        <b class="title-info-count">(0)</b>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="row"><hr/></div>
    <div class="row">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item active">
                    <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>&nbsp;&nbsp;基本信息
                </a>
                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;&nbsp;我的动态</a>
                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>&nbsp;&nbsp;我关注的</a>
                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-heart" aria-hidden="true"></span>&nbsp;&nbsp;我的粉丝</a>
                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;&nbsp;私信中心<span class="badge">4</span></a>
                <a href="#" class="list-group-item"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span>&nbsp;&nbsp;修改密码</a>
            </div>
        </div>

        <div class="col-md-9">
            {{--基本信息栏--}}
            <div class="row" style="display: block;" id="info-foundation">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">个人中心&nbsp;&gt;&nbsp;基本信息</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <br/><br/>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>邮箱</th>
                                    <th class="foundation-info-label">YowFung@outlook.com</th>
                                    <th class="foundation-info-edit">
                                        <input type="text" class="form-control" value="YowFung@outlook.com">
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>性别</td>
                                    <td class="foundation-info-label">帅哥</td>
                                    <th class="foundation-info-edit">
                                        <input type="radio" value="gender-male" name="gender" id="gender-male" checked="checked">
                                        <label for="gender-male">帅哥</label>
                                        &nbsp;
                                        <input type="radio" value="gender-female" name="gender" id="gender-female">
                                        <label for="gender-female">美女</label>
                                    </th>
                                </tr>
                                <tr>
                                    <td>社团</td>
                                    <td class="foundation-info-label">网园资讯工作室</td>
                                    <th class="foundation-info-edit">
                                        <input type="text" class="form-control" value="网园资讯工作室">
                                    </th>
                                </tr>
                                <tr>
                                    <td>院系</td>
                                    <td class="foundation-info-label">信息科学与技术学院</td>
                                    <th class="foundation-info-edit">
                                        <input type="text" class="form-control" value="信息科学与技术学院">
                                    </th>
                                </tr>
                                <tr>
                                    <td>籍贯</td>
                                    <td class="foundation-info-label">广东韶关浈江区</td>
                                    <th class="foundation-info-edit">
                                        <input type="text" class="form-control" value="广东韶关浈江区">
                                    </th>
                                </tr>
                                </tbody>
                            </table>

                            <div class="alert alert-danger alert-dismissible" role="alert" style="display: none;">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <strong>警告：</strong> 邮箱格式不正确。
                            </div>
                            <br>

                            <div>
                                <button class="btn btn-md btn-default" type="button" id="change_info" style="padding: 8px 32px">修改信息</button>
                                <button class="btn btn-md btn-primary" type="submit" id="save_info" style="display: none; padding: 8px 32px;">保存</button>
                                <button class="btn btn-md btn-default" type="button" id="cancel_change" style="display: none; margin-left: 16px; padding: 8px 32px;">取消</button>
                            </div>

                        </div>
                        <div class="col-md-3"></div>
                    </div>
                </div>
            </div>

            {{--我的动态栏--}}
            <div class="row" style="display: none;" id="info-published">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">个人中心&nbsp;&gt;&nbsp;我的动态</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>

            {{--我关注的栏--}}
            <div class="row" style="display: none;" id="info-attentions">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">个人中心&nbsp;&gt;&nbsp;我关注的</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>

            {{--我的粉丝栏--}}
            <div class="row" style="display: none;" id="info-fans">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">个人中心&nbsp;&gt;&nbsp;我的粉丝</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>

            {{--私信中心栏--}}
            <div class="row" style="display: none;" id="info-messages">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">个人中心&nbsp;&gt;&nbsp;私信中心</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>

            {{--修改密码栏--}}
            <div class="row" style="display: none" id="info-security">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">个人中心&nbsp;&gt;&nbsp;修改密码</h3>
                    </div>
                    <div class="panel-body">
                        Panel content
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    //“基本信息界面中”点击“修改信息”按钮
    $('#change_info').click(function() {
        $('.foundation-data').css('display', 'none');
        $('.foundation-edit').css('display', 'block');
        $('#save_info').css('display', 'inline');
        $('#cancel_change').css('display', 'inline');
        $('#change_info').css('display', 'none');
    });

    //基本信息界面中点击“保存”按钮
    $('#save_info').click(function() {
        $('.foundation-data').css('display', 'block');
        $('.foundation-edit').css('display', 'none');
        $('#save_info').css('display', 'none');
        $('#cancel_change').css('display', 'none');
        $('#change_info').css('display', 'inline');
    });

    //基本信息界面中点击“取消”按钮
    $('#cancel_change').click(function() {
        $('.foundation-data').css('display', 'block');
        $('.foundation-edit').css('display', 'none');
        $('#save_info').css('display', 'none');
        $('#cancel_change').css('display', 'none');
        $('#change_info').css('display', 'inline');
    });

    //显示标签
    function showLabel() {

    }

    //显示编辑框
    function showEdit() {

        //显示组件
        $('.foundation-info-edit').css('display', 'inline');
        $('#save_info').css('display', 'inline');
        $('#cancel_change').css('display', 'inline');

        //隐藏组件
        $('.foundation-info-label').css('display', 'none');
        $('#change_info').css('display', 'none');
    }
@stop