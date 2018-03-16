@extends('layouts._user')

@section('panel_title', '个人资料')

@section('active_show', 'active')

@section('panel_content')
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <br>

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-label-group">
                <label for="inputOldPassword">原先密码</label>
                <input type="password" id="inputOldPassword" name="password_old" class="form-control control-edit" placeholder="Old Password" autofocus>
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputNewPassword">新的密码</label>
                <input type="password" id="inputNewPassword" name="password_new" class="form-control control-edit" placeholder="New Password">
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputPasswordConfirmation">确认密码</label>
                <input type="password" id="inputPasswordConfirmation" name="password_new_confirmation" class="form-control control-edit" placeholder="Password Confirmation">
            </div>
            <br/>

            @include('shared._msgs', ['show_all' => false, 'title' => '修改失败', 'msg_type' => 'danger'])

            <br/>
            <div class="user-show-btn">
                <button type="submit" class="btn btn-md btn-primary">保存修改</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a class="btn btn-md btn-default" href="{{ route('users.show', $user) }}">取消</a>
            </div>
        </form>

    </div>
@stop