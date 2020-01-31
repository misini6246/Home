<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
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
<img src="{{get_img_path('images/hd/hongzao_1_01.jpg')}}"/>
<img src="{{get_img_path('images/hd/hongzao_2_02.jpg')}}"/>
<a target="_blank" href="{{route('goods.index',['id'=>32188])}}"><img
            src="{{get_img_path('images/hd/hongzao_3_02.jpg')}}"/></a>
<a target="_blank" href="{{route('goods.index',['id'=>32368])}}"><img
            src="{{get_img_path('images/hd/hongzao_4_02.jpg')}}"/></a>
<a target="_blank" href="{{route('goods.index',['id'=>32370])}}"><img
            src="{{get_img_path('images/hd/hongzao_5_02.jpg')}}"/></a>
<img src="{{get_img_path('images/hd/hongzao_6_02.jpg')}}"/>
</body>

</html>