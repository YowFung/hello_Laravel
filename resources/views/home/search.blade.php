@extends('layouts._home')

@section('col-left')

    @if ($users->currentPage() <= 0 || $users->currentPage() > $users->lastPage())
        <script>
            window.location.href = '{{ $users->url(1) }}';
        </script>
    @endif

    {{--搜索结果顶部栏--}}
    <div class="alert alert-info" role="alert">
        <form action="{{ route('back') }}" method="POST" style="display: inline-block">
            {{ csrf_field() }}

            <input type="submit" style="display: none" id="back-btn">
            <a class="btn btn-default" type="submit" style="margin-top: -4px" href="javascript:$('#back-btn').click()">返回</a>
        </form>
        <span class="search-result-tips">共找到 {{ $users->total() }} 个与「<strong>{{ $keyword }}</strong>」相关的用户</span>
    </div>

    @if ($users->total())
        <div class="panel panel-default">
            <div class="panel-body">

            {{--搜索结果列表--}}
            @for ($i = 0; $i < count($users); $i += 4)
                    <div class="row">
                        @for ($j = $i; $j < $i+4 && $j < count($users); $j++)
                                <div class="col-md-3">
                                    <div class="thumbnail">
                                        <a href="{{ route('users.show', $users[$j]->id) }}">
                                            <img data-src="holder.js/100%x200" alt="{{ $users[$j]->name }}" src="{{ $users[$j]->avatar() }}" data-holder-rendered="true" style="width: 100%; display: block;">
                                        </a>
                                        <div class="caption">
                                            <p class="search-show-name">
                                                <strong title="{{ $users[$j]->name }}">{{ $users[$j]->name }}</strong>
                                                <span title="{{ $users[$j]->email }}">{{ $users[$j]->email }}</span>
                                            </p>
                                            <form method="POST" action="{{ route('users.attach', $users[$j]->id) }}">
                                                {{ csrf_field() }}

                                                @if (Auth::check() && Auth::user()->id == $users[$j]->id)
                                                    <button class="btn btn-warning" disabled="true">我自己</button>
                                                @elseif ($users[$j]->isAttached())
                                                    <button class="btn btn-danger" type="submit">已关注</button>
                                                @else
                                                    <button @if (Auth::check()) type="submit" @else type="button" data-toggle="popover" data-content="登录后才可以关注TA哦，快去登录吧！" data-placement="bottom" data-container="body" @endif class="btn btn-info" type="submit">关注TA</button>
                                                @endif

                                                <a href="{{ route('users.show', $users[$j]->id) }}" class="btn btn-default" role="button">查看</a>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        @endfor
                    </div>
                @endfor
            </div>

            {{--分页栏--}}
            <nav aria-label="..." class="page-split">
                {{ $users->appends(['keyword' => $keyword])->render() }}
            </nav>
        </div>
    @endif

@stop