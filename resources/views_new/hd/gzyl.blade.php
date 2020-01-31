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
<img src="{{get_img_path2('images/hd/yl1.jpg')}}"/>
<img src="{{get_img_path2('images/hd/yl2.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path2('images/hd/yl3.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path2('images/hd/yl4.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path2('images/hd/yl5.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path2('images/hd/yl6.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path2('images/hd/yl7.jpg')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path2('images/hd/yl8.jpg')}}" usemap="#map7" id="img7"/>
<map id="map1" name="map1">
    <area target="_blank" href="{{route('goods.index',['id'=>3440])}}" shape="rect" coords=''
          data-coords='{"x1":"340","y1":"0","x2":"1550","y2":"665","w":"1920","h":"732"}'>
</map>
<map id="map2" name="map2">
    <area target="_blank" href="{{route('goods.index',['id'=>27559])}}" shape="rect" coords=''
          data-coords='{"x1":"360","y1":"0","x2":"1560","y2":"560","w":"1920","h":"627"}'>
</map>
<map id="map3" name="map3">
    <area target="_blank" href="{{route('goods.index',['id'=>3450])}}" shape="rect" coords=''
          data-coords='{"x1":"360","y1":"0","x2":"1560","y2":"560","w":"1920","h":"635"}'>
</map>
<map id="map4" name="map4">
    <area target="_blank" href="{{route('goods.index',['id'=>652])}}" shape="rect" coords=''
          data-coords='{"x1":"360","y1":"0","x2":"1560","y2":"560","w":"1920","h":"632"}'>
</map>
<map id="map5" name="map5">
    <area target="_blank" href="{{route('goods.index',['id'=>682])}}" shape="rect" coords=''
          data-coords='{"x1":"360","y1":"0","x2":"1560","y2":"560","w":"1920","h":"635"}'>
</map>
<map id="map6" name="map6">
    <area target="_blank" href="{{route('goods.index',['id'=>578])}}" shape="rect" coords=''
          data-coords='{"x1":"360","y1":"0","x2":"1560","y2":"560","w":"1920","h":"560"}'>
</map>
<map id="map7" name="map7">
    <area href="javascript:;" shape="rect" coords=''
          data-coords='{"x1":"890","y1":"280","x2":"1240","y2":"380","w":"1920","h":"864"}'
          onclick="$('body,html').animate({scrollTop:0},500)">
</map>
</body>
<script src="{{path('js/resize.js')}}"></script>
</html>
