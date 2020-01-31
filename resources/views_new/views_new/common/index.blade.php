<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="baidu-site-verification" content="qUlVl7Atu0" />
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}" />
    <meta name="Description" content="{{shopConfig('shop_desc')}}" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>{{$page_title or '系统提示'}}{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}" />
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif" />
    <link rel="alternate" type="application/rss+xml" title="RSS|{{$page_title or '系统提示'}}" href="feed.php" />
    <script type="text/javascript" src="{{path('/js/transport_jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    @include('common.tanchu_attr')
    @yield('links')
</head>

<body id="body" style="background-color: #ffffff;">
@yield('content')
</body>
</html>
