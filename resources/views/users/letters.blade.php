@extends('layouts._user')

@section('panel_title', '给TA私信')

@section('active_letters', 'active')

@section('panel_content')
    <form action="{{ route('letters.store') }}" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="user" value="{{ $user->id }}">
        <textarea name="content" class="form-control" cols="30" rows="6" placeholder="你有什么话要对TA讲的吗？" style="resize: none" autofocus></textarea>
        <button @if (Auth::check()) type="submit" @else type="button" data-toggle="popover" data-content="登录后才可以给TA发私信哦，快去登录吧！" data-placement="right" data-container="body" @endif class="btn btn-primary" style="width: 80px">
            发送
        </button>
    </form>
@stop