@extends('miaosha.body')
@section('links')
    <style>
        body, li, p, ul, a {
            font-size: 12px;
            margin: 0;
            padding: 0;
            font-family: "microsoft yahei";
            list-style: none;
            text-decoration: none;
        }

        #miaosha-top {
            width: 100%;
            height: 803px;
            background: url('http://www.jyeyw.com/69d1e6cb7573103b7c1adcfc2419faa.jpg') no-repeat scroll top center;
            min-width: 1200px;
            max-width: 1920px;
            margin: 0 auto;
            overflow: hidden;
        }

        .remaitime {
            position: relative;
            width: 450px;
            height: 34px;
            margin: 0 auto;
            font-size: 24px;
            color: #794848;
            font-weight: bold;
        }

        .remaitime1 {
            position: relative;
            width: 450px;
            height: 34px;
            margin: 0 auto;
            font-size: 24px;
            color: #fff;
            display: none;
            text-align: center;
            background: #7f0818f7;
        }

        .zhuangtai-text-1,
        .zhuangtai-text-2 {
            display: inline-block;
            font-size: 24px;
            /*color: #fff000 !important;*/
            color: #f00 !important;
        }

        .zhuangtai-text-2 {
            display: none;
        }

        .time-before,
        .time-after {
            float: right;
            height: 34px;
            font-weight: normal;
        }

        /*
        .time-after {
            display: none;
        }*/

        .hourse,
        .minute,
        .second {
            display: inline-block;
            width: 36px;
            height: 34px;
            line-height: 34px;
            text-align: center;
            font-size: 24px;
            /*color: #fff;*/
            color: #b51e1e;
        {{--background: url('{{get_img_path('data/afficheimg/' . $bottom_img->left_img)}}');--}}
}

        /*增加*/
        span.s {
            font-size: 18px;
            /*color: #fff;*/
            color: #ff0000  ;
            margin: 0 5px;

        }

        .btn_box {
            width: 100%;
        }

        /*增加*/

        #miaosha-bottom {
            width: 100%;
            min-width: 1200px;
            max-width: 1920px;
            margin: 0 auto;
            overflow: hidden;
            min-height: 442px;
            background: url(http://images.hezongyy.com/data/afficheimg/201910/adad_code_1749_08083900.jpg);
        }

        #miaosha-top .time {
            height: 94px;
            width: 574px;
            /*width:50%;*/
            margin: 647px auto 16px auto;
            position: relative;
        }

        #miaosha-top .time li {
            float: left;
            text-align: center;
            cursor: pointer;
            width: 240px;
            height: 60px;
            background: #FDF102;
            border-radius: 30px;
        }

        #miaosha-top .time li .sj,
        #miaosha-top .time li .zt {
            display: inline-block;
        }

        #miaosha-top .time li .sj {
            font-size: 36px;
            height: 60px;
            line-height: 60px;
        }

        /*#miaosha-top .time li:first-child + li {*/
        #miaosha-top .time li + li {
            margin-left: 90px;
        }

        #miaosha-top .time li .zt {
            box-sizing: border-box;
            font-size: 18px;
            width: 90px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            border-radius: 30px;
            position: relative;
            top: -5px;
            margin-left: 10px;
        }

        #miaosha-top .time li.time_end .sj {
            color: #666;
        }

        #miaosha-top .time li.time_end .zt {
            color: #0b0b0b;
            border: 1px solid #666;
        }

        #miaosha-top .time li.time_ing .sj {
            color: #8724a1;
        }

        #miaosha-top .time li.time_ing .zt {
            color: #8724a1;
            border: 1px solid #8724a1;
        }

        #miaosha-top .time li.time_begin .sj {
            color: #6b099a;
        }

        #miaosha-top .time li.time_begin .zt {
            color: #6b099a;
            border: 1px solid #6b099a;
        }

        #miaosha-top .time li.active {
            background: #6b099a !important;
            filter: none !important;
        }

        #miaosha-top .time li.active .sj {
            color: #fff !important;
        }

        #miaosha-top .time li.active .zt {
            color: #fff !important;
            border: 1px solid #fff !important;
        }

        /*秒杀商品*/
        .sp_box {
            width: 1200px;
            margin: 0 auto;
            /*	background: rgba(0, 0, 0, .2);*/
            /*filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#33000000,endColorstr=#33000000);*/
        }

        .sp_box li {
            box-sizing: border-box;
            width: 1200px;
            /*height: 530px;*/
            display: none;
            overflow: hidden;
        }

        .sp_box li.active {
            display: block;
        }

        .sp_box li .sp {
            box-sizing: border-box;
            width: 580px;
            height: 240px;
            margin: 10px;
            float: left;
            background: white;
        }

        .sp_box li .sp .img_box {
            box-sizing: border-box;
            width: 220px;
            height: 220px;
            border: 1px solid #e5e5e5;
            margin: 10px 0 0 10px;
            float: left;
            position: relative;
        }

        .sp_box li .sp .text {
            width: 320px;
            height: 220px;
            float: left;
            margin: 10px 0 0 20px;
        }

        .sp_box li .sp .text p {
            width: 100%;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: middle;
            font-size: 14px;
            height: 20px;
            line-height: 20px;
            margin-top: 5px;
        }

        .sp_box li .sp .text .name {
            color: #996027;
            font-size: 20px;
            height: 24px;
            line-height: 24px;
            margin-top: 0;
        }

        .sp_box li .sp .text .guige {
            color: #996027;
            border-bottom: 1px dashed #996027;
            height: 34px;
            line-height: 34px;
            margin-top: 0;
        }

        .sp_box li .sp .text .company {
            color: #6f6e6e;
        }

        .sp_box li .sp .text .shuliang {
            color: #6f6e6e;
        }

        .sp_box li .sp .text .xiangou {
            color: #fd333c;
            font-weight: bold;
            border-bottom: 1px dashed #996027;
            padding-bottom: 5px;
        }

        .sp_box li .sp .text .jiage {
            height: 48px;
            line-height: 48px;
            color: #fd333c;
            margin: 0;
        }

        .sp_box li .sp .text .jiage span {
            font-size: 20px;
            font-weight: bold;
        }

        .sp_box li .sp .text .btn {
            display: inline-block;
            width: 100%;
            height: 32px;
            line-height: 32px;
            text-align: center;
            font-size: 18px;
            color: #fff;
            border-radius: 4px;
        }

        .sp_box li .sp .text .begin {
            background: #ff4e00;
        }

        .sp_box li .sp .text .maiwan {
            background: #999999;
        }

        .sp_box li .sp .text .qiang {
            background-image: linear-gradient(45deg, rgb(196, 43, 247) 0%, rgb(241, 45, 102) 100%);
            background-image: -moz-linear-gradient(45deg, rgb(196, 43, 247) 0%, rgb(241, 45, 102) 100%);
            background-image: -webkit-linear-gradient(45deg, rgb(196, 43, 247) 0%, rgb(241, 45, 102) 100%);
            background-image: -ms-linear-gradient(45deg, rgb(196, 43, 247) 0%, rgb(241, 45, 102) 100%);
        }

        /*已抢完*/
        .none {
            position: absolute;
            left: 0;
            bottom: 0;
            display: none;
        }

        .sp_box li .sp .img_box img {
            width: 100%;
        }

        .diqu {
            float: right;
            font-size: 14px !important;
            color: #f32c3a;
            display: inline-block;
            height: 22px;
            line-height: 22px;
            padding: 0 2px;
            margin-top: 13px;
            border: 1px solid #f32c3a;
            font-weight: initial !important;
        }
    </style>
    @include('layout.token')
    @include('common.ajax_set')
