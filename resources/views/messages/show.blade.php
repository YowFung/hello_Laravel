@extends('layouts._user')

@section('panel_title', '消息中心')

@section('active_messages', 'active')

@section('panel_content')
    <h5 class="message-item-key">
        类型：
        <strong>{{ $message->category() }}</strong>
    </h5>

    <h5 class="message-item-key">
        状态：
        <strong>{{ $message->read }}</strong>
    </h5>

    <h5 class="message-item-key">
        时间：
        <strong>{{ $message->created_at }}</strong>
    </h5>
    <br>

    <div class="panel panel-default message-passage-panel">
        <div class="panel-body">
            <p class="message-passage">
                {!! $message->content !!}
            </p>
        </div>
    </div>


    <hr>
    <a  href="{{ redirect()->back()->getTargetUrl() }}" class="btn btn-md btn-default">返回</a>&nbsp;

    <form action="{{ route('messages.destroy', $message->id) }}" method="POST" style="display: inline-block">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}

        <button type="button" class="btn btn-md btn-danger status-delete-btn" data-toggle="modal" data-target="#myModal{{ $message->id }}">删除消息</button>

        <div class="modal fade" id="myModal{{ $message->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{ $message->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel{{ $message->id }}">确定要删除这条消息吗？</h4>
                    </div>
                    <div class="modal-body">
                        {!! $message->content !!}
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-md btn-danger">确认</button>
                        <button type="button" class="btn btn-md btn-default" data-dismiss="modal">取消</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop