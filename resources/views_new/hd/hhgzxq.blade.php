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
            vertical-align: middle;
            border: none;
        }

        body {
            min-width: 1109px;
            background: #000;
        }

        .top {
            width: 100%;
            height: 480px;
            background: url('{{get_img_path2('images/hd/hhgzxqtop.jpg')}}') no-repeat center;
        }

        .center {
            width: 1109px;
            margin: 0 auto;
        }

        #to_top {
            width: 100px;
            height: 297px;
            background: url('{{get_img_path2('images/hd/hhgzxqto_top.jpg')}}') no-repeat center;
            position: fixed;
            right: 10px;
            bottom: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="top"></div>
<div class="center">
    <img src="{{get_img_path2('images/hd/hhgzxq1.jpg')}}"/>
    <img src="{{get_img_path2('images/hd/hhgzxq2.jpg')}}"/>
    <img src="{{get_img_path2('images/hd/hhgzxq3.jpg')}}"/>
    <img src="{{get_img_path2('images/hd/hhgzxq4.jpg')}}"/>
    <img src="{{get_img_path2('images/hd/hhgzxq5.jpg')}}"/>
    <img src="{{get_img_path2('images/hd/hhgzxq6.jpg')}}"/>
    <img src="{{get_img_path2('images/hd/hhgzxq7.jpg')}}"/>
</div>
<div id="to_top" onclick="$('body,html').animate({scrollTop:0},500)"></div>
</body>
</html>
