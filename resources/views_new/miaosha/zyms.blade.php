@if($info)
    <style type="text/css">
        #jrms .jrms_content {
            height: 380px;
            margin-top: 20px;
        }

        #jrms .jrms_content .left {
            float: left;
        }

        #jrms .jrms_content .right {
            float: right;
            margin-left: 10px;
            width: 740px;
            height: 380px;
            box-sizing: border-box;
            border: 1px solid #FFECC2;
            background: rgba(255, 255, 255, 1);
        }

        #jrms .right .title {
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            padding: 0 12px;
            background-color: #FFECC2;
        }

        #jrms .right .title .text img {
            float: left;
            margin-top: 19px;
        }

        #jrms .right .title .text div {
            float: left;
            margin-top: 20px;
            margin-left: 14px;
            color: #333333;
            font-size: 18px;
        }

        #jrms .right .title .djs {
            width: 307px;
            height: 100%;
            line-height: 60px;
            position: absolute;
            top: 0;
            right: 0;
            background: url('{{get_img_path('adimages1/201808/erji/zyms2.png')}}') no-repeat;
            padding: 0 0 0 56px;
        }

        #jrms .right .title .djs span {
            font-size: 18px;
            color: #FFFFFF;
            display: block;
            float: left;
        }

        #jrms .right .title .djs .num {
            width: 32px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            margin: 15px 4px;
            color: #333333;
            font-weight: bold;
            background: url('{{get_img_path('adimages1/201808/erji/zyms3.png')}}') no-repeat;
        }

        #jrms .right .title .djs .first {
            margin-left: 12px;
            margin-right: 5px;
        }

        #jrms .right .content {
            padding: 10px 0 10px 9px;
        }

        #jrms .right .content .img {
            float: left;
            position: relative;
        }

        #jrms .right .content .info {
            float: right;
            width: 429px;
            height: 300px;
            padding-top: 10px;
            padding-left: 20px;
            padding-right: 10px;
        }

        @-moz-document url-prefix() {
            #jrms .right .content .info {
                padding-top: 3px;
            }
        }

        #jrms .right .drug-name {
            font-size: 24px;
            font-weight: bold;
            color: #333333;
        }

        #jrms .right .name {
            font-size: 16px;
            color: #999999;
        }

        #jrms .right .gg,
        #jrms .right .cj {
            font-size: 16px;
            color: #666666;
        }

        #jrms .right .count {
            margin-top: 10px;
        }

        #jrms .right .count p {
            display: inline-block;
            width: 49%;
        }

        #jrms .right .count .xl,
        #jrms .right .count .zl {
            color: #FF1919;
            font-size: 16px;
        }

        #jrms .right .price {
            margin-top: 15px;
        }

        #jrms .right .price .xj {
            color: #FF1919;
            font-size: 36px;
        }

        #jrms .right .price .yj {
            text-decoration: line-through;
            font-size: 18px;
            color: #999999;
            margin-left: 15px;
        }

        #jrms .right .yqg {
            margin-top: 12px;
        }

        #jrms .right .yqg span {
            font-size: 12px;
            color: #666666;
        }

        #jrms .right .yqg .line {
            display: block;
            float: right;
            width: 270px;
            height: 8px;
            margin-top: 4px;
            background-color: #E9E9E9;
        }

        #jrms .right .yqg .line .cur {
            display: block;
            height: 100%;
            width: {{$info->points}}%;
            background-color: #BB8D2B;
        }

        #jrms .right .btn {
            width: 400px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            font-size: 18px;
            color: #FFFFFF;
            background: rgba(255, 25, 25, 1);
            margin-top: 13px;
            cursor: pointer;
        }

        .content .img .status {
            width: 300px;
            height: 300px;
            position: absolute;
            top: 0;
            left: 0;
        }

        .content .img .status_2 {
            background: url(http://images.hezongyy.com/adimages1/201808/erji/zyms5.png) no-repeat;
        }

        .content .img .status_3 {
            background: url(http://images.hezongyy.com/adimages1/201808/erji/zyms6.png) no-repeat;
        }
    </style>
    <div id="jrms" class="container" data-group_id="{{$info->group_id}}" data-goods_id="{{$info->goods_id}}">
        <div class="container_box">
            <div class="jrms_content">
                <div class="left">
                    <img width="450" height="380" src="{{get_img_path('adimages1/201808/erji/zyms4.gif')}}"/>
                </div>
                <div class="right">
                    <div class="title">
                        <div class="text">
                            <img width="94" height="23" src="{{get_img_path('adimages1/201808/erji/zyms1.png')}}"/>
                            <div>周一至周五每天15点准时开抢</div>
                        </div>
                        <div class="djs" id="djs" data-time="{{$info->djs_time}}" data-time1="{{$info->djs_time1}}"
                             data-status="{{$info->djs_status}}">
                            <span id="djs_text">{{$info->djs_text}}</span>
                            <span id="hours" class="num first">00</span>
                            <span>时</span>
                            <span id="minutes" class="num">00</span>
                            <span>分</span>
                            <span id="seconds" class="num">00</span>
                            <span>秒</span>
                        </div>
                    </div>
                    <div class="content">
                        <div class="img">
                            <img width="300" height="300" src="{{$info->goods->goods_thumb}}"/>
                            <div id="{{$info->group_id}}-{{$info->goods_id}}-bg">
                                @if($info->is_has==1)
                                    <div class="status status_2"></div>
                                @elseif($info->goods_number<=0)
                                    <div class="status status_3"></div>
                                @endif
                            </div>
                        </div>
                        <div class="info">
                            <span class="drug-name">{{$info->goods->goods_name}}</span>
                            <p style="margin-top: 15px;"><span class="name">规格：</span><span
                                        class="gg">{{$info->goods->spgg}}</span></p>
                            <p style="margin-top: 5px;"><span class="name">厂家：</span><span
                                        class="cj">{{$info->goods->sccj}}</span>
                            </p>
                            <div style="margin-top: 10px;height: 1px;background-color: #E5E5E5;"></div>
                            <div class="count">
                                <p><span class="name">限量：</span><span
                                            class="xl">{{$info->min_number}}{{$info->goods->dw}}</span></p>
                                <p><span class="name">剩余库存：</span><span
                                            class="zl"><span class="zl"
                                                             id="{{$info->group_id}}-{{$info->goods_id}}-kc">{{$info->goods_number}}</span>{{$info->goods->dw}}</span>
                                </p>
                            </div>
                            <div class="price">
                                <span class="xj">{{formated_price($info->goods_price)}}</span>
                                <span class="yj">{{formated_price($info->goods->shop_price)}}</span>
                            </div>
                            <div style="height: 1px;background-color: #E5E5E5;"></div>
                            <div class="yqg">
                                <span>已抢购{{$info->points}}%</span>
                                <span class="line">
            						<span class="cur"></span>
            					</span>
                            </div>
                            <a id="{{$info->group_id}}-{{$info->goods_id}}-btn">
                                @if($info->is_has==1)
                                    <div class="btn" style="background-color: #999;">已抢购</div>
                                @elseif($info->goods_number==0)
                                    <div class="btn" style="background-color: #999;">已抢完</div>
                                @elseif($info->djs_status==0)
                                    <div class="btn" style="background-color: #999;">即将开始</div>
                                @else
                                    <div class="btn" onclick="addCart()">立即秒杀</div>
                                @endif
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var group_id = parseInt($('#jrms').data('group_id'));
        var goods_id = parseInt($('#jrms').data('goods_id'));
        var djs_time = parseInt($('#djs').data('time'));
        var djs_time1 = parseInt($('#djs').data('time1'));
        var djs_status = parseInt($('#djs').data('status'));
        var djs_fun = setInterval('djs()', 1000);

        function djs() {
            //定义参数 获得小时
            var hours = Math.floor(djs_time / (60 * 60))
            //定义参数 获得分钟
            var minutes = Math.floor(djs_time / (60)) % 60;
            //定义参数 获得秒钟
            var seconds = Math.floor(djs_time) % 60;
            $('#hours').text(hours);
            $('#minutes').text(minutes);
            $('#seconds').text(seconds);
            if (djs_time == 0) {
                if (djs_status == 0) {
                    djs_time = djs_time1;
                    djs_status = 1;
                    changeBtn();
                } else {
                    clearInterval(djs_fun);
                    getZy();
                }
            }
            djs_time--;
        }

        function changeBtn() {
            var btn = '<div class="btn" onclick="addCart()">立即秒杀</div>'
            $('#' + group_id + '-' + goods_id + '-btn').html(btn)
            $('#djs_text').text('距结束')
        }

        function addCart() {
            $.ajax({
                url: '/xin/miaosha/add_cart',
                type: 'get',
                data: {group_id: group_id, goods_id: goods_id},
                dataType: 'json',
                success: function (data) {
                    if (data.error >= 300) {
                        layer.msg(data.msg, {icon: 2})
                        return false;
                    }
                    var icon = data.error + 1;
                    if (data.error == 2) {
                        icon = 2;
                    }
                    layer.confirm(data.msg, {
                        btn: ['继续购物', '去结算'], //按钮
                        icon: icon
                    }, function (index) {
                        layer.close(index);
                    }, function () {
                        location.href = '/cart';
                        return false;
                    });
                    $('#' + group_id + '-' + goods_id + '-kc').text(data.goods_number);
                    if (data.error == 2) {
                        $('#' + group_id + '-' + goods_id + '-btn').html('<div class="btn" style="background-color: #999;">已抢完</div>')
                        $('#' + group_id + '-' + goods_id + '-bg').html('<div class="status status_3"></div>')
                    } else {
                        $('#' + group_id + '-' + goods_id + '-btn').html('<div class="btn" style="background-color: #999;">已抢购</div>')
                        $('#' + group_id + '-' + goods_id + '-bg').html('<div class="status status_2"></div>')
                    }
                }
            });
        }
    </script>
@endif