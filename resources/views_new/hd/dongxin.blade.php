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
<img src="{{get_img_path('adimages1/201808/erji/dongxin1.jpg')}}1" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin2.jpg')}}1" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin3.jpg')}}1" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin4.jpg')}}1" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin5.jpg')}}1" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin6.jpg')}}1" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin7.jpg')}}1" usemap="#map7" id="img7"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin8.jpg')}}1" usemap="#map8" id="img8"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin9.jpg')}}1" usemap="#map9" id="img9"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin10.jpg')}}1" usemap="#map10" id="img10"/>
<img src="{{get_img_path('adimages1/201808/erji/dongxin11.jpg')}}" usemap="#map11" id="img11"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"765","w":"1583","h":"765"}'
          href="{{route('category.index',['step'=>48,'style'=>'g'])}}" coords="0,0,1583,765"/>
</map>
<map name="map2" id="map2">

</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"220","y1":"0","x2":"580","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>22056])}}" coords="220,0,580,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"580","y1":"0","x2":"1000","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>13548])}}" coords="580,0,1000,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"1000","y1":"0","x2":"1400","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>8371])}}" coords="1000,0,1400,618"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"220","y1":"0","x2":"580","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>35704])}}" coords="220,0,580,618"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"220","y1":"0","x2":"580","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>3798])}}" coords="220,0,580,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"580","y1":"0","x2":"1000","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>3273])}}" coords="580,0,1000,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"1000","y1":"0","x2":"1400","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>6271])}}" coords="1000,0,1400,618"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"220","y1":"0","x2":"580","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>6752])}}" coords="220,0,580,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"580","y1":"0","x2":"1000","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>13272])}}" coords="580,0,1000,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"1000","y1":"0","x2":"1400","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>3606])}}" coords="1000,0,1400,618"/>
</map>
<map name="map7" id="map7">
    <area target="_blank" shape="rect" data-coords='{"x1":"220","y1":"0","x2":"580","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>3167])}}" coords="220,0,580,618"/>
</map>
<map name="map8" id="map8">
    <area target="_blank" shape="rect" data-coords='{"x1":"220","y1":"0","x2":"580","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>35135])}}" coords="220,0,580,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"580","y1":"0","x2":"1000","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>35359])}}" coords="580,0,1000,618"/>
</map>
<map name="map9" id="map9">
    <area target="_blank" shape="rect" data-coords='{"x1":"220","y1":"0","x2":"580","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>6271])}}" coords="220,0,580,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"580","y1":"0","x2":"1000","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>193])}}" coords="580,0,1000,618"/>
</map>
<map name="map10" id="map10">
    <area target="_blank" shape="rect" data-coords='{"x1":"220","y1":"0","x2":"580","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>8374])}}" coords="220,0,580,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"580","y1":"0","x2":"1000","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>32865])}}" coords="580,0,1000,618"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"1000","y1":"0","x2":"1400","y2":"618","w":"1583","h":"618"}'
          href="{{route('goods.index',['id'=>8373])}}" coords="1000,0,1400,618"/>
</map>
<map name="map11" id="map11">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"224","w":"1583","h":"224"}'
          onclick="to_top()" coords="0,0,1583,224"/>
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
