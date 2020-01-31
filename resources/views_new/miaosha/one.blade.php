@extends('layout.body')
@section('links')
    <style>
        body {
            font-size: 12px;
            margin: 0;
            padding: 0;
            font-family: "microsoft yahei";
        }

        #miaosha-top {
            width: 100%;
            height: 513px;
            background: url('{{get_img_path('images/miaosha/170808/pcmiaosha-1.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
            max-width: 1920px;
            margin: 0 auto;
        }

        .remaitime {
            position: relative;
            width: 345px;
            height: 34px;
            margin: 0 auto;
            top: 370px;
            font-size: 24px;
            color: #fff;
            left: 0px;
        }

        .zhuangtai-text-1,
        .zhuangtai-text-2 {
            display: inline-block;
            font-size: 24px;
            color: #fdf102 !important;
        }

        .zhuangtai-text-2 {
            display: none;
        }

        .time-before,
        .time-after {
            display: inline-block;
            width: 168px;
            height: 34px;
            position: absolute;
            top: -7px;
            right: 13px;
        }

        .time-after {
            display: none;
        }

        .hourse,
        .minute,
        .second {
            display: inline-block;
            width: 36px;
            height: 34px;
            line-height: 34px;
            text-align: center;
            font-size: 24px;
            color: #fff;
            position: absolute;
            top: 9px;
        }

        .hourse {
            left: 1px;
        }

        .minute {
            left: 67px;
        }

        .second {
            right: 0px;
        }

        #miaosha-bottom {
            width: 100%;
            height: 463px;
            background: #972cf8 url('{{get_img_path('images/miaosha/170808/pcmiaosha-2.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
            max-width: 1920px;
            margin: 0 auto;
        }

        .chanpin-box {
            width: 1200px;
            margin: 0 auto;
        }

        .ct-1,
        .ct-2,
        .ct-3 {
            width: 580px;
            height: 260px;
            position: relative;
            float: left;
        }

        .kucun {
            width: 120px;
            height: 30px;
            line-height: 30px;
            position: absolute;
            left: 270px;
            top: 97px;
            color: #6f6e6e;
        }

        .ct-1 a,
        .ct-2 a,
        .ct-3 a {
            width: 270px;
            height: 38px;
            position: absolute;
            bottom: 20px;
            right: 40px;
            line-height: 38px;
            text-align: center;
            color: #f9ff63;
            font-size: 18px;
            text-decoration: none;
            cursor: pointer;
        }

        .maiwan {
            position: absolute;
            bottom: 20px;
            left: 21px;
            display: none;
        }

        .kaishi {
            display: block;
            background: rgb(153, 153, 153);
        }

        .goumai {
            display: none;
            background: #f55967;
        }

        .maiwan-btn {
            display: none;
            background: rgb(153, 153, 153);
        }
    </style>
    <!--[if lte IE 8]>
    <script src="{{path('20170412/js/PIE_IE678.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
    @include('layout.token')
@endsection
@section('content')
    <div id="miaosha-top">
        <div class="remaitime" start="{{$result[0]->start}}" end="{{$result[0]->end}}">
            距离<span class="zhuangtai-text-1" @if($now<$result[0]->start) style="display: inline-block;"
                    @else style="display: none;" @endif>开始</span><span class="zhuangtai-text-2"
                                                                       @if($result[0]->start<=$now&&$now<$result[0]->end) style="display: inline-block;"
                                                                       @else style="display: none;" @endif>结束</span>还有：
            <div class="time-before" @if($now<$result[0]->start) style="display: block;"
                 @else style="display: none;" @endif>
                <span class="hourse"></span>
                <span class="minute"></span>
                <span class="second"></span>
            </div>
            <div class="time-after" @if($result[0]->start<=$now&&$now<$result[0]->end) style="display: block;"
                 @else style="display: none;" @endif>
                <span class="hourse"></span>
                <span class="minute"></span>
                <span class="second"></span>
            </div>
        </div>
    </div>
    <div id="miaosha-bottom">
        <div class="chanpin-box">
            @foreach($result[0]->ms_goods as $k=>$v)
                <div class="ct-{{$k+1}}"
                     style=" @if($k>0) margin-left:20px; @endif background: url('{{$v->goods->goods_thumb}}') no-repeat scroll top center;">
                    <div class="kucun">
                        总量：<span>{{$v->goods_number}}</span>
                    </div>
                    <a @if($v->goods_number<=0) style="display: block;" @endif href="javascript:;" class="maiwan-btn">已售罄</a>
                    <a @if($result[0]->start<=$now&&$now<$result[0]->end&&$v->goods_number>0) style="display: block;"
                       @else style="display: none;"
                       @endif onclick="add_to_redis('{{$type}}','{{$v->group_id}}','{{$v->goods_id}}')"
                       class="goumai">立即购买</a>
                    <a @if($now<$result[0]->start&&$v->goods_number>0) style="display: block;"
                       @else style="display: none;" @endif href="javascript:;" class="kaishi">即将开始</a>
                    <img @if($v->goods_number<=0) style="display: block;"
                         @endif src="{{get_img_path('images/miaosha/170808/maiwan.png')}}" class="maiwan"/>
                </div>
            @endforeach
        </div>

    </div>
    @include('miaosha.daohang')
    <script type="text/javascript">
        $(function () {
            var start = '{{$result[0]->start}}'; //活动开始时间
            var now = '{{time()}}';  //当前时间
            var end = '{{$result[0]->end}}'; //活动结束时间
            var SysSecond = start - now;
            var jieshu = end - now;

            $(document).ready(function () {
                if (SysSecond > 0) {
                    before();
                    window.setInterval(before, 1000);
                }
                start1();
                window.setInterval(start1, 1000);
            });
            function before() {
                SysSecond--;
                if (SysSecond >= 0) {
                    var second = Math.floor(SysSecond % 60);             // 计算秒
                    var minite = Math.floor((SysSecond / 60) % 60);      //计算分
                    var hour = Math.floor((SysSecond / 3600));  //计算小时
                    $('.time-before').html(
                        '<span class="hourse">' + hour + '</span>' + '<span class="second">' + second + '</span>' + '<span class="minute">' + minite + '</span>'
                    )

                }

                if (SysSecond < 0) {
                    $('.time-before').hide();
                    $('.time-after').show();
                    $('.zhuangtai-text-1').hide();
                    $('.zhuangtai-text-2').css('display', 'inline-block');
                    $('.maiwan-btn').hide();
                    $('.kaishi').hide();
                    $('.goumai').show();
                }
            }

            function start1() {
                jieshu--;
                var second = Math.floor(jieshu % 60);             // 计算秒
                var minite = Math.floor((jieshu / 60) % 60);      //计算分
                var hour = Math.floor((jieshu / 3600));  //计算小时
                $('.time-after').html(
                    '<span class="hourse">' + hour + '</span>' + '<span class="second">' + second + '</span>' + '<span class="minute">' + minite + '</span>'
                )
            }

        })
        function add_to_redis(type, group_id, goods_id) {
            $.ajax({
                url: '/ms',
                data: {type: type, group_id: group_id, goods_id: goods_id},
                dataType: 'json',
                success: function (data) {
                    layer.msg(data.msg, {icon: data.error + 1})
                }
            })
        }
    </script>
@endsection