<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <title>{{config('services.web.title')}}</title>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        img {
            vertical-align: middle;
        }

        .div1,
        .div2,
        .div3,
        .div4,
        .div5,
        .div6 {
            position: relative;
        }

        .div1 {
            background: url('{{get_img_path('images/hd/20180401jpzz-1.jpg')}}') no-repeat scroll top center;
            height: 1832px;
        }

        .div2 {
            background: url('{{get_img_path('images/hd/20180401jpzz-2.jpg')}}') no-repeat scroll top center;
            height: 552px;
        }

        .div3 {
            background: url('{{get_img_path('images/hd/20180401jpzz-3.jpg')}}') no-repeat scroll top center;
            height: 565px;
        }

        .div4 {
            background: url('{{get_img_path('images/hd/20180401jpzz-4.jpg')}}') no-repeat scroll top center;
            height: 563px;
        }

        .div5 {
            background: url('{{get_img_path('images/hd/20180401jpzz-5.jpg')}}') no-repeat scroll top center;
            height: 555px;
        }

        .div6 {
            background: url('{{get_img_path('images/hd/20180401jpzz-6.jpg')}}') no-repeat scroll top center;
            height: 1021px;
        }

        .center {
            width: 1200px;
            margin: 0 auto;
            position: relative;
        }

        .zhezhao-1,
        .zhezhao-2,
        .zhezhao-3,
        .zhezhao-4,
        .zhezhao-5 {
            width: 198px;
            height: 266px;
            position: absolute;
            top: 137px;
            /*				border: 1px solid red;*/
        }

        .zhezhao-1 {
            left: 80px;
        }

        .zhezhao-2 {
            left: 283px;
        }

        .zhezhao-3 {
            left: 486px;
        }

        .zhezhao-4 {
            left: 688px;
        }

        .zhezhao-5 {
            right: 110px;
        }

        .div3 .center div,
        .div4 .center div,
        .div5 .center div,
        .div6 .center div {
            top: 137px !important;
        }

        #to_top {
            display: inline-block;
            width: 260px;
            height: 260px;
            position: absolute;
            top: 645px !important;
            left: 442px;
        }
    </style>
</head>
<body>
<div class="div1">
</div>
<div class="div2">
    <div class="center">
        <div class="zhezhao-1"></div>
        <div class="zhezhao-2"></div>
        <div class="zhezhao-3"></div>
        <div class="zhezhao-4"></div>
        <div class="zhezhao-5"></div>
    </div>
</div>
<div class="div3">
    <div class="center">
        <div class="zhezhao-1"></div>
        <div class="zhezhao-2"></div>
        <div class="zhezhao-3"></div>
        <div class="zhezhao-4"></div>
        <div class="zhezhao-5"></div>
    </div>
</div>
<div class="div4">
    <div class="center">
        <div class="zhezhao-1"></div>
        <div class="zhezhao-2"></div>
        <div class="zhezhao-3"></div>
        <div class="zhezhao-4"></div>
        <div class="zhezhao-5"></div>
    </div>
</div>
<div class="div5">
    <div class="center">
        <div class="zhezhao-1"></div>
        <div class="zhezhao-2"></div>
        <div class="zhezhao-3"></div>
        <div class="zhezhao-4"></div>
        <div class="zhezhao-5"></div>
    </div>
</div>
<div class="div6">
    <div class="center">
        <div class="zhezhao-1"></div>
        <div class="zhezhao-2"></div>
        <div class="zhezhao-3"></div>
        <div class="zhezhao-4"></div>
        <div class="zhezhao-5"></div>
        <div id="to_top"></div>
    </div>
</div>
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