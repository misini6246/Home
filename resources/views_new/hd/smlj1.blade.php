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
            vertical-align: middle;
            border: 0;
            width: 100%;
        }
    </style>
</head>
<body>
<a target="_blank" href="{{route('goods.index',['id'=>25911])}}">
    <img src="{{get_img_path('adimages1/201807/erji/slmj1.jpg')}}"/>
</a>
<img src="{{get_img_path('adimages1/201807/erji/slmj2.jpg')}}"/>
<img src="{{get_img_path('adimages1/201807/erji/slmj3.jpg')}}"/>
<img src="{{get_img_path('adimages1/201807/erji/slmj4.jpg')}}"/>
<img src="{{get_img_path('adimages1/201807/erji/slmj5.jpg')}}"/>
<a target="_blank" href="{{route('goods.index',['id'=>25911])}}">
    <img src="{{get_img_path('adimages1/201807/erji/slmj6.jpg')}}"/>
</a>
<a target="_blank" href="{{route('goods.index',['id'=>25911])}}">
    <img src="{{get_img_path('adimages1/201807/erji/slmj7.jpg')}}"/>
</a>
<a target="_blank" href="{{route('goods.index',['id'=>25911])}}">
    <img src="{{get_img_path('adimages1/201807/erji/slmj8.jpg')}}"/>
</a>
<script type="text/javascript">
    window.onload = function () {

        var btn = document.getElementById("to_top");
        btn.style.cursor = "pointer"
        var clientHeight = document.documentElement.clientHeight;
        var timer = null;
        var isTop = true;

        window.onscroll = function () {
            var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;

            btn.style.display = scrollTop >= clientHeight ? "block" : "none";

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
