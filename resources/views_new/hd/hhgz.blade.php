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
        }

        area {
            outline: none
        }
    </style>
</head>
<body>
<img src="{{get_img_path('images/hd/bxt1.jpg')}}"/>
<img src="{{get_img_path('images/hd/bxt2.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('images/hd/bxt3.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('images/hd/bxt4.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('images/hd/bxt5.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('images/hd/bxt6.jpg')}}" usemap="#map5" id="img5"/>
<map id="map1" name="map1">
    <area target="_blank" href="{{route('goods.index',['id'=>31579])}}" shape="rect" coords=''
          data-coords='{"x1":"1000","y1":"0","x2":"1420","y2":"485","w":"1920","h":"713"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>31580])}}" shape="rect" coords=''
          data-coords='{"x1":"335","y1":"210","x2":"750","y2":"690","w":"1920","h":"713"}'>
</map>
<map id="map2" name="map2">
    <area target="_blank" href="{{route('goods.index',['id'=>31577])}}" shape="rect" coords=''
          data-coords='{"x1":"1000","y1":"0","x2":"1420","y2":"485","w":"1920","h":"753"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>31578])}}" shape="rect" coords=''
          data-coords='{"x1":"335","y1":"210","x2":"750","y2":"700","w":"1920","h":"753"}'>
</map>
<map id="map3" name="map3">
    <area target="_blank" href="{{route('goods.index',['id'=>31575])}}" shape="rect" coords=''
          data-coords='{"x1":"1080","y1":"0","x2":"1600","y2":"650","w":"1920","h":"878"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>31576])}}" shape="rect" coords=''
          data-coords='{"x1":"345","y1":"200","x2":"845","y2":"870","w":"1920","h":"878"}'>
</map>
<map id="map4" name="map4">
    <area target="_blank" href="{{route('goods.index',['id'=>31573])}}" shape="rect" coords=''
          data-coords='{"x1":"1080","y1":"0","x2":"1600","y2":"650","w":"1920","h":"841"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>31574])}}" shape="rect" coords=''
          data-coords='{"x1":"345","y1":"200","x2":"845","y2":"870","w":"1920","h":"878"}'>
</map>
<map id="map5" name="map5">
    <area href="javascript:;" shape="rect" coords=''
          data-coords='{"x1":"820","y1":"0","x2":"1140","y2":"157","w":"1920","h":"157"}'
          onclick="$('body,html').animate({scrollTop:0},500)">
</map>
</body>
<script src="{{path('js/resize.js')}}"></script>
</html>
