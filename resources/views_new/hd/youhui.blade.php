@extends('layouts.app')
@section('title')
{{-- <title>促销专区-优惠专区</title> --}}
<title>促销专区-折扣专区</title>
@endsection
@section('links')
<link rel="stylesheet" type="text/css" href="/pyzq/pyzq-css/pyzq.css" />
<link rel="stylesheet" type="text/css" href="/new_cxzq/tejia.css" />
<!--layer-->
<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
{{-- layui --}}
<link rel="stylesheet" href="/layui/css/layui.css">
<script src="/layui/layui.js"></script>
<script src="/pyzq/pyzq.js" type="text/javascript" charset="utf-8"></script>
<script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
<script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>
<!--layer-->
<style>
/*    .czhg_list li {
        height: 440px;
    }*/

    .czhg_list li:hover {
        border: 1px solid #418ed2 !important;
    }

    #layer_tips {
        color: #0b0b0b;
    }
</style>
@endsection
@section('content')
@include('layouts.header')
@include('layouts.search')
@include('layouts.nav')
<!--banner-->
<div class="banner_box" style="width: 100%;min-width: 1190px;height: 300px;">
    <img style="width: 100%;height: 100%;display: block;transform:none;" src="/new_cxzq/tejiazq.jpg" alt="" />
</div>
<!--/banner-->

<!--商品列表-->
<div id="bgcolor_1" class="container">
    <div class="container_box">
        <div id="tejia" class="cxzq_section">
            <ul class="czhg_list">
                @foreach($youhui as $v)
                <li>
                    {{-- 右上角三角 --}}
                    <div class="triangle">
                        <a target="_blank" href="{{$v->goods_url}}">
                            <img class="label" src="/new_cxzq/label.png" alt="">
                            <span class="text">{{$v->round}}折</span>
                        </a>
                    </div>
                    {{--  <div class="yh layer_tips" id="dt_yh{{$v->goods_id}}"
                    data-msg="￥{{$v->zyzk}}">
                    优惠<i class="jiantou xia_i"></i>--}}
                    
                    <div class="tejia layer_tips" style="background: #418ed2" id="dt_yh{{$v->goods_id}}"
                        data-msg="￥{{$v->zyzk}}">优惠</div>
                    {{-- 2019 6.18 
                            <div class="tejia" style="background:#fff;top:0;left:0">
                                <a target="_blank" href="{{$v->goods_url}}">
                    <img src="/new_cxzq/label618.png" style="transform:none;width:80px" alt="">
                    </a>
        </div> --}}
        <div class="img_box">
            <a target="_blank" href="{{$v->goods_url}}"><img src="{{$v->goods_thumb}}" /></a>
        </div>
        <p class="name">{{$v->goods_name}}</p>
        <p class="gg">{{$v->spgg}}</p>
        <p class="company">{{$v->sccj}}</p>
        <div class="hd" style="height:auto;margin-top:10px">
            <div class="fl" style="width:30px;">满减</div>
            @if($user&&$user->ls_review==1)
            <div class="fr" style="width:210px;" id="{{$v->goods_id}}">
                满￥{{$v->shop_price}}减￥{{$v->zyzk}}</div>
            @endif
        </div>
        {{-- 限购 --}}

        <div class="btn">
            <div class="fl">
                @if($user&&$user->ls_review==1)
                {{formated_price($v->real_price)}}
                @else
                会员可见
                @endif
            </div>
            <a target="_blank" href="{{$v->goods_url}}" class="fr">
                立即抢购
            </a>
        </div>
        </li>
        @endforeach
        </ul>
        @if(!empty($youhui))
        <div id="page-box"></div>
        @else
        <div class="readmore">
            <a target="_blank">敬请期待</a>
        </div>
        @endif
    </div>
</div>
</div>
<!--/商品列表-->

@include('layouts.new_footer')
<script type="text/javascript">
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
                window.location.href = "http://47.107.103.86/category?keywords="+val+"&showi=0";
            },
            $('.search-btn')
		);
		
		//翻页
		layui.use(['laypage'],function(){
			var laypage = layui.laypage;
			laypage.render({
    			elem: 'page-box',
				count: {{$count}},
				curr:{{$curr}},
				limit:20,
				jump:function(obj,first){
					if(!first){
						window.location.href='/cxhd/youhui?page='+obj.curr;
					}
				}
  			});
		});
</script>
@endsection