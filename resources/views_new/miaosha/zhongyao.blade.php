@extends('layout.body')
@section('links')
    		<!--[if lte IE 9]>
<style type="text/css">
    .text .qiang {
        background: #c62bf1;
    }
</style>
<![endif]-->
<style>
    body, li, p, ul, a, div {
        font-size: 12px;
        margin: 0;
        padding: 0;
        font-family: "microsoft yahei";
        list-style: none;
        text-decoration: none;
        box-sizing: border-box;
    }

    body {
        background: #801109;
        padding-bottom: 200px;
    }

    .section_1 .zhuangtai li {
        float: left;
        width: 248px;
        margin-left: 34px;
        text-align: center;
        height: 51px;
        line-height: 51px;
        cursor: pointer;
        position: relative;
    }

    .section_1 .zhuangtai li img {
        position: absolute;
        bottom: -34px;
        left: 114px;
    }

    .top {
        width: 100%;
        min-width: 1216px;
        background: url('{{get_img_path('images/miaosha/171109/banner.jpg')}}') no-repeat scroll top center;
        height: 578px;
    }

    .section_1, .section_2, .section_3, .section_4 {
        width: 1216px;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }

    .section_1 {
        height: 747px;
        background: url('{{get_img_path('images/miaosha/171109/section_1.jpg')}}') no-repeat scroll top center;
    }

    .section_2 {
        height: 737px;
        background: url('{{get_img_path('images/miaosha/171109/section_2.jpg')}}') no-repeat scroll top center;
    }

    .section_3 {
        height: 797px;
        background: url('{{get_img_path('images/miaosha/171109/section_3.jpg')}}') no-repeat scroll top center;
    }

    .section_4 {
        height: 537px;
        background: url('{{get_img_path('images/miaosha/171109/section_4.jpg')}}') no-repeat scroll top center;
    }

    .section_1 .zhuangtai {
        height: 51px;
        margin: 185px 0 0 170px;
    }

    .section_1 .zhuangtai li {
        float: left;
        width: 248px;
        margin-left: 34px;
        text-align: center;
        height: 51px;
        line-height: 51px;
        cursor: pointer;
    }

    .section_1 .zhuangtai li span.time {
        font-size: 24.78px;
        color: #fce3a4;
    }

    .section_1 .zhuangtai li span.zt {
        font-size: 24.78px;
        margin-left: 34px;
    }

    .section_1 .zhuangtai li.time_ing .zt {
        color: #fff04b;
    }

    .section_1 .zhuangtai li.time_end .zt, .section_1 .zhuangtai li.time_begin .zt {
        color: #333;
    }

    .section_1 .zhuangtai li.active .zt {
        color: #fff04b !important;
    }

    .remaintime {
        /*text-align: center;*/
        width: 188px;
        margin: 45px auto 0 auto;
    }

    .remaintime p {
        color: #000;
        font-size: 24.78px;
        text-align: center;
    }

    .remaintime p span.zt {
        color: #a3111e !important;
    }

    .remaintime .hourse, .remaintime .minute, .remaintime .second {
        display: inline-block;
        width: 40px;
        height: 34px;
        line-height: 34px;
        text-align: center;
        margin-top: 17px;
        color: #fbee3f;
        font-size: 24px;
    }

    .remaintime .minute {
        margin-left: 23px;
    }

    .remaintime .second {
        margin-left: 21px;
    }

    .chanpin_box {
        width: 1140px;
        margin: 45px auto 0 auto;
        height: 220px;
    }

    .chanpin_box li {
        display: none;
        /*overflow: hidden;*/
    }

    .chanpin_box li.active {
        display: block;
    }

    .chanpin_box .chanpin {
        width: 560px;
        height: 220px;
        float: left;
    }

    .chanpin_box .chanpin:first-child + .chanpin {
        margin-left: 20px;
    }

    .chanpin_box .chanpin .img_box {
        width: 220px;
        height: 220px;
        border: 1px solid #e5e5e5;
        float: left;
        position: relative;
    }

    .chanpin_box .chanpin .img_box .none {
        width: 218px;
        height: 80px;
        position: absolute;
        bottom: 0;
        left: 0;
        display: none;
    }

    .chanpin_box .chanpin .img_box img {
        width: 100%;
        height: 100%;
    }

    .chanpin_box .chanpin .text {
        width: 320px;
        *width: 318px;
        height: 220px;
        float: left;
        /*border: 1px solid red;*/
        margin-left: 20px;
    }

    .text p {
        width: 100%;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        vertical-align: middle;
    }

    .name {
        color: #a51121;
        font-size: 20px;
    }

    .guige, .company, .zongliang, .qianggou, .jiage {
        font-size: 14px;
    }

    .guige {
        color: #a51121;
        margin-top: 3px;
    }

    .company, .zongliang {
        color: #6f6e6e;
    }

    .company {
        margin-top: 12px;
    }

    .zongliang {
        margin-top: 7px;
    }

    .qianggou {
        color: #fd333c;
        font-weight: bold;
        margin-top: 4px;
    }

    .jiage {
        color: #fd333c;
        margin-top: 19px;
        *margin-top: 17px;
    }

    .jiage span {
        font-size: 20px;
        font-weight: bold;
    }

    .text .btn {
        height: 36px;
        line-height: 36px;
        border-radius: 5px;
        font-size: 18px;
        color: #fff;
        text-align: center;
        display: inline-block;
        width: 100%;
        margin-top: 11px;
        *margin-top: 10px;
    }

    .text .qiang {
        background-image: linear-gradient(45deg, rgb(196, 43, 247) 0%, rgb(241, 45, 102) 100%);
        background-image: -moz-linear-gradient(45deg, rgb(196, 43, 247) 0%, rgb(241, 45, 102) 100%);
        background-image: -webkit-linear-gradient(45deg, rgb(196, 43, 247) 0%, rgb(241, 45, 102) 100%);
        background-image: -ms-linear-gradient(45deg, rgb(196, 43, 247) 0%, rgb(241, 45, 102) 100%);
    }

    .text .begin {
        background: #ff4e00;
    }

    .text .maiwan {
        background: #999999;
    }

    /*秒杀下面的产品链接*/
    .chanpin_url {
        width: 935px;
        height: 474px;
        margin: 220px 0 0 140px;
    }

    .chanpin_url li {
        width: 334px;
        height: 474px;
        /*border: 1px solid red;*/
        float: left;
    }

    .chanpin_url li:first-child + li {
        margin-left: 267px;
    }

    .chanpin_url li .img_box {
        width: 280px;
        height: 280px;
        margin-left: 27px;
    }

    .chanpin_url li .img_box img {
        width: 100%;
        height: 100%;
    }

    .chanpin_url li p {
        text-align: center;
        font-size: 16px;
    }

    .chanpin_url li .name {
        margin-top: 10px;
        font-size: 24px;
    }

    .chanpin_url li .company, .chanpin_url li .guige, .chanpin_url li .qianggou {
        margin-top: 5px;
    }

    .chanpin_url li a {
        width: 100%;
        height: 60px;
        line-height: 60px;
        display: inline-block;
        margin-top: 10px;
        font-size: 36px;
        color: #fce3a4;
        text-indent: 75px;
        *text-indent: 40px;
        font-weight: bold;
    }

    .readmore {
        width: 300px;
        height: 50px;
        display: block;
        margin: 25px auto;
    }

    .mon {
        /*border: 1px solid red;*/
        width: 125px;
        text-align: center;
        margin-left: 50px;
        text-indent: 0 !important;
        font-size: 36px;
        *margin-left: 10px;
    }

