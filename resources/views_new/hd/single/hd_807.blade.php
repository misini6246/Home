@extends('layouts.app')
@section('title')
<title>111一分购</title>
@endsection
@section('links')
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
<link rel="stylesheet" href="/huodong/201908/css/hd_1908.css">
<script src="/isIE/isIE.js"></script>
<script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>
<style>
    body{
        background-color:#ffffff !important;
    }
    .load {
        margin:300px auto;

        width: 150px;

        text-align: center;
    }
    .load div{
        width: 30px;

        height: 30px;

        background-color:rgb(118,224,250);

        border-radius: 100%;

        display: inline-block;

        -webkit-animation: load 1.4s infinite ease-in-out;

        -webkit-animation-fill-mode: both;
    }

    .load .circle1 {
        -webkit-animation-delay: -0.32s;
    }
    .load .circle2 {
        -webkit-animation-delay: -0.16s;
    }
    @-webkit-keyframes load {

        0%, 80%, 100% { -webkit-transform: scale(0.0) }

        40% { -webkit-transform: scale(1.0) }

    }
    .big-container{
        background: #fff;
        display: none;
    }
</style>
<!--IE兼容-->
<!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
	<![endif]-->
<!--IE兼容-->
<!--[if lte IE 7]>
	<script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
	<![endif]-->
@endsection
<div class="load">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
</div>
@section('content')

