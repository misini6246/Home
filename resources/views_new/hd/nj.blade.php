<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <script src="{{path('js/jquery.min.js')}}" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            border: none;
        }

        .div1 {
            height: 1800px;
            background: url('{{get_img_path('images/hd/nuojin_1.jpg')}}') no-repeat scroll top center;
            min-width: 1000px;
        }

        .div2 {
            height: 1247px;
            background: url('{{get_img_path('images/hd/nuojin_2.jpg')}}') no-repeat scroll top center;
            min-width: 1000px;
        }

        .div3 {
            height: 2059px;
            background: url('{{get_img_path('images/hd/nuojin_3.jpg')}}') no-repeat scroll top center;
            min-width: 1000px;
        }

        .div4 {
            height: 1028px;
            background: url('{{get_img_path('images/hd/nuojin_4.jpg')}}') no-repeat scroll top center;
            min-width: 1000px;
        }

        .center {
            width: 1000px;
            margin: 0 auto;
            position: relative;
        }

        a {
            display: inline-block;
            position: absolute;
        }

        .div1_a1, .div2_a1, .div2_a2 {
            width: 1000px;
            height: 540px;
        }

        .div1_a1 {
            top: 966px;
        }

        .div2_a1 {
            top: 0px;
        }

        .div2_a2 {
            top: 540px;
        }

        .div3 a {
            width: 495px;
            height: 500px;
        }

        .div3_a1 {
            top: 235px;
        }

        .div3_a2 {
            top: 235px;
            right: 0;
        }

        .div3_a3 {
            top: 870px;
        }

        .div3_a4 {
            top: 790px;
            right: 0;
            height: 578px !important;
        }

        .div3_a5 {
            top: 1403px;
            height: 595px !important;
        }

        .div3_a6 {
            top: 1403px;
            right: 0;
            height: 595px !important;
        }

        .div4_a1 {
            width: 1000px;
            top: 240px;
            height: 460px;
        }

        .to_top {
            width: 300px !important;
            height: 245px !important;
            top: 776px;
            left: 373px;
        }
    </style>
</head>
<body>
<div class="div1">
    <div class="center">
        <a target="_blank" href="/goods?id=18066" class="div1_a1"></a>
    </div>
</div>
<div class="div2">
    <div class="center">
        <a target="_blank" href="/goods?id=2049" class="div2_a1"></a>
        <a target="_blank" href="/goods?id=2050" class="div2_a2"></a>
    </div>

</div>
<div class="div3">
    <div class="center">
        <a target="_blank" href="/goods?id=18049" class="div3_a1"></a>
        <a target="_blank" href="/goods?id=11083" class="div3_a2"></a>
        <a target="_blank" href="/goods?id=534" class="div3_a3"></a>
        <a target="_blank" href="/goods?id=12645" class="div3_a4"></a>
        <a target="_blank" href="/goods?id=18078" class="div3_a5"></a>
        <a target="_blank" href="/goods?id=12646" class="div3_a6"></a>
    </div>
</div>
<div class="div4">
    <div class="center">
        <a target="_blank" href="/goods?id=7424" class="div4_a1"></a>
        <a class="to_top"></a>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $(".to_top").bind("click", function () {
            $("html,body").animate({
                scrollTop: 0
            }, "slow", "swing", function () {
            });
        });
    })
</script>
</body>
</html>
