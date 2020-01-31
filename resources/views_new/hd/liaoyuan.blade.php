@extends('miaosha.app')
@section('links')
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        img {
            display: block;
            border: none;
            width: 100%;
            height: 100%;
        }

        area {
            /*outline: none*/
        }
    </style>
@endsection
@section('content')
    <img src="{{get_img_path('adimages1/201809/erji/liaoyaun1.jpg')}}" usemap="#map1" id="img1"/>
    <img src="{{get_img_path('adimages1/201809/erji/liaoyaun2.jpg')}}" usemap="#map2" id="img2"/>
    <img src="{{get_img_path('adimages1/201809/erji/liaoyaun3.jpg')}}" usemap="#map3" id="img3"/>
    <img src="{{get_img_path('adimages1/201809/erji/liaoyaun4.jpg')}}" usemap="#map4" id="img4"/>
    <img src="{{get_img_path('adimages1/201809/erji/liaoyaun5.jpg')}}" usemap="#map5" id="img5"/>
    <img src="{{get_img_path('adimages1/201809/erji/liaoyaun6.jpg')}}" usemap="#map6" id="img6"/>
    <img src="{{get_img_path('adimages1/201809/erji/liaoyaun7.jpg')}}" usemap="#map7" id="img7"/>
    <img src="{{get_img_path('adimages1/201809/erji/liaoyaun8.jpg')}}" usemap="#map8" id="img8"/>
    <map name="map1" id="map1">

    </map>
    <map name="map2" id="map2">

    </map>
    <map name="map3" id="map3">

    </map>
    <map name="map4" id="map4">
        <area target="_blank" shape="rect"
              data-coords='{"x1":"1230","y1":"300","x2":"1430","y2":"370","w":"1583","h":"601"}'
              href="{{route('member.hongbao_money_log')}}" coords="800,0,1500,618"/>
    </map>
    <map name="map5" id="map5">

    </map>
    <map name="map6" id="map6">

    </map>
    <map name="map7" id="map7">
        <area shape="rect"
              data-coords='{"x1":"920","y1":"90","x2":"1150","y2":"180","w":"1583","h":"280"}'
              onclick="generateTjm()" coords="800,0,1500,618"/>
    </map>
    <map name="map8" id="map8">

    </map>
    <script src="{{path('js/resize.js')}}"></script>
    <script>
        function generateTjm() {
            $.ajax({
                url: '{{route('member.generate_tjm')}}',
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0) {
                        layer.confirm('您的邀请码是：' + data.tjm, {
                            btn: ['前往会员中心', '确定'], //按钮
                            icon: 1
                        }, function () {
                            location.href = '/member';
                        }, function (e) {
                            layer.close(e);
                        });
                    } else {
                        layer.msg(data.msg, {icon: data.error + 1})
                    }
                }
            })
        }
    </script>
@endsection