@extends('layouts.app')
@section('title')
	<title>商品详情</title>
@endsection
	@section('links')
	<link rel="stylesheet" type="text/css" href="/xiangqing/xiangqing.css" />
	<script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
	<script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>

	<!--layer-->
	<script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
	<script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>

	<script src="/xiangqing/xiangqing.js" type="text/javascript" charset="utf-8"></script>
	@endsection
@section('content')
	@include('layouts.header')
	@include('layouts.search')
	@include('layouts.youce')
	@include('layouts.nav')
	<!--详情开始-->
	<div id="xiangqing" class="container">
		<div class="container_box">
			<div class="xiangqing_title">
				<i class="myicon address"></i>当前位置：
				<a href="{{route('index')}}">首页<i class="myicon xq_right"></i>中药专区</a><i class="myicon xq_right"></i>{{$info->goods_name}}
			</div>
			<div class="xq_main">
				<div class="xq_main_top">
					<div class="xiaotu_list_box" style="min-height: 100%">
						<ul class="xiaotu_list" >
							@foreach($img as $k=>$v)
								<li>
									<img src="{{get_img_path($v->thumb_url)}}"
										 data-src="{{get_img_path($v->img_url)}}"/>
								</li>
							@endforeach
						</ul>
					</div>
					<div class="xq_datu">
								<span class="jqzoom">
								<img jqimg="{{$info->goods_img}}"
									 src="{{$info->goods_thumb}}"/>
							</span>
					</div>
					<div class="mid" style="position: relative;">
                        <span style="position: absolute;height: 50px;bottom: -10px;font-size: 14px;font-weight: bold;line-height: 25px;left: -451px;width: 398px;text-align: center;background: #fff;">
                            温馨提示：图片均为原品的真实拍摄，仅供参考；
                            <br/>
                            如遇新包装上市可能存在更新滞后，请以实物为准！
                        </span>
						<p class="name">{{$info->goods_name}}</p>
						@if(($info->is_zx==1)&&!empty($info->cxxx))

							@if($info->cxxx)
								<p class="cxxx">{{$info->cxxx}}</p>
							@endif

						@endif
						@if(!empty($info->bzxx))
							<p class="cxxx">{{$info->bzxx or ''}}</p>
						@endif
						@if(!empty($info->bzxx2))
							<p class="cxxx">{{$info->bzxx2 or ''}}</p>
						@endif
						<div class="money">
							<p class="yuanjia">建议零售价： {{formated_price($info->market_price)}}</p>
							@if($info->is_cx==1)
								<p class="cxj">
									促销价：<span>{{$info->real_price_format}}
										@if($user&&$user->ls_review==1)
											<s style="font-size: 16px;color: #777;margin-left: 10px;font-weight: normal;">
                                                {{formated_price($info->shop_price)}}
                                            </s>
										@endif</span><span class="bs">特价</span>
									@if($info->zyzk>0)
										<span class="bs" style="background: #418ed2">优惠</span>
									@endif
									@if($info->is_zx==1)
										@if(strpos($info->cxxx,'换购')!==false)
											<span class="bs" style="background: #bb8d2b">换购</span>
										@else
											<span class="bs" style="background: #3634cf">买赠</span>
										@endif
									@endif
								</p>
							@elseif($info->product_id==1)
								<p class="cxj">
									促销价：<span>{{$info->real_price_format}}
										@if($user&&$user->ls_review==1)
											<s style="font-size: 16px;color: #777;margin-left: 10px;font-weight: normal;">
                                                {{formated_price($info->shop_price)}}
                                            </s>
										@endif</span><span
											class="bs" style="padding: 0 5px;width: auto;">此品种为特卖品种</span>
									@if($info->is_xqpz==1)
										<span
												class="bs" style="padding: 0 5px;width: auto;">此品种为效期品种</span>
									@endif
								</p>
							@else
								<p class="cxj">
									会员价：<span>{{$info->real_price_format}}</span>
									@if($info->zyzk>0)
										<span class="bs" style="background: #418ed2">优惠</span>
									@endif
									@if($info->is_zx==1)
										@if(strpos($info->cxxx,'换购')!==false)
											<span class="bs" style="background: #bb8d2b">换购</span>
										@else
											<span class="bs" style="background: #3634cf">买赠</span>
										@endif
									@endif
								</p>
							@endif
						</div>
						<div class="text">
							<p><span class="justy">生产厂家</span>：{{$info->sccj}} </p>
							<p><span class="justy">包装规格</span>：{{$info->spgg}}</p>
							<p><span class="justy">包装单位</span>：{{$info->dw}}</p>
							<p><span class="justy">产地</span>：{{$info->jzl}}</p>
							<p><span class="justy">中包装</span>：{{$info->zbz}}</p>
							<p><span class="justy">效期</span>：@if($info->is_xq_red==1)<span
										style="color: #e70000">{{$info->xq}}</span>@else{{$info->xq}}@endif</p>
							<p><span class="justy">批准文号</span>： {{$info->gyzz}}</p>
						</div>
						<div class="jiajian">
							<span class="justy">数量</span>：
							<span class="jian">-</span><input
									@if($info->product_id==0)
									id="J_dgoods_num_{{$info->goods_id}}"
									@else
									id="J_dgoods_num1_{{$info->goods_id}}"
									@endif
									type="text"
									value="@if($info->zbz == 0) 1 @else {{$info->zbz}} @endif" class="input_val"
									data-zbz="@if($info->zbz == 0) 1 @else {{$info->zbz}} @endif"
									data-kc="{{$info->goods_number}}"
									data-jzl="{{$info->jzl}}"
									data-xl="{{$info->xg_num}}"
									data-isxl="{{$info->is_xg}}"/><span
									class="jia">+</span>库存：@if($info->goods_number>800)
								充裕@elseif($info->goods_number==0)
								暂时缺货@else{{$info->goods_number}}&nbsp;{{$info->dw}}@endif
						</div>
					</div>
				</div>
				<div class="xq_main_bottom">
					<div class="xq_main_bottom_left">
						<div class="bdsharebuttonbox">
							<a href="#" class="bds_more" data-cmd="more">分享到：</a>
							<a href="#" class="bds_qzone" data-cmd="qzone"></a>
							<a href="#" class="bds_tsina" data-cmd="tsina"></a>
							<a href="#" class="bds_tqq" data-cmd="tqq"></a>
							<a href="#" class="bds_renren" data-cmd="renren"></a>
							<a href="#" class="bds_weixin" data-cmd="weixin"></a>
						</div>
						<div class="zffs">
							<a target="_blank" href="{{route('article.index',['id'=>5])}}" class="fr"><i
										class="myicon xq_gwc"></i>如何购买？</a>
							支付方式：<a target="_blank" href="{{route('articleInfo',['id'=>91])}}"><i
										class="myicon epay"></i>在线支付</a>
							<a target="_blank" href="{{route('articleInfo',['id'=>49])}}"><i class="myicon bank"></i>银行转账</a>
						</div>
					</div>
					<div class="xq_main_bottom_right">
							<span id="jrgwc" data-img="{{$info->goods_thumb}}" class="fly_to_cart{{$info->goods_id}}"
								  onclick="tocart('{{$info->goods_id}}','{{$info->product_id}}')">
								<i class="myicon btn_gwc"></i>加入购物车
							</span><span id="jrsc" onclick="tocollect('{{$info->goods_id}}')">
								<i class="myicon btn_sc"></i>加入收藏
							</span>
					</div>
				</div>
			</div>
			<div class="xiangqing_bottom">
				<div class="xiangqing_bottom_right">
					<ul class="xiangqing_bottom_right_title">
						<li class="active">商品详情</li>
						@if( !(\Illuminate\Support\Facades\Auth::user() && \Illuminate\Support\Facades\Auth::user()->user_id==65207))
						<li>商品说明书</li>

						<li>售后保障</li>
							@endif
					</ul>
					<ul class="xiangqing_bottom_right_list">
						<li class="active">
							<p>生产厂家：{{$info->sccj}}</p>
							<p>包装单位：{{$info->dw}}</p>
							<p>药品规格：{{$info->spgg}}</p>
							<p>批准文号：{{$info->gyzz}}</p>
							<p>件 装 量：{{$info->jzl}}</p>
						</li>
						<li>
							<p>
								{!! $info->goods_sms !!}
							</p>
							{{--<p class="MsoNormal"><span lang="EN-US">&nbsp;</span></p>--}}
						</li>
						<li>
							<div id="shouhou">
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--详情结束-->
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
                window.location.href = "http://www.jyeyw.com/category?keywords="+val+"&showi=0";
            },
            $('.search-btn')
        );


        //放大镜
        $('.jqzoom').magnifyEvent();
        $('.jqzoom').css('position','absolute');
        $('.xiaotu_list li').hover(function(){
            $('.jqzoom').attr('data-src',$(this).find('img').attr('data-src'));
            $('.jqzoom img').attr('src',$(this).find('img').attr('src'));
        })
	</script>
	@endsection
