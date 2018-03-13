@if(!Auth::check() || Auth::user()->id != $user->id)
    <script>
        window.location.href = '{{ route('home') }}'
    </script>
@endif

@extends('layouts._user')

@section('panel_title', '修改资料')

@section('active_show', 'active')

@section('panel_content')
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <form method="POST" action="{{ route('users.update', $user->id) }}">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="form-label-group">
                <label for="inputEmail">邮箱</label>
                <input type="email" id="inputEmail" name="email" value="{{ $user->email }}" class="form-control control-edit" placeholder="E-mail" disabled="true">
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputEmail">昵称</label>
                <input type="text" id="inputEmail" name="name" value="{{ $user->name }}" class="form-control control-edit" placeholder="Name" autofocus>
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputEmail">性别</label>
                <select class="form-control control-edit" name="gender">
                    <option value="male" @if ($user->gender == 'male') selected @endif>帅哥</option>
                    <option value="female" @if ($user->gender == 'female') selected @endif>美女</option>
                </select>
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputEmail">社团</label>
                <input type="text" id="inputEmail" name="associations" value="{{ $user->associations }}" class="form-control control-edit" placeholder="Associations">
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputEmail">院系</label>
                <input type="text" id="inputEmail" name="college" value="{{ $user->college }}" class="form-control control-edit" placeholder="College">
            </div>
            <br/>

            <div class="form-label-group">
                <label for="inputEmail">籍贯</label>
                <input type="text" id="inputEmail" name="address" value="{{ $user->address }}" class="form-control control-edit" placeholder="Address">
            </div>
            <br/>

            @include('shared._msgs', ['show_all' => false, 'title' => '修改失败', 'msg_type' => 'danger'])

            <div class="user-show-btn">
                <button type="submit" class="btn btn-md btn-primary">保存</button>
                <a class="btn btn-md btn-default" href="{{ route('users.show', $user) }}">取消</a>
            </div>
        </form>

    </div>
@stop