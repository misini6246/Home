@extends('layouts.app')
@section('title')
<title>清凉一夏</title>
@endsection
@section('links')
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
{{-- <link rel="stylesheet" type="text/css" href="/huodong/april/css/ccxsj.css"/> --}}
<link rel="stylesheet" href="/huodong/201906/css/hd_617.css">

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
@include('layouts.header')
@include('layouts.search')
@include('layouts.nav')
<div class="container">
    <div class="content">
        {{-- 优惠券 --}}
        <div class="coupon-box">
            <div class="title">
                <img src="/huodong/201906/img/title1.png">
            </div>
            <div class="coupons">
                @for ($i = 1; $i < 7; $i++) <div class="coupon">
                    <img coupon-id="127+{{$i}}" class="can-click" src="/huodong/201906/img/coupons/coupon{{$i}}.png">
            </div>
            @endfor
        </div>
    </div>
    <div class="list">
        <div class="title">
            <img src="/huodong/201906/img/title2.png">
        </div>
        <ul>
            @foreach($goods as $k=>$v)
            <li>
                <div class="left">
                    <a href="http://www.jyeyw.com/goods?id={{$v->goods_id}}" target="_blank"><img
                            src="http://112.74.176.233/{{$v->goods_thumb}}" alt=""></a>
                </div>
                <div class="right">
                    <!-- 商品名 -->
                    <p class="name">{{$v->goods_name}}</p>
                    <!-- 生产厂家 -->
                    <p class="sccj">{{$v->product_name}}</p>
                    <!-- 商品规格 -->
                    <p class="spgg">规格：{{$v->ypgg}}</p>
                    <!-- 件装量 -->
                    <p class="jzl">件装量：{{$v->jzl or ''}}</p>
                    <!-- 效期 -->
                    <p class="xq">效期：{{$v->xq}}</p>
                    <!-- 价格 -->
                    <p class="jg">
                        <!-- 活动价 -->
                        @if ($v->promote_price>0)
                        <span class="hdj"> <span>秒杀</span>￥{{$v->promote_price}}
                        </span>
                        @endif
                        <!-- 原价 -->
                        <span class="yj">原价:<span style="text-decoration:line-through">￥{{$v->shop_price}}
                            </span></span>
                    </p>
                    <!-- 库存 -->
                    <p class="kc">库存：
                        @if($v->goods_number>800)
                        充裕@elseif($v->goods_number==0)缺货@else{{$v->goods_number}}@endif
                    </p>
                    {{-- 限购 --}}
                    <p class="xg">
                        限购：10袋
                    </p>
                    <!-- 中包装 -->
                    <p class="zbz">中包装：{{$v->zbz or 1}}</p>
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
                        <div class="add-cart" data-img="{{$v->goods_thumb}}" onclick="tocart('{{$v->goods_id}}')">
                            <img src="/huodong/april/img/cart.png" /> 加入购物车
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
</div>
@include('layouts.new_footer')
<script type="text/javascript">
    $(".coupon-box .coupons .coupon img.can-click").click(function(){
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