<div class="container" >

        <div class="list">
            <ul>
            @foreach($goods as $v)
                    <li>
                        <div class="sp-bg">
                            <a href="{{$v->goods_url}}" target="_blank"> <img style="width: 100%;height: 100%;" src="{{$v->goods_thumb}}" alt=""></a>
                        </div>
                        <div class="sp-name">
                            <p>
                                <i style=" letter-spacing:5px;font-weight: bold; font-size: 30px;">{{$v->goods_name}}</i>
                                <i class="sp-font">{{$v->zy_yxq}}</i>
                            </p>
                            <p>
                                <i>{{$v->product_name}}</i>
                                <i class="sp-font">{{$v->ypgg}}</i>
                            </p>
                        </div>
                        <div class="sp-shop">
                            <p class="p1">
                                <span style="font-size: 18px; text-decoration: line-through;">￥{{$v->shop_price}}</span>
                                <span style="font-size: 25px;">活动价</span>
                            </p>
                            <p class="p2">
                                <span>{{$v->real_price_format}}</span>
                            </p>
                            <a href="{{$v->goods_url}}" target="_blank"> <p class="pp"></p></a>
                        </div>
                    </li>
                @endforeach


            </ul>
        </div>
{{--    <div class="list">
        <ul>
            @foreach($goods as $k=>$v)
                <li>
                    --}}{{-- 商品图片 --}}{{--
                    <div class="thumb">
                        <a href="http://www.jyeyw.com/goods?id={{$v->goods_id}}" target="_blank">
                            <img src="http://112.74.176.233/{{$v->goods_thumb}}" alt="">
                        </a>
                    </div>
                    --}}{{-- 标签 --}}{{--
                    <div class="label">
                        --}}{{-- 标签背景 --}}{{--
                        <div class="bg">
                            <img src="/huodong/201908/img/label.png" alt="">
                        </div>
                        --}}{{-- 节省钱 --}}{{--
                        <div class="save-money">
                            {{$v->shop_price-$v->promote_price}}
                        </div>
                    </div>
                    --}}{{-- 商品信息 --}}{{--
                    <div class="goods-info">
                        <!-- 商品名 -->
                        <p class="name" title="{{$v->goods_name}}">{{$v->goods_name}}</p>
                        <!-- 生产厂家 -->
                        <p class="sccj">{{$v->product_name}}</p>
                        <!-- 商品规格 -->
                        <p class="spgg">规格：{{$v->ypgg}}</p>
                        <!-- 效期 件装量-->
                        <p class="xq-jzl">
                            <span class="xq">效期：{{$v->xq}}</span>
                            <span class="jzl">件装量：{{$v->jzl or '无'}}</span>
                        </p>
                        <!-- 价格 -->
                        <p class="jg">
                            <!-- 活动价 -->
                            @if($user)
                                @if ($v->promote_price>0)
                                    <span class="hdj">
                            <span>特价</span>
                            ￥{{$v->promote_price}}
                        </span>
                                    <span class="yj">
                            原价:
                            <span style="text-decoration:line-through">
                                ￥{{$v->shop_price}}
                            </span>
                        </span>
                                @else
                                <!-- 原价 -->
                                    <span class="yj" style="margin-left:0">
                            原价:
                            <span>￥{{$v->shop_price}}</span>
                        </span>
                                @endif
                            @else
                                <span class="hdj">
                            <span>特价</span>
                            会员可见
                        </span>
                            @endif
                        </p>
                        <!-- 库存 中包装-->
                        <p class="kc-zbz">
                        <span class="kc">
                            库存：
                            @if($v->goods_number>800)
                                充裕
                            @elseif($v->goods_number==0)
                                缺货
                            @else
                                {{$v->goods_number}}
                            @endif
                        </span>
                            <span class="zbz">
                            中包装：{{$v->zbz or 1}}
                        </span>
                        </p>
                        --}}{{-- 限购 --}}{{--
                        --}}{{-- <p class="xg">
                            限购：10袋
                        </p> --}}{{--
                        <div class="btn-box">
                            <!-- 加减 -->
                            <div class="jiajian">
                                <input id="J_dgoods_num_{{$v->goods_id}}" type="text" value="1" class="input_val"
                                       data-zbz="1" data-kc="350" data-jzl="100" data-xl="100" data-isxl="0" />
                                <div class="jiajian_btn">
                                    <div class="jia">
                                        <img src="/huodong/april/img/up.png" alt="">
                                    </div>
                                    <div class="jian min">
                                        <img src="/huodong/april/img/down.png" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- 加入购物车 -->
                            @if ($v->promote_start_date>time())
                                <div class="add-cart" data-img="{{$v->goods_thumb}}">
                                    <img src="/huodong/april/img/cart.png" />
                                    活动未开始
                                </div>
                            @elseif($v->promote_end_date<time())
                                <div class="add-cart" data-img="{{$v->goods_thumb}}">
                                    <img src="/huodong/april/img/cart.png" />
                                    活动已结束
                                </div>
                            @else
                                <div class="add-cart" data-img="{{$v->goods_thumb}}" onclick="tocart('{{$v->goods_id}}')">
                                    <img src="/huodong/april/img/cart.png" /> 加入购物车
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>--}}
</div>
@include('hd.111.nav111')
{{--@include('layouts.new_footer')--}}
<script type="text/javascript">

    $(document).ready(function(){
        setTimeout(function () {
            $('.big-container').show();
            $('.load').hide();

        },1000)

         // $('.load').hide();
    });
        $('.btn-top').click(function(){
            $('html,body').animate({
                'scrollTop':0
            })
        });
        /**
         * searchEvent 初始化搜索功能
         * 参数1 获取数据方法
         * 参数2 回调方法
         * 参数3 按钮元素(执行搜索)(可选)
         * 参数4 搜索结果列表显示或隐藏的回调  返回true/false(可选)
         */
        $('.search').searchEvent(
            function(_target, _val) { //获取数据方法 val:搜索框内输入的值
                $.get('/ajax/cart/searchKey',{keyword:_val},function(data){
                    _target.searchDataShow(data, 'value')
                },'json');
                /**
                 * searchDataShow 将数据渲染至页面
                 * 参数1:数据数组
                 * 参数2:数据数组内下标名
                 */
            },
            function(val) { //回调方法 val:返回选中的值
                window.location.href = "http://www.jyeyw.com/category?keywords="+val+"&showi=0";
            },
            $('.search-btn')
        );
</script>

@endsection