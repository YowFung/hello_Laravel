<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>简易微博 - @yield('title', '首页')</title>
    <link rel="stylesheet" href="/css/app.css">
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    @yield('file_links')
    {{-- <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/index.css') }}"> --}}
    {{-- <script type="text/javascript" src="{{ URL::asset('js/html5shiv.min.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ URL::asset('js/respond.min.js') }}"></script> --}}
</head>
<body>
    <!-- 导航栏开始 -->
    @include('layouts._header')
    <!-- 导航栏结束 -->

    <!-- 主体区开始 -->
    <div class="container">
        @yield('content')
    </div>
    <!-- 主体区结束 -->

    <!-- 页脚开始 -->
    @include('layouts._footer')
    <!-- 页脚结束 -->
</body>
</html>