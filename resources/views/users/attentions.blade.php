@extends('layouts._user')

@section('panel_title', '我关注的')

@section('active_attentions', 'active')

@section('panel_content')
    <div class="row">
        <div class="media">
            <div class="media-left">
                <div class="media-object thumbnail" style="width: 120px">
                    <a href="#">
                        <img alt="{{ $user->name }}" src="{{ $user->gravatar(132) }}">
                    </a>
                </div>
            </div>
            <div class="media-body">
                <a href="#"><h4>{{ $user->name }}</h4></a>
                <p>
                    <span class="label label-default label-note-show">最新动态：</span>
                    粉丝大粉丝扥苏打粉丝扥ad森森扥共扥三等三扥个三扥个 东风封三扥个苏打扥个三扥个三扥个三扽僧三扽共三扽共三扽三扽共三扽共三扽共三扽共三扥个三扥个三扥个
                </p>
                <a href="#" class="btn btn-sm btn-danger">取消关注</a>
                <a href="#" class="btn btn-sm btn-success">查看更多</a>
            </div>
        </div>
        <br>



    </div>

@stop