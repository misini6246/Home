@extends('layouts.app')
@section('title')
	<title>新人特价</title>
@endsection
@section('links')
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge" />

	<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css"/>
	<link rel="stylesheet" type="text/css" href="/pyzq/pyzq-css/pyzq.css" />
	<link rel="stylesheet" type="text/css" href="/pyzq/pyzq-css/puyao_other.css"/>
	<link rel="stylesheet" type="text/css" href="/pyzq/pyzq-css/pages_other.css"/>

	<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css"/>

	<script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
	<!--layer-->
	<script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
	<script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
	<!--加减-->
	<script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
	<script src="/pyzq/pyzq.js" type="text/javascript" charset="utf-8"></script>
	<script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
	<div class="big-container">
		<!--头部-->
	{{--@include('layouts.header')--}}
			{{--<!--/头部-->--}}

			{{--<!--搜索导航-->--}}
	{{--@include('layouts.search')--}}
			{{--<!--/搜索导航-->--}}
	@include('layouts.youce')

			{{--<!--导航-->--}}
	{{--@include('layouts.nav')--}}
			{{--<!--/导航-->--}}

	<!--banner开始-->
		{{--<div class="banner_box" style="height: 580px;background: url(/new/images/header.png) no-repeat center;">--}}
			{{--<img class="img-not-hover" width="100%" height="580" src="/new/images/header.png" />--}}
		{{--</div>--}}
		<!--banner结束-->

		<!--商品列表开始-->
		<style type="text/css">
			.goods-box .title {
				width: 100%;
				min-width: 1190px;
				/* height: 355px; */
			}
			.goods-box a.go-ljzx {
				display: block;
				margin: 20px auto 100px;
				background-color: #ffde27;
				color: #fff;
				text-align: center;
				width: 300px;
				height: 80px;
				line-height: 80px;
				border-radius: 20px;
				font-size: 30px;
			}
		</style>
		<div class="goods-box" style="width: 100%;padding-bottom: 30px;margin-bottom: 0;background:#B90B02">
			<div class="title" style="text-align:center">
				<img  class="img-not-hover" src="/new/images/xkh/banner_201910.jpg" style="width:100%;transform:none">
			</div>
			<div class="content" style="text-align:center;margin-top:-200px">
				<a href="/yhq" target="_blank">
					<img class="img-not-hover" style="width:60%" src="/new/images/xkh/title1_201910.png"/>
				</a>
			</div>
			
			<!--商品列表开始-->
			<div class="goods-box" style="min-width:1230px;margin-top:110px;">
				<div class="title" style="margin:0 auto;text-align:center;z-index:5">
					<img class="img-not-hover" style="width:60%" src="/new/images/xkh/title2_201910.png"/>
				</div>
				<div class="content" style="padding-left: 6px;padding-bottom: 20px;margin-top:-40px;border:2px solid #10126a;border-radius:8px;width:1200px;background:#fff">
					<div id="datu" class="container">
						<div class="container_box">
							<ul class="datu">
								@foreach($result as $v)
									<li style="background: #fff">
										<div class="datu-chanpin-img">
											@if($v->is_cx==1&&$step=='yzj')
												@include('goods.zkbz')
											@endif
											<a target="_blank" href="{{$v->goods_url}}">
												<img class="lazy" data-original="{{$v->goods_thumb}}"/>
											</a>
											<img title="加入收藏夹" onclick="tocollect('{{$v->goods_id}}')"
												 src="/pyzq/img/icon_40.png"
												 class="datu-shoucang"/>
											<div class="datu_bs">
												@if($v->is_cx==1)
													<div class="tj layer_tips" id="dt_tj{{$v->goods_id}}"
														 data-msg="此商品为新人专享商品">
														新
													</div>
												@endif
											</div>
										</div>

										@if($v->is_can_see==0)
											<div class="datu-jiage-none">
												会员可见
											</div>
										@else
											@if($user->is_zhongduan==0)
												<div class="datu-jiage">
													{{formated_price($v->real_price)}}
												</div>
											@elseif($step=='nextpro')
												<div class="datu-jiage">
													活动价：{{formated_price($v->promote_price)}}
													<span style="margin-left: 5px;font-weight: normal;color: #999;text-decoration: line-through;">{{formated_price($v->real_price)}}</span>
												</div>
											@else
												<div class="datu-jiage">
													{{formated_price($v->real_price)}}
													@if(!isset($hide_shop_price))
														<span style="margin-left: 5px;font-weight: normal;color: #999;text-decoration: line-through;">{{formated_price($v->shop_price)}}</span>
													@endif
												</div>
											@endif
										@endif
										<div class="datu-mingzi">
											{{$v->goods_name}}
										</div>
										<div class="datu-compamy">
											{{$v->sccj}}
										</div>
										@if($step=='nextpro')
											<div class="datu-guige">
												规格：<span style="width: 80px;">{{$v->spgg}}</span>
												@if(($v->xg_type>0&&$v->xg_end_date>$v->promote_start_date&&$v->xg_start_date<=$v->promote_start_date)||$v->xg_type==1)
													限量：<span style="width: auto">{{$v->ls_ggg}}</span>
												@endif
											</div>
										@else
											<div class="datu-guige">
												规格：<span>{{$v->spgg}}</span>
											</div>
										@endif
										<div class="datu-xiaoqi">
											效期：<span
													@if($v->is_xq_red==1) class="daoqi" @endif>{{$v->xq}}</span>
											@if($v->is_zyyp==0)
												件装量：
												<span class="jianzhuang">{{$v->jzl}}</span>
											@endif
										</div>
										@if($step=='nextpro')
											<div class="datu-jianzhuang">
												<span style="color: #ef2c2f;width: 115px;">活动时间：{{$ad160->ad_name or '07.26'}}</span>
												库存：<span>@if($v->goods_number>=800)充裕@elseif($v->goods_number==0)
														缺货@else{{$v->goods_number}}@endif</span>
											</div>
										@else
											<div class="datu-jianzhuang">
												库存：<span>@if($v->goods_number>=800)充裕@elseif($v->goods_number==0)
														缺货@else{{$v->goods_number}}@endif</span> 中包装：
												<span>{{$v->zbz}}</span>
											</div>
										@endif
										<div class="btn_box">
											<div class="datu-jrgwc fly_to_cart{{$v->goods_id}}"
												 style="background-color: #3CBFE8"
												 data-img="{{$v->goods_thumb}}"
												 onclick="tocart('{{$v->goods_id}}','{{$v->product_id}}')">
												<img src="/pyzq/img/icon_39.png"/> 加入购物车
											</div>
											<div class="jiajian">
												<div class="jian min">
													-
												</div>
												<input id="J_dgoods_num_{{$v->goods_id}}" type="text"
													   value="{{$v->zbz}}" class="input_val"
													   data-zbz="{{$v->zbz}}"
													   data-kc="{{$v->goods_number}}"
													   data-jzl="{{$v->jzl}}" data-xl="{{$v->xg_num}}"
													   data-isxl="{{$v->is_xg}}"/>
												<div class="jia">
													+
												</div>
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
			<!--footer-->
			{{--@include('layouts.new_footer')--}}
			<!--/footer-->
	</div>
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
	</script>
@endsection

