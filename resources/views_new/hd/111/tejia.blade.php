@extends('layouts.app')
@section('title')
<title>111狂欢特价，火力全开</title>
@endsection
@section('links')
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="http://www.jyeyw.com/index/common/css/com-css.css" />
<link rel="stylesheet" href="/layui/css/layui.css">
<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
<link rel="stylesheet" href="/111/css/tejia.css">

<script src="/isIE/isIE.js"></script>
<script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/layui/layui.js"></script>
<script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>
<style>
    .load {
        margin: 300px auto;

        width: 150px;

        text-align: center;
    }

    .load div {
        width: 30px;

        height: 30px;

        background-color: rgb(118, 224, 250);

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

        0%,
        80%,
        100% {
            -webkit-transform: scale(0.0)
        }

        40% {
            -webkit-transform: scale(1.0)
        }

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

@section('content')
{{-- <div class="load">
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
</div> --}}
<div class="container">
    {{-- 头部 --}}
    <div class="header">
        <img class="header-pic" src="http://www.jyeyw.com/111/tejia/banner.jpg" alt="">
    </div>
    <div class="list" curr="{{$goods->currentPage()}}" total="{{$total}}">
        <div class="titles">
            <div class="title title0">
                <a href="/11.1/tejia?tab=0">
                    <img src="http://www.jyeyw.com/111/tejia/tejia.png" alt="">
                </a>
            </div>
            <div class="title title1">
                <a href="/11.1/tejia?tab=1">
                    <img src="http://www.jyeyw.com/111/tejia/zhekou.png" alt="">
                </a>
            </div>
            <div class="title title2">
                <a href="/11.1/tejia?tab=2">
                    <img src="http://www.jyeyw.com/111/tejia/zy.png" alt="">
                </a>
            </div>
        </div>
        <ul>
            @foreach($goods as $k=>$v)
            @if ($v->is_promote==1)
            <li>
                {{-- 商品图片 --}}
                <div class="thumb">
                    <a href="http://www.jyeyw.com/goods?id={{$v->goods_id}}" target="_blank">
                        <img src="{{$v->goods_thumb}}" alt="">
                    </a>
                </div>
                {{-- 标签 --}}
                <div class="m-label">
                    {{-- 标签背景 --}}
                    <div class="bg">
                        <img src="/huodong/201908/img/label.png" alt="">
                    </div>
                    {{-- 节省钱 --}}
                    <div class="save-money">
                        {{$v->shop_price-$v->promote_price}}
                    </div>
                </div>
                {{-- 商品信息 --}}
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
                    @if($v->is_yhq_status == 2)
                        <p class="no-yhq" title="此商品不能使用优惠券">* 此商品不能使用优惠券</p>
                    @endif
                    @if($v->is_yhq_status == 1)
                        @if($v->is_promote == 1 && time() >= $v->promote_start_date && time() < $v->promote_end_date)
                            <p class="no-yhq" title="此商品不能使用优惠券">* 此商品不能使用优惠券</p>
                        @endif

                        @if(time() >= $v->preferential_start_date && time() < $v->preferential_end_date && $v->zyzk > 0.01)
                            <p class="no-yhq" title="此商品不能使用优惠券">* 此商品不能使用优惠券</p>
                        @endif
                    @endif
                    <!-- 价格 -->
                    <p class="jg">
                        <!-- 活动价 -->
                        @if(isset($user))
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
                    {{-- 限购 --}}
                    {{-- <p class="xg">
                            限购：10袋
                        </p> --}}
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
                        @elseif($v->promote_end_date<time()) <div class="add-cart" data-img="{{$v->goods_thumb}}">
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
    @else
    <li>
        {{-- 商品图片 --}}
        <div class="thumb">
            @if ($v->preferential_start_date<$now&&$now<$v->preferential_end_date&&$v->zyzk>0)
                <div class="triangle triangle-index">
                    <a target="_blank" href="http://www.jyeyw.com/goods?id={{$v->goods_id}}">
                        <img class="label" src="http://www.jyeyw.com/new_cxzq/label.png" alt="">
                        <span class="text">{{$v->round}}折</span>
                    </a>
                </div>
                @endif
                <a href="http://www.jyeyw.com/goods?id={{$v->goods_id}}" target="_blank">
                    <img src="{{$v->goods_thumb}}" alt="">
                </a>
        </div>
        {{-- 标签 --}}
        <div class="m-label">
        </div>
        {{-- 商品信息 --}}
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
            @if($v->is_yhq_status == 2)
                <p class="no-yhq" title="此商品不能使用优惠券">* 此商品不能使用优惠券</p>
            @endif
            @if($v->is_yhq_status == 1)
                @if($v->is_promote == 1 && time() >= $v->promote_start_date && time() < $v->promote_end_date)
                    <p class="no-yhq" title="此商品不能使用优惠券">* 此商品不能使用优惠券</p>
                @endif

                @if(time() >= $v->preferential_start_date && time() < $v->preferential_end_date && $v->zyzk > 0.01)
                    <p class="no-yhq" title="此商品不能使用优惠券">* 此商品不能使用优惠券</p>
                @endif
            @endif
            <!-- 价格 -->
            <p class="jg">
                <!-- 活动价 -->
                @if(isset($user))
                <span class="hdj">
                    <span>折扣</span>
                    ￥{{$v->shop_price}}
                </span>
                @else
                <span class="hdj">
                    <span>折扣</span>
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
            {{-- 限购 --}}
            {{-- <p class="xg">
                                            限购：10袋
                                        </p> --}}
            <div class="btn-box">
                <!-- 加减 -->
                <div class="jiajian">
                    <input id="J_dgoods_num_{{$v->goods_id}}" type="text" value="1" class="input_val" data-zbz="1"
                        data-kc="350" data-jzl="100" data-xl="100" data-isxl="0" />
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
                @if ($v->preferential_start_date>time())
                <div class="add-cart" data-img="{{$v->goods_thumb}}">
                    <img src="/huodong/april/img/cart.png" />
                    活动未开始
                </div>
                @elseif($v->preferential_end_date<time()) <div class="add-cart" data-img="{{$v->goods_thumb}}">
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
@endif
@endforeach
</ul>
</div>
</div>
<div style="text-align:center" id="page-box"></div>
@include('layouts.youce')
@include('hd.111.nav111')
<script type="text/javascript">
    $(document).ready(function(){
        var height=$('.container>.header').height()
        $('html,body').animate({
            'scrollTop': height-30
        })
    });
    var total=$('.list').attr('total')
    // 初始化tab
    var tab=getQueryVariable('tab')
    switch (tab){
        case '1':
            $('.title1 img').attr('src','http://www.jyeyw.com/111/tejia/zhekou1.png')
            break
        case '2':
            $('.title2 img').attr('src','http://www.jyeyw.com/111/tejia/zy1.png')
            break;
        default:
            $('.title0 img').attr('src','http://www.jyeyw.com/111/tejia/tejia1.png')
    }
    //返回顶部
    $('.btn-top').click(function () {
        $('html,body').animate({
            'scrollTop': 0
        })
    });
    // 分页
        layui.use('laypage', function(){
            var laypage = layui.laypage;
            var currPage=$('.list').attr('curr');
            //执行一个laypage实例
            laypage.render({
            elem: 'page-box',
            limit:50,
            curr:currPage,
            layout:['prev','page','next','count'],
            count: total, //数据总数，从服务端得到
            jump: function(obj, first){     
                //首次不执行
                if(!first){
                    window.location.href="/11.1/tejia?tab="+tab+"&page="+obj.curr
                }
            }
        });
    });
    function getQueryVariable(variable)
    {
        var query = window.location.search.substring(1);
        var vars = query.split("&");
        for (var i=0;i<vars.length;i++) {
            var pair = vars[i].split("=");
            if(pair[0] == variable){return pair[1];}
        }
        return(false);
    }
</script>
@endsection