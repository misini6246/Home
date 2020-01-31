<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('layer/layer.js')}}"></script>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        a {
            display: inline-block;
            outline: none;
        }

        .top {
            width: 100%;
            height: 420px;
            background: url('{{get_img_path('images/pcbg-1.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
        }

        .bottom {
            width: 100%;
            height: 660px;
            background: url('{{get_img_path('images/pcbg-2.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
        }

        .content {
            width: 1200px;
            margin: 0 auto;
            position: relative;
        }

        .buy-1, .buy-2 {
            width: 270px;
            height: 38px;
            position: absolute;
            top: 260px;
        }

        .buy-1 {
            left: 279px;
        }

        .buy-2 {
            right: 49px;
        }

        .imgclick-1 {
            width: 220px;
            height: 220px;
            position: absolute;
            top: 80px;
            left: 30px;
        }

        .imgclick-2 {
            width: 220px;
            height: 220px;
            position: absolute;
            top: 80px;
            right: 348px;

        }
    </style>
</head>
<body>
<div class="top"></div>
<div class="bottom">
    <div class="content">
        @if(time()<strtotime(20170621))
            <a href="javascript:;" onclick="check_hd()" class="imgclick-1"></a>
            <a href="javascript:;" onclick="check_hd()" class="imgclick-2"></a>
            <a href="javascript:;" onclick="check_hd()" class="buy-1"></a>
            <a href="javascript:;" onclick="check_hd()" class="buy-2"></a>
        @else
            <a target="_blank" href="/goods?id=9838" class="imgclick-1"></a>
            <a target="_blank" href="/goods?id=783" class="imgclick-2"></a>
            <a target="_blank" href="/goods?id=9838" class="buy-1"></a>
            <a target="_blank" href="/goods?id=783" class="buy-2"></a>
        @endif
    </div>
</div>
@include('miaosha.daohang')
<script type="text/javascript">
    layer.config({
        title: '温馨提示', //默认皮肤
        shade: 0
    });
    function check_hd() {
        layer.alert('活动未开始', {icon: 0})
    }
</script>
</body>
</html>
