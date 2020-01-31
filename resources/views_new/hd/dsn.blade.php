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

        area {
            outline: none
        }
    </style>
</head>
<body>
<img src="{{get_img_path('images/hd/disainuo_1.jpg')}}" hidefocus="true">
<img id="img1" src="{{get_img_path('images/hd/disainuo_2.jpg')}}" usemap="#map1"
     hidefocus="true">
<img src="{{get_img_path('images/hd/disainuo_3.jpg')}}" hidefocus="true">
<map id="map1" name="map1">
    <area shape="rect" data-coords='{"x1":"230","y1":"25","x2":"1700","y2":"400","w":"1903","h":"990"}'
          href="{{route('goods.index',['id'=>1130])}}" target="_blank"
          coords="230,25,1700,400"/>
</map>
</body>
<script src="{{path('js/resize.js')}}"></script>
</html>
