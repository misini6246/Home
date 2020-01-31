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
<img src="{{get_img_path('adimages1/201807/erji/yili1.png')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/yili2.png')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/yili3.png')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/yili4.png')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/yili5.png')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/yili6.jpg')}}" usemap="#map6" id="img6"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"707","w":"1583","h":"707"}'
          href="{{route('category.index',['step'=>37,'style'=>'g'])}}" coords="0,0,1583,707"/>
</map>
<map name="map2" id="map2">

</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"630","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>3440])}}" coords="300,0,630,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"630","y1":"0","x2":"960","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>33916])}}" coords="630,0,960,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"960","y1":"0","x2":"1310","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>652])}}" coords="960,0,1310,470"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"630","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>32911])}}" coords="300,0,630,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"630","y1":"0","x2":"960","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>3675])}}" coords="630,0,960,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"960","y1":"0","x2":"1310","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>3450])}}" coords="960,0,1310,470"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"630","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>29500])}}" coords="300,0,630,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"630","y1":"0","x2":"960","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>578])}}" coords="630,0,960,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"960","y1":"0","x2":"1310","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>682])}}" coords="960,0,1310,470"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"101","w":"1583","h":"101"}'
          onclick="to_top()" coords="0,0,1583,101"/>
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
