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
                    <span class="label label-danger">{{ $errors->first() }}</span>
                @endif
                <button type="submit" class="btn btn-md btn-success btn-notes-published">发表动态</button>
            </form>
            <br><br><hr>
        @endif

        @if (session()->has('success'))
            @include('shared._msgs', ['show_all' => false, 'title' => '提示', 'msg_type' => 'success'])
        @endif

        <div class="note-lists" id="lists">

            @if (Auth::check() && Auth::user()->id == $user->id)
                @if ($notes->total())
                    <h3><span class="label label-info" style="padding: 8px">我发表过的微博动态（{{ $notes->total() }}）</span></h3><br>
                @else
                    <p class="tips">你还没发表过任何微博动态哦~</p>
                @endif
            @else
                @if ($notes->total())
                    <h3><span class="label label-info" style="padding: 8px">TA发表过的微博动态（{{ $notes->total() }}）</span></h3><br>
                @else
                    <p class="tips">TA还没发表过任何微博动态哦~</p>
                @endif
            @endif

            @foreach( $notes as $note)
                <div class="media">
                    <div class="media-left">
                        <img class="media-object" src="{{ $user->gravatar(48) }}" alt="{{ $user->name }}"/>
                    </div>
                    <div class="media-body">
                        {{ $note->content }}
                        <br>
                        <span class="label label-default label-note-show">{{ $note->created_at->diffForHumans() }}</span>
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
                </div>
                <br>
            @endforeach

            <br><br>
            <nav aria-label="..." class="page-split">
                {{ $notes->fragment('lists')->render() }}
            </nav>

        </div>
    </div>
@stop