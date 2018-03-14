@if (count($errors) > 0)
    <div class="alert alert-{{ $msg_type }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        @if($show_all)
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        @else
            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
            <strong>{{ $title }}：</strong> {{ $errors->first() }}
        @endif
    </div>
@elseif (session()->has($msg_type))
    <div class="alert alert-{{ $msg_type }} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        @if ($msg_type == 'danger')
            <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
        @elseif ($msg_type == 'success')
            <span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span>
        @elseif ($msg_type == 'info')
            <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span>
        @elseif ($msg_type == 'warning')
            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        @endif
        <strong>{{ $title }}：</strong> {{ session()->get($msg_type) }}
    </div>
@endif