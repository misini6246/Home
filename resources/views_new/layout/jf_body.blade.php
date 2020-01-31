<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="baidu-site-verification" content="qUlVl7Atu0" />
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}" />
    <meta name="Description" content="{{shopConfig('shop_desc')}}" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('/jfen/favicon.ico')}}" />
    <link rel="icon" href="{{path('/jfen//animated_favicon.gif')}}" type="image/gif" />
    @yield('links')
</head>

<body>
@yield('content')
</body>
</html>
