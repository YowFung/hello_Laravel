<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>简易微博 - @yield('title', '首页')</title>
    <link rel="stylesheet" href="/css/app.css">
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

    {{--回顶部--}}
    <span class="back-to-top" style="display: none" title="返回顶部">
        <span class="glyphicon glyphicon-chevron-up" aria-hidden="true"></span>
    </span>

    <script type="text/javascript" src="/js/app.js"></script>

</body>
</html>