</style>
@include('layout.token')
@include('common.ajax_set')
@endsection
@section('content')
    @include('miaosha.daohang')
    <input type="hidden" value="{{$start}}" id="start">
    <input type="hidden" value="{{$end}}" id="end">
    <div class="top"></div>
    <div class="section_1">
        <ul class="zhuangtai">
            @foreach($team as $k=>$v)
                <li data-start="{{$v->start}}" data-end="{{$v->end}}" class="time_begin">
                    <span class="time">{{date('H:i',$v->start)}}</span>
                    <span class="zt">即将开始</span>
                </li>
            @endforeach
        </ul>
        <div class="remaintime">
            <p>距离<span class="zt">开始</span>还有</p>
            <div class="time_box">
                <span class="hourse"></span>
                <span class="minute"></span>
                <span class="second"></span>
            </div>
        </div>
        <ul class="chanpin_box">
            @foreach($team as $k=>$v)
                <li>
                    @foreach($v->goods as $val)
                        <div class="chanpin" id="{{$val->goods_id}}" data-type="1">
                            <div class="img_box">
                                <img src="{{$val->goods_thumb}}"/>
                                <img id="none{{$val->goods_id}}" class="none"
                                     src="{{get_img_path('images/miaosha/171109/none.png')}}">
                            </div>
                            <div class="text">
                                <p class="name">{{$val->goods_name}}</p>
                                <p class="guige">{{$val->spgg}}</p>
                                <p class="company">{{$val->sccj}}</p>
                                <p class="zongliang" id="kc{{$val->goods_id}}">总量：{{$val->goods_number}}</p>
                                <p class="qianggou">固定抢购量：{{$val->cart_number}}{{$val->bzdw}} </p>
                                <p class="jiage">秒杀价：￥<span>{{$val->real_price}}</span></p>
                                <a href="javascript:;" class="btn begin" id="btn{{$val->goods_id}}">即将开始</a>
                            </div>
                        </div>
                    @endforeach
                </li>
            @endforeach
        </ul>
    </div>
    <div class="section_2">
        <ul class="chanpin_url">
            @foreach($list as $v)
                @if(in_array($v->goods_id,[31295, 27248]))
                    <li>
                        <div class="img_box">
                            <img src="{{get_img_path($v->goods_thumb)}}"/>
                        </div>
                        <p class="name">{{$v->goods_name}}</p>
                        <p class="company">{{$v->product_name}}</p>
                        <p class="guige">{{$v->ypgg}}</p>
                        <p class="qianggou">&nbsp;</p>
                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                            <div class="mon">{{$v->promote_price}}</div>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="section_3">
        <ul class="chanpin_url">
            @foreach($list as $v)
                @if(in_array($v->goods_id,[27821, 29731]))
                    <li>
                        <div class="img_box">
                            <img src="{{get_img_path($v->goods_thumb)}}"/>
                        </div>
                        <p class="name">{{$v->goods_name}}</p>
                        <p class="company">{{$v->product_name}}</p>
                        <p class="guige">{{$v->ypgg}}</p>
                        <p class="qianggou">&nbsp;</p>
                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                            <div class="mon">{{$v->promote_price}}</div>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
        <a target="_blank" href="{{route('tejia',['step'=>'nextpro','type'=>'zyyp'])}}" class="readmore"></a>
    </div>
    <a target="_blank" href="/cxhd/zyhg">
        <div class="section_4"></div>
    </a>
    <script>
        $(function () {
            var now;
            var start = $('#start').val();
            var end = $('#end').val();
            var jieshu;
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
                            $('#btn' + id).addClass('maiwan').removeClass('begin');
                            $('#btn' + id).text('已抢完');
                            $('#none' + id).show();
                        }
                        $('#kc' + id).text('总量：' + kc);
                    }
                    jieshu = end - now;
                    if (now < start) {
                        jieshu = start - now;
                    } else {
                        jieshu = end - now;
                    }
                    judge();
                    start1();
                    window.setInterval(start1, 1000);
                }
            });

            $('.zhuangtai li').click(function () {
                var tar = $(this).index();
                start = $(this).data('start');
                $(this).addClass('active').siblings('li').removeClass('active');
                $('.chanpin_box li').eq(tar).addClass('active').siblings('li').removeClass('active');
                $('.zhuangtai li').children('img').remove();
                $(this).append("<img src='{{get_img_path('images/miaosha/171109/active.png')}}'/>");
                if (now >= $(this).data('start')) {  //判断当前时间大于秒杀时间,则状态为结束,倒计时也为结束
                    $('.remaintime .zt').html("结束");
                    jieshu = end - now;
                } else if (now < $(this).data('start')) {  //判断当前时间小于秒杀时间,则状态为结束,倒计时也为结束
                    $('.remaintime .zt').html("开始");
                    jieshu = $(this).data('start') - now;
                }
                if (now < start) {
                    $('.remaintime .zt').html("开始");
                    jieshu = start - now;
                    $('.time li').removeClass('time-ing');
                }
                second = Math.floor(jieshu % 60); // 计算秒
                hour = Math.floor((jieshu / 3600)); //计算小时
                $('.hourse').html(hour);
                $('.second').html(second);
            });
            //判断秒杀时间状态
            function judge() {
                if (now < start) {
                    $('.chanpin_box li').eq(0).addClass('active');
                    $('.zhuangtai li').addClass('time_begin');
                    $('.zhuangtai li').eq(0).addClass('active');
                    $('.zhuangtai li').eq(0).append("<img src='{{get_img_path('images/miaosha/171109/active.png')}}'/>");
                } else {
                    var len = $('.zhuangtai li').length;
                    var type = 0;
                    $('.zhuangtai li').each(function (index) {
                        var tar = len - index - 1;
                        var _this = $('.zhuangtai li').eq(tar);
                        time_arr.push(_this.data('start'));
                        if (now >= _this.data('start')) {
                            _this.addClass('time_ing').removeClass('time_begin');
                            _this.children('.zt').html("正在秒杀");
                            $('.remaintime .zt').html("结束");
                            $('.chanpin_box li').eq(tar).find('.begin').click(function () {
                                add_to_redis($(this).parents('.chanpin').attr('id'))
                            });
                            $('.chanpin_box li').eq(tar).find('.begin').addClass('qiang').removeClass('begin').text('立即抢购');
                            //判断显示当前时间段秒杀的商品,并显示
                            if (type == 0) {
                                _this.append("<img src='{{get_img_path('images/miaosha/171109/active.png')}}'/>");
                                type = 1;
                                $('.zhuangtai li').removeClass('active');
                                $('.chanpin_box li').removeClass('active');
                                _this.addClass('active').addClass('now_check');
                                $('.chanpin_box li').eq(tar).addClass('active');
                            }
                        } else if (now < _this.data('start')) {
                            _this.addClass('time_begin').removeClass('time_ing')
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
                $('.hourse').html(hour);
                $('.minute').html(minite);
                $('.second').html(second);
                if ($.inArray(now, time_arr) != -1) {
                    judge();
                }
            }

            function add_to_redis(id) {
                var type = $('#' + id).data('type');
                if (type != 0) {
                    $.ajax({
                        url: '/buy_ms',
                        data: {id: id},
                        dataType: 'json',
                        success: function (result) {
                            if (result) {
                                if (result.error == 0) {
                                    if (result.kc <= 0) {
                                        result.kc = 0;
                                        $('#btn' + id).addClass('maiwan').removeClass('begin');
                                        $('#btn' + id).text('已抢完');
                                        $('#none' + id).show();
                                    }
                                    $('#kc' + id).text('总量：' + result.kc);
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
                } else {
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