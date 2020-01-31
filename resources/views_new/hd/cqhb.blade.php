<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        img {
            display: block;
            border: none;
        }

        area {
            outline: none
        }
    </style>
</head>
<body>
<img src="{{get_img_path('images/hd/sale_1.jpg')}}" style="width: 100%;height: 100%">
<img id="img1" src="{{get_img_path('images/hd/sale_2.jpg')}}" style="width: 100%;height: 100%" usemap="#map1"
     hidefocus="true">
<img id="img2" src="{{get_img_path('images/hd/sale_3.jpg')}}" style="width: 100%;height: 100%" usemap="#map2"
     hidefocus="true">
<img id="img3" src="{{get_img_path('images/hd/sale_4.jpg')}}" style="width: 100%;height: 100%" usemap="#map3"
     hidefocus="true">
<map id="map1" name="map1">
    <area target="_blank" href="{{route('goods.index',['id'=>4653])}}" shape="rect" coords='320,110,610,460'
          data-coords='{"x1":"320","y1":"110","x2":"610","y2":"460","w":"1349","h":"910"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>3959])}}" shape="rect" coords='735,110,1030,460'
          data-coords='{"x1":"735","y1":"110","x2":"1030","y2":"460","w":"1349","h":"910"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>1091])}}" shape="rect" coords='320,540,610,890'
          data-coords='{"x1":"320","y1":"540","x2":"610","y2":"890","w":"1349","h":"910"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>30846])}}" shape="rect" coords='735,540,1030,890'
          data-coords='{"x1":"735","y1":"540","x2":"1030","y2":"890","w":"1349","h":"910"}'>
</map>
<map id="map2" name="map2">
    <area target="_blank" href="{{route('goods.index',['id'=>15079])}}" shape="rect" coords='320,90,610,480'
          data-coords='{"x1":"320","y1":"90","x2":"610","y2":"480","w":"1349","h":"965"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>1021])}}" shape="rect" coords='735,90,1030,480'
          data-coords='{"x1":"735","y1":"90","x2":"1030","y2":"480","w":"1349","h":"965"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>4701])}}" shape="rect" coords='320,520,610,910'
          data-coords='{"x1":"320","y1":"520","x2":"610","y2":"910","w":"1349","h":"965"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>4714])}}" shape="rect" coords='735,520,1030,910'
          data-coords='{"x1":"735","y1":"520","x2":"1030","y2":"910","w":"1349","h":"965"}'>
</map>
<map id="map3" name="map3">
    <area target="_blank" href="{{route('goods.index',['id'=>4460])}}" shape="rect" coords='320,70,610,480'
          data-coords='{"x1":"320","y1":"70","x2":"610","y2":"480","w":"1349","h":"683"}'>
    <area target="_blank" href="{{route('goods.index',['id'=>26421])}}" shape="rect" coords='735,70,1030,480'
          data-coords='{"x1":"735","y1":"70","x2":"1030","y2":"480","w":"1349","h":"683"}'>
    <area onclick="rt()" shape="rect" coords='320,550,1030,800'
          data-coords='{"x1":"320","y1":"550","x2":"1030","y2":"800","w":"1349","h":"683"}'>
</map>
</body>
<script src="{{path('js/resize.js')}}"></script>
<script>
    function rt() {
        var d = document,
            dd = document.documentElement,
            db = document.body,
            top = dd.scrollTop || db.scrollTop,
            step = Math.floor(top / 20);
        (function () {
            top -= step;
            if (top > -step) {
                dd.scrollTop == 0 ? db.scrollTop = top : dd.scrollTop = top;
                setTimeout(arguments.callee, 20);
            }
        })();
    }
</script>
</html>
