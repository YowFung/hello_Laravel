@extends('layouts._home')

@section('col-left')

    @if ($users->currentPage() <= 0 || $users->currentPage() > $users->lastPage())
        <script>
            window.location.href = '{{ $users->url(1) }}';
        </script>
    @endif

    {{--搜索结果顶部栏--}}
    <div class="alert alert-info" role="alert">
        <a class="btn btn-default" href="{{ redirect()->back() }}">返回</a>
        <span class="search-result-tips">共找到 {{ $users->total() }} 个与「<strong>{{ $keyword }}</strong>」相关的用户</span>
    </div>

    {{--搜索结果列表--}}
    @for ($i = 0; $i < $users->total(); $i += 4)
        <div class="row">
            @for ($j = $i; $j < $i+4; $j++)
                @if ($j < $users->total())
                    {{ print_r($j.'/'.$users->total())}}
                    <div class="col-md-3">
                        <div class="thumbnail">
                            <img data-src="holder.js/100%x200" alt="100%x200" src="{{ $users[$j]->gravatar() }}" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">
                            <div class="caption">
                                <h3>{{ $users[$j]->name }}</h3>
                                <p>
                                    <a href="#" class="btn btn-primary" role="button">关注TA</a>
                                    <a href="#" class="btn btn-default" role="button">查看</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    @endfor


@stop