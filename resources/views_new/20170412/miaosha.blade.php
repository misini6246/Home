@extends('layout.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('20170412/css/qianggou.css')}}"/>
    <style>
        #container{
            width: 100%;
            min-width: 1200px;
            height: 800px;
            background: url('{{get_img_path('images/20170412/img/bg.jpg')}}') no-repeat scroll top center;
        }
        .remaintime9 .remaintime-box-9,.remaintime14 .remaintime-box-14{
            width: 430px;
            height: 60px;
            background: url('{{get_img_path('images/20170412/img/daojishi-bg.jpg')}}');
            margin: 10px 10px;
            position: relative;
        }
        .chanpin-1,.chanpin-2{
            width: 580px;
            height: 260px;
            background: url('{{get_img_path('images/20170412/img/chanpin-bg.jpg')}}');
            float: left;
            position: relative;
        }
    </style>
    <!--[if lte IE 8]>
    <script src="{{path('20170412/js/PIE_IE678.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
    @include('common.tanchu_attr')
    @include('layout.token')
    @include('common.ajax_set')
@endsection
@section('content')
    <div id="container">
        <input type="hidden" value="{{$now}}" id="now_time"/>
        <div class="container-box">
            <div class="title">
                <div class="title-img">
                    <img src="{{get_img_path('images/20170412/img/title.png')}}"/>
                </div>
            </div>

            <!--秒杀时间开始-->
            <div class="shijian">
                @foreach($team as $k=>$v)
                    <div class="shijian-{{$v->team}}" start="{{$v->start}}" end="{{$v->end}}"
                         @if(($now_check==0&&$k==0)||$now_check==$v->team||($now_check==-1&&$k==0)) style="background:#f55967;"
                         now_check="1" @elseif($v->hd_status==2) style="background:#999999;" now_check="0"
                         @else style="background:#4dac98;" now_check="0" @endif>
                        <img src="{{get_img_path('images/20170412/img/'.$v->team.'dian.png')}}"/>
                        <p class="start"
                           style="line-height: 58px; @if($now<$v->start) display:block; @else display:none @endif">
                            即将开始</p>
                        <p class="ing"
                           style="line-height: 58px; @if($now>=$v->start&&$now<$v->end) display:block; @else display:none @endif">
                            秒杀进行中...</p>
                        <p class="end"
                           style="line-height: 58px; @if($now>=$v->end) display:block; @else display:none @endif">
                            秒杀已结束</p>
                    </div>
                @endforeach
            </div>
            <!--秒杀时间结束-->

            <!--倒计时开始-->
            @foreach($team as $k=>$v)
                <div hd_status="{{$v->hd_status}}" class="remaintime{{$v->team}}"
                     @if(($now_check==0&&$k==0)||$now_check==$v->team||$now_check==-1)
                     @if($v->hd_status==0) style="border: 10px solid #96cdc1;"
                     @elseif($v->hd_status==1) style="border: 10px solid #96cdc1;"
                     @else style="border: 10px solid #999999;"
                     @endif
                     now_check="1" @elseif($v->hd_status==2) now_check="0" style="display: none;"
                     @else now_check="0" style="display: none;" @endif>
                    <div class="remaintime-box-{{$v->team}}"
                         @if($v->hd_status==0) style="background: url('{{get_img_path('images/20170412/img/daojishi-bg.jpg')}}');"
                         @elseif($v->hd_status==1) style="background: url('{{get_img_path('images/20170412/img/end.jpg')}}');"
                         @else style="background: url('{{get_img_path('images/20170412/img/jieshu.jpg')}}');"
                            @endif>
                        <div class="hourse"></div>
                        <div class="minuted"></div>
                        <div class="sencond"></div>
                    </div>
                </div>
            @endforeach
        <!--倒计时结束-->
            <!--产品开始-->
            @foreach($team as $k=>$val)
                <div class="chanpin-{{$val->team}}"
                     @if(($now_check==0&&$k==0)||$now_check==$val->team||$now_check==-1)
                     now_check="1" style="display: block;" @elseif($v->hd_status==2) now_check="0"
                     style="display: none;"
                     @else now_check="0" style="display: none;" @endif>
                    @foreach($val->goods as $k=>$v)
                        <div class="chanpin-{{$k+1}}">
                            <div class="chanpin-img">
                                <img style="width: 220px;height: 220px;" src="{{($v->goods_thumb)}}"/>
                            </div>
                            <div class="maiwan" @if($v->goods_number<=0) style="display: block" @endif>
                                <img src="{{get_img_path('images/20170412/img/maiwan.png')}}"/>
                            </div>
                            <div class="mingzi">
                                {{str_limit($v->goods_name,22)}}
                            </div>
                            <div class="haosheng">
                                {{$v->spgg}}
                            </div>
                            <div class="company">
                                {{str_limit($v->product_name,38)}}
                            </div>
                            <div class="kucun">
                                库存：<span>{{$v->goods_number}}</span>
                            </div>
                            <div class="xianliang">
                                限量：<span>{{$v->cart_number}}</span>
                                @if(count($v->area_xg)>0&&$val->team!=9)
                                    <span style="float:right;text-align: right;width: 215px;color: red;*position: absolute;*top: 0;*left: 50px;">{{$v->xg_tip}}</span>
                                @endif
                            </div>
                            <div class="jiage">
                                秒杀价：￥<span>{{sprintf('%.2f',$v->real_price)}}</span>
                            </div>
                            <div @if($val->hd_status==1&&$v->goods_number>0) style="display: block" @else style="display: none;" @endif class="goumaiBtn" type="1" id="{{$v->goods_id}}"
                                 onclick="add_to_redis({{$v->goods_id}})" href="javascript:;">
                                立即秒杀
                            </div>
                            <div @if($val->hd_status==0&&$v->goods_number>0) style="display: block" @else style="display: none;" @endif class="goumaiBtn-1">
                                活动未开始
                            </div>
                            <div @if($val->hd_status==2&&$v->goods_number>0) style="display: block" @else style="display: none;" @endif class="goumaiBtn-end">
                                活动已结束
                            </div>
                            <div @if($v->goods_number<=0) style="display: block" @else style="display: none;" @endif class="goumaiBtn-no">
                                已售罄
                            </div>
                        </div>
                    @endforeach
                </div>
        @endforeach
        <!--产品结束-->
        </div>
    </div>
    @include('20170412.daohang')
    <script type="text/javascript">

        //	活动剩余时间定时器
        var SysSecond;
        var SysSecond14;
        var InterValObj;
        var date9 = parseInt($('.shijian-9').attr('start'));
        var data14 = parseInt($('.shijian-14').attr('start'));
        var data1 = parseInt($('#now_time').val());
        var hd_status9 = $('.remaintime9').attr('hd_status');
        var hd_status14 = $('.remaintime14').attr('hd_status');
        var s9 = date9;
        var s1 = data1;
        var s14 = data14;

        $(function () {
            $('.shijian-9').hover(function () {
                $('.chanpin-9').css('display', 'block');
                $('.chanpin-14').css('display', 'none');
                $('.remaintime9').css('display', 'block');
                $('.remaintime14').css('display', 'none');
                $('.remaintime9').css('display', 'block');
                $('.remaintime14').css('display', 'none');
                $('.shijian-9').css('background', '#f55967');
                if (hd_status14 == 2) {
                    $('.shijian-14').css('background', '#999999');
                } else {
                    $('.shijian-14').css('background', '#4dac98');
                }
                $('.shijian-9').attr('now_check', 1);

            })
            $('.shijian-14').hover(function () {
                $('.chanpin-14').css('display', 'block');
                $('.chanpin-9').css('display', 'none');
                $('.remaintime14').css('display', 'block');
                $('.remaintime9').css('display', 'none');
                $('.remaintime14').css('display', 'block');
                $('.remaintime9').css('display', 'none');
                $('.shijian-14').css('background', '#f55967');
                if (hd_status9 == 2) {
                    $('.shijian-9').css('background', '#999999');
                }else{
                    $('.shijian-9').css('background', '#4dac98');
                }
                $('.shijian-14').attr('now_check', 1);
            });
            if (hd_status9 == 1) {
                s9 = parseInt($('.shijian-9').attr('end'));
            }
            if (hd_status14 == 1) {
                s14 = parseInt($('.shijian-14').attr('end'));
            }
            SysSecond = (s9 - s1);//这里获取倒计时的起始时间

            SysSecond14 = (s14 - s1);
            InterValObj9 = setInterval(SetRemainTime9, 1000);//间隔函数，1秒执行
            InterValObj14 = setInterval(SetRemainTime14, 1000);//间隔函数，1秒执行
        });


        //将时间减去1秒，计算天、时、分、秒
        function SetRemainTime9() {
            s1++;
            if (SysSecond >= 0) {
                SysSecond = SysSecond - 1;
                var second = Math.floor(SysSecond % 60);             // 计算秒
                var minite = Math.floor((SysSecond / 60) % 60);      //计算分
                var hour = Math.floor((SysSecond / 3600));      //计算小时
                $(".remaintime-box-9").html('<span class="hourse">' + hour + '</span>' + '<span class="sencond">' + minite + '</span>' + '<span class="minuted">' + second + '</span>');
            }
            if (SysSecond < 1) {
                if (hd_status9 == 0) {//未开始 变成开始
                    $('.shijian-9').css('background', '#f55967');
                    $('.shijian-14').css('background', '#4dac98');
                    $('.remaintime9').css('border', '10px solid #96cdc1');
                    $('.remaintime9').css('display', 'block');
                    $('.remaintime14').css('display', 'none');
                    $('.chanpin-9').css('display', 'block');
                    $('.chanpin-14').css('display', 'none');
                    $('.remaintime-box-9').css('background', 'url({{get_img_path('images/20170412/img/end.jpg')}})');
                    $('.chanpin-9 .goumaiBtn').css('display', 'block');
                    $('.chanpin-9 .goumaiBtn-1').css('display', 'none');
                    $('.chanpin-9 .goumaiBtn-end').css('display', 'none');
                    $('.shijian-9 .start').css('display', 'none');
                    $('.shijian-9 .ing').css('display', 'block');
                    $('.shijian-9 .end').css('display', 'none');
                    var date9 = parseInt($('.shijian-9').attr('end'));
                    //9点活动结束时间设置
                    var s9 = date9;
                    SysSecond = (s9 - s1);
                    hd_status9 = 1;
                } else if (hd_status9 == 1) {//已开始 到结束
                    $(".remaintime-box-9").html('');
                    $('.shijian-9').css('background', '#999999');
                    $('.remaintime9').css('border', '10px solid #999999');

                    $('.remaintime-box-9').css('background', 'url({{get_img_path('images/20170412/img/jieshu.jpg')}})');
                    $('.chanpin-9 .goumaiBtn-1').css('display', 'none');
                    $('.chanpin-9 .goumaiBtn').css('display', 'none');
                    $('.chanpin-9 .goumaiBtn-end').css('display', 'block');
                    $('.chanpin-9 .goumaiBtn-no').css('display', 'none');
                    $('.shijian-9 .start').css('display', 'none');
                    $('.shijian-9 .ing').css('display', 'none');
                    $('.shijian-9 .end').css('display', 'block');
                    hd_status9 = 2;
                    clearInterval(InterValObj9);
                }

            }

        }
        //	活动剩余时间定时器

        function SetRemainTime14() {
            if (SysSecond14 > 0) {
                SysSecond14 = SysSecond14 - 1;
                var second14 = Math.floor(SysSecond14 % 60);             // 计算秒
                var minite14 = Math.floor((SysSecond14 / 60) % 60);      //计算分
                var hour14 = Math.floor((SysSecond14 / 3600));      //计算小时
                $(".remaintime-box-14").html('<span class="hourse">' + hour14 + '</span>' + '<span class="sencond">' + minite14 + '</span>' + '<span class="minuted">' + second14 + '</span>');
            }
            if (SysSecond14 < 1) {
                if (hd_status14 == 0) {
                    $('.shijian-14').css('background', '#f55967');
                    $('.shijian-9').css('background', '#4dac98');
                    $('.remaintime14').css('border', '10px solid #96cdc1');
                    $('.remaintime14').css('display', 'block');
                    $('.remaintime9').css('display', 'none');
                    $('.chanpin-14').css('display', 'block');
                    $('.chanpin-9').css('display', 'none');
                    $('.remaintime-box-14').css('background', 'url({{get_img_path('images/20170412/img/end.jpg')}})');
                    $('.chanpin-14 .goumaiBtn').css('display', 'block');
                    $('.chanpin-14 .goumaiBtn-1').css('display', 'none');
                    $('.chanpin-14 .goumaiBtn-end').css('display', 'none');
                    $('.shijian-14 .start').css('display', 'none')
                    $('.shijian-14 .ing').css('display', 'block')
                    $('.shijian-14 .end').css('display', 'none')
                    var date14 = parseInt($('.shijian-14').attr('end'));  //9点活动结束时间设置
                    var s14 = date14;
                    SysSecond14 = (s14 - s1);
                    hd_status14 = 1;
                } else if (hd_status14 == 1) {
                    $(".remaintime-box-14").html('');
                    $('.shijian-14').css('background', '#999999');
                    $('.remaintime14').css('border', '10px solid #999999');

                    $('.remaintime-box-14').css('background', 'url({{get_img_path('images/20170412/img/jieshu.jpg')}})');
                    $('.chanpin-14 .goumaiBtn-1').css('display', 'none');
                    $('.chanpin-14 .goumaiBtn').css('display', 'none');
                    $('.chanpin-14 .goumaiBtn-end').css('display', 'block');
                    $('.chanpin-14s .goumaiBtn-no').css('display', 'none');
                    $('.shijian-14 .start').css('display', 'none');
                    $('.shijian-14 .ing').css('display', 'none');
                    $('.shijian-14 .end').css('display', 'block');
                    hd_status14 = 2;
                    clearInterval(InterValObj14);
                }
            }
        }
        function add_to_redis(id) {
            var type = $('#' + id).attr('type');
//            if (type == 1) {
//
//            } else {
//                $(".tip_text").html('商品已抢购');
//                $(".tanchuc").show();
//            }
            $.ajax({
                url: '/buy_ms',
                data: {id: id},
                dataType: 'json',
                success: function (result) {
                    if (result) {
                        add_tanchuc(result.msg);
                        $('#' + id).attr('type', result.error)
                    }
                }
            })
        }
    </script>
@endsection