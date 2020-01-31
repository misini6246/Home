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
            /*outline: none*/
        }
    </style>
</head>
<body>
<img src="{{get_img_path('adimages1/201807/erji/simida1.png')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/simida2.png')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/simida3.png')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/simida4.png')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/simida5.png')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/simida6.png')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201807/erji/simida7.jpg')}}" usemap="#map7" id="img7"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"526","w":"1583","h":"526"}'
          href="{{route('category.index',['step'=>27,'style'=>'g'])}}" coords="0,0,1583,526"/>
</map>
<map name="map2" id="map2">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"1310","y2":"456","w":"1583","h":"456"}'
          href="{{route('goods.index',['id'=>3216])}}" coords="300,0,1310,456"/>
</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"1310","y2":"298","w":"1583","h":"298"}'
          href="{{route('goods.index',['id'=>1106])}}" coords="300,0,1310,298"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"1310","y2":"330","w":"1583","h":"330"}'
          href="{{route('goods.index',['id'=>24757])}}" coords="300,0,1310,330"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"1310","y2":"326","w":"1583","h":"326"}'
          href="{{route('goods.index',['id'=>31273])}}" coords="300,0,1310,326"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"1310","y2":"349","w":"1583","h":"349"}'
          href="{{route('goods.index',['id'=>29424])}}" coords="300,0,1310,349"/>
</map>
<map name="map7" id="map7">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"87","w":"1583","h":"87"}'
          onclick="to_top()" coords="0,0,1583,87"/>
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
