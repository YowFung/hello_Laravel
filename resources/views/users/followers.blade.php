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

        @include('shared._msgs', ['show_all' => false, 'title' => '提示', 'msg_type' => 'success'])

        @if ($followers->total())

            @foreach ($followers as $follower)
                <div class="media">
                    <div class="media-left">
                        <div class="media-object thumbnail" style="width: 64px; margin-bottom: 6px">
                            <a href="{{ route('users.show', $follower->id) }}">
                                <img alt="{{ $follower->name }}" src="{{ $follower->avatar() }}">
                            </a>
                        </div>
                        <form action="{{ route('users.attach', $follower->id) }}" method="POST" style="display: inline-block">
                            {{ csrf_field() }}

                            <button type="submit" class="btn btn-xs btn-danger" style="margin-left: 2px">取消关注</button>
                        </form>
                    </div>
                    <div class="media-body follower-info">
                        <a href="{{ route('users.show', $follower->id) }}"><h4>{{ $follower->name }}</h4></a>
                        <strong>
                            <span class="label label-default label-note-show">邮箱：</span>
                            {{ $follower->email }}
                        </strong>
                        @if (empty($follower->newNote()))
                            <p class="tips" style="text-align: left">该瓜友未发表过任何动态~</p>
                        @else
                            <p>
                                <span class="label label-default label-note-show">动态：</span>
                                {{ $follower->newNote() }}
                            </p>
                        @endif
                    </div>
                </div>
                <br>
            @endforeach

            <br><br>
            <nav aria-label="..." class="page-split">
                {{ $followers->render() }}
            </nav>

        @else
            <p class="tips">你未关注过任何瓜友~</p>
        @endif
    </div>

@stop