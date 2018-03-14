@extends('layouts._user')

@section('panel_title', '微博动态')

@section('active_notes', 'active')

@section('panel_content')
    <div class="col-md-12">
        @if (Auth::user()->id == $user->id)
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

        <div class="note-lists">
            <h3><span class="label label-info">已发表的微博（{{ count($user->notes) }}）</span></h3><br>

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
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                </ul>
            </nav>

        </div>
    </div>
@stop