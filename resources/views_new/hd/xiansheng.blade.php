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
<img src="{{get_img_path('adimages1/201807/erji/xiansheng1.jpg')}}1" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/xiansheng2.jpg')}}"/>
<img src="{{get_img_path('adimages1/201807/erji/xiansheng3.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/xianshen4.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/xiansheng5.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/xiansheng6.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/xiansheng7.jpg')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201807/erji/xiansheng8.jpg')}}" usemap="#map7" id="img7"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"315","y1":"0","x2":"1225","y2":"489","w":"1583","h":"489"}'
          href="{{route('goods.index',['id'=>6874])}}" coords="315,0,1225,489"/>
</map>
<map name="map2" id="map2">
    <area target="_blank" shape="rect" data-coords='{"x1":"315","y1":"0","x2":"1225","y2":"510","w":"1583","h":"510"}'
          href="{{route('goods.index',['id'=>5326])}}" coords="315,0,1225,510"/>
</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"315","y1":"0","x2":"780","y2":"521","w":"1583","h":"521"}'
          href="{{route('goods.index',['id'=>6874])}}" coords="0,0,780,521"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"780","y1":"0","x2":"1225","y2":"521","w":"1583","h":"521"}'
          href="{{route('goods.index',['id'=>5041])}}" coords="780,0,1225,521"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"315","y1":"0","x2":"780","y2":"521","w":"1583","h":"521"}'
          href="{{route('goods.index',['id'=>34451])}}" coords="0,0,780,521"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"780","y1":"0","x2":"1225","y2":"521","w":"1583","h":"521"}'
          href="{{route('goods.index',['id'=>34459])}}" coords="780,0,1225,521"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"315","y1":"0","x2":"780","y2":"521","w":"1583","h":"521"}'
          href="{{route('goods.index',['id'=>8186])}}" coords="0,0,780,521"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"780","y1":"0","x2":"1225","y2":"521","w":"1583","h":"521"}'
          href="{{route('goods.index',['id'=>30740])}}" coords="780,0,1225,521"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"315","y1":"0","x2":"780","y2":"521","w":"1583","h":"521"}'
          href="{{route('goods.index',['id'=>30736])}}" coords="0,0,780,521"/>
</map>
<map name="map7" id="map7">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"95","w":"1583","h":"95"}'
          onclick="to_top()" coords="0,0,1583,95"/>
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
