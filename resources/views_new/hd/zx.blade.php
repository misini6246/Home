<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.singlePageNav.min.js')}}"></script>
    <script src="{{path('js/resize.js')}}"></script>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        img {
            width: 100%;
            border: none;
            display: block;
        }

        .to_top {
            cursor: pointer;
        }

        #fixed a {
            width: 100%;
            height: 11.9%;
            display: inline-block;
            position: absolute;
            left: 0;
            z-index: 2;
        }

        #fixed a:first-child {
            top: 32%;
        }

        #fixed a:first-child + a {
            top: 45%;
        }

        #fixed a:first-child + a + a {
            top: 58%;
        }

        #fixed a:first-child + a + a + a {
            top: 74%;
        }
    </style>
</head>
<body>
<img src="{{get_img_path('adimages1/hd/zhuangxiu_1.jpg')}}"/>
<img src="{{get_img_path('adimages1/hd/zhuangxiu_2.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path('adimages1/hd/zhuangxiu_3.jpg')}}" usemap="#map2" id="img2"/>
<img src="{{get_img_path('adimages1/hd/zhuangxiu_4.jpg')}}" usemap="#map3" id="img3"/>
<img src="{{get_img_path('adimages1/hd/zhuangxiu_5.jpg')}}"/>
<img src="{{get_img_path('adimages1/hd/zhuangxiu_6.jpg')}}"/>
<img src="{{get_img_path('adimages1/hd/zhuangxiu_7.jpg')}}"/>
<img src="{{get_img_path('adimages1/hd/zhuangxiu_8.jpg')}}" class="to_top"/>
<img src="{{get_img_path('images/hd/zhuangxiu_bg.png')}}" usemap="#map4" id="img4"/>
<map name="map1" id="map1">
    <area shape="rect" data-coords='{"x1":"360","y1":"680","x2":"650","y2":"1075","w":"1903","h":"1075"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"665","y1":"680","x2":"950","y2":"1075","w":"1903","h":"1075"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"970","y1":"680","x2":"1255","y2":"1075","w":"1903","h":"1075"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"1270","y1":"680","x2":"1560","y2":"1075","w":"1903","h":"1075"}'
          class="alert_box"/>
</map>
<map name="map2" id="map2">
    <area shape="rect" data-coords='{"x1":"360","y1":"666","x2":"650","y2":"1055","w":"1903","h":"1465"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"665","y1":"666","x2":"950","y2":"1055","w":"1903","h":"1465"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"970","y1":"666","x2":"1255","y2":"1055","w":"1903","h":"1465"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"1270","y1":"666","x2":"1560","y2":"1055","w":"1903","h":"1465"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"360","y1":"1070","x2":"650","y2":"1465","w":"1903","h":"1465"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"665","y1":"1070","x2":"950","y2":"1465","w":"1903","h":"1465"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"970","y1":"1070","x2":"1255","y2":"1465","w":"1903","h":"1465"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"1270","y1":"1070","x2":"1560","y2":"1465","w":"1903","h":"1465"}'
          class="alert_box"/>
</map>
<map name="map3" id="map3">
    <area shape="rect" data-coords='{"x1":"360","y1":"673","x2":"650","y2":"1068","w":"1903","h":"1068"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"665","y1":"673","x2":"950","y2":"1068","w":"1903","h":"1068"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"970","y1":"673","x2":"1255","y2":"1068","w":"1903","h":"1068"}'
          class="alert_box"/>
    <area shape="rect" data-coords='{"x1":"1270","y1":"673","x2":"1560","y2":"1068","w":"1903","h":"1068"}'
          class="alert_box"/>
</map>
<map name="map4" id="map4">
    <area shape="rect" data-coords='{"x1":"200","y1":"375","x2":"480","y2":"430","w":"680","h":"473"}' class="close"/>
</map>

<div id="fixed">
    <a href="#img1"></a><a href="#img2"></a><a href="#img3"></a><a href="javascript:;" class="to_top"></a>
    <img src="{{get_img_path('adimages1/hd/fixed_zhuangxiu.png')}}"/>
</div>
</body>
<script type="text/javascript">
    $('.to_top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        })
    })

    $(function () {
        $(window).resize(function () {
            img_size()
        });
        $(document).ready(function () {
            img_size()
        })

        function img_size() {
            $('#img4').css({
                'width': $('body').width() * 0.358,
                'height': $('body').width() * 0.25,
                'position': 'fixed',
                'left': '33%',
                'top': '20%',
                'display': 'none'
            })
            $('#fixed').css({
                'width': $('body').width() * 0.087,
                'height': $('body').width() * 0.132,
                'position': 'fixed',
                'left': '5%',
                'top': '20%'
            })
        }

        $('.alert_box').click(function () {
            $('#img4').show();
            $('.close').click(function (e) {
                $('#img4').hide();
                e.stopPropagation();
            })
        })
        $('#fixed').singlePageNav({
            offset: 0
        });
    })
</script>

</html>