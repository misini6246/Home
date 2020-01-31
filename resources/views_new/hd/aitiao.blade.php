<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>【合纵医药网&mdash;药易购】</title>
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
    </style>
</head>
<body>
<img src="{{get_img_path('adimages1/201806/erji/aitiao_01.jpg')}}"/>
<img src="{{get_img_path('images/hd/aitiao_02.jpg')}}"/>
<a target="_blank" href="{{route('goods.index',['id'=>33404])}}"><img
            src="{{get_img_path('images/hd/aitiao_03.jpg')}}"/></a>
<a target="_blank" href="{{route('goods.index',['id'=>33405])}}"><img
            src="{{get_img_path('images/hd/aitiao_04.jpg')}}"/></a>
<a target="_blank" href="{{route('goods.index',['id'=>33406])}}"><img
            src="{{get_img_path('images/hd/aitiao_05.jpg')}}"/></a>
<a target="_blank" href="{{route('goods.index',['id'=>33407])}}"><img
            src="{{get_img_path('images/hd/aitiao_06.jpg')}}"/></a>
<img src="{{get_img_path('images/hd/aitiao_07.jpg')}}"/>
<img src="{{get_img_path('images/hd/aitiao_08.jpg')}}"/>
<img src="{{get_img_path('images/hd/aitiao_09.jpg')}}" id="to_top"/>
<script type="text/javascript">
    window.onload = function () {

        var btn = document.getElementById("to_top");
        btn.style.cursor = "pointer";
        var clientHeight = document.documentElement.clientHeight;
        var timer = null;
        var isTop = true;

        window.onscroll = function () {
            var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
            if (!isTop) {
                clearInterval(timer);
            }
            isTop = false;

        }
        btn.onclick = function () {

            timer = setInterval(function () {

                var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

                var speed = Math.floor(-scrollTop / 6);
                document.documentElement.scrollTop = document.body.scrollTop = scrollTop + speed;
                isTop = true;

                if (scrollTop == 0) {
                    clearInterval(timer);
                }

            }, 50);
        }

    }
</script>
</body>
</html>
