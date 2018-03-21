@extends('layouts._user')

@section('panel_title', '微博动态')

@section('active_notes', 'active')

@section('panel_content')

    @if ($notes->currentPage() <= 0 || $notes->currentPage() > $notes->lastPage())
        <script>
            window.location.href = '{{ $notes->url(1) }}';
        </script>
    @endif

    <div class="row">
        @if (Auth::check() && Auth::user()->id == $user->id)
            <form method="POST" action="{{ route('notes.store') }}">
                {{ csrf_field() }}

                <textarea name="notes_content" cols="30" rows="4" class="form-control input-notes-content" placeholder="此刻你在想什么呢？" autofocus>{{ old('notes_content') }}</textarea>
                @if (count($errors) > 0)
                    <span class="label label-warning" style="float: right">{{ $errors->first() }}</span>
                @endif
                <button type="submit" class="btn btn-md btn-primary">发表动态</button>
            </form>
            <br><hr>
        @endif

        @if (session()->has('success'))
            @include('shared._msgs', ['show_all' => false, 'title' => '提示', 'msg_type' => 'success'])
        @endif

        <div class="note-lists" id="lists">

            @if (Auth::check() && Auth::user()->id == $user->id)
                @if ($notes->total())
                    <h3><h4>我发表过的微博动态({{ $notes->total() }})</h4></h3><br>
                @else
                    <p class="tips">你还没发表过任何微博动态哦~</p>
                @endif
            @else
                @if ($notes->total())
                    <h3><h4>TA发表过的微博动态({{ $notes->total() }})</h4></h3><br>
                @else
                    <p class="tips">TA还没发表过任何微博动态哦~</p>
                @endif
            @endif

            <br>
            @foreach( $notes as $note)
                <div class="row" style="padding: 8px 24px">
                    <a href="{{ route('notes.show', $note->id) }}" class="home-note-link">
                        <p>{{ $note->content }}</p>
                    </a>

                    <span class="label label-default label-note-show" title="评论数">
                        <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                        ({{ $note->commentsCount() }})
                    </span>
                    &nbsp;
                    <span class="label label-default label-note-show" title="发表时间">
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        {{ $note->created_at->diffForHumans() }}
                    </span>
                    &nbsp;
                    <a href="{{ route('notes.show', $note->id) }}" class="btn btn-xs btn-info">
                        查看
                    </a>
                    @if (Auth::check() && Auth::user()->id == $user->id)
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
                    @endif
                </div>
                <hr>
            @endforeach

            <nav aria-label="..." class="page-split">
                {{ $notes->fragment('lists')->render() }}
            </nav>

        </div>
    </div>
@stop