<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <style type="text/css">
        *{
            margin: 0;
            padding: 0;
        }
        .top{
            width: 100%;
            height: 741px;
            background: url('{{get_img_path('images/hd/zhongda_1.jpg')}}') no-repeat scroll top center;
        }
        .content{
            width: 100%;
            height: 964px;
            background: url('{{get_img_path('images/hd/zhongda_2.jpg')}}') no-repeat scroll top center;
        }
        .bottom{
            width: 100%;
            height: 1678px;
            background: url('{{get_img_path('images/hd/zhongda_3.jpg')}}') no-repeat scroll top center;
        }
        .content_box{
            width: 1200px;
            margin: 0 auto;
            position: relative;
        }
        a{
            display: inline-block;
            outline: none;
        }
        .url_1{
            width: 1500px;
            height: 830px;
            margin-left: -150px;
        }
        .url_2,.url_3{
            width: 420px;
            height: 480px;

        }
        .url_2{
            margin: 367px 0 0 113px;
        }
        .url_3{
            margin-left: 100px;
        }
        .url_4{
            margin: 140px 0 0 113px;
            width: 470px;
            height: 515px;

        }
        .url_5{
            position: absolute;
            bottom: 5px;
            right: 90px;
            width: 470px;
            height: 560px;

        }
    </style>
</head>
<body>
<div class="top"></div>
<div class="content">
    <div class="content_box">
        <a target="_blank" href="/goods?id=14034" class="url_1"></a>
    </div>
</div>
<div class="bottom">
    <div class="content_box">
        <a target="_blank" href="/goods?id=29963" class="url_2"></a>
        <a target="_blank" href="/goods?id=25865" class="url_3"></a>
        <a target="_blank" href="/goods?id=25859" class="url_4"></a>
        <a target="_blank" href="/goods?id=29964" class="url_5"></a>
    </div>
</div>
</body>
</html>
