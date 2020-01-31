<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>积分商城</title>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/jfen/jfsc-js/jquery.singlePageNav.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/index.css"/>
    <script src="/jfen/jfsc-js/add_to_cart.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
@include('jifen.layouts.header')
@include('jifen.layouts.nav')
<!--我的积分以及信息-->
<div class="my content">
    <div class="content_box">
        <div class="my_left">
            <div class="my_left_top">
                <div class="my_left_top_title">
                    <div class="img_box">
                        <img src="http://images.hezongyy.com/images/jf/jifen_red_03.png?1" />
                    </div>
                    <span>我的积分</span>
                </div>
                @if(!$user)
                    <div class="login_before">
                        <a href="/auth/login">请登录</a>
                    </div>
                @else
                    <div class="login_after">
                        <div class="login_after_title">
                            您好！<span>{{$user->msn}}</span>
                        </div>
                        <div class="login_after_content">
                            可用积分：<span>{{$user->pay_points}}</span>
                        </div>
                        <div class="login_after_bottom">
                            <a href="{{route('jifen.order.index')}}">[积分订单]</a>
                            <a href="{{route('jifen.address.index')}}">[查看收货地址]</a>
                            <a href="{{route('index')}}">[去赚取积分]</a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="my_left_bottom">
                <div class="my_left_top_title">
                    <div class="img_box">
                        <img src="http://images.hezongyy.com/images/jf/lipin_1_03.png?1" />
                    </div>
                    <span>礼品分类</span>
                </div>
                <div class="my_left_bottom_content">
                    <a href="#rmdh">热门兑换</a>
                    <a href="#jydq">家用电器</a>
                    <a href="#jjbb">移动电器</a>
                    <a href="#bgyp">办公用品</a>
                </div>
            </div>
        </div>
        <div id="ban2">
            <div class="banner">
                <ul class="img">
                    <li>
                        <a target="_blank" href="http://www.jyeyw.com/jifen/user"><img src="/jfen/banner-jf.jpg" /></a>
                    </li>
                </ul>
                <ul class="num">
                </ul>
            </div>
        </div>
    </div>
</div>
<!--我的积分以及信息-->
<!--热门兑换-->
<div class="common content" id="rmdh">
    <div class="content_box">
        <div class="content_title">
            <div class="img_box">
                <img src="http://images.hezongyy.com/images/jf/hot_03.png?1" />
            </div>
            <span>热门兑换</span>
        </div>
        @include('jifen.layouts.cat',['cat'=>$cat5])
    </div>
</div>
<!--热门兑换-->
<!--家用电器-->
<div class="common content" id="jydq">
    <div class="content_box">
        <div class="content_title">
            <div class="img_box">
                <img src="http://images.hezongyy.com/images/jf/jiadian_03.png?1" />
            </div>
            <span>家用电器</span>
        </div>
        @include('jifen.layouts.cat',['cat'=>$cat1])
    </div>
</div>
<!--家用电器-->
<!--居家必备-->
<div class="common content" id="jjbb">
    <div class="content_box">
        <div class="content_title">
            <div class="img_box">
                <img src="http://images.hezongyy.com/images/jf/jujia_03.png?1" />
            </div>
            <span>移动电器</span>
        </div>
        @include('jifen.layouts.cat',['cat'=>$cat6])
    </div>
</div>
<!--居家必备-->
<!--办公用品-->
<div class="common content" id="bgyp">
    <div class="content_box">
        <div class="content_title">
            <div class="img_box">
                <img src="http://images.hezongyy.com/images/jf/bangong_03.png?1" />
            </div>
            <span>办公用品</span>
        </div>
        @include('jifen.layouts.cat',['cat'=>$cat3])
    </div>
</div>
<!--办公用品-->
<!--季节特惠-->
<!--季节特惠-->
@include('jifen.layouts.footer')
<script>
    $('.my_left_bottom_content').singlePageNav({
        offset: 0
    });
</script>
</body>

</html>