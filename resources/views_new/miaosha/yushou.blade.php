@extends('layout.body')
@section('links')
    <style>
        * {
            margin: 0;
            padding: 0;
            list-style: none;
            font-family: "微软雅黑";
            font-size: 12px;
            box-sizing: border-box;
            text-decoration: none;
        }

        img {
            border: none;
            vertical-align: middle;
        }

        #header {
            width: 100%;
            height: 1376px;
            background: url('{{get_img_path('images/hd/top_bg.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
            position: relative;
        }

        #container {
            width: 100%;
            height: 1061px;
            background: url('{{get_img_path('images/hd/bottom_bg.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
            overflow: hidden;
        }

        .center {
            width: 1060px;
            margin: 0 auto;
        }

        #container .center .content .title {
            width: 648px;
            height: 80px;
            margin: 0 auto;
        }

        #container .center .content .title span {
            width: 324px;
            height: 80px;
            line-height: 80px;
            text-align: center;
            color: white;
            font-size: 40.39px;
            display: inline-block;
            border: 1px solid #e00e17;
            *width: 320px;

        }

        #container .center .content li {
            display: none;
        }

        #container .center .content .title span:first-child {
            background: #e00e17;
        }

        .chanpin_1, .chanpin_2 {
            width: 880px;
            height: 445px;
            margin-left: 118px;
        }

        .chanpin_1 {
            margin-top: 92px;
        }

        .chanpin_2 {
            margin-top: 50px;
        }

        .img_box {
            width: 428px;
            height: 290px;
            line-height: 290px;
            text-align: center;
            margin-top: 65px;
            overflow: hidden;
            float: left;

        }

        .img_box img {
            width: 100%;
        }

        .text {
            width: 435px;
            height: 405px;
            float: right;
            margin-top: 10px;
            text-indent: 15px;
            color: white;
        }

        .text p {
            vertical-align: middle;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text .guige {
            font-size: 25px;
            margin-top: 27px;
        }

        .text .name {
            font-size: 35px;
            line-height: 70px;
        }

        .text .company {
            font-size: 20.19px;
            margin-top: 8px;
        }

        .text hr {
            width: 191px;
            height: 6px;
            background: #e00e17;
            border: 0;
            margin: 15px 0 18px 15px;
            text-align: left;
            *margin-left: 0;
        }

        .text .xiangou {
            font-size: 25px;
            margin-left: 15px;
        }

        .text .btn {
            display: inline-block;
            width: 355px;
            height: 83px;
            background: #ffff00;
            text-indent: 0;
            margin: 18px 0 0 15px;
            position: relative;
        [;
            margin-left: 0;
        ];
            *margin-left: 15px;
        }

        .btn_tomorrow {
            background: #bfbfbf !important;

        }

        .btn_tomorrow span {
            color: #290d3b !important;
        }

        .btn_tomorrow span.url {
            color: #fff !important;
        }

        .text .btn span {
            height: 50px;
            float: left;
            color: #000;
            /*margin-top: 16px;*/
            cursor: pointer;
        }

        .text .btn span.yuanjia p {
            font-size: 17.06px;
            margin-left: 12px;
        }

        .text .btn span.yuanjia p:first-child {
            text-decoration: line-through;
        }

        .text .btn span.jiage {
            font-size: 53.34px;
            font-weight: bold;
            line-height: 50px;
            margin: 16px 0 0 0px;
        }

        .text .btn span.yuanjia {
            margin-top: 20px;
        }

        .text .btn span.url {
            font-size: 17.06px;
            line-height: 30px;
            color: white;
            width: 111px;
            height: 30px;
            background: #000;
            margin: 28px 0 0 7px;
            text-align: center;
            border-radius: 30px;
        }

        .sanjiao {
            position: absolute;
            right: 0;
            top: 0;
            width: 0;
            height: 0;
            border-top: 42px solid transparent;
            border-right: 13px solid #280e3a;
            border-bottom: 42px solid transparent;
        }

        .active {
            display: block !important;
        }

        /*ADD*/
        .time_arr {
            width: 886px;
            height: 98px;
            /*border: 1px solid red;*/
            /*margin: 0 auto;*/
            position: absolute;
            bottom: 194px;
            margin-left: 94px;
            /*overflow: hidden;*/
        }

        .time_arr li {
            /*width: 105px;*/
            width: 155px;
            /*border: 1px solid red;*/
            height: 98px;
            float: left;
            margin-left: 18.7px;
            background: #fff;
            cursor: pointer;
            text-align: center;
        }

        .time_arr li p {
            text-align: center;
            color: #000;
            display: inline-block;
            margin: 2px 0 0 0;
        }

        .time_arr li p.date {
            font-size: 32px;
            font-weight: bold;
            margin-top: 8px;
        }

        .time_arr li p.txt {
            color: #000;
            font-size: 16px;
            border: 1px solid #000;
            width: 80px;
            height: 25px;
            /*margin: 2px 0 0 12.5px;*/
            border-radius: 30px;
        }

        .time_arr li p.over {
            color: #999;
            font-size: 16px;
            border: 1px solid #999;
            width: 80px;
            height: 25px;
            /*margin: 2px 0 0 12.5px;*/
            border-radius: 30px;
        }

        .time_arr li.active {
            box-shadow: 4px 0 16px rgba(13, 102, 136, 0.69);
            background: #6f0eaa;
        }

        .time_arr li.active p {
            color: #fff;
        }

        .time_arr li.active p.txt {
            border: 1px solid #fff;
        }

        .jian {
            background: url('{{get_img_path('images/hd/jian.jpg')}}') no-repeat;
        }

        .jia {
            background: url('{{get_img_path('images/hd/jia.jpg')}}') no-repeat;
        }

        .jian, .jia, .shuliang {
            height: 38px;
            line-height: 38px;
            text-align: center;
            float: left;
            text-indent: 0 !important;
            border: 1px solid #e5e5e5;
        }

        .jian, .jia {
            width: 38px;
            cursor: pointer;
        }

        .shuliang {
            border-left: none;
            border-right: none;
            width: 80px;
            font-size: 18px;
            color: #000;
        }

        .xl {
            float: left;
        }

        .xl p {
            font-size: 18px;
            color: #fff;
            margin-top: -4px;
            height: 38px;
        }

        /*定时器*/
        .remaintime {
            width: 419px;
            height: 35px;
            line-height: 35px;
            position: absolute;
            bottom: 129px;
            margin-left: 327px;
            color: #fff;
            text-align: center;
        }

        .remaintime .zt {
            display: inline-block;
            height: 35px;
            line-height: 35px;
            font-size: 18px;
            text-align: center;
            position: relative;
            top: -3px;
        }

        .remaintime .zt span {
            color: #fbee3f;
            font-size: 18px;
        }

        .remaintime .hourse, .remaintime .minute, .remaintime .second {
            display: inline-block;
            width: 38px;
            height: 34px;
            line-height: 34px;
            /*border: 1px solid red;*/
            text-align: center;
            font-size: 24px;
            color: #fbee3f;
            background: url('{{get_img_path('images/hd/time_span.png')}}') no-repeat;
        }

        .remaintime .hourse {
            margin-left: 10px;
        }

        /*.remaintime .minute{
            margin-left: 22px;
        }
        .remaintime .second{
            margin-left: 21px;
        }*/
        .remaintime .time_txt {
            display: inline-block;
            height: 34px;
            line-height: 34px;
            /*border: 1px solid red;*/
            font-size: 18px;
            color: #fff;
            position: relative;
            top: -3px;
            margin: 0 5px;
        }


    </style>
    <!--[if lte IE 8]>
    <script src="{{path('20170412/js/PIE_IE678.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
    @include('layout.token')
    @include('common.ajax_set')
@endsection
@section('content')
    @include('miaosha.daohang')
    <input type="hidden" id="start" value="{{$start}}">
    <input type="hidden" id="end" value="{{$end}}">
    <input type="hidden" id="sjs" value="0">
    <div id="header">
        <div class="center">
            <ul class="time_arr">
                @foreach($team as $k=>$v)
                    {{--<li data-start="{{$v->start}}" data-end="{{$v->end}}"--}}
                    {{--@if(($v->hd_status==1||$v->hd_status==3)||($now_check==0&&$k==0))class="active"@endif>--}}
                    {{--<p class="date">{{date('m.d',$v->start)}}</p>--}}
                    {{--@if($v->hd_status==2||$now_check==-1)--}}
                    {{--<p class="over">活动结束</p>--}}
                    {{--@elseif($v->hd_status==1)--}}
                    {{--<p class="txt">正在抢购</p>--}}
                    {{--@else--}}
                    {{--<p class="txt">即将开始</p>--}}
                    {{--@endif--}}
                    {{--</li>--}}
                    <li data-start="{{$v->start}}" data-end="{{$v->end}}">
                        <p class="date">{{str_replace('0','',date('m月d日',$v->start))}}</p>
                        <p class="txt">即将开始</p>
                    </li>
                @endforeach
            </ul>
            <div class="remaintime">
                <span class="zt">距离<span>开始</span>还有</span>
                <span class="hourse">0</span><span class="time_txt">时</span>
                <span class="minute">0</span><span class="time_txt">分</span>
                <span class="second">0</span><span class="time_txt">秒</span>
            </div>
        </div>
    </div>
    <div id="container">
        <div class="center">
            <ul class="content">
                @foreach($team as $k=>$v)
                    <li @if(($v->hd_status==1||$v->hd_status==3)||($now_check==0&&$k==0))class="active"@endif>
                        @foreach($v->goods as $key=>$val)
                            <div class="chanpin_{{$key+1}}" id="{{$val->goods_id}}" data-type="1"
                                 data-cart_number="{{$val->cart_number}}" data-xg_number="{{$val->xg_number}}"
                                 data-jzl="{{$val->jzl or 0}}">
                                <div class="img_box">
                                    <img src="{{$val->ad->ad_code or ''}}"/>
                                </div>
                                <div class="text">
                                    <p class="guige"><span
                                                style="display: inline-block;width: 250px;font-size: 16px;text-indent: 0;">规格：{{$val->spgg}}</span>
                                        <span style="display: inline-block;width: 100px;font-size: 16px;text-indent: 0;">件装量：{{$val->jzl}}</span>
                                    </p>
                                    <p class="name">{{str_limit($val->goods_name,20)}}</p>
                                    @if($val->goods_id!=17937&&!empty($val->xq))
                                        <p style="font-size: 14px;">效期：{{$val->xq}}</p>
                                    @endif
                                    <p class="company">{{str_limit($val->sccj,34)}}</p>
                                    <hr/>
                                    <div class="xiangou">
                                        <div class="jian" onclick="change_num('{{$val->goods_id}}',-1)"></div>
                                        <input type="text" name="shuliang" class="shuliang"
                                               onchange="change_num('{{$val->goods_id}}')"
                                               value="{{$val->cart_number}}" id="shuliang{{$val->goods_id}}"/>
                                        <div class="jia" onclick="change_num('{{$val->goods_id}}',1)"></div>
                                        <div class="xl"
                                             @if(($val->xg_number>0&&empty($val->xg_tip))||($val->xg_number==0&&!empty($val->xg_tip)))
                                             style="line-height: 47px;"
                                                @endif>
                                            @if($val->xg_number>0)
                                                <p>当天限量：{{$val->xg_number}}</p>
                                            @endif
                                            @if(!empty($val->xg_tip))
                                                <p>{{$val->xg_tip}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    {{--<a href="javascript:;" class="btn @if($v->hd_status!=1) btn_tomorrow @endif"--}}
                                    {{--@if($v->hd_status==1)onclick="add_to_redis({{$val->goods_id}})"--}}
                                    {{--@endif data-id="{{$val->goods_id}}">--}}
                                    {{--<span class="yuanjia">--}}
                                    {{--<p style="width: 65px;">@if($k<2){{formated_price($val->old_price)}}@endif</p>--}}
                                    {{--<p>预售价:</p>--}}
                                    {{--</span>--}}
                                    {{--<span class="jiage">@if($k<2){{$val->real_price}}@endif</span>--}}
                                    {{--@if($v->hd_status==2||$now_check==-1)--}}
                                    {{--<span class="url">活动结束 ></span>--}}
                                    {{--@elseif($v->hd_status==1)--}}
                                    {{--<span class="url">点击抢购 ></span>--}}
                                    {{--@else--}}
                                    {{--<span class="url">敬请期待 ></span>--}}
                                    {{--@endif--}}
                                    {{--<div class="sanjiao"></div>--}}
                                    {{--</a>--}}
                                    <a href="javascript:;" id="kk{{$val->goods_id}}" class="btn btn_tomorrow"
                                       data-id="{{$val->goods_id}}" data-kc="{{$val->goods_number}}">
									<span class="yuanjia">
										<p style="width: 65px;">{{formated_price($val->old_price)}}</p>
										<p>预售价:</p>
									</span>
                                        <span class="jiage">{{sprintf('%.2f', $val->real_price)}}</span>
                                        <span class="url" id="btn{{$val->goods_id}}">敬请期待 ></span>
                                        <div class="sanjiao"></div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        var sjs = Math.floor(Math.random() * 999 + 1);
        sjs = 0;
        $(function () {
            var now;
            var start = parseInt($('#start').val());
            var end = parseInt($('#end').val());
            var jieshu = 0;
            var second;
            var minite;
            var hour;
            var time_arr = [];
            $.ajax({
                url: '/get_kc',
                type: 'get',
                success: function (data) {
                    now = data.now;
                    for (var i in data.arr) {
                        var id = data.arr[i].id;
                        var kc = data.arr[i].kc;
                        if (kc <= 0) {
                            kc = 0;
                            $('#btn' + id).text('已售罄');
                            $('#kk' + id).addClass('btn_tomorrow');
                            $('#kk' + id).data('kc', kc);
                        }
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
            $('.time_arr li').click(function () {
                var tar = $(this).index();
                var start = parseInt($(this).data('start'));
                var end = parseInt($(this).data('end'));
                if (now < start) {
                    $('.remaintime .zt').html("距离<span>开始</span>还有");
                    $(this).find('.txt').html("即将开始");
                    $('.remaintime .hourse,.remaintime .minute,.remaintime .second,.remaintime .time_txt').show();
                    $('.content li').eq(tar).find('.url:eq(0),.url:eq(1)').text('敬请期待');
                    $('.content li').eq(tar).find('.btn:eq(0),.btn:eq(1)').addClass('btn_tomorrow');
                    $('.content li').eq(tar).find('.btn:eq(0),.btn:eq(1)').unbind('click');
                    jieshu = start - now;
                    if (tar > 0 && now >= start - 3600 * 10) {
                        $('.content li').eq(tar).find('.yuanjia').show();
                        $('.content li').eq(tar).find('.jiage').show();
                    } else if (tar > 0) {
                        $('.content li').eq(tar).find('.yuanjia').hide();
                        $('.content li').eq(tar).find('.jiage').hide();
                        $('.content li').eq(tar).find('.url:eq(0),.url:eq(1)').css('margin-left', '110px')
                    }
                } else if (now >= start && now < end) {
                    $('.remaintime .zt').html("距离<span>结束</span>还有");
                    $(this).find('.txt').html("正在抢购");
                    $('.remaintime .hourse,.remaintime .minute,.remaintime .second,.remaintime .time_txt').show();
                    var kc = $('.content li').eq(tar).find('.btn:eq(0)').data('kc');
                    if (kc == 0) {
                        $('.content li').eq(tar).find('.url:eq(0)').text('已售罄');
                        $('.content li').eq(tar).find('.btn:eq(0)').addClass('btn_tomorrow');
                        $('.content li').eq(tar).find('.btn:eq(0)').unbind('click');
                    } else {
                        $('.content li').eq(tar).find('.url:eq(0)').text('点击抢购');
                        $('.content li').eq(tar).find('.btn:eq(0)').removeClass('btn_tomorrow');
                        $('.content li').eq(tar).find('.btn:eq(0)').on('click', function () {
                            add_to_redis($(this).data('id'));
                        });
                    }
                    var kc = $('.content li').eq(tar).find('.btn:eq(1)').data('kc');
                    if (kc == 0) {
                        $('.content li').eq(tar).find('.url:eq(1)').text('已售罄');
                        $('.content li').eq(tar).find('.btn:eq(1)').addClass('btn_tomorrow');
                        $('.content li').eq(tar).find('.btn:eq(1)').unbind('click');
                    } else {
                        $('.content li').eq(tar).find('.url:eq(1)').text('点击抢购');
                        $('.content li').eq(tar).find('.btn:eq(1)').removeClass('btn_tomorrow');
                        $('.content li').eq(tar).find('.btn:eq(1)').on('click', function () {
                            add_to_redis($(this).data('id'));
                        });
                    }
                    jieshu = end - now;
                    $('.content li').eq(tar).find('.yuanjia').show();
                    $('.content li').eq(tar).find('.jiage').show();
                } else {
                    $('.remaintime .hourse,.remaintime .minute,.remaintime .second,.remaintime .time_txt').hide();
                    $('.remaintime .zt').html("活动已结束");
                    $(this).find('.txt').html("活动结束");
                    $(this).find('.txt').addClass("over");
                    $('.content li').eq(tar).find('.url:eq(0),.url:eq(1)').text('活动结束');
                    $('.content li').eq(tar).find('.btn:eq(0),.btn:eq(1)').addClass('btn_tomorrow');
                    $('.content li').eq(tar).find('.btn:eq(0),.btn:eq(1)').unbind('click');
                    $('.content li').eq(tar).find('.yuanjia').show();
                    $('.content li').eq(tar).find('.jiage').show();
                }
                $(this).addClass('active').siblings('li').removeClass('active');
                $('.content li').eq(tar).addClass('active').siblings('li').removeClass('active');
                second = Math.floor(jieshu % 60); // 计算秒
                hour = Math.floor((jieshu / 3600)); //计算小时
                $('.hourse').html(hour);
                $('.second').html(second);
            })
            //判断秒杀时间状态
            function judge() {
                if (now < start) {
                    $('.time_arr li').eq(0).click();
                    time_arr.push($('.time_arr li').eq(0).data('start'));
                    time_arr.push($('.time_arr li').eq(0).data('end'));
                } else {
                    $('.time_arr li').each(function (index) {
                        var tar = index;
                        var _this = $('.time_arr li').eq(tar);
                        time_arr.push(_this.data('start'));
                        time_arr.push(_this.data('end'));
                        if (now >= parseInt(_this.data('start')) - 3600 * 10) {
                            _this.click();
                        }
                    })
                }
            }

            function start1() {
                now++;
                jieshu--;
                second = Math.floor(jieshu % 60); // 计算秒
                minite = Math.floor((jieshu / 60) % 60); //计算分
                hour = Math.floor((jieshu / 3600)); //计算小时
                $('.remaintime .hourse').html(hour);
                $('.remaintime .minute').html(minite);
                $('.remaintime .second').html(second);
                if ($.inArray(now, time_arr) != -1) {
                    time_arr = [];
                    judge();
                }
            }
        });
    </script>
    <script type="text/javascript">
        function change_num(id, type) {
            var cart_number = parseInt($('#' + id).data('cart_number'));
            var shuliang = parseInt($('#shuliang' + id).val());
            var xg_number = parseInt($('#' + id).data('xg_number'));
            var jzl = parseInt($('#' + id).data('jzl'));
            if (type == 1 || type == -1) {
                shuliang += cart_number * type;
            } else {
                shuliang = Math.ceil(shuliang / cart_number) * cart_number;
            }
            if (shuliang <= 0) {
                shuliang = cart_number;
            }
            if (shuliang > xg_number && xg_number > 0) {
                shuliang = xg_number;
            }
            if ((shuliang % jzl) / jzl >= 0.8 && type == -1) {
                shuliang = Math.floor(shuliang / jzl) * jzl + Math.ceil(jzl * 0.8 / cart_number) * cart_number - cart_number;
            } else if ((shuliang % jzl) / jzl >= 0.8) {
                shuliang = Math.ceil(shuliang / jzl) * jzl;
            }
            $('#shuliang' + id).val(shuliang);
        }
        function add_to_redis(id) {
            var type = $('#' + id).data('type');
            var cart_number = $('#' + id).data('cart_number');
            var shuliang = $('#shuliang' + id).val();
            var xg_number = parseInt($('#' + id).data('xg_number'));
            var jzl = parseInt($('#' + id).data('jzl'));
            if (shuliang > xg_number && xg_number > 0) {
                shuliang = xg_number;
            }
            if ((shuliang % jzl) / jzl >= 0.8 && type == -1) {
                shuliang = Math.floor(shuliang / jzl) * jzl + Math.ceil(jzl * 0.8 / cart_number) * cart_number - cart_number;
            } else if ((shuliang % jzl) / jzl >= 0.8) {
                shuliang = Math.ceil(shuliang / jzl) * jzl;
            }
            shuliang = Math.ceil(shuliang / cart_number) * cart_number;
            $('#shuliang' + id).val(shuliang);
            setTimeout(function () {
                $.ajax({
                    url: '/buy_ms',
                    data: {id: id, goods_number: shuliang},
                    dataType: 'json',
                    success: function (result) {
                        if (result) {
                            if (result.error == 0) {
                                if (result.kc <= 0) {
                                    result.kc = 0;
                                    $('#btn' + id).text('已售罄');
                                    $('#kk' + id).addClass('btn_tomorrow');
                                    $('#kk' + id).data('kc', result.kc);
                                }
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
        }
    </script>
@endsection