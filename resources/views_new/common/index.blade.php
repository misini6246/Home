<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="baidu-site-verification" content="qUlVl7Atu0"/>
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}"/>
    <meta name="Description" content="{{shopConfig('shop_desc')}}"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{$page_title or '系统提示'}}{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}"/>
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif"/>
    <link rel="alternate" type="application/rss+xml" title="RSS|{{$page_title or '系统提示'}}" href="feed.php"/>
    <script type="text/javascript" src="{{path('/js/transport_jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('layer/layer.js')}}"></script>
    <script src="{{path('new/js/jquery.singlePageNav.min.js')}}" type="text/javascript" charset="utf-8"></script>
    @yield('links')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            type: 'post'
//            beforeSend: function () {
//                layer.load(1, {
//                    shade: [0.1, '#fff'] //0.1透明度的白色背景
//                });
//            },
//            complete: function () {
//                layer.closeAll('loading');
//            },
        });
        layer.config({
            title: '温馨提示', //默认皮肤
            shade: 0
        });
    </script>
</head>

<body id="body" style="background-color: #ffffff;">
@yield('content')
<div style="position: absolute;width: 50px;height: 50px;left: 570px;top: 30px;z-index: 1000000;display: none;">

    <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
        document.write(unescape("%3Cspan id='cnzz_stat_icon_1252987830'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s19.cnzz.com/stat.php%3Fid%3D1252987830%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>

</div>
</body>
</html>
