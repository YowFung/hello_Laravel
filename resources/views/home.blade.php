@extends('layouts._master')
@section('content')
    <!-- 栅格开始 -->
    <div class="row">
        <!-- 左边栅格 -->
        <div class="col-md-8">

            @if ($data['notes']->currentPage() <= 0 || $data['notes']->currentPage() > $data['notes']->lastPage())
                <script>
                    window.location.href = '{{ $data['notes']->url(1) }}';
                </script>
            @endif

            {{--动态导航栏--}}
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <span class="navbar-brand">动态列表</span>
                    </div>
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                            <li @if ($data['category'] == 'recommend') class="active" @endif>
                                <a href="{{ route('home', 'recommend') }}">推荐 <span class="sr-only">(current)</span></a>
                            </li>
                            <li @if ($data['category'] == 'concerned') class="active" @endif>
                                <a href="{{ route('home', 'concerned') }}">关注</a>
                            </li>
                            <li @if ($data['category'] == 'newest') class="active" @endif>
                                <a href="{{ route('home', 'newest') }}">最新</a>
                            </li>
                        </ul>
                        <form class="navbar-form navbar-right">
                            <a href="@if (Auth::check()) {{  route('users.notes', Auth::user()->id) }} @else {{ route('login') }} @endif" class="btn btn-primary">
                                <span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;&nbsp;发微博
                            </a>
                        </form>
                    </div>
                </div>
            </nav>

            <!-- 动态列表 -->
            <div class="panel panel-default">
                <div class="panel-body">

                    @foreach( $data['notes'] as $note)
                        <div class="media" id="note{{ $note->id }}">
                            <div class="media-left">
                                <a href="{{ route('users.show', $note->user->id) }}">
                                    <img class="media-object" src="{{ $note->user->gravatar(48) }}" alt="{{ $note->user->name }}"/>
                                </a>
                            </div>
                            <div class="media-body">
                                <strong>
                                    <a href="{{ route('users.show', $note->user->id) }}">{{ $note->user->name }}</a>
                                </strong>
                                <span class="note-info">
                                    <span class="note-info-datetime" title="{{ $note->created_at }}">{{ $note->created_at->diffForHumans() }}</span>
                                    <a class="" title="查看" href="{{ route('notes.show', $note->id) }}">
                                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                                    </a>
                                    &nbsp;
                                    <a class="" title="评论" href="javascript:comment({{ $note->id }})">
                                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                                    </a>
                                </span>
                                <br>
                                <p class="note-content">
                                    {{ $note->content }}
                                </p>
                                @can('destroy', $note)
                                    <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display: inline-block">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}

                                        <button type="button" class="btn btn-xs btn-danger status-delete-btn" data-toggle="modal" data-target="#myModal">删除</button>

                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">确定要删除该条动态吗？</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ $note->content }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-danger">确认</button>
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                @endcan
                            </div>
                        </div>
                        <hr>
                    @endforeach

                    {{--分页栏--}}
                    <nav aria-label="..." class="page-split">
                        {{ $data['notes']->render() }}
                    </nav>

                </div>
            </div>

        </div>

        <!-- 右边栅格 -->
        <div class="col-md-4">

            {{--搜索栏--}}
            <br>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="昵称/邮箱">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button">搜索用户</button>
                </span>
            </div>
            <br>

            <!-- 粉丝/关注人列表 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">关注人列表</h3>
                </div>
                <div class="panel-body fans-panel-body">
                    @if (!Auth::check())
                        <p class="tips">
                            <a href="{{ route('login') }}">登录</a> 后才能显示关注人列表哦~
                        </p>
                    @elseif (!count($data['followers']))
                        <p class="tips">你还没有关注过任何人哦~</p>
                    @else
                        @for($i = 0; $i < count($data['followers']); $i += 6)
                            <div class="row">
                                @for($j = $i; $j < $i+6 && $j < count($data['followers']); $j++)
                                    <div class="col-md-2 fans-list" title="{{ $data['followers'][$j]->name }}">
                                        <a href="{{ route('users.show', $data['followers'][$j]->id) }}" class="thumbnail">
                                            <img alt="{{ $data['followers'][$j]->name }}" src="{{ $data['followers'][$j]->gravatar('64') }}">
                                        </a>
                                    </div>
                                @endfor
                            </div>
                        @endfor
                    @endif
                </div>
            </div>

            <!-- 站点通知 -->
            <div class="alert alert-warning" role="alert">
                <b style="font-size: 15px">站点通知:</b>&nbsp;&nbsp; 本站广告位招租，欢迎 <a href="mailto::xxx@example.com" class="alert-link">联系站长</a>！
            </div>

            <!-- 关于本站 -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">关于本站</h3>
                </div>
                <div class="panel-body  about-panel-body">
                    <p>本站是「Han'」的毕业设计项目，采用 PHP Laravel 5.5 后端框架和 BootStrap v3 前端框架开发，含表单验证、路由过滤、授权策略、响应式布局等，开发架构遵循RESTFul和PSR规范。</p>
                    <img src="/img/sign/QRCode.png">
                    <p>扫二维码访问移动端测试站点</p>
                </div>
            </div>

        </div>

    </div>
    <!-- 栅格结束 -->
@stop