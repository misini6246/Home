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

        a {
            display: inline-block;
            width: 100%;
        }

        .div1 {
            height: 595px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/b1.jpg')}}') no-repeat scroll top center;
        }

        .div2 {
            height: 904px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/b2.jpg')}}') no-repeat scroll top center;
        }

        .div3 {
            height: 455px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/b3.jpg')}}') no-repeat scroll top center;
        }

        .div4 {
            height: 441px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/b4.jpg')}}') no-repeat scroll top center;
        }

        .div5 {
            height: 445px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/b5.jpg')}}') no-repeat scroll top center;
        }

        .div6 {
            height: 665px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/b6.jpg')}}') no-repeat scroll top center;
        }

        .center {
            width: 1200px;
            margin: 0 auto;
        }

        .a1 {
            height: 660px;
        }

        .a2, .a4 {
            height: 455px;
        }

        .a3 {
            height: 440px;
        }

        .a5 {
            height: 550px;
        }

    </style>
</head>
<body>
<div class="div1"></div>
<div class="div2">
    <div class="center">
        <a target="_blank" href="/goods?id=18112" class="a1"></a>
    </div>
</div>
<div class="div3">
    <div class="center">
        <a target="_blank" href="/goods?id=18012" class="a2"></a>
    </div>
</div>
<div class="div4">
    <div class="center">
        <a target="_blank" href="/goods?id=18119" class="a3"></a>
    </div>
</div>
<div class="div5">
    <div class="center">
        <a target="_blank" href="/goods?id=6840" class="a4"></a>
    </div>
</div>
<div class="div6">
    <div class="center">
        <a target="_blank" href="/goods?id=18115" class="a5"></a>
    </div>
</div>
</body>
</html>
