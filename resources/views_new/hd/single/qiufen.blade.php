@extends('layouts.app')
@section('title')
<title>秋分</title>
@endsection
@section('links')
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
<link rel="stylesheet" href="/huodong/qiufen/qiufen.css">

<script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>

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
<div class="container">
    {{-- 头部 --}}
    <div class="header">
        <img class="header-pic" src="/huodong/qiufen/banner1.jpg" alt="">
    </div>
    <div class="list">
        <div class="title">
            <img src="/huodong/qiufen/title.png" alt="">
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
                <div class="label">
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
            <a href="http://www.jyeyw.com/goods?id={{$v->goods_id}}" target="_blank">
                <img src="{{$v->goods_thumb}}" alt="">
            </a>
        </div>
        {{-- 标签 --}}
        <div class="label">
            {{-- 标签背景 --}}
            <div class="bg">
                <img src="/huodong/201908/img/label.png" alt="">
            </div>
            {{-- 节省钱 --}}
            <div class="save-money">
                {{$v->zyzk}}
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
            <!-- 价格 -->
            <p class="jg">
                <!-- 活动价 -->
                @if(isset($user))
                <span class="hdj">
                    <span>满减</span>
                    ￥{{$v->shop_price}}
                </span>
                @else
                <span class="hdj">
                    <span>满减</span>
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
@include('layouts.youce')
@include('hd.single.layout.nav')
<script type="text/javascript">
    //返回顶部
    $('.btn-top').click(function () {
        $('html,body').animate({
            'scrollTop': 0
        })
    });
</script>

@endsection