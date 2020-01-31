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
        }

        area {
            outline: none
        }
    </style>
</head>
<body>
<img src="{{get_img_path('images/hd/yabang_1.jpg')}}" style="width: 100%;height: 100%">
<img id="img1" src="{{get_img_path('images/hd/yabang_2.jpg')}}" style="width: 100%;height: 100%" usemap="#map1"
     hidefocus="true">
<img id="img2" src="{{get_img_path('images/hd/yabang_3.jpg')}}" style="width: 100%;height: 100%" usemap="#map2"
     hidefocus="true">
<map id="map1" name="map1">
    <area target="_blank" href="{{route('goods.index',['id'=>19749])}}" shape="rect" coords='256,270,1100,660'
          data-coords='{"x1":"256","y1":"270","x2":"1100","y2":"660","w":"1349","h":"1292"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>19988])}}" shape="rect" coords='256,720,1100,1120'
          data-coords='{"x1":"256","y1":"720","x2":"1100","y2":"1120","w":"1349","h":"1292"}'>
</map>
<map id="map2" name="map2">
    <area target="_blank" href="{{route('goods.index',['id'=>10769])}}" shape="rect" coords='250,215,672,900'
          data-coords='{"x1":"250","y1":"215","x2":"672","y2":"900","w":"1349","h":"1840"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>3661])}}" shape="rect" coords='682,215,1100,900'
          data-coords='{"x1":"682","y1":"215","x2":"1100","y2":"900","w":"1349","h":"1840"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>10716])}}" shape="rect" coords='250,930,672,1650'
          data-coords='{"x1":"250","y1":"930","x2":"672","y2":"1650","w":"1349","h":"1840"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>3139])}}" shape="rect" coords='682,930,1100,1650'
          data-coords='{"x1":"682","y1":"930","x2":"1100","y2":"1650","w":"1349","h":"1840"}'>
</map>
</body>
<script src="{{path('js/resize.js')}}"></script>
</html>
