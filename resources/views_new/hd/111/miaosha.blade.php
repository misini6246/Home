<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script src="/layer/layer.js"></script>
    <script src="/isIE/isIE.js"></script>
    <script>
        (function (doc, win) {
        var docEl = doc.documentElement,
            resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
            recalc = function () {
                var clientWidth = docEl.clientWidth;
                if (!clientWidth) return;
                if(clientWidth>=640){
                    docEl.style.fontSize = '100px';
                }else{
                    docEl.style.fontSize = 100 * (clientWidth / 640) + 'px';
                }
            };

        if (!doc.addEventListener) return;
        win.addEventListener(resizeEvt, recalc, false);
        doc.addEventListener('DOMContentLoaded', recalc, false);
    })(document, window);
    </script>
    <title>{{$page_title}}</title>
    <style>
        body {
            margin: 0;
        }

        ul>li {
            list-style: none;
        }

        .container {
            background: url('http://www.jyeyw.com/111/miaosha/bg.jpg');
            background-size: 100%;
            background-repeat: no-repeat;
            background-color: #1d1f2c;
            min-height: 100vh;
            width: 100%;
        }

        .top {
            padding-top: 40%;
        }

        .top .times {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .top .times .item {
            width: 2.90rem;
            height: 2.9rem;
            background: url('http://www.jyeyw.com/111/miaosha/time_bg.png');
            background-size: 100% 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 0.4rem;
            font-weight: bold;
            cursor: pointer;
        }

        .top .times .item.active {
            background: url('http://www.jyeyw.com/111/miaosha/time_bg_active.png');
            background-size: 100% 100%;
        }

        .top .times .item .time {
            font-size: 0.6rem;
        }

        .content .goods {
            display: none;
            flex-wrap: wrap;
            justify-content: center;
            padding: 0 1.50rem;
        }

        .content .goods.active {
            display: flex;
        }

        .content .goods .item {
            width: 4rem;
            padding: 0.1rem 0;
            margin-top: 0.2rem;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            background: url("http://112.74.176.233/weapp/static/img/miaosha/11.1/goods_bg.png") no-repeat;
            background-size: 100% 100%;
            padding: 1rem;
        }

        .content .goods .item:first-child {
            margin-top: 0;
        }

        .content .goods .item .thumb {
            width: 42%;
            position: relative;
        }

        .content .goods .item .thumb img {
            width: 100%;
        }

        .content .goods .item .thumb .sold-out {
            position: absolute;
        }

        .content .goods .item .info {
            width: 56%;
            font-size: 0.14rem;
            color: #383838;
        }

        .content .goods .item .info .name {
            font-size: 0.18rem;
            color: #e60012;
            font-weight: bold;
        }

        .content .goods .item .info .gg-xq,
        .content .goods .item .info .total-xg,
        .content .goods .item .info .sccj,
        .content .goods .item .info .price,
        .content .goods .item .info .cart {
            margin-top: 0.08rem;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        .content .goods .item .info .sccj,
        .content .goods .item .info .price {
            padding-top: 0.08rem;
            border-top: 1px solid #4900c1;
        }

        .content .goods .item .info .cart {
            display: block;
        }

        .content .goods .item .info .gg-xq .xq,
        .content .goods .item .info .total-xg .xg {
            color: #eb6100;
        }

        .content .goods .item .info .price {
            color: #d43030;
        }

        .content .goods .item .info .price .msj {
            font-weight: bold;
            font-size: 0.18rem;
        }

        .content .goods .item .info .price .yj {
            font-size: 0.12rem;
            text-decoration: line-through;
        }

        .content .goods .item .info .cart button {
            width: 100%;
            height: 0.3rem;
            font-size: 0.14rem;
            border: none;
            border-radius: 0.06rem;
            background: #eb6100;
            color: #fff;
            line-height: 0.3rem;
            cursor: pointer;
        }

        .remaitime {
            display: none;
            position: relative;
            width: 4.8rem;
            height: 0.34rem;
            margin: 0 auto;
            font-size: 0.24rem;
            color: #fff;
            font-weight: bold;
            text-align: center;
        }

        .remaitime.active {
            display: block;
        }

        .time-before,
        .time-after {
            float: right;
            height: 0.34rem;
            font-weight: normal;
        }

        .bottom {
            /* position: absolute; */
            bottom: 0;
            text-align: center;
            width: 100%;
        }

        .bottom img {
            width: 100%;
        }

        @media screen and (max-width: 1000px) {
            .content .goods{
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top">
            {{--  时间  --}}
            <div class="times">
                @foreach ($team as $k=>$v)
                <div class="item 　@if($v->end>$now&&$v->start<$now) active @endif" data-index="{{$k}}">
                    <div class="time">{{date('H:i',$v->start)}}</div>
                    @if($v->start>$now)
                    <div class="text">即将开始</div>
                    @elseif($v->end<$now) <div class="text">已结束
                </div>
                @else
                <div class="text">正在进行</div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    <div class="content">
        <div class="tabs">
            @foreach ($team as $k=>$v)
            <div class="remaitime remaitime-{{$k}} @if($v->end>$now&&$v->start<$now) active @endif">
                @if($v->end>$now&&$v->start<$now) {{-- 正在秒杀 --}} <div class="time-after" left-time="{{$v->end-$now}}">
                    <span class="days">0</span>
                    <span class="s">天</span>
                    <span class="hours">0</span>
                    <span class="s">时</span>
                    <span class="minute">0</span>
                    <span class="s">分</span>
                    <span class="second">0</span>
                    <span class="s">秒</span>
            </div>
            距离秒杀结束还有：
            @elseif($now<$v->start)
                {{-- 秒杀未开始 --}}
                <div class="time-after" left-time="{{$v->start-$now}}">
                    <span class="days">0</span>
                    <span class="s">天</span>
                    <span class="hours">0</span>
                    <span class="s">时</span>
                    <span class="minute">0</span>
                    <span class="s">分</span>
                    <span class="second">0</span>
                    <span class="s">秒</span>
                </div>
                距离秒杀开始还有：
                @else
                秒杀已结束
                @endif
        </div>
        <div class="goods goods-{{$k}} @if($v->end>$now&&$v->start<$now) active @endif">
            {{-- {{$v->goods}} --}}
            @foreach ($v->goods as $i)
            <div class="item">
                <div class="thumb">
                    @if ($i->goods_number
                    <0) <img class="sold-out" src="http://www.jyeyw.com/111/miaosha/sold_out.png" />
                    @endif
                    <img class="img" src="{{$i->goods_thumb}}" />
                </div>
                <div class="info">
                    <div class="name van-ellipsis">{{$i->goods_name}}</div>
                    <!-- 规格、效期 -->
                    <div class="gg-xq">
                        <div class="gg">{{$i->ypgg}}</div>
                        <div class="xq">{{$i->xq}}</div>
                    </div>
                    <div class="sccj van-ellipsis">{{$i->sccj}}</div>
                    <!-- 总量、限购 -->
                    <div class="total-xg">
                        <div class="total total-{{$i->goods_id}}}">总量：{{$i->goods_number}}</div>
                        <div class="xg">固定抢购量：{{$i->cart_number}}</div>
                    </div>
                    <div class="price">
                        <!-- 秒杀价 -->
                        <div class="msj">￥{{$i->real_price}}</div>
                        <!-- 原价 -->
                        <div class="yj">原价：￥{{$i->old_price}}</div>
                    </div>
                    <div class="cart">
                        @if ($v->end<$now) <button>秒杀已结束</button>
                            @elseif($now<$v->start)
                                <button>秒杀未开始</button>
                                @elseif($i->goods_number<=0) <button>已抢完</button>
                                    @else
                                    <button class="btn-{{$i->goods_id}} canclick"
                                        data-goodsid="{{$i->goods_id}}">立即抢购</button>
                                    @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
    </div>
    <div class="bottom">
        <img src="http://www.jyeyw.com/111/miaosha/rules.png" alt="">
    </div>
    </div>
    {{-- @include('hd.111.nav111') --}}
    {{-- @include('hd.111.nav111') --}}
</body>
<script>
    setLeftTime()
    // 倒计时
    function setLeftTime(){
        var intervals = []
        $('.tabs .remaitime .time-after').each(function(i,e){
            var leftTime = $(this).attr('left-time')
            intervals[i] = setInterval(function() {
                $(e).find('.days').html(parseInt(getLeftTime(leftTime).days));
                $(e).find('.hours').html(parseInt(getLeftTime(leftTime).hours));
                $(e).find('.minute').html(parseInt(getLeftTime(leftTime).minutes));
                $(e).find('.second').html(parseInt(getLeftTime(leftTime).seconds));
                leftTime = leftTime - 1;
                if (leftTime < 0) {
                    clearInterval(interval[i])
                    window.location.reload()
                }
            }, 1000)
        })
    }
    $('.times .item').click(function(){
        $('.times .item').removeClass('active');
        $(this).addClass('active');

        var index=$(this).attr('data-index');

        var dom='.tabs .goods-'+index;
        $('.tabs .goods').removeClass('active');
        $(dom).addClass('active');

        var dom1='.tabs .remaitime-'+index;
        $('.tabs .remaitime').removeClass('active');
        $(dom1).addClass('active')
    });
    $('.cart button.canclick').click(function(){
        var id=$(this).attr('data-goodsid')
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
                            result.kc=0; 
                            $('.btn-' + id).css('background','#999');
                            $('.btn-'+ id).text('已抢完'); 
                        } 
                        $('.total-' + id).text('总量：' + result.kc); 
                        layer.confirm(result.msg, 
                            { 
                                btn: ['继续购物', '去结算' ],
                            }, 
                            function () { 
                                return false
                            },
                            function () { 
                                location.href='/cart' ; return false; 
                            }); 
                    } else if (result.error==2) {
                        layer.confirm(result.msg, 
                            { 
                                btn: ['注册', '登录' ], //按钮 icon: 2 
                            }, 
                            function () { 
                                location.href='/auth/register' ; 
                            },
                            function () { 
                                location.href='/auth/login' ; 
                                return false;
                        }); 
                    } else { 
                        layer.msg(result.msg, {
                            icon: result.error +1
                        }); 
                    } 
                } 
            } 
        })
    })
    function getLeftTime(date) {
            var days = Math.floor(date / (24 * 3600));

            var leave1 = date % (24 * 3600);
            var hours = Math.floor(leave1 / 3600);

            var leave2 = leave1 % 3600;
            var minutes = Math.floor(leave2 / (60));

            var leave3 = leave2 % (60)
            var seconds = Math.round(leave3)

            var leftTime = {
                "hours": hours,
                "days": days,
                "minutes": minutes,
                "seconds": seconds
            }
            return leftTime;
    }

</script>

</html>