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
<img src="{{get_img_path('adimages1/201807/erji/jzt1.png')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/jzt2.png')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/jzt3.png')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/jzt4.png')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/jzt5.png')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/jzt6.png')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201807/erji/jzt7.png')}}" usemap="#map7" id="img7"/>
<img src="{{get_img_path('adimages1/201807/erji/jzt8.jpg')}}" usemap="#map8" id="img8"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"707","w":"1583","h":"707"}'
          href="{{route('category.index',['step'=>40,'style'=>'g'])}}" coords="0,0,1583,707"/>
</map>
<map name="map2" id="map2">

</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"630","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>957])}}" coords="300,0,630,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"630","y1":"0","x2":"960","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>4302])}}" coords="630,0,960,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"960","y1":"0","x2":"1310","y2":"470","w":"1583","h":"470"}'
          href="{{route('xiangqing',['id'=>7564])}}" coords="960,0,1310,470"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"630","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>16364])}}" coords="300,0,630,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"630","y1":"0","x2":"960","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>4371])}}" coords="630,0,960,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"960","y1":"0","x2":"1310","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>8809])}}" coords="960,0,1310,470"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"630","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>27465])}}" coords="300,0,630,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"630","y1":"0","x2":"960","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>4498])}}" coords="630,0,960,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"960","y1":"0","x2":"1310","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>844])}}" coords="960,0,1310,470"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"630","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>4600])}}" coords="300,0,630,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"630","y1":"0","x2":"960","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>4657])}}" coords="630,0,960,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"960","y1":"0","x2":"1310","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>4618])}}" coords="960,0,1310,470"/>
</map>
<map name="map7" id="map7">
    <area target="_blank" shape="rect" data-25624='{"x1":"300","y1":"0","x2":"630","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>25624])}}" coords="300,0,630,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"630","y1":"0","x2":"960","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>8441])}}" coords="630,0,960,470"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"960","y1":"0","x2":"1310","y2":"470","w":"1583","h":"470"}'
          href="{{route('goods.index',['id'=>21571])}}" coords="960,0,1310,470"/>
</map>
<map name="map8" id="map8">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"385","w":"1583","h":"385"}'
          onclick="to_top()" coords="0,0,1583,385"/>
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
