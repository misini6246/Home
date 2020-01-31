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
<img src="{{get_img_path('adimages1/201809/erji/hydj1.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201809/erji/hydj2.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201809/erji/hydj3.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201809/erji/hydj4.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201809/erji/hydj5.jpg')}}" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201809/erji/hydj6.jpg')}}1" usemap="#map6" id="img6"/>
<map name="map1" id="map1">

</map>
<map name="map2" id="map2">

</map>
<map name="map3" id="map3">

</map>
<map name="map4" id="map4">

</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect"
          data-coords='{"x1":"1240","y1":"340","x2":"1450","y2":"400","w":"1583","h":"624"}'
          href="{{route('member.hongbao_money_log')}}" coords="800,0,1500,618"/>
</map>
<map name="map6" id="map6">

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
