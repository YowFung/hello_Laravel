<nav class="navbar navbar-default" id="nav_top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="/img/sign/logo.png" alt="LOGO" class="favicon">简易微博
            </a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li role="presentation" class="presentation">
                        <a href="{{ route('users.show', Auth::user()->id) }}" class="nav-user-name">
                            <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px; width: 32px; height: 32px">
                                <img src="{{ Auth::user()->avatar() }}">
                            </span>
                            {{ Auth::user()->name }}
                        </a>
                    </li>
                    @if (Auth::user()->newMessagesCount())
                        <li role="presentation" class="presentation">
                            <a href="{{ route('messages.index') }}">
                                <span class="messages-count">{{ Auth::user()->newMessagesCount() }}</span>
                            </a>
                        </li>
                    @endif
                    <li role="presentation" class="presentation">
                        <form action="{{ route('logout') }}" method="POST" style="display: none">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" id="link-logout"></button>
                        </form>
                        <a href="javascript:$('#link-logout').click()">
                            退出
                            <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                        </a>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">登录</a></li>
                    <li><a href="{{ route('users.create') }}">注册</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->

    </div><!--/.container-fluid -->
</nav>

<br>
