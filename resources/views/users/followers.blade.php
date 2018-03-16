@extends('layouts._user')

@section('panel_title', '我关注的')

@section('active_followers', 'active')

@section('panel_content')

    <div class="row">
        @if ($followers->currentPage() <= 0 || $followers->currentPage() > $followers->lastPage())
            <script>
                window.location.href = '{{ $followers->url(1) }}';
            </script>
        @endif

        @if ($followers->total())

            @foreach ($followers as $follower)
                <div class="media">
                    <div class="media-left">
                        <div class="media-object thumbnail" style="width: 120px">
                            <a href="{{ route('users.show', $follower->id) }}">
                                <img alt="{{ $follower->name }}" src="{{ $follower->gravatar(132) }}">
                            </a>
                        </div>
                    </div>
                    <div class="media-body">
                        <a href="{{ route('users.show', $follower->id) }}"><h4>{{ $follower->name }}</h4></a>
                            @if (empty($follower->newNote()))
                                <p class="tips" style="text-align: left">该用户未发表过微博动态~</p>
                            @else
                                <p>
                                    <span class="label label-default label-note-show">最新动态：</span>
                                    {{ $follower->newNote() }}
                                </p>
                            @endif
                        <form action="{{ route('users.attach', $follower->id) }}" method="POST" style="display: inline-block">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-sm btn-danger">取消关注</button>
                        </form>
                        <a href="{{ route('users.show', $follower->id) }}" class="btn btn-sm btn-success">查看更多</a>
                    </div>
                </div>
                <br>
            @endforeach

            <br><br>
            <nav aria-label="..." class="page-split">
                {{ $followers->render() }}
            </nav>

        @else

        @endif
    </div>

@stop