@endsection
@section('content')
    @include('miaosha.daohang')
    <input type="hidden" value="{{$start}}" id="start">
    <input type="hidden" value="{{$end}}" id="end">
    <div id="miaosha-top">
        <ul class="time">
            @foreach($team as $k=>$v)
                <li data-start="{{$v->start}}" data-end="{{$v->end}}" class="time_begin active">
                    <p class="sj">{{date('H:i',$v->start)}}</p>
                    <p class="zt">即将开始</p>
                </li>
            @endforeach
        </ul>
        <div class="remaitime">
            <div class="time-after">
                <span class="hourse"></span>
                <span class="s">时</span>
                <span class="minute"></span>
                <span class="s">分</span>
                <span class="second"></span>
                <span class="s">秒</span>
            </div>
            距离秒杀<span class="zhuangtai-text-1">开始</span>还有：
        </div>
        <div class="remaitime1">
            活动已结束
        </div>
        {{--<ul id="jyje" style="width: 250px;text-align: center;margin: 0 auto;margin-top: 30px;">--}}
        {{--<li style="display: none"><img style="width: 250px;"--}}
        {{--src="{{get_img_path('images/miaosha/171109/500.png')}}"></li>--}}
        {{--</ul>--}}
    </div>
    <div id="miaosha-bottom">
        <ul class="sp_box">
            @foreach($team as $k=>$v)
                <li data-hdcheck="0" class="active">
                    @foreach($v->goods as $val)
                        <div class="sp" id="{{$val->goods_id}}" data-type="1" data-kc="{{$val->goods_number}}">
                            <div class="img_box">
                                @if($val->goods_id==15932)
                                    <img src="http://images.hezongyy.com/images/201505/thumb_img/15932_thumb_P_1431937292676.jpg?110112">
                                @else
                                    <img src="{{$val->goods_thumb}}"/>
                                @endif
                                {{-- <img id="none{{$val->goods_id}}" class="none"
                                     src="{{get_img_path('images/miaosha/171109/none.png')}}"> --}}
                            </div>
                            <div class="text">
                                <p class="name">{{$val->goods_name}}</p>
                                <p class="guige">{{$val->spgg}}<span
                                            style="float: right;color: #fd333c;">效期：{{$val->xq}}</span></p>
                                <p class="company">{{$val->sccj}}</p>
                                <p class="shuliang" id="kc{{$val->goods_id}}">总量：{{$val->goods_number}}</p>
                                <p class="xiangou"><span
                                            style="float: left;">固定抢购量：{{$val->cart_number}}{{$val->dw}}</span><span
                                            style="font-size: 12px;float: right;">@if($val->goods_id==31644)
                                            全国独家剂型，不伤胃@else{{$val->xg_tip}}@endif</span></p>
                                <p class="jiage">秒杀价：￥<span
                                            style="margin-right: 20px;">{{sprintf('%.2f',$val->real_price)}}</span>
                                    <strike>原价：{{sprintf('%.2f',$val->old_price)}}</strike>
                                </p>
                                <a data-id="{{$val->goods_id}}" id="btn{{$val->goods_id}}" href="javascript:;"
                                   class="btn begin">即将开始</a>
                            </div>
                        </div>
                    @endforeach
                </li>
            @endforeach
        </ul>

        <div style="margin: 50px auto;color:#de3049;font-size:22px;">
            <h3 style="width: 850px;margin: 10px auto;">活动提示:</h3>
            <h5 style="width: 850px;margin: 10px auto;">1.活动期间，秒杀商品未能在秒杀时间范围内提交订单，秒杀商品将自动取消。</h5>
            <h5 style="width: 850px;margin: 5px auto;">2.秒杀商品只能在秒杀活动页面抢购，搜索相同商品加入购物车均视为无效秒杀。</h5>
            <h5 style="width: 850px;margin: 10px auto;">3.秒杀商品不参加任何优惠券和返利活动</h5>



        </div>
    </div>
    <script>
        $(function () {
            var now_check = -1;
            var now = 0;
            var start = parseInt($('#start').val());
            var end = parseInt($('#end').val());
            var jieshu;
            var second;
            var minite;
            var hour;
            var time_arr = [];
            var sjs = Math.random() * 1000 + 1;
            $.ajax({
                url: '/get_kc',
                type: 'get',
                beforeSend: function () {
                    layer.load(1, {
                        shade: [0.1, '#fff'] //0.1透明度的白色背景
                    });
                },
                complete: function () {
                    layer.closeAll('loading');
                },
                success: function (data) {
                    now = data.now;
                    for (var i in data.arr) {
                        var id = data.arr[i].id;
                        var kc = data.arr[i].kc;
                        if (kc <= 0) {
                            kc = 0;
                            $('#btn' + id).addClass('maiwan').removeClass('begin');
                            $('#btn' + id).text('已抢完');
                            $('#none' + id).show();
                            $('#' + id).data('kc', kc);
                        }
                        $('#kc' + id).text('总量：' + kc);
                    }
                    if (now < start) {
                        jieshu = start - now;
                    } else {
                        jieshu = end - now;
                    }
                    if (jieshu < 0) {
                        jieshu = 0;
                    }
                    judge();
                    start1();
                    window.setInterval(start1, 1000);
                }
            });
            $('#miaosha-top .time li').hover(function () {
                $(this).click();
            });
            $('#miaosha-top .time li').click(function () {
                var tar = $(this).index();
                var start = parseInt($(this).data('start'));
                var end = parseInt($(this).data('end'));
                $(this).addClass('active').siblings('li').removeClass('active');
                var _thisTime = $(this).children('.sj').html();
                $('.remaitime .now_time').html(_thisTime);
                $('#jyje li').hide();
                $('#jyje li').eq(tar).show();
                $('#miaosha-bottom .sp_box li').eq(tar).addClass('active').siblings('li').removeClass('active');
                if (now < start) {
                    $('.remaitime1').hide();
                    $('.remaitime').show();
                    $('.zhuangtai-text-1').html("开始");
                    $(this).find('.zt').html("即将开始");
                    $(this).removeClass('time_ing').removeClass('over');
                    $(this).data('hdcheck', 0);
                    $('.jies').hide();
                    $('.daojishi').show();
                    $('#miaosha-bottom .sp_box li').eq(tar).find('.btn').text('即将开始');
                    $('#miaosha-bottom .sp_box li').eq(tar).find('.btn').addClass('begin').removeClass('maiwan');
                    jieshu = start - now;
                }
                else if (now >= start && now < end) {  //判断当前时间大于秒杀时间,则状态为结束,倒计时也为结束
                    $('.remaitime1').hide();
                    $('.remaitime').show();
                    $('.zhuangtai-text-1').html("结束");
                    $(this).find('.zt').html("正在秒杀");
                    $(this).addClass('time_ing').removeClass('time_begin').removeClass('over');
                    $(this).data('hdcheck', 1);
                    $('.jies').hide();
                    $('.daojishi').show();
                    $('#miaosha-bottom .sp_box li').eq(tar).find('.sp').each(function () {
                        var kc = $(this).data('kc');
                        if (kc > 0) {
                            $(this).find('.btn').text('立即抢购');
                            $(this).find('.btn').addClass('qiang').removeClass('maiwan');
                            $(this).find('a').unbind('click');
                            $(this).find('a').bind('click', function () {
                                var goods_id = $(this).data('id');
                                add_to_redis(goods_id)
                            });
                        } else {
                            $(this).find('.btn').text('已抢完');
                            $(this).find('.btn').addClass('maiwan').removeClass('qiang');
                        }
                    });
                    jieshu = end - now;
                } else if (now >= end) {
                    $('.remaitime').hide();
                    $('.remaitime1').show();
                    $('.zhuangtai-text-1').html("结束");
                    $(this).find('.zt').html("已经结束");
                    $(this).data('hdcheck', 2);
                    $('.jies').show();
                    $('.daojishi').hide();
                    $(this).addClass('over');
                    $('#miaosha-bottom .sp_box li').eq(tar).find('.sp .btn').text('已抢完');
                    $('#miaosha-bottom .sp_box li').eq(tar).find('.sp .btn').addClass('maiwan').removeClass('qiang');
                }
                minite = Math.floor((jieshu / 60) % 60); //计算分
                hour = Math.floor((jieshu / 3600)); //计算小时
                $('.hourse').html(hour);
                $('.minute').html(minite);
            });

            //判断秒杀时间状态
            function judge() {
                if (now < start) {
                    $('.time li').eq(0).click();
                    time_arr.push($('.time li').eq(0).data('start'));
                    time_arr.push($('.time li').eq(0).data('end'));
                } else {
                    $('.time li').each(function (index) {
                        var tar = index;
                        var _this = $('.time li').eq(tar);
                        time_arr.push(_this.data('start'));
                        time_arr.push(_this.data('end'));
                        if (now >= _this.data('start')) {
                            _this.click();
                            now_check = tar;
                        }
                    });
                    var hdcheck = $('.time li').eq(now_check).data('hdcheck');
                    if (hdcheck == 2) {
                        $('.time li').eq(now_check + 1).click();
                    }
                }
            }

            function start1() {
                now++;
                jieshu--;
                second = Math.floor(jieshu % 60); // 计算秒
                minite = Math.floor((jieshu / 60) % 60); //计算分
                hour = Math.floor((jieshu / 3600)); //计算小时
                $('.hourse').html(hour);
                $('.second').html(second);
                $('.minute').html(minite);

                if ($.inArray(now, time_arr) != -1) {
                    judge();
                }
            }
            function add_to_redis(id) {
                var type = $('#' + id).data('type');
                if (type != 0 && type != -1) {
                    $('#' + id).data('type', -1);
                    layer.load(1, {
                        shade: [0.1, '#fff'] //0.1透明度的白色背景
                    });
                    setTimeout(function () {
                        $.ajax({
                            url: '/buy_ms',
                            data: {id: id},
                            dataType: 'json',
                            complete: function () {
                                layer.closeAll('loading');
                            },
                            success: function (result) {
                                if (result) {
                                    if (result.error == 0) {
                                        if (result.kc <= 0) {
                                            result.kc = 0;
                                            $('#btn' + id).addClass('maiwan').removeClass('begin').removeClass('qiang');
                                            $('#btn' + id).text('已抢完');
                                            $('#none' + id).show();
                                        }
                                        $('#kc' + id).text('总量：' + result.kc);
                                        $('#' + id).data('kc', result.kc);
                                        layer.confirm(result.msg, {
                                            btn: ['继续购物', '去结算'], //按钮
                                            icon: 1
                                        }, function (index) {
                                            layer.close(index);
                                        }, function () {
                                            location.href = '/cart';
                                            return false;
                                        });
                                    } else if (result.error == 2) {
                                        layer.confirm(result.msg, {
                                            btn: ['注册', '登录'], //按钮
                                            icon: 2
                                        }, function () {
                                            location.href = '/auth/register';
                                        }, function () {
                                            location.href = '/auth/login';
                                            return false;
                                        });
                                    } else {
                                        layer.msg(result.msg, {icon: result.error + 1});
                                    }
                                    $('#' + id).data('type', result.error)
                                }
                            }
                        })
                    }, sjs)
                } else if (type == 0) {
                    layer.confirm('商品已抢购', {
                        btn: ['继续购物', '去结算'], //按钮
                        icon: 1
                    }, function (index) {
                        layer.close(index);
                    }, function () {
                        location.href = '/cart';
                        return false;
                    });
                }
            }
        });
    </script>
@endsection