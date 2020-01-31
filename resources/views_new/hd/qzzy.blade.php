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
<img src="{{get_img_path('adimages1/201808/erji/qzzy1.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201808/erji/qzzy2.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201808/erji/qzzy3.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201808/erji/qzzy4.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201808/erji/qzzy5.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201808/erji/qzzy6.jpg')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201808/erji/qzzy7.jpg')}}" usemap="#map7" id="img7"/>
<map name="map1" id="map1">

</map>
<map name="map2" id="map2">

</map>
<map name="map3" id="map3">

</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"200","y1":"0","x2":"800","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>31288])}}" coords="200,0,800,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"800","y1":"0","x2":"1500","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>3814])}}" coords="800,0,1500,618"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"200","y1":"0","x2":"800","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>20188])}}" coords="200,0,800,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"800","y1":"0","x2":"1500","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>9008])}}" coords="800,0,1500,618"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"200","y1":"0","x2":"800","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>20189])}}" coords="200,0,800,618"/>
</map>
<map name="map7" id="map7">
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
