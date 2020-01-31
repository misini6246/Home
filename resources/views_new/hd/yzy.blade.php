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
            top: 25.5%;
            left: 8.5%;
            width: 40%;
            height: 26.4%;
        }

        .input_text {
            height: 19%;
            width: 100%;
            overflow: hidden;
            margin-bottom: 4% !important;
        }

        form input[type=text] {
            height: 100%;
            border: none;
            background: #fff;
            font-size: 20px;
            text-indent: 5%;
            color: #000;
        }

        input.left {
            width: 41%;
        }

        input.right {
            width: 58%;
            float: right;
        }

        textarea {
            resize: none;
            width: 96%;
            font-size: 20px;
            height: 30%;
            padding: 2% !important;
        }
    </style>
</head>
<body>
<img src="{{get_img_path2('images/hd/yzy_1.jpg')}}"/>
<img src="{{get_img_path2('images/hd/yzy_2.jpg')}}"/>
<img src="{{get_img_path2('images/hd/yzy_3.jpg')}}" usemap="#map1" id="img1"/>
<img src="{{get_img_path2('images/hd/yzy_4.jpg')}}"/>
<div class="bottom">
    <img src="{{get_img_path2('images/hd/yzy_5.jpg')}}" usemap="#map2" id="img2"/>
    <form>
        <div class="input_text">
            <input id="phone" type="text" class="right" placeholder="联系电话"/>
            <input id="consignee" type="text" class="left" placeholder="联系人"/>
        </div>
        <div class="input_text">
            <input id="name" type="text" class="right" placeholder="诊所名称"/>
            <input id="address" type="text" class="left" placeholder="详细地址"/>
        </div>
        <textarea id="content" placeholder="咨询内容"></textarea>
    </form>
</div>
<map name="map1" id="map1">
    <area shape="rect" data-coords='{"x1":"1210","y1":"425","x2":"1380","y2":"470","w":"1903","h":"1250"}'
          onclick="lq()"/>
    <area shape="rect" data-coords='{"x1":"1210","y1":"760","x2":"1380","y2":"810","w":"1903","h":"1250"}'
          target="_blank" href="{{route('goods.index',['id'=>22080])}}"/>
    <area shape="rect" data-coords='{"x1":"1210","y1":"1105","x2":"1380","y2":"1150","w":"1903","h":"1250"}'
          target="_blank" href="{{route('goods.index',['id'=>22079])}}"/>
</map>
<map name="map2" id="map2">
    <area shape="rect" data-coords='{"x1":"900","y1":"1025","x2":"1080","y2":"1060","w":"1903","h":"1125"}'
          onclick="to_top()"/>
    <area shape="rect" data-coords='{"x1":"320","y1":"615","x2":"775","y2":"690","w":"1903","h":"1125"}'
          onclick="sub()"/>
</map>
<script src="{{path('js/resize.js')}}"></script>
<script type="text/javascript">
    function to_top() {
        $('html,body').animate({
            scrollTop: 0
        })
    }
    function lq() {
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            url: '{{route('other.yzy_add_c')}}',
            type: 'put',
            dataType: 'json',
            success: function (data) {
                layer.msg(data.msg, {icon: data.error + 1})
            },
            error: function (jqXHR) {
                if (jqXHR.status == 403) {
                    layer.confirm('请登录后再操作', {
                        btn: ['注册', '登录'], //按钮
                        icon: 2
                    }, function () {
                        location.href = '/auth/register';
                    }, function () {
                        location.href = '/auth/login';
                        return false;
                    });
                }
            }
        })
    }
    function sub() {
        var consignee = jtrim($('#consignee').val());
        var phone = jtrim($('#phone').val());
        var address = jtrim($('#address').val());
        var name = jtrim($('#name').val());
        var content = jtrim($('#content').val());
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
        if (name == '') {
            layer.msg('诊所名称不能为空', {icon: 2});
            return false;
        }
        if (content == '') {
            layer.msg('咨询内容不能为空', {icon: 2});
            return false;
        }
        $.ajax({
            headers: {

                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            },
            url: '{{route('other.yzy_add_info')}}',
            type: 'post',
            data: {consignee: consignee, phone: phone, address: address, name: name, content: content},
            dataType: 'json',
            success: function (data) {
                if (data.error == 0) {
                    $('#consignee').val('');
                    $('#phone').val('');
                    $('#address').val('');
                    $('#name').val('');
                    $('#content').val('');
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
