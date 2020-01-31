@extends('layouts.app')
@section('title')
<title>一点都不能少</title>
@endsection
@section('links')
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
<link rel="stylesheet" href="/huodong/20190821/css/hd821py.css">

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
    <div class="content">
        <img src="http://www.jyeyw.com/huodong/20190821/img/py/header.jpg" alt="">
        {{-- 优惠券 --}}
        <div class="yhq clear-float">
            @if (strtotime('2019-08-22')<time()&&strtotime('2019-08-24')>time())
                @foreach ([344, 343, 342, 341, 340, 1] as $item)
                <img coupon-id={{$item}} src="http://www.jyeyw.com/huodong/20190821/img/py/yhq/{{$item}}.png" alt="">
                @endforeach
            @elseif(strtotime('2019-08-21')<time()&&strtotime('2019-08-23')>time())
                @foreach ([318,317,316,315,314,1] as $item)
                <img coupon-id={{$item}} src="http://www.jyeyw.com/huodong/20190821/img/py/yhq/{{$item}}.png" alt="">
                @endforeach
            @endif
        </div>
    </div>
    <div class="list">
        <div class="title">
            <img src="http://www.jyeyw.com/huodong/20190821/img/py/title.png" alt="">
        </div>
        <ul class="clear-float">
            @foreach($goods as $k=>$v)
            @if($v->promote_start_date<time()&&$v->promote_end_date>time())
                <li class="clear-float">
                    {{-- 左边商品图片 --}}
                    <div class="thumb">
                        <a target="_blank" href="/goods?id={{$v->goods_id}}">
                            <img src="http://112.74.176.233/{{$v->goods_thumb}}" alt="">
                        </a>
                    </div>
                    {{-- 右边商品信息 --}}
                    <div class="goods-info">
                        <p class="name">{{$v->goods_name}}</p>
                        <p class="sccj">{{$v->product_name}}</p>
                        <p class="gg">规格：{{$v->ypgg}}</p>
                        <p class="dw">效期：{{$v->xq}}</p>
                        @if ($v->goods_number>800)
                        <p class="kc">库存：充裕</p>
                        @elseif($v->goods_number<=0) <p class="kc">库存：无</p>
                            @else
                            <p class="kc">库存：{{$v->goods_number}}</p>
                            @endif
                            @if ($v->ls_ggg>0)
                            <p>限购：{{$v->ls_ggg}}</p>
                            @else
                            <p>限购：不限购</p>
                            @endif
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
                            <div class="btn-box">
                                <!-- 加减 -->
                                <div class="jiajian">
                                    <input id="J_dgoods_num_{{$v->goods_id}}" type="text" value="1" class="input_val"
                                        data-zbz="1" data-kc="350" data-jzl="100" data-xl="100" data-isxl="0" />
                                    <div class="jiajian_btn">
                                        <div class="jia">
                                            <img src="http://www.jyeyw.com/huodong/20190821/img/up.png" alt="">
                                        </div>
                                        <div class="jian min">
                                            <img src="http://www.jyeyw.com/huodong/20190821/img/down.png" alt="">
                                        </div>
                                    </div>
                                </div>
                                <!-- 加入购物车 -->
                                @if ($v->promote_start_date>time())
                                <div class="add-cart" data-img="{{$v->goods_thumb}}">
                                    <img src="http://www.jyeyw.com/huodong/20190821/img/cart.png" /> 活动未开始
                                </div>
                                @elseif($v->promote_end_date<time()) <div class="add-cart"
                                    data-img="{{$v->goods_thumb}}">
                                    <img src="http://www.jyeyw.com/huodong/20190821/img/cart.png" /> 活动已结束
                            </div>
                            @else
                            <div class="add-cart" data-img="{{$v->goods_thumb}}" onclick="tocart('{{$v->goods_id}}')">
                                <img src="http://www.jyeyw.com/huodong/20190821/img/cart.png" /> 加入购物车
                            </div>
                            @endif
                    </div>
                </li>
                @endif
                @endforeach
        </ul>
    </div>
</div>
@include('layouts.youce')
<script type="text/javascript">
    $(".yhq img").click(function(){
        var id=$(this).attr('coupon-id');
        $.ajax({
            url:'/yhq',
            type:'post',
            data:{id:id},
            dataType:"json",
            success:function(data){
                layer.open({
                    title:'优惠券',
                    content:data.msg
                })
            }
        });
    })
    //返回顶部
        $('.btn-top').click(function(){
            $('html,body').animate({
                'scrollTop':0
            })
        });
</script>

@endsection