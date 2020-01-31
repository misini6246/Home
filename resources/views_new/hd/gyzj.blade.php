<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <style type="text/css">

        * {
            padding: 0;
            margin: 0;
        }

        img {
            display: block;
            border: none;
            width: 100%;
            height: 100%;
        }

        .video_box {
            position: relative;
        }

        .video {
            position: absolute;
            width: 25%;
            height: 84%;
            top: 7%;
            left: 49.7%;
        }

        .flash {
            width: 30%;
            text-align: center;
            color: #fff;
            position: absolute;
            top: 35%;
            left: 35%;
        }
    </style>
</head>

<body>
<img src="{{get_img_path('images/hd/zhijun_1.jpg')}}"/>
<a href="javascript:;"><img src="{{get_img_path('images/hd/zhijun_2.jpg')}}"/></a>
<a href="javascript:;"><img src="{{get_img_path('images/hd/zhijun_3.jpg')}}"/></a>
<img src="{{get_img_path('images/hd/zhijun_5.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('images/hd/zhijun_6.jpg')}}"/>
<img src="{{get_img_path('images/hd/zhijun_7.jpg')}}" onclick="$('html,body').animate({scrollTop:0})"
     style="cursor:pointer;"/>
<map name="map1" id="map1">
    <area shape="rect" data-coords='{"x1":"475","y1":"260","x2":"920","y2":"820","w":"1903","h":"2064"}' target="_blank"
          href="{{route('goods.index',['id'=>764])}}"/>
    <area shape="rect" data-coords='{"x1":"958","y1":"260","x2":"1430","y2":"820","w":"1903","h":"2064"}'
          target="_blank" href="{{route('goods.index',['id'=>765])}}"/>
    <area shape="rect" data-coords='{"x1":"475","y1":"915","x2":"920","y2":"1365","w":"1903","h":"2064"}'
          target="_blank" href="{{route('goods.index',['id'=>1033])}}"/>
    <area shape="rect" data-coords='{"x1":"958","y1":"915","x2":"1430","y2":"1365","w":"1903","h":"2064"}'
          target="_blank" href="{{route('xiangqing',['id'=>683])}}"/>
    <area shape="rect" data-coords='{"x1":"475","y1":"1420","x2":"920","y2":"1870","w":"1903","h":"2064"}'
          target="_blank" href="{{route('goods.index',['id'=>3750])}}"/>
    <area shape="rect" data-coords='{"x1":"958","y1":"1420","x2":"1430","y2":"1870","w":"1903","h":"2064"}'
          target="_blank" href="{{route('goods.index',['id'=>5803])}}"/>
</map>
<script src="{{path('js/resize.js')}}"></script>
</body>

</html>