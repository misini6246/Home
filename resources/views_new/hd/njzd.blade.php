<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
        }

        img {
            vertical-align: middle;
            border: none;
            width: 100%;
        }

        #to_top {
            cursor: pointer;
        }
    </style>
</head>

<body>
<img src="{{get_img_path('images/hd/njzhongda_1.jpg')}}"/>
<a target="_blank" href="{{route('goods.index',['id'=>25203])}}">
    <img src="{{get_img_path('images/hd/njzhongda_2.jpg')}}"/>
</a>
<a target="_blank" href="{{route('goods.index',['id'=>14034])}}">
    <img src="{{get_img_path('images/hd/njzhongda_3.jpg')}}"/>
</a>
<a target="_blank" href="{{route('goods.index',['id'=>25852])}}">
    <img src="{{get_img_path('images/hd/njzhongda_4.jpg')}}"/>
</a>
<a target="_blank" href="{{route('goods.index',['id'=>31227])}}">
    <img src="{{get_img_path('images/hd/njzhongda_5.jpg')}}"/>
</a>
<img src="{{get_img_path('images/hd/njzhongda_6.jpg')}}" id="to_top"/>
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