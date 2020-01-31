<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
        }

        a {
            display: inline-block;
            outline: none;
        }

        .img2 div,
        .img3 div {
            width: 1200px;
            margin: 0 auto;
            position: relative;

        }

        .img2 div {
            height: 1513px;
        }

        .img3 div {
            height: 708px;
        }

        .img2 > div > .btn-left-1 {
            width: 760px;
            height: 220px;

            position: absolute;
            bottom: 377px;
            left: 217px;
        }

        .img2 > div > .btn-left-2 {
            width: 760px;
            height: 220px;

            position: absolute;
            bottom: 75px;
            left: 217px;
        }

        .img3 > div > .btn-left {
            width: 760px;
            height: 220px;

            position: absolute;
            bottom: 400px;
            left: 217px;
        }

        .img3 > div > .btn-right {
            width: 760px;
            height: 220px;

            position: absolute;
            bottom: 112px;
            left: 217px;
        }

        .btn-top {
            width: 900px;
            height: 460px;
            position: absolute;
            top: 127px;
            left: 150px;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="img1"
         style="background: url('{{get_img_path('images/diyan-1.jpg')}}') no-repeat scroll top center;height: 1068px;min-width: 1200px;">
    </div>
    <div class="img2"
         style="background: url('{{get_img_path('images/diyan-2.jpg')}}') no-repeat scroll top center;height: 1513px;min-width: 1200px;">
        <div>
            <a target="_blank" href="/goods?id=25405" class="btn-left-1"></a>
            <a target="_blank" href="/goods?id=25334" class="btn-left-2"></a>
            <a target="_blank" href="/goods?id=2185" class="btn-top"></a>
        </div>
    </div>
    <div class="img3"
         style="background: url('{{get_img_path('images/diyan-3.jpg')}}') no-repeat scroll top center;height: 708px;min-width: 1200px;">
        <div>
            <a target="_blank" href="/goods?id=4311" class="btn-left"></a>
            <a target="_blank" href="/goods?id=4195" class="btn-right"></a>
        </div>
    </div>

</div>

</body>

</html>