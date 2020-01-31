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
<img src="{{get_img_path('adimages1/201807/erji/zmsk1.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/201807/erji/zmsk2.jpg')}}"/>
<img src="{{get_img_path('adimages1/201807/erji/zmsk3.jpg')}}0" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/201807/erji/zmsk4.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/201807/erji/zmsk5.jpg')}}" usemap="#map4" id="img4"/>
<img src="{{get_img_path('adimages1/201807/erji/zmsk6.jpg')}}1" usemap="#map5" id="img5"/>
<img src="{{get_img_path('adimages1/201807/erji/zmsk7.jpg')}}" usemap="#map6" id="img6"/>
<img src="{{get_img_path('adimages1/201807/erji/zmsk8.jpg')}}" usemap="#map7" id="img7"/>
<map name="map1" id="map1">
    <area target="_blank" shape="rect" data-coords='{"x1":"340","y1":"0","x2":"1245","y2":"646","w":"1583","h":"646"}'
          href="{{route('category.index',['step'=>4,'style'=>'g'])}}" coords="340,0,1245,646"/>
</map>
<map name="map2" id="map2">
    <area target="_blank" shape="rect" data-coords='{"x1":"340","y1":"115","x2":"565","y2":"475","w":"1583","h":"878"}'
          href="{{route('goods.index',['id'=>12271])}}" coords="340,115,565,475"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"565","y1":"115","x2":"792","y2":"475","w":"1583","h":"878"}'
          href="{{route('goods.index',['id'=>10863])}}" coords="565,115,792,475"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"792","y1":"115","x2":"1020","y2":"475","w":"1583","h":"878"}'
          href="{{route('goods.index',['id'=>14452])}}" coords="792,115,1020,475"/>
    <area target="_blank" shape="rect"
          data-coords='{"x1":"1020","y1":"115","x2":"1245","y2":"475","w":"1583","h":"878"}'
          href="{{route('goods.index',['id'=>12271])}}" coords="1020,115,1245,475"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"340","y1":"475","x2":"565","y2":"850","w":"1583","h":"878"}'
          href="{{route('goods.index',['id'=>4639])}}" coords="340,475,565,850"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"565","y1":"475","x2":"792","y2":"850","w":"1583","h":"878"}'
          href="{{route('goods.index',['id'=>1126])}}" coords="565,475,792,850"/>
</map>
<map name="map3" id="map3">
    <area target="_blank" shape="rect" data-coords='{"x1":"340","y1":"125","x2":"565","y2":"500","w":"1583","h":"911"}'
          href="{{route('goods.index',['id'=>15074])}}" coords="340,125,565,500"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"565","y1":"125","x2":"790","y2":"500","w":"1583","h":"911"}'
          href="{{route('xiangqing',['id'=>10865])}}" coords="565,125,790,500"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"790","y1":"125","x2":"1015","y2":"500","w":"1583","h":"911"}'
          href="{{route('goods.index',['id'=>15500])}}" coords="790,125,1015,500"/>
    <area target="_blank" shape="rect"
          data-coords='{"x1":"1015","y1":"125","x2":"1240","y2":"500","w":"1583","h":"911"}'
          href="{{route('goods.index',['id'=>10869])}}" coords="1015,125,1240,500"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"340","y1":"500","x2":"565","y2":"875","w":"1583","h":"911"}'
          href="{{route('goods.index',['id'=>9062])}}" coords="340,500,565,875"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"565","y1":"500","x2":"790","y2":"875","w":"1583","h":"911"}'
          href="{{route('goods.index',['id'=>9061])}}" coords="565,500,790,875"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"790","y1":"500","x2":"1015","y2":"875","w":"1583","h":"911"}'
          href="{{route('goods.index',['id'=>9063])}}" coords="790,500,1015,875"/>
</map>
<map name="map4" id="map4">
    <area target="_blank" shape="rect" data-coords='{"x1":"340","y1":"120","x2":"565","y2":"495","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>5007])}}" coords="340,120,565,495"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"565","y1":"120","x2":"790","y2":"495","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>17183])}}" coords="565,120,790,495"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"790","y1":"120","x2":"1015","y2":"495","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>10870])}}" coords="790,120,1015,495"/>
    <area target="_blank" shape="rect"
          data-coords='{"x1":"1015","y1":"120","x2":"1240","y2":"495","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>4695])}}" coords="1015,120,1240,495"/>
</map>
<map name="map5" id="map5">
    <area target="_blank" shape="rect" data-coords='{"x1":"340","y1":"120","x2":"565","y2":"495","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>10872])}}" coords="340,120,565,495"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"565","y1":"120","x2":"790","y2":"495","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>24449])}}" coords="565,120,790,495"/>
    <area target="_blank" shape="rect" data-coords='{"x1":"790","y1":"120","x2":"1015","y2":"495","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>10874])}}" coords="790,120,1015,495"/>
    <area target="_blank" shape="rect"
          data-coords='{"x1":"1015","y1":"120","x2":"1240","y2":"495","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>10875])}}" coords="1015,120,1240,495"/>
</map>
<map name="map6" id="map6">
    <area target="_blank" shape="rect" data-coords='{"x1":"340","y1":"130","x2":"565","y2":"520","w":"1583","h":"534"}'
          href="{{route('goods.index',['id'=>18036])}}" coords="340,130,565,520"/>
</map>
<map name="map7" id="map7">
    <area target="_blank" shape="rect" data-coords='{"x1":"0","y1":"0","x2":"1583","y2":"302","w":"1583","h":"302"}'
          onclick="to_top()" coords="0,0,1583,302"/>
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
