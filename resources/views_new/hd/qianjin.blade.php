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
<img src="{{get_img_path('adimages1/201807/erji/qianjin1.jpg')}}1" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/qianjin2.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/qianjin3.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/qianjin4.jpg')}}1" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/qianjin5.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/qianjin6.jpg')}}" usemap="#map6" id="img6"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"664","w":"1583","h":"664"}'
          href="{{route('category.index',['step'=>34,'style'=>'g'])}}" coords="0,0,1583,664"/>
</map>
<map name="map2" id="map2">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"780","y2":"653","w":"1583","h":"653"}'
          href="{{route('goods.index',['id'=>17940])}}" coords="0,0,780,653"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"780","y1":"0","x2":"1280","y2":"653","w":"1583","h":"653"}'
          href="{{route('goods.index',['id'=>18101])}}" coords="780,0,1280,653"/>
</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"780","y2":"445","w":"1583","h":"445"}'
          href="{{route('goods.index',['id'=>18054])}}" coords="0,0,780,445"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"780","y1":"0","x2":"1280","y2":"445","w":"1583","h":"445"}'
          href="{{route('goods.index',['id'=>7947])}}" coords="780,0,1280,445"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"780","y2":"383","w":"1583","h":"383"}'
          href="{{route('goods.index',['id'=>8448])}}" coords="0,0,780,383"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"780","y1":"0","x2":"1280","y2":"383","w":"1583","h":"383"}'
          href="{{route('goods.index',['id'=>8443])}}" coords="780,0,1280,383"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"780","y2":"388","w":"1583","h":"388"}'
          href="{{route('goods.index',['id'=>1141])}}" coords="0,0,790,388"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"151","w":"1583","h":"151"}'
          onclick="to_top()" coords="0,0,1583,151"/>
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
