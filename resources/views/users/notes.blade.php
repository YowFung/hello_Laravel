@extends('layouts._user')

@section('panel_title', '微博动态')

@section('active_notes', 'active')

@section('panel_content')
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
                        @can('destroy', $note)
                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display: inline-block">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-xs btn-danger status-delete-btn">删除</button>
                            </form>
                        @endcan
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