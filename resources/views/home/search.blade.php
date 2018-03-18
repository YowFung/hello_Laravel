@extends('layouts._home')

@section('col-left')

    @if ($users->currentPage() <= 0 || $users->currentPage() > $users->lastPage())
        <script>
            window.location.href = '{{ $users->url(1) }}';
        </script>
    @endif

    {{--搜索结果顶部栏--}}
    <div class="alert alert-info" role="alert">
        <a class="btn btn-default" href="{{ route('home') }}">返回</a>
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
                                            <img data-src="holder.js/100%x200" alt="{{ $users[$j]->name }}" src="{{ $users[$j]->gravatar('188') }}" data-holder-rendered="true" style="width: 100%; display: block;">
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
                                                    <button class="btn btn-info" type="submit">关注TA</button>
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