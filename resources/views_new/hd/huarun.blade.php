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
<img src="{{get_img_path('images/hd/huarun_1.jpg')}}">
<img src="{{get_img_path('images/hd/huarun_2.jpg')}}">
<img id="img1" src="{{get_img_path('images/hd/huarun_3.jpg')}}" usemap="#map1"
     hidefocus="true">
<map id="map1" name="map1">
    <area target="_blank" href="{{route('goods.index',['id'=>30750])}}" shape="rect" coords='256,720,1100,1120'
          data-coords='{"x1":"464","y1":"510","x2":"1425","y2":"1000","w":"1903","h":"990"}'>
</map>
</body>
<script src="{{path('js/resize.js')}}"></script>
</html>
