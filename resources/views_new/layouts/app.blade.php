<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    @yield('title')
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/index/css/index/index.css" />
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    @yield('links')
    <!--倒计时-->
    <script src="/index/common/js/leftTime.min.js" type="text/javascript" charset="utf-8"></script>
    <!--自定义滚动条-->
    <script src="/index/common/js/slimScroll.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
    <div class="big-container">
        @yield('content')
    </div>
</body>
</html>
