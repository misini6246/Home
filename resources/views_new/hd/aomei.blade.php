<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif"/>
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
<img src="{{get_img_path('adimages1/201807/erji/aomei1.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/aomei2.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/aomei3.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/aomei4.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/aomei5.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/aomei6.jpg')}}" usemap="#map6" id="img6"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"798","w":"1583","h":"798"}'
          href="{{route('category.index',['step'=>26,'style'=>'g'])}}" coords="0,0,1583,798"/>
</map>
<map name="map2" id="map2">
    <area target="_blank" shape="rect" data-coords='{"x1":"330","y1":"0","x2":"660","y2":"482","w":"1583","h":"482"}'
          href="{{route('goods.index',['id'=>27064])}}" coords="330,0,660,482"/>
</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"330","y1":"0","x2":"660","y2":"494","w":"1583","h":"494"}'
          href="{{route('goods.index',['id'=>27391])}}" coords="330,0,660,494"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"330","y1":"0","x2":"660","y2":"505","w":"1583","h":"505"}'
          href="{{route('goods.index',['id'=>9230])}}" coords="330,0,660,505"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"660","y1":"0","x2":"981","y2":"505","w":"1583","h":"505"}'
          href="{{route('goods.index',['id'=>32489])}}" coords="660,0,981,505"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"330","y1":"0","x2":"660","y2":"495","w":"1583","h":"495"}'
          href="{{route('goods.index',['id'=>9216])}}" coords="330,0,660,495"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"660","y1":"0","x2":"981","y2":"495","w":"1583","h":"495"}'
          href="{{route('goods.index',['id'=>27299])}}" coords="660,0,981,495"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"981","y1":"0","x2":"1310","y2":"495","w":"1583","h":"495"}'
          href="{{route('goods.index',['id'=>28600])}}" coords="981,0,1310,495"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"261","w":"1583","h":"261"}'
          onclick="to_top()" coords="0,0,1583,261"/>
</map>
<script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
<script src="{{path('js/resize.js')}}"></script>
<script>
    function to_top() {
        $("html,body").animate({
            scrollTop: 0
        });
    }
</script>
<script>
</script>
</body>
</html>
