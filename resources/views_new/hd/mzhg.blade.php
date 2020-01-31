@extends('layouts.app')
@section('title')
<title>促销专区-买赠专区</title>
@endsection
@section('links')
<link rel="stylesheet" type="text/css" href="/pyzq/pyzq-css/pyzq.css" />
<link rel="stylesheet" type="text/css" href="/hgzq/hgzq.css" />
<!--layer-->
<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />

<script src="/pyzq/pyzq.js" type="text/javascript" charset="utf-8"></script>
<script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
<script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
<script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>
<!--layer-->
@endsection
@section('content')
@include('layouts.header')
@include('layouts.search')
@include('layouts.nav')
<!--banner-->
<div class="banner_box" style="width: 100%;min-width: 1190px;height: 300px;">
	{{--<img width="100%" height="100%" src="/images/换购专区_01.jpg"/>--}}
	@if(isset($link))
	<a target="_blank" href="{{$link}}">
		<img style="width: 100%;height: 100%;display: block;transform:none;" src="{{$img_url}}" alt="" />
	</a>
	@else
	<img style="width: 100%;height: 100%;display: block;transform:none;" src="{{$img_url}}" alt="" />
	@endif
</div>
<!--/banner-->

<!--商品列表-->
<div style="background-color: #F8F8F8;">
	<div class="goods-box">
		<div class="content">
			<div id="datu" class="container">
				<div class="container_box">
					<ul class="datu">
						@foreach($mz as $v)
						<li>
							<div class="datu-chanpin-img">
								<a @if(!empty($v->url)) href="{{$v->url}}"
									@else href="{{route('goods.index',['id'=>$v->goods_id])}}" @endif target="_blank">
									<img src="{{get_img_path($v->goods->goods_img)}}" alt="" />
								</a>
								<div class="datu_bs">
								</div>
							</div>
							<div class="datu-mingzi">
								{{$v->goods_name}}
							</div>
							<div style="height: 1px;background-color: #E5E5E5;margin-top: 10px;"></div>
							<div class="datu-guige">
								<span>{{$v->goods->ypgg}}</span>
							</div>
							<div class="datu-compamy">
								{{$v->goods->product_name}}
							</div>
							<div style="height: 1px;background-color: #E5E5E5;margin-top: 10px;"></div>
							@if($user&&$user->ls_review==1)
							<div class="huodong">
								<span class="left">活动</span>
								@if (isset($v->goods_zp->message))
								<p>{{ $v->goods_zp->message }}</p>
								@endif
							</div>
							@endif
							{{-- 价格 --}}
							<div class="datu-jg">
								@if($user&&$user->ls_review==1)
								{{formated_price($v->goods->shop_price)}}
								@else
								会员可见
								@endif
							</div>
							<div class="btn_box">
								<div class="datu-jrgwc fly_to_cart16942"
									data-img="http://47.106.142.169:8103/image/goods/thumb_img/5f5cf42a5a887ee42b665d5e6d197f64.jpg?110112"
									onclick="tocart({{$v->goods_id}})">
									立即购买
								</div>
							</div>
						</li>
						@endforeach
					</ul>
					<div style="clear: both;"></div>
				</div>
			</div>
		</div>
	</div>
	<!--商品列表结束-->

	<!--footer开始-->
	<div class="footer_line"></div>

</div>
<!--/商品列表-->
@include('hd.111.nav111')
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
//                alert('搜索关键词"' + val + '"...');
                window.location.href = "http://47.107.103.86/category?keywords="+val+"&showi=0";
            },
            $('.search-btn')
        );
</script>
@endsection