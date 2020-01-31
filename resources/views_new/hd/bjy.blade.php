<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }

        .top {
            width: 100%;
            height: 1436px;
            background: url('{{get_img_path('images/hd/bai_top.jpg')}}') no-repeat top center;
            margin: 0 auto;
            min-width: 1200px;
        }

        .center {
            width: 1130px;
            margin: 0 auto;
            position: relative;
        }

        a {
            display: inline-block;
            position: absolute;
            outline: none;
        }

        .a1 {
            width: 870px;
            height: 460px;
            top: 440px;
            left: 189px;
        }

        .bottom {
            width: 100%;
            height: 2323px;
            background: url('{{get_img_path('images/hd/bai_bottom.jpg')}}') no-repeat top center;
            margin: 0 auto;
            position: relative;
            min-width: 1200px;
        }

        .a2 {
            width: 485px;
            height: 570px;
            top: 316px;
            left: 20px;
        }

        .a3 {
            width: 460px;
            height: 760px;
            top: 476px;
            right: -40px;
        }

        .a4 {
            width: 485px;
            height: 570px;
            top: 1014px;
            left: 20px;
        }

        .a5 {
            width: 523px;
            height: 520px;
            top: 1514px;
            right: -22px;
        }
    </style>
</head>
<body>
<div class="top">
    <div class="center">
        <a target="_blank" href="/goods?id=23769" class="a1"></a>
    </div>
</div>
<div class="bottom">
    <div class="center">
        <a target="_blank" href="/goods?id=18073" class="a2"></a>
        <a target="_blank" href="/goods?id=29541" class="a3"></a>
        <a target="_blank" href="/goods?id=12724" class="a4"></a>
        <a target="_blank" href="/goods?id=1046" class="a5"></a>
    </div>
</div>
</body>
</html>
