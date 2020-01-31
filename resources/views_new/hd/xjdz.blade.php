<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>【合纵医药网&mdash;药易购】</title>
    <script src="{{path('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
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
    </style>
</head>
<body>
<img src="{{get_img_path('images/hd/dazao_01.jpg')}}"/>
<img src="{{get_img_path('images/hd/dazao_02.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('images/hd/dazao_03.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('images/hd/dazao_04.jpg')}}"/>
<img src="{{get_img_path('images/hd/dazao_05.jpg')}}" usemap="#map3" id="img3"/>
<map name="map1" id="map1">
    <area shape="rect" data-coords='{"x1":"390","y1":"550","x2":"965","y2":"1400","w":"1903","h":"1457"}'
          target="_blank" href="{{route('goods.index',['id'=>33647])}}"/>
    <area shape="rect" data-coords='{"x1":"965","y1":"550","x2":"1550","y2":"1400","w":"1903","h":"1457"}'
          target="_blank" href="{{route('goods.index',['id'=>33648])}}"/>
</map>
<map name="map2" id="map2">
    <area shape="rect" data-coords='{"x1":"425","y1":"70","x2":"810","y2":"700","w":"1903","h":"1709"}' target="_blank"
          href="{{route('goods.index',['id'=>33644])}}"/>
    <area shape="rect" data-coords='{"x1":"810","y1":"70","x2":"1160","y2":"700","w":"1903","h":"1709"}'
          target="_blank" href="{{route('goods.index',['id'=>33645])}}"/>
    <area shape="rect" data-coords='{"x1":"1160","y1":"70","x2":"1530","y2":"700","w":"1903","h":"1709"}'
          target="_blank" href="{{route('goods.index',['id'=>33646])}}"/>
</map>
<map name="map3" id="map3">
    <area shape="rect" data-coords='{"x1":"840","y1":"1780","x2":"1100","y2":"1830","w":"1903","h":"1878"}'
          onclick="$('html,body').animate({scrollTop:0})"/>
</map>
<script src="{{path('js/resize.js')}}" type="text/javascript" charset="utf-8"></script>
</body>
</html>
