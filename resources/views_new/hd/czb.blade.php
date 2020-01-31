<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>嘉年华第一波提前冲弹-{{config('services.web.title')}}</title>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        img {
            display: block;
            border: none;
            width: 100%;
        }

        area {
            outline: none
        }
    </style>
</head>
<body>
<img id="img1" src="{{get_img_path('images/hd/czfq1.jpg')}}" usemap="#map1"
     hidefocus="true">
<map id="map1" name="map1">
    <area target="_blank" href="{{route('goods.index',['id'=>22207])}}" shape="rect" coords='620,620,740,670'
          data-coords='{"x1":"620","y1":"620","x2":"740","y2":"670","w":"1349","h":"703"}'>
</map>
</body>
<script src="{{path('js/resize.js')}}"></script>
</html>
