<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">
                <img src="/favicon.ico" alt="LOGO" class="favicon">简易微博
            </a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                @if (Auth::check())
                    <li role="presentation">
                        <a href="{{ route('users.show', Auth::user()->id) }}">
                            {{ Auth::user()->name }}
                            <span class="badge">3</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('users.logout') }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-block btn-logout" type="submit" name="button" title="退出登录">
                                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                            </button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('users.login') }}">登录</a></li>

                    <li><a href="{{ route('users.create') }}">注册</a></li>
                @endif
            </ul>
        </div><!--/.nav-collapse -->

    </div><!--/.container-fluid -->
</nav>