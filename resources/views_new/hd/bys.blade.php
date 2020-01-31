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
<img src="{{get_img_path('adimages1/201808/erji/bys1.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201808/erji/bys2.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201808/erji/bys3.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201808/erji/bys4.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201808/erji/bys5.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201808/erji/bys6.jpg')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201808/erji/bys7.jpg')}}" usemap="#map7" id="img7"/>
<img src="{{get_img_path('adimages1/201808/erji/bys8.jpg')}}" usemap="#map8" id="img8"/>
<map name="map1" id="map1">

</map>
<map name="map2" id="map2">

</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"1285","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>18112])}}" coords="300,0,1285,618"/>
</map>
<map name="map4" id="map4">

</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"620","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>26321])}}" coords="300,0,620,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"620","y1":"0","x2":"970","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>18119])}}" coords="620,0,970,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"970","y1":"0","x2":"1285","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>16803])}}" coords="970,0,1285,618"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"620","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>18012])}}" coords="300,0,620,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"620","y1":"0","x2":"970","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>6840])}}" coords="620,0,970,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"970","y1":"0","x2":"1285","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>15679])}}" coords="970,0,1285,618"/>
</map>
<map name="map7" id="map7">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"620","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>18115])}}" coords="300,0,620,618"/>
</map>
<map name="map8" id="map8">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"130","w":"1583","h":"130"}'
          onclick="to_top()" coords="0,0,1583,130"/>
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
