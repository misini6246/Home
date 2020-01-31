<!DOCTYPE html>
<html lang="zh">

	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="ie=edge" />
		<title>填写核对订单信息</title>
		<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
		<link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/common_gwc.css" />
		<link rel="stylesheet" type="text/css" href="/new_gwc/jiesuan_common.css"/>
		<link rel="stylesheet" type="text/css" href="/new_gwc/gwc_2.css"/>
		<!--layer-->
		<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
		
		<script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
		<!--layer-->
		<script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
		<script src="/new_gwc/gwc-js/common.gwc.js" type="text/javascript" charset="utf-8"></script>
		<script src="/new_gwc/gwc_2.js" type="text/javascript" charset="utf-8"></script>
		<!--<script src="js/gwc/slides.jquery.js" type="text/javascript" charset="utf-8"></script>-->
		<script src="/new_gwc/gwc-js/tanchuc.js" type="text/javascript" charset="utf-8"></script>
		<script src="/new_gwc/gwc-js/transport_jquery.js" type="text/javascript" charset="utf-8"></script>
	</head>
	<style type="text/css">
		.top-box {
			height: 120px;
			width: 100%;
			border-bottom: 2px solid #0090D2;
		}
		
		.top-box .box-container .left {
			height: 100%;
			width: 370px;
			float: left;
		}
		
		.top-box .box-container .left img {
			display: block;
			width: 100%;
			height: 100%;
		}
		
		.top-box .box-container .right {
			height: 100%;
			width: 620px;
			float: right;
		}
		
		.top-box .box-container .right img {
			display: block;
			width: 100%;
			height: 100%;
		}
	</style>

	<body style="overflow-x: auto">
		<div class="big-container">
			<!--头部-->
			@include('layouts.header')
			<!--/头部-->

			<div class="top-box" style="background-color: #fff;">
				<div class="box-container">
					<div class="left"><a href="http://www.jyeyw.com/"><img src="/new_gwc/img/购物车_01.jpg" /></a></div>
					<div class="right"><img src="/new_gwc/jiesuan_img/填写核对订单信息_01.jpg" /></div>
				</div>
			</div>

			<!--主体内容开始-->
			<!--主体内容开始-->
			<form action="/cart/order" method="post" onsubmit="return check_sub()" id="forms">
				{!! csrf_field() !!}
				<div class="jiesuan_box container">
					<div class="container_title">
						填写核对订单信息
						<a href="{{route('cart.index')}}" style="float: right;">返回购物车</a>
					</div>
					<div class="spqd">
						<div class="spqd_title">

							<img src="/new_gwc/jiesuan_img/椭圆.png"/><span class="weight">商品清单</span><span
									class="txt">(满<span>800</span>全国包邮)</span>
						</div>
						<div class="spqd_thead">
							<div class="spmc">商品名称</div>
							<div class="sccj">生产厂家</div>
							<div class="gg">规格</div>
							<div class="xq">效期</div>
							<div class="gyzz">国药准字</div>
							<div class="dj">单价</div>
							<div class="sl">数量</div>
							<div class="xj">小计</div>
						</div>
						<ul class="spqd_tbody">
							@include('cart.goods',['result'=>$goods_list])
						</ul>
						@if(count($goods_list)>5)
							<div class="readmore" onclick="check_all()" id="zhankai">
								<div class="readmore_box">
									<span>查看完整清单</span>
									<img src="/pyzq/img/icon_42.jpg"/>
								</div>
							</div>
							<div class="readmore" onclick="shouqi()" id="shouqi" style="display: none;">
								<div class="readmore_box">
									<span>收起清单</span>
									<img src="/pyzq/img/icon_42.jpg"/>
								</div>
							</div>
						@endif
					</div>
					{{--@if(count($gifts)>0)--}}
					{{--<div class="lplb">--}}
					{{--<div class="spqd_title">--}}
					{{--<img src="/images/xinlong/dian.png"/><span class="weight">礼品列表</span>--}}
					{{--</div>--}}
					{{--<div class="lplb_box">--}}
					{{--<ul class="dh_list">--}}
					{{--@foreach($gifts as $v)--}}
					{{--<li data-name="{{$v->gift_name}}">--}}
					{{--<div class="img_box">--}}
					{{--<img src="{{get_img_path($v->img)}}" style="width: 130px;height: 130px;"/>--}}
					{{--</div>--}}
					{{--<div class="choose">--}}
					{{--<span>--}}
					{{--<img src="/images/xinlong/choose.png"/>--}}
					{{--</span>{{$v->gift_name}}--}}
					{{--</div>--}}
					{{--</li>--}}
					{{--@endforeach--}}
					{{--</ul>--}}
					{{--</div>--}}
					{{--</div>--}}
					{{--@endif--}}
					{{--<input type="hidden" name="gift_status" id="gift_staus" value="@if(count($gifts)>0) 1 @endif"/>--}}
					<div class="address">
						<div class="spqd_title">
							<img src="/new_gwc/jiesuan_img/椭圆.png"/><span class="weight">收货地址与物流配送</span>
						</div>
						<p style="display: block;border: 1px #e5e5e5 dashed; padding: 10px; width: 1160px;margin: 0 auto;color: red;">收货信息与配送方式只能让客服修改，所有货物请在送货员在场时开箱验货再签收，如有破损时联系客服人员，如当面未开箱验货，破损不予赔付，自行承担</p>
						<div class="lplb_box">
							<ul class="shdz">
								<li>
									<div class="shdz_title">
										收货地址
									</div>
									<div class="shdz_box">
										<p class="name">
											<span class="fr">{{$address->tel or $address->mobile}}</span>
											{{$address->consignee}}
										</p>
										<p class="dizhi">
											{{$province->region_name or ''}} {{$city->region_name or ''}} {{$district->region_name or ''}} {{$address->address}}
										</p>
									</div>
								</li>
								@if($user->shipping_id!=0)
									<li>
										<div class="shdz_title">
											物流配送
										</div>
										<div class="shdz_box">
											<p class="express">
												配送物流：<span>{{$user->shipping_name}}</span>
											</p>
										</div>
									</li>
								@else
								<!--<li class="add_wuliu">
                                    {{--<img src="{{get_img_path('images/cart/add_wuliu.png')}}"/>--}}
										<span>选择物流</span>
                                    </li>-->
								@endif
							</ul>
						</div>
					</div>
					<input type="hidden" name="shipping" value="{{$user->shipping_id}}">
					<div class="fapiao">
						<div class="spqd_title">
							<img src="/new_gwc/jiesuan_img/椭圆.png"/><span class="weight">发票类型</span>
						</div>
						<div class="fapiao_box">
							@if($order_num==0)
								<ul class="fapiao_choose">
									<li>
										<input checked type="radio" name="dzfp" id="a" value="0">
										<label for="a">普通发票</label>
									</li>
									<li>
										<input type="radio" name="dzfp" id="ab" value="2"/>
										<label for="ab">增值税发票</label>
										{{--<a href="/uploads/tax_receipt.doc">下载表单</a>--}}
									</li>

								</ul>
							@else
								<ul class="fapiao_choose">
									<li>
										<label for="a">@if($user->dzfp==0)普通发票@elseif($user->dzfp==2)
												增值税发票@endif</label>
									</li>
								</ul>
								<input name="dzfp" value="{{$user->dzfp}}" type="hidden">
							@endif
						</div>
					</div>
					@if(count($yhq_list)>0&&$pack_fee>0)
						<div class="youhuijuan">
							<div class="spqd_title">
								<img src="/new_gwc/jiesuan_img/椭圆.png"/><span class="weight">优惠券</span>
							</div>
							<div class="fapiao_box">
								<div class="fapiao_box_title">
									使用优惠券<span>{{$yhq_count or 1}}</span>张&nbsp;&nbsp;&nbsp;&nbsp;抵扣金额<span>{{$pack_fee}}</span>元
								</div>
								@include('cart.youhuiq',['result'=>$yhq_list])
							</div>
						</div>
					@endif
					<div class="fangshi">
						<div class="spqd_title">
							<img src="/new_gwc/jiesuan_img/椭圆.png"/><span class="weight">选择支付方式</span>
						</div>
						<div class="fangshi_box">
							{{--<div class="spzje">--}}
								{{--商品总金额：<span>{{formated_price($goods_amount)}}</span>--}}
								{{--折扣金额：<span>￥1160.00</span>--}}
								{{--优惠金额：<span>{{formated_price($zyzk)}}</span>--}}
								{{--@if(count($yhq_list)>0||$pack_fee>0)--}}
									{{--可参与{{trans('common.pack_fee')}}金额：<span>{{formated_price($ty_amount)}}</span>--}}
								{{--@endif--}}
							{{--</div>--}}
							@if($surplus>0)
								<div class="ye">
									<img src="/index/img/ye.png"/>
									<span class="f">
								<span class="txt">
									使用余额：
								</span>
								<span class="ye_money">
									{{formated_price($surplus)}}
								</span>
								<span class="keyong">
									（可用余额：<span>{{formated_price($user->user_money)}}</span>）
								</span>
							</span>
								</div>
							@endif
							@if(isset($cz_money)&&$cz_money>0)
								<div class="ye">
									<img src="index/img/ye.png"/>
									<span class="f">
								<span class="txt">
									使用{{trans('common.cz_money')}}：
								</span>
								<span class="ye_money">
									{{formated_price($cz_money)}}
								</span>
								<span class="keyong">
									（当前{{trans('common.cz_money')}}
									：<span>{{formated_price($user->cz_money->money)}}</span>）
								</span>
							</span>
								</div>
							@endif
							@if($order_amount>=0)
								<div class="zhifufangshi">
									<div class="zhifufangshi_title">
										选择剩余款项的支付方式
									</div>
									<ul class="zhifufangshi_list">

										@foreach($payment as $v)
											@if($v->pay_id==7)
												<li data-id="{{$v->pay_id}}" class="active">
													<div class="img_box">
														<img src="/index/img/weixin_03.jpg"/>
														<span>微信支付</span>
														<div class="choose_box">
															<img src="/index/img/choose.png"/>
														</div>
													</div>
													<p class="name">微信扫码支付</p>
													<p class="js_tishi">无手续费，支持储蓄卡，信用卡。</p>
													<a target="_blank"
													   href="https://kf.qq.com/touch/sappfaq/151210EJfUZZ151210qq2yUn.html?scene_id=kf1&platform=14">查看支付限额></a>
												</li>

											@elseif($v->pay_id==9)
												<li data-id="{{$v->pay_id}}">
													<div class="img_box">
														<img src="/index/img/zhifubao_03.jpg"/>
														<span>支付宝支付</span>
														<div class="choose_box">
															<img src="/index/img/choose.png"/>
														</div>
													</div>
													<p class="name">支付宝扫码支付</p>
													<p class="js_tishi">使用支付宝app扫描网页二维码或者登录支付宝账户支付。</p>
												</li>
											@elseif($v->pay_id==2)
												<li data-id="{{$v->pay_id}}">
													<div class="img_box">
														<span>银行转账/汇款</span>
														<div class="choose_box">
															<img src="/index/img/choose.png"/>
														</div>
													</div>
													<p class="name">银行转账/汇款</p>
													<a target="_blank" href="/articleInfo?id=13">查看账户></a>
												</li>
											@endif
										@endforeach

									</ul>
								</div>
							@endif
						</div>
					</div>
					<input type="hidden" name="payment" value="7">
					<div class="beizhu">
						<div class="spqd_title">
							<img src="/new_gwc/jiesuan_img/椭圆.png"/><span class="weight">订单备注</span>
						</div>
						<div class="beizhu_box">
							<textarea name="postscript"></textarea>
						</div>
					</div>
					<div class="heji">
						<div class="spqd_title">
							<img src="/new_gwc/jiesuan_img/椭圆.png"/><span class="weight">费用总计</span>
						</div>
						<div class="heji_box">
							<div class="feiyong">
								<ul class="fr">
									<li>
										<span class="left">商品总金额：</span>
										<span class="right">{{formated_price($goods_amount)}}</span>
									</li>
									<li>
										<span class="left">运费：</span>
										<span class="right">+ {{formated_price($shipping_fee)}}</span>
									</li>
									{{--<li>--}}
									{{--<span class="left">折扣金额：</span>--}}
									{{--<span class="right"> - ￥0.00</span>--}}
									{{--</li>--}}
									<li>
										<span class="left">优惠金额：</span>
										<span class="right">- {{formated_price($zyzk)}}</span>
									</li>
									@if($surplus>0)
										<li>
											<span class="left">使用余额：</span>
											<span class="right">- {{formated_price($surplus)}}</span>
										</li>
									@endif
									@if(isset($cz_money)&&$cz_money>0)
										<li>
											<span class="left">使用{{trans('common.cz_money')}}：</span>
											<span class="right">- {{formated_price($cz_money)}}</span>
										</li>
									@endif
									@if($pack_fee>0||count($yhq_list)>0)
										<li>
											<span class="left">活动优惠：</span>
											<span class="right">- {{formated_price($pack_fee)}}</span>
										</li>
									@endif
								</ul>
							</div>
							<div class="manage fixed_manage">
								<div class="manage_box">
									<div class="fr">
										<span class="text">应付款金额：</span><span
												class="money">{{formated_price($order_amount)}}</span><input
												type="submit"
												name=""
												id="btn"
												value="提交订单" style="cursor: pointer;"/>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>

			<!--主体内容结束-->

			<!--footer开始-->
		@include('layouts.new_footer')
		<!--footer结束-->
			<!--/footer-->
		</div>
	</body>

</html>