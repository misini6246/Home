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
<img src="{{get_img_path('images/hd/1023_1.jpg')}}"/>
<img src="{{get_img_path('images/hd/1023_2.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('images/hd/1023_3.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('images/hd/1023_4.jpg')}}" usemap="#map3" id="img3"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"450","y1":"110","x2":"950","y2":"750","w":"1903","h":"990"}'
          href="{{route('goods.index',['id'=>2187])}}" coords="450,110,950,750"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"110","x2":"1450","y2":"750","w":"1903","h":"990"}'
          href="{{route('goods.index',['id'=>3425])}}" coords="950,110,1450,750"/>
</map>
<map name="map2" id="map2">
    <area target="_blank" shape="rect" data-coords='{"x1":"450","y1":"20","x2":"950","y2":"750","w":"1903","h":"990"}'
          href="{{route('goods.index',['id'=>23414])}}"
          coords="450,20,950,750"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"20","x2":"1450","y2":"750","w":"1903","h":"990"}'
          href="{{route('goods.index',['id'=>4562])}}"
          coords="950,20,1450,750"/>
</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"470","y1":"20","x2":"970","y2":"850","w":"1903","h":"990"}'
          href="{{route('goods.index',['id'=>1102])}}"
          coords="470,20,970,850"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"970","y1":"20","x2":"1450","y2":"850","w":"1903","h":"990"}'
          href="{{route('xiangqing',['id'=>748])}}"
          coords="970,20,1450,850"/>
</map>
</body>
<script src="{{path('js/resize.js')}}"></script>
</html>
