@extends('layouts._user')

@section('panel_title', '给TA私信')

@section('active_letters', 'active')

@section('panel_content')

    @include('shared._msgs', ['show_all' => false, 'title' => '提示', 'msg_type' => 'success'])

    <form action="{{ route('letters.store') }}" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="user" value="{{ $user->id }}">
        <textarea name="content" class="form-control" cols="30" rows="6" placeholder="你有什么话要对TA讲的吗？" style="resize: none" autofocus></textarea>
        <button class="btn btn-primary" style="width: 104px" @if (Auth::check()) type="submit" @else
        type="button" data-trigger="focus" data-placement="right" data-toggle="popover" data-content="登录后才可以给TA发私信哦，快去登录吧！" title="您还没有登录" @endif>
            发送私信
        </button>
        @if (count($errors) > 0)
            <span class="label label-warning" style="float: right">{{ $errors->first() }}</span>
        @endif
    </form>
@stop