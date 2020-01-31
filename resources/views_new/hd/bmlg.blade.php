<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
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
<img src="{{get_img_path('bmlg.jpg')}}1" usemap="#map1" id="img1"/>
<map name="map1" id="map1">

</map>
<map name="map2" id="map2">

</map>
<map name="map3" id="map3">
</map>
<map name="map4" id="map4">

</map>
<map name="map5" id="map5">

</map>
<map name="map6" id="map6">

</map>
<map name="map7" id="map7">

</map>
<map name="map8" id="map8">

</map>
<map name="map9" id="map9">
</map>
<map name="map10" id="map10">


</map>
<map name="map11" id="map11">

</map>
<map name="map12" id="map12">

</map>
<map name="map13" id="map13">
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
