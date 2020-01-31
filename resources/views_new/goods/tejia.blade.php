@extends('layouts.app')
@section('title')
	<title>特价页面</title>
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
	@include('layouts.header')
	@include('layouts.search')
	@include('layouts.nav')
	@include('layouts.youce')
	{{--@include('tejia.gg1',['page'=>$result->currentPage()])--}}
	<div class="banner_box">
		<img width="100%" height="320" src="/index/img/tj.jpg"/>
	</div>
	<div>
		<div class="goods-box">
			<div class="content">
				@if(count($result)==0)
					<div id="none" class="container">
						<div class="container_box">
							<div class="none">
								<div class="img_box">
									<img src="/index/img/search_none.jpg"/>
								</div>
								<div class="text">
									<p>抱歉！没有找到@if(!empty($keywords))与“<span>{{$keywords}}</span>”@endif相关的药品</p>
									<p>你可以发布求购意向，重庆今瑜e药网会尽快补货！</p>
									<a target="_blank" href="/requirement" class="link">发布求购</a>
								</div>
							</div>
							@if(isset($cx_goods[6]))
								<div id="wntj" class="container">
									<div class="container_box">
										<div id="ban3" class="ban">
											<div class="section_title">
												<i class="myicon wntj_icon"></i>
												<span class="biaoti">为您推荐</span>
											</div>
											<div class="banner">
												<ul class="img">
													@if(count($cx_goods[6])>0)
														<li>
															@foreach($cx_goods[6] as $k=>$v)
																@if($k<5)
																	<a target="_blank"
																	   href="{{route('goods.index',['id'=>$v->goods_id])}}">
																		<div class="wntj-cp">
																			<div class="img_box">
																				<img src="{{$v->goods_thumb}}"/>
																			</div>
																			<p class="name">{{$v->goods_name}}</p>
																			<p class="gg">{{$v->ypgg}}</p>
																			<p class="money login">{{$v->format_price}}</p>
																		</div>
																	</a>
																@endif
															@endforeach
														</li>
													@endif
													@if(count($cx_goods[6])>5)
														<li>
															@foreach($cx_goods[6] as $k=>$v)
																@if($k>=5&$k<10)
																	<a target="_blank"
																	   href="{{route('goods.index',['id'=>$v->goods_id])}}">
																		<div class="wntj-cp">
																			<div class="img_box">
																				<img src="{{$v->goods_thumb}}"/>
																			</div>
																			<p class="name">{{$v->goods_name}}</p>
																			<p class="gg">{{$v->ypgg}}</p>
																			<p class="money login">{{$v->format_price}}</p>
																		</div>
																	</a>
																@endif
															@endforeach
														</li>
													@endif
												</ul>
												<div class="btn btn_l">
													<i class="myicon lb_left_icon"></i>
												</div>
												<div class="btn btn_r">
													<i class="myicon lb_right_icon"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
							@endif
						</div>
					</div>
				@else
					<div id="datu" class="container">
						<div class="container_box">
							<ul class="datu">
								@foreach($result as $v)
									<li style="position: relative;">
										<div class="datu-chanpin-img">
											@if($v->is_cx==1&&$step=='yzj')
												@include('goods.zkbz')
											@endif
											<a target="_blank" href="{{$v->goods_url}}">
												<img class="lazy" data-original="{{$v->goods_thumb}}"/>
												@if($v->getAttribute('119zk')>0)
													<img style="position: absolute;top: 0;right: 1px;"
														 data-original="{{get_img_path('adimages1/201809/sale_'.$v->getAttribute('119zk').'.png')}}"
														 class="lazy"/>
												@endif
											</a>
											<img title="加入收藏夹" onclick="tocollect('{{$v->goods_id}}')"
												 src="/pyzq/img/icon_40.png"
												 class="datu-shoucang"/>
											<div class="datu_bs">
												{{--@if($user&&in_array($step,['nextpro','promotion']))--}}
												{{--<div class="yh layer_tips lscg" id="dt_cg{{$v->goods_id}}"--}}
												{{--data-sync="0"--}}
												{{--data-msg="历史采购均价：$avg_price<br/>近期购买过$num{{$v->dw}}($count次)">--}}
												{{--历史采购<i class="jiantou xia_i"></i>--}}
												{{--</div>--}}
												{{--@endif--}}
												@if($v->zyzk>0)
													<div class="yh layer_tips" id="dt_yh{{$v->goods_id}}"
														 data-msg="此商品为优惠商品">
														优惠
													</div>
												@endif
												@if($v->is_zx==1)
													@if(strpos($v->cxxx,'换购')!==false)
														<div class="hg layer_tips" id="dt_hg{{$v->goods_id}}"
															 data-msg="{{$v->cxxx}}">
															换购
														</div>
													@else
														<div class="mz layer_tips" id="dt_mz{{$v->goods_id}}"
															 data-msg="{{$v->cxxx}}">
															买赠
														</div>
													@endif
												@endif
												@if($v->is_cx==1)
													<div class="tj layer_tips" id="dt_tj{{$v->goods_id}}"
														 data-msg="此商品为特价促销商品">
														特价
													</div>
												@endif
											</div>
										</div>
										@if(!empty($v->getAttribute('119bz')))
											<span title="{{$v->getAttribute('119bz')}}"
												  style="position: absolute;width: 208px;background-color: red;height: 30px;line-height: 30px;top: 200px;margin: 0 10px;color: #fff;padding: 0 10px;overflow: hidden;">{{$v->getAttribute('119bz')}}</span>
										@endif
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
												<span style="color: #ef2c2f;width: 115px;">活动时间：{{$ad160->ad_name or '12.29'}}</span>
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
												 style="background-color: #ef2c2f"
												 data-img="{{$v->goods_thumb}}"
												 onclick="tocart('{{$v->goods_id}}')">
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
							@if($result->hasPages())
								{!! $pages_view !!}
							@endif
						</div>
					</div>
				@endif
			</div>
		</div>
	</div>
	@if(isset($daohang)&&$daohang==1)
		@include('miaosha.daohang')
	@endif
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

