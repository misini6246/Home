@extends('layout.body')
@section('links')
    <style>
        body{
            font-size: 12px;
            margin: 0;
            padding: 0;
            font-family: "microsoft yahei";
        }

        #miaosha-top {
            width: 100%;
            min-width: 1200px;
            height: 450px;
            background: url('{{get_img_path('images/bg-top.jpg')}}') no-repeat scroll top center;
        }

        .remaitime {
            position: relative;
            width: 295px;
            height: 34px;
            margin: 0 auto;
            left: 40px;
            top: 246px;
        }

        .zhuangtai-text-1,.zhuangtai-text-2{
            display: inline-block;
            font-size: 16px;
            color: #890211;
            margin-top: 12px;
        }
        .zhuangtai-text-2{
            display: none;
        }
        .time-before,.time-after{
            display: inline-block;
            width: 168px;
            height: 34px;
            position: absolute;
            top: 0;
            right: 0;
        }
        .time-after{
            display: none;
        }
        .hourse,
        .minute,
        .second{
            display: inline-block;
            width: 36px;
            height: 34px;
            line-height: 34px;
            text-align: center;
            font-size: 24px;
            color: white;
            position: absolute;
            top: 2px;
        }

        .hourse {
            left: 0;
        }

        .minute {
            left: 65px;
        }

        .second {
            right: 2px;
        }

        #miaosha-bottom {
            width: 100%;
            min-width: 1200px;
            height: 660px;
            background: url('{{get_img_path('images/bg-bottom.jpg')}}') no-repeat scroll top center;
        }

        .chanpin-box{
            width: 1200px;
            margin: 0 auto;
        }
        .ct-1,.ct-2{
            width: 580px;
            height: 480px;
            display: inline-block;
            position: relative;
            *float: left;
        }
        .ct-1{
            background: url('{{get_img_path('images/tejia-1.jpg')}}') no-repeat scroll top center;
        }
        .ct-2{
            background: url('{{get_img_path('images/tejia-2.jpg')}}') no-repeat scroll top center;
            margin-left: 15px;
        }
        .kucun{
            width: 120px;
            height: 30px;
            line-height: 30px;
            position: absolute;
            left: 270px;
            top: 96px;
            color: #6f6e6e;
        }
        .ct-1 a,.ct-2 a{
            width: 280px;
            height: 38px;
            position: absolute;
            top: 220px;
            right: 29px;
            line-height: 38px;
            text-align: center;
            color: #f9ff63;
            font-size: 18px;
            text-decoration: none;
        }
        .maiwan{
            position: absolute;
            top:22px;
            left: 22px;
            display: none;
        }
        .kaishi{
            display: block;
            background: rgb(153, 153, 153);
        }
        .goumai{
            display: none;
            background: #f55967;
        }
        .maiwan-btn{
            display: none;
            background: rgb(153, 153, 153);
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
    <div id="miaosha-top">
        <div class="remaitime" start="{{$team[0]->start}}" end="{{$team[0]->end}}">
            <div class="zhuangtai-text-1" @if($now<$team[0]->start) style="display: inline-block;" @else style="display: none;"  @endif>
                距离开始还有：
            </div>
            <div class="zhuangtai-text-2" @if($team[0]->start<=$now&&$now<$team[0]->end) style="display: inline-block;" @else style="display: none;"   @endif>
                距离结束还有：
            </div>
            <div class="time-before" @if($now<$team[0]->start) style="display: block;" @else style="display: none;"  @endif>
                <span class="hourse"></span>
                <span class="minute"></span>
                <span class="second"></span>
            </div>
            <div class="time-after" @if($team[0]->start<=$now&&$now<$team[0]->end) style="display: block;" @else style="display: none;"   @endif>
                <span class="hourse"></span>
                <span class="minute"></span>
                <span class="second"></span>
            </div>
        </div>
    </div>
    <div id="miaosha-bottom">
        <div class="chanpin-box">
            @foreach($team[0]->goods as $k=>$v)
                <div class="ct-{{$k+1}}">
                    <div class="kucun">
                        总量：<span>{{$v->goods_number}}</span>
                    </div>
                    <a @if($v->goods_number<=0) style="display: block;" @endif href="javascript:;" class="maiwan-btn">已售罄</a>
                    <a @if($team[0]->start<=$now&&$now<$team[0]->end&&$v->goods_number>0) style="display: block;" @else style="display: none;" @endif onclick="add_to_redis({{$v->goods_id}})" class="goumai">立即购买</a>
                    <a @if($now<$team[0]->start&&$v->goods_number>0) style="display: block;" @else style="display: none;" @endif href="javascript:;" class="kaishi">即将开始</a>
                    <img @if($v->goods_number<=0) style="display: block;" @endif src="{{get_img_path('images/maiwan.png')}}" class="maiwan"/>
                </div>
            @endforeach
        </div>
    </div>
    @include('20170412.daohang')
    <script type="text/javascript">
        $(function(){
            var start='{{$team[0]->start}}'; //活动开始时间
            var now='{{time()}}';  //当前时间
            var end='{{$team[0]->end}}'; //活动结束时间
            var SysSecond=start-now;
            var jieshu=end-now;

            $(document).ready(function(){
                if(SysSecond>0) {
                    before();
                    window.setInterval(before, 1000);
                }
                start1();
                window.setInterval(start1, 1000);
            });
            function before(){
                SysSecond--;
                if(SysSecond>=0){
                    var second = Math.floor(SysSecond % 60);             // 计算秒
                    var minite = Math.floor((SysSecond / 60) % 60);      //计算分
                    var hour = Math.floor((SysSecond / 3600));  //计算小时
                    $('.time-before').html(
                        '<span class="hourse">'+hour+'</span>'+'<span class="second">'+second+'</span>'+'<span class="minute">'+minite+'</span>'
                    )

                }

                if(SysSecond<0){
                    $('.time-before').hide();
                    $('.time-after').show();
                    $('.zhuangtai-text-1').hide();
                    $('.zhuangtai-text-2').css('display','inline-block');
                    $('.maiwan-btn').hide();
                    $('.kaishi').hide();
                    $('.goumai').show();
                }
            }
            function start1(){
                jieshu--;
                var second = Math.floor(jieshu % 60);             // 计算秒
                var minite = Math.floor((jieshu / 60) % 60);      //计算分
                var hour = Math.floor((jieshu / 3600));  //计算小时
                $('.time-after').html(
                    '<span class="hourse">'+hour+'</span>'+'<span class="second">'+second+'</span>'+'<span class="minute">'+minite+'</span>'
                )
            }

        })
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