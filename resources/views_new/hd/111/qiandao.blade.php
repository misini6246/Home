<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/111/css/qiandao.css">
    <script src="https://cdn.bootcss.com/jquery/3.4.0/jquery.min.js"></script>
    <script src="/layer/layer.js"></script>
    <script src="/isIE/isIE.js"></script>
    <script src="/111/js/qiandao.js"></script>
    <title>签到返现金</title>
</head>

<body>
    <div class="container">
        {{-- 头部banner --}}
        <div class="top">
            <img src="http://www.jyeyw.com/111/qiandao/pc_banner.jpg" alt="">
        </div>
        <div class="content">
            {{-- 倒计时 --}}
            <div class="countdown">
                <div class="title">距11.1嗨购狂欢开始剩</div>
                <div class="time">
                    <div class="day item">
                        <span class="num-box 10">0</span>
                        <span class="num-box 1">0</span>
                        <span>天</span>
                    </div>
                    <div class="hours item">
                        <span class="num-box 10">0</span>
                        <span class="num-box 1">0</span>
                        <span>:</span>
                    </div>
                    <div class="min item">
                        <span class="num-box 10">0</span>
                        <span class="num-box 1">1</span>
                        <span>:</span>
                    </div>
                    <div class="seconds item ">
                        <span class="num-box 10">0</span>
                        <span class="num-box 1">0</span>
                    </div>
                </div>
            </div>
            {{-- 签到日历 --}}
            <div class="qiandao">
                <div class="title"></div>
                <div class="items">
                    <div class="item">
                        <div class="en-day">MON</div>
                        <div class="cn-day">星期一</div>
                        <!-- 优惠券 -->
                        <div class="coupon">
                            <img src="http://112.74.176.233/weapp/static/img/11.1/qiandao/coupon.png"
                                mode="widthFix" />
                        </div>
                        <div class="button">
                            @if (in_array(28,$days))
                            <button disabled class="signed">已签到</button>
                            @else
                                @if ( strtotime(date('Y-m-d',$now))== strtotime(date('2019-10-28')))
                                <button>今日签到</button>
                                @elseif(strtotime(date('Y-m-d',$now))< strtotime(date('2019-10-28')))
                                <button disabled class="signed">时间未到</button>
                                @elseif(strtotime(date('Y-m-d',$now))> strtotime(date('2019-10-28')))
                                <button disabled class="signed">未签到</button>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="item">
                        <div class="en-day">TUS</div>
                        <div class="cn-day">星期二</div>
                        <!-- 优惠券 -->
                        <div class="coupon">
                            <img src="http://112.74.176.233/weapp/static/img/11.1/qiandao/coupon.png"
                                mode="widthFix" />
                        </div>
                        <div class="button">
                                @if (in_array(29,$days))
                                <button disabled class="signed">已签到</button>
                                @else
                                    @if ( strtotime(date('Y-m-d',$now))== strtotime(date('2019-10-29')))
                                    <button>今日签到</button>
                                    @elseif(strtotime(date('Y-m-d',$now))< strtotime(date('2019-10-29')))
                                    <button disabled class="signed">时间未到</button>
                                    @elseif(strtotime(date('Y-m-d',$now))> strtotime(date('2019-10-29')))
                                    <button disabled class="signed">未签到</button>
                                    @endif
                                @endif
                            </div>
                    </div>
                    <div class="item">
                        <div class="en-day">WED</div>
                        <div class="cn-day">星期三</div>
                        <!-- 优惠券 -->
                        <div class="coupon">
                            <img src="http://112.74.176.233/weapp/static/img/11.1/qiandao/coupon.png"
                                mode="widthFix" />
                        </div>
                        <div class="button">
                                @if (in_array(30,$days))
                                <button disabled class="signed">已签到</button>
                                @else
                                    @if ( strtotime(date('Y-m-d',$now))== strtotime(date('2019-10-30')))
                                    <button>今日签到</button>
                                    @elseif(strtotime(date('Y-m-d',$now))< strtotime(date('2019-10-30')))
                                    <button disabled class="signed">时间未到</button>
                                    @elseif(strtotime(date('Y-m-d',$now))> strtotime(date('2019-10-30')))
                                    <button disabled class="signed">未签到</button>
                                    @endif
                                @endif
                            </div>
                    </div>
                    <div class="item">
                        <div class="en-day">THU</div>
                        <div class="cn-day">星期四</div>
                        <!-- 优惠券 -->
                        <div class="coupon">
                            <img src="http://112.74.176.233/weapp/static/img/11.1/qiandao/coupon.png"
                                mode="widthFix" />
                        </div>
                        <div class="button">
                                @if (in_array(31,$days))
                                <button disabled class="signed">已签到</button>
                                @else
                                    @if ( strtotime(date('Y-m-d',$now))== strtotime(date('2019-10-31')))
                                    <button>今日签到</button>
                                    @elseif(strtotime(date('Y-m-d',$now))< strtotime(date('2019-10-31')))
                                    <button disabled class="signed">时间未到</button>
                                    @elseif(strtotime(date('Y-m-d',$now))> strtotime(date('2019-10-31')))
                                    <button disabled class="signed">未签到</button>
                                    @endif
                                @endif
                            </div>
                    </div>
                </div>
            </div>
            {{-- 规则 --}}
            <div class="rule">
                <img src="http://112.74.176.233/weapp/static/img/11.1/qiandao/rule.png" alt="">
            </div>
        </div>
    </div>
</body>

</html>