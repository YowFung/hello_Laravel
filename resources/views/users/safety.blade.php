@extends('layouts._user')

@section('panel_title', '修改密码')

@section('active_password', 'active')

@section('panel_content')
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-label-group">
                <label for="inputOldPassword">原先密码</label>
                <input type="password" id="inputOldPassword" name="password_old" class="form-control" placeholder="Old Password 暂未做授权处理" autofocus>
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputNewPassword">新的密码</label>
                <input type="password" id="inputNewPassword" name="password_new" class="form-control" placeholder="New Password">
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputPasswordConfirmation">确认密码</label>
                <input type="password" id="inputPasswordConfirmation" name="password_new_confirmation" class="form-control" placeholder="Password Confirmation">
            </div>
            <br/>

            @include('shared._msgs', ['show_all' => false, 'title' => '修改失败', 'msg_type' => 'danger'])

            <br/>
            <div class="user-show-btn">
                <button type="submit" class="btn btn-md btn-primary">确认修改</button>
            </div>
        </form>

    </div>
@stop