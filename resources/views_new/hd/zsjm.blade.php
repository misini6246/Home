<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>{{config('services.web.title')}}</title>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('layer/layer.js')}}"></script>
    <script src="{{path('js/placeholder.js')}}"></script>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            font-size: 12px;
            font-family: "微软雅黑";
            outline: none;
        }

        img {
            display: block;
            border: none;
            width: 100%;
            height: 100%;
            vertical-align: middle;
        }

        .bottom {
            position: relative;
        }

        form {
            position: absolute;
            top: 22.5%;
            left: 8.5%;
            width: 40%;
            height: 26.4%;
        }

        form input[type=text] {
            border: none;
            background: #fff;
            font-size: 20px;
            text-indent: 5%;
            color: #000;
        }

        input.left {
            width: 60%;
            height: 100%;
            margin-left: 29%;
            margin-bottom: 4%;
        }

        input.right {
            width: 65%;
            height: 140%;
            margin-left: 29%;
        }

        .input_text {
            height: 50%;
        }
    </style>
</head>
<body>
<img src="{{get_img_path('adimages1/201808/erji/zsjm1.jpg')}}"/>
<img src="{{get_img_path('adimages1/201808/erji/zsjm2.jpg')}}"/>
<img src="{{get_img_path('adimages1/201808/erji/zsjm3.jpg')}}"/>
<img src="{{get_img_path('adimages1/201808/erji/zsjm4.jpg')}}"/>
<img src="{{get_img_path('adimages1/201808/erji/zsjm5.jpg')}}"/>
<img src="{{get_img_path('adimages1/201808/erji/zsjm6.jpg')}}"/>
<div class="bottom">
    <img src="{{get_img_path('adimages1/201808/erji/zsjm7.jpg')}}" usemap="#map1" id="img1"/>
    <form>
        <div class="input_text">
            <input id="consignee" type="text" class="left" placeholder="联系人"/>
            <input id="phone" type="text" class="left" placeholder="联系电话"/>
            <input id="address" type="text" class="right" placeholder="所在区域"/>
        </div>
    </form>
</div>
<map name="map1" id="map1">
    {{--<area shape="rect" data-coords='{"x1":"900","y1":"1025","x2":"1080","y2":"1060","w":"1903","h":"1125"}'--}}
    {{--onclick="to_top()"/>--}}
    <area shape="rect" data-coords='{"x1":"420","y1":"410","x2":"630","y2":"460","w":"1583","h":"498"}'
          onclick="sub()"/>
</map>
<script src="{{path('js/resize.js')}}"></script>
<script type="text/javascript">
    function to_top() {
        $('html,body').animate({
            scrollTop: 0
        })
    }

    function sub() {
        var consignee = jtrim($('#consignee').val());
        var phone = jtrim($('#phone').val());
        var address = jtrim($('#address').val());
        if (consignee == '') {
            layer.msg('联系人不能为空', {icon: 2});
            return false;
        }
        if (phone == '') {
            layer.msg('联系电话不能为空', {icon: 2});
            return false;
        }
        var rule = /^((0\d{2,3}-\d{7,8})|(1[3584]\d{9}))$/;
        if (!rule.test(phone)) {
            layer.msg('请输入正确的联系电话', {icon: 2});
            return false;
        }
        if (address == '') {
            layer.msg('详细地址不能为空', {icon: 2});
            return false;
        }
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            url: '{{route('other.yzy_add_info',['flag'=>1])}}',
            type: 'post',
            data: {consignee: consignee, phone: phone, address: address},
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    $('#consignee').val('');
                    $('#phone').val('');
                    $('#address').val('');
                }
                layer.msg(data.msg, {icon: data.error + 1})
            }
        })
    }

    function jtrim(s) {
        return s.replace(/(^\s*)|(\s*$)/g, "");
    }
</script>
</body>
</html>
