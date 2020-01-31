<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <style type="text/css">
        *{
            padding: 0;
            margin: 0;
        }
        #div1{
            height: 1889px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/renshen_1.jpg')}}') no-repeat scroll top center;
        }
        #div2{
            height: 1366px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/renshen_2.jpg')}}') no-repeat scroll top center;
        }
        #div3{
            height: 3245px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/renshen_3.jpg')}}') no-repeat scroll top center;
        }
        a{
            display: inline-block;
        }
        .center{
            width: 1200px;
            margin: 0 auto;
        }
        .center a{
            width: 1200px;
            height: 445px;
        }
    </style>
</head>
<body>
<div id="div1">

</div>
<div id="div2">
    <div class="center">
        <a target="_blank" href="/goods?id=23763"></a>
        <a target="_blank" href="/goods?id=23765"></a>
        <a target="_blank" href="/goods?id=23766"></a>
    </div>
</div>
<div id="div3">

</div>
</body>
</html>
