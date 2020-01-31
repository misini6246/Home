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
<img src="{{get_img_path('adimages1/201807/erji/dinuo1.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/dinuo2.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/dinuo3.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/dinuo4.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/dinuo5.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/dinuo6.jpg')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201807/erji/dinuo7.jpg')}}" usemap="#map7" id="img7"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"454","w":"1583","h":"454"}'
          href="{{route('category.index',['step'=>33,'style'=>'g'])}}" coords="0,0,1583,454"/>
</map>
<map name="map2" id="map2">

</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"290","y1":"0","x2":"620","y2":"458","w":"1583","h":"458"}'
          href="{{route('goods.index',['id'=>20792])}}" coords="290,0,620,458"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"620","y1":"0","x2":"950","y2":"458","w":"1583","h":"458"}'
          href="{{route('goods.index',['id'=>15481])}}" coords="620,0,950,458"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"0","x2":"1270","y2":"458","w":"1583","h":"458"}'
          href="{{route('goods.index',['id'=>10752])}}" coords="950,0,1270,458"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"290","y1":"0","x2":"620","y2":"408","w":"1583","h":"408"}'
          href="{{route('goods.index',['id'=>20369])}}" coords="290,0,620,408"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"620","y1":"0","x2":"950","y2":"408","w":"1583","h":"408"}'
          href="{{route('goods.index',['id'=>20367])}}" coords="620,0,950,408"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"0","x2":"1270","y2":"408","w":"1583","h":"408"}'
          href="{{route('goods.index',['id'=>20366])}}" coords="950,0,1270,408"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"290","y1":"0","x2":"620","y2":"330","w":"1583","h":"330"}'
          href="{{route('goods.index',['id'=>19524])}}" coords="290,0,620,330"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"620","y1":"0","x2":"950","y2":"330","w":"1583","h":"330"}'
          href="{{route('goods.index',['id'=>20788])}}" coords="620,0,950,330"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"950","y1":"0","x2":"1270","y2":"330","w":"1583","h":"330"}'
          href="{{route('goods.index',['id'=>6786])}}" coords="950,0,1270,330"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"290","y1":"0","x2":"620","y2":"435","w":"1583","h":"435"}'
          href="{{route('goods.index',['id'=>20370])}}" coords="290,0,620,435"/>
</map>
<map name="map7" id="map7">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"152","w":"1583","h":"152"}'
          onclick="to_top()" coords="0,0,1583,152"/>
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
