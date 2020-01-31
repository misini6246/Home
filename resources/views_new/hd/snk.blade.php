<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            position: relative;
        }

        img {
            width: 100%;
            border: none;
            vertical-align: middle;
        }

        #to_top {
            height: 140px;
            width: 400px;
            z-index: 2;
            margin: 0 auto;
            cursor: pointer;
            margin-top: -150px;
            position: relative;
            z-index: 2;
        }
    </style>
</head>

<body>
<img src="{{get_img_path('images/hd/aoli_1.jpg')}}"/>
<img src="{{get_img_path('images/hd/aoli_2.jpg')}}"/>
<img src="{{get_img_path('images/hd/aoli_3.jpg')}}"/>
<a target="_blank" href="{{route('goods.index',['id'=>31500])}}"><img
            src="{{get_img_path('images/hd/aoli_4.jpg')}}"/></a>
<div id="to_top"></div>
<script type="text/javascript">
    window.onload = function () {

        var btn = document.getElementById("to_top");
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