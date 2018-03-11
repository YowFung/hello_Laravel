@extends('layouts._master')

@section('title', '用户登录')

@section('content')
    @if(session()->has('user'))
        有session
        {{ session()->get('user') }}
    @endif
@stop