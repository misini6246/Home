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

        a {
            display: inline-block;
            width: 1250px;
            height: 680px;
        }

        .div1 {
            height: 1442px;
            min-width: 1250px;
            background: url('{{get_img_path('images/hd/img1.jpg')}}') no-repeat scroll top center;
        }

        .div2 {
            height: 683px;
            min-width: 1250px;
            background: url('{{get_img_path('images/hd/img2.jpg')}}') no-repeat scroll top center;
        }

        .div3 {
            height: 741px;
            min-width: 1250px;
            background: url('{{get_img_path('images/hd/img3.jpg')}}') no-repeat scroll top center;
        }

        .div4 {
            height: 873px;
            min-width: 1250px;
            background: url('{{get_img_path('images/hd/img4.jpg')}}') no-repeat scroll top center;
        }

        .center {
            width: 1250px;
            margin: 0 auto;
            height: 710px;
        }
    </style>
</head>
<body>
<div class="div1">
</div>
<div class="div2">
    <div class="center">
        <a target="_blank" href="/goods?id=2185"></a>
    </div>
</div>
<div class="div3">
    <div class="center">
        <a target="_blank" href="/goods?id=25334"></a>
    </div>
</div>
<div class="div4">
    <div class="center">
        <a target="_blank" href="/goods?id=4195"></a>
    </div>
</div>

</body>
</html>
