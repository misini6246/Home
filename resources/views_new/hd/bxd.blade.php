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
            display: block;
            border: 0;
            width: 100%;
        }

        .fixed_to_top {
            position: fixed;
            bottom: 0;
            right: 1%;
            width: 13%;
            cursor: pointer;
        }
    </style>
</head>

<body>
<div class="fixed_to_top to_top">
    <img src="{{get_img_path2('images/hd/bxd_to_top.png')}}"/>
</div>
<a target="_blank" href="{{route('goods.index',['id'=>31943])}}"><img
            src="{{get_img_path2('images/hd/baixiaodan_1.jpg')}}1"/></a>
<img src="{{get_img_path2('images/hd/baixiaodan_2.jpg')}}"/>
<img src="{{get_img_path2('images/hd/baixiaodan_3.jpg')}}"/>
<img src="{{get_img_path2('images/hd/baixiaodan_4.jpg')}}"/>
<img src="{{get_img_path2('images/hd/baixiaodan_5.jpg')}}"/>
<img src="{{get_img_path2('images/hd/baixiaodan_6.jpg')}}"/>
<img src="{{get_img_path2('images/hd/baixiaodan_7.jpg')}}"/>
<a target="_blank" href="{{route('goods.index',['id'=>31943])}}"><img
            src="{{get_img_path2('images/hd/baixiaodan_8.jpg')}}1"/></a>
<img src="{{get_img_path2('images/hd/baixiaodan_9.jpg')}}" class="to_top" style="cursor: pointer;"/>
<script type="text/javascript">
    window.onload = function () {

        var btn = document.getElementsByClassName("to_top");
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
        for (var i = 0; i < btn.length; i++) {
            btn[i].onclick = function () {

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

    }
</script>
</body>

</html>