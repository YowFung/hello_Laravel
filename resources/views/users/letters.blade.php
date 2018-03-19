@extends('layouts._user')

@section('panel_title', '给TA私信')

@section('active_letters', 'active')

@section('panel_content')
    <form action="{{ route('letters.store') }}" method="POST">
        {{ csrf_field() }}

        <input type="hidden" name="user" value="{{ $user->id }}">
        <textarea name="content" class="form-control" cols="30" rows="6" placeholder="你有什么话要对TA讲的吗？" style="resize: none" autofocus></textarea>
        <button type="submit" class="btn btn-md btn-primary" style="width: 80px">发送</button>
    </form>
@stop