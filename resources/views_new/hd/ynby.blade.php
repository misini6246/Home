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
<img src="{{get_img_path('adimages1/201807/erji/ynby1.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby2.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby3.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby4.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby5.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby6.jpg')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby7.jpg')}}" usemap="#map7" id="img7"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby8.jpg')}}" usemap="#map8" id="img8"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby9.jpg')}}" usemap="#map9" id="img9"/>
<img src="{{get_img_path('adimages1/201807/erji/ynby10.jpg')}}" usemap="#map10" id="img10"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"765","w":"1583","h":"765"}'
          href="{{route('category.index',['step'=>7,'style'=>'g'])}}" coords="0,0,1583,765"/>
</map>
<map name="map2" id="map2">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"640","y2":"584","w":"1583","h":"584"}'
          href="{{route('goods.index',['id'=>1148])}}" coords="300,0,640,584"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"640","y1":"0","x2":"950","y2":"584","w":"1583","h":"584"}'
          href="{{route('goods.index',['id'=>3780])}}" coords="640,0,950,584"/>
</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"640","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>3497])}}" coords="300,0,640,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"640","y1":"0","x2":"950","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>4254])}}" coords="640,0,950,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"0","x2":"1285","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>7908])}}" coords="950,0,1285,618"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"640","y2":"600","w":"1583","h":"600"}'
          href="{{route('goods.index',['id'=>1113])}}" coords="300,0,640,600"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"640","y1":"0","x2":"950","y2":"600","w":"1583","h":"600"}'
          href="{{route('xiangqing',['id'=>4530])}}" coords="640,0,950,600"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"640","y2":"560","w":"1583","h":"560"}'
          href="{{route('goods.index',['id'=>4004])}}" coords="300,0,640,560"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"640","y1":"0","x2":"950","y2":"560","w":"1583","h":"560"}'
          href="{{route('goods.index',['id'=>4189])}}" coords="640,0,950,560"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"0","x2":"1285","y2":"560","w":"1583","h":"560"}'
          href="{{route('goods.index',['id'=>15680])}}" coords="950,0,1285,560"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"640","y2":"435","w":"1583","h":"435"}'
          href="{{route('goods.index',['id'=>21568])}}" coords="300,0,640,435"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"640","y1":"0","x2":"950","y2":"435","w":"1583","h":"435"}'
          href="{{route('goods.index',['id'=>20926])}}" coords="640,0,950,435"/>
</map>
<map name="map7" id="map7">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"640","y2":"500","w":"1583","h":"500"}'
          href="{{route('goods.index',['id'=>3159])}}" coords="300,0,640,500"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"640","y1":"0","x2":"950","y2":"500","w":"1583","h":"500"}'
          href="{{route('goods.index',['id'=>17100])}}" coords="640,0,950,500"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"0","x2":"1285","y2":"500","w":"1583","h":"500"}'
          href="{{route('goods.index',['id'=>1095])}}" coords="950,0,1285,500"/>
</map>
<map name="map8" id="map8">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"640","y2":"416","w":"1583","h":"416"}'
          href="{{route('goods.index',['id'=>4230])}}" coords="300,0,640,416"/>
</map>
<map name="map9" id="map9">
    <area target="_blank" shape="rect" data-coords='{"x1":"300","y1":"0","x2":"640","y2":"621","w":"1583","h":"621"}'
          href="{{route('goods.index',['id'=>3932])}}" coords="300,0,640,621"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"640","y1":"0","x2":"950","y2":"621","w":"1583","h":"621"}'
          href="{{route('goods.index',['id'=>4660])}}" coords="640,0,950,621"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"0","x2":"1285","y2":"621","w":"1583","h":"621"}'
          href="{{route('goods.index',['id'=>27270])}}" coords="950,0,1285,621"/>
</map>
<map name="map10" id="map10">
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
