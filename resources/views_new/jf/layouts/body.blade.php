<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="baidu-site-verification" content="qUlVl7Atu0"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}"/>
    <meta name="Description" content="{{shopConfig('shop_desc')}}"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name=renderer content=webkit>
    <meta http-equiv="Content-Security-Policy" content="
    img-src 'unsafe-inline' 'unsafe-eval' 'self'  *.hezongyy.com *.cnzz.com *.swiftpass.cn *.adyun.com blob:;
    script-src 'unsafe-inline' 'unsafe-eval' 'self'  *.hezongyy.com *.cnzz.com *.swiftpass.cn *.adyun.com;
    style-src 'unsafe-inline' 'unsafe-eval' 'self'  *.hezongyy.com *.cnzz.com *.swiftpass.cn *.adyun.com;
    connect-src 'unsafe-inline' 'unsafe-eval' 'self'  *.hezongyy.com *.cnzz.com *.swiftpass.cn *.adyun.com;
    object-src 'unsafe-inline' 'unsafe-eval' 'self'  *.hezongyy.com *.cnzz.com *.swiftpass.cn *.adyun.com;
    child-src 'unsafe-inline' 'unsafe-eval' 'self'  *.hezongyy.com *.cnzz.com *.swiftpass.cn *.adyun.com;
    media-src 'unsafe-inline' 'unsafe-eval' 'self'  *.hezongyy.com *.cnzz.com *.swiftpass.cn *.adyun.com;">
    <title>{{$page_title or '系统提示'}}{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('/jfen/favicon.ico')}}"/>
    <link rel="icon" href="{{path('/jfen//animated_favicon.gif')}}" type="image/gif"/>
    <link rel="alternate" type="application/rss+xml" title="RSS|{{$page_title or '系统提示'}}" href="feed.php"/>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('layer/layer.js')}}"></script>
    <script src="{{path('new/js/jquery.singlePageNav.min.js')}}" type="text/javascript" charset="utf-8"></script>
    @yield('links')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            type: 'post',
//            beforeSend: function () {
//                layer.load(1, {
//                    shade: [0.1, '#fff'] //0.1透明度的白色背景
//                });
//            },
//            complete: function () {
//                layer.closeAll('loading');
//            },
            error: function (jqXHR) {
                if (jqXHR.status == 403) {
                    layer.confirm('请登录后再操作', {
                        btn: ['注册', '登录'], //按钮
                        icon: 2
                    }, function () {
                        location.href = '/auth/register';
                    }, function () {
                        location.href = '/auth/login';
                        return false;
                    });
                }
            }
        });
        layer.config({
            title: '温馨提示', //默认皮肤
            shade: 0
        });
    </script>
</head>

<body>
@yield('content')
</body>
</html>
