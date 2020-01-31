@extends('layouts.app')
@section('title')
	<title>诊所专区</title>
	@endsection
		@section('links')
			<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
			<link rel="stylesheet" type="text/css" href="/index/css/index/index.css" />
			<link rel="stylesheet" type="text/css" href="/new_zs/zszq.css"/>

			<script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
			<script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>

			@endsection
@section('content')
	<div class="big-container">
		<!--头部-->
		@include('layouts.header')
		<!--/头部-->

		<!--搜索导航-->
		@include('layouts.search')
		<!--/搜索导航-->

		<!--导航-->
		<div class="nav-box">
			<div class="box-container">
				<div class="all">
					<i class="my-icon icon-4"></i> 全部商品分类
					<div class="site_content" style="height: 400px;*height: 401px !important;background: #3e8b63;top: 0;">
						<ul class="menu_list">
						@foreach($category as $k=>$v)
							@if($k<5)

							<li class="">
								<div class="text" style="border-bottom: 1px dashed rgb(178, 209, 193);">
									<p class="text_top">
										<img src="/new_zs/menu_right.png?110112" class="fr">
										<img src="/new_zs/menu_right_hove.png?110112" class="fr"> {{$v->cat_name}}
									</p>
									<p class="text_bottom">
										@foreach($v->cate as $key=>$val)
											@if($key<3)
												<span>{{$val->cat_name}}</span>
											@endif
										@endforeach
									</p>
								</div>
								<ul class="child">
									@foreach($v->cate as $val)
										@if(count($val->cate)>0)
											<li style="height: auto;">
												<p class="title">{{$val->cat_name}}</p>
												<ul>
													@foreach($val->cate as $value)
														<li class="cat_name"><a
																	href="{{route('category.index',['ylfl'=>'n','ylfl1'=>$v->cat_id,'ylfl2'=>$value->cat_id])}}">{{$value->cat_name}}</a>
														</li>
													@endforeach
												</ul>
											</li>
										@endif
									@endforeach
								</ul>
							</li>
							@endif
							@endforeach
						</ul>
					</div>
				</div>
				<ul class="nav-item">
					@foreach($middle_nav as $k=>$v)
						<li @if(isset($dh_check)&&$v->id==$dh_check)
							class="cur"
								@endif><a href="{{$v->url}}" @if($v->opennew==1)target="_blank" @endif >{{$v->name}}</a>
							@if($v->is_hot==1)
								<img src="{{get_img_path('adimages1/201807/hot.gif')}}"/>
							@endif
						</li>
					@endforeach
				</ul>
			</div>
		</div>


		@include('layouts.youce')
		<!--/导航-->

		<!--banner-->
		<div class="banner-box" style="background-color: #f8feff;height: 400px;">
			<div class="box-container">
				<!--轮播-->
				<div id="carousel" class="carousel" style="height: 400px;">
					<ul class="carousel-list">
						<div class="banner-pic">
							@foreach($ad167 as $k=>$v)
								<ul>
									<li style="background:#{{$v->ad_bgc}}; @if($k==0) display:list-item @endif">
										<a href="{{$v->ad_link}}"
										   title="" target="_blank">
											<img data-src="{{$v->ad_code}}"
												 src="{{$v->ad_code}}"/>
										</a>
									</li>
								</ul>
							@endforeach
						</div>
					</ul>
				</div>
				<!--/轮播-->

				<!--广告-->
				<div class="yg-box">
					@foreach($type4 as $v)
						<div class="img-box" style="height: 200px;">
							<a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
								<div class="img_box">
									<img style="width: 140px;height: 140px;" class="lazy"
										 src="{{get_img_path($v->goods->goods_thumb)}}"/>
								</div>
								<div class="text" style="text-align: center">
									<p class="name" title="{{$v->goods_name}}">{{str_limit($v->goods_name,26)}}</p>
									<p class="gg">{{$v->ypgg}}</p>
									<p class="company" title="{{$v->sccj}}">{{str_limit($v->sccj,32)}}</p>
								</div>
							</a>
						</div>
					@endforeach
				</div>
				<!--/广告-->
			</div>
		</div>
		<!--/banner-->

		<!--link-->
		<div id="links" class="container">
			<ul class="container_box" style="text-align: center;">
				<li>
					<a target="_blank" href="{{route('category.index',['dis'=>'v'])}}">
						<img src="/new_zs/link_01.jpg"/>
					</a>
				</li>
				<li>
					<a target="_blank" href="{{route('category.index',['dis'=>'r'])}}">
						<img src="/new_zs/link_02.jpg"/>
					</a>
				</li>
				<li>
					<a target="_blank" href="{{route('category.index',['dis'=>'s'])}}">
						<img src="/new_zs/link_03.jpg"/>
					</a>
				</li>
				<li>
					<a target="_blank" href="{{route('category.index',['dis'=>'t'])}}">
						<img src="/new_zs/link_04.jpg"/>
					</a>
				</li>
				<li>
					<a target="_blank" href="{{route('category.index',['dis'=>'u'])}}">
						<img src="/new_zs/link_05.jpg"/>
					</a>
				</li>
			</ul>
		</div>
		<!--/link-->

		<!--精选好药-->
		<div id="jxhy" class="container">
			<div class="container_box">
				<div class="jxhy_title">
					<img src="/new_zs/jxhy.png">
				</div>
				<ul class="jxhy_list">
					@foreach($type1 as $v)
						<li>
							<a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
								<div class="img_box">
									<img src="{{get_img_path($v->goods->goods_thumb)}}"/>
								</div>
								<div class="text">
									<p class="name" title="{{$v->goods_name}}">{{str_limit($v->goods_name,22)}}</p>
									<p class="gg">{{$v->ypgg}}</p>
									<p class="company" title="{{$v->sccj}}">{{str_limit($v->sccj,26)}}</p>
								</div>
							</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
		<!--/精选好药-->

		<!--新品上架-->
		<div id="xpsj" class="container">
			<div class="container_box">
				<!--销量排行-->
				<div class="content-left">
					<div class="content-left-title">
						<div></div>
						<span>一周销量排行榜</span>
					</div>
					@foreach($week_sale as $k=>$v)
						@if($k<3)
							<div class="paihang">
								<div class="paihang-title">
									@if($k==0)
										<img src="new_zs/jin.jpg"/>
									@elseif($k==1)
										<img src="new_zs/yin.jpg"/>
									@elseif($k==2)
										<img src="new_zs/tong.jpg"/>
									@endif
									<div class="chengjiaoliang">
										成交量：<span>{{$v->num+2000}}</span>
									</div>
									<div class="paihang-img">
										<a target="_blank" href="{{$v->goods_url}}">
											<img class="lazy" src="{{$v->goods_thumb}}"/>
										</a>
									</div>
									<div class="paihang-name">
										<div>{{$v->goods_name}}</div>
										<div>{{$v->ypgg}}</div>
									</div>
								</div>
							</div>
						@endif
					@endforeach
					<div class="paihang-bottom">
						<ul>
							@foreach($week_sale as $k=>$v)
								@if($k>=3)
									<li>
										<span>{{$k+1}}</span>
										<div class="hover-before">
											<a target="_blank" href="{{$v->goods_url}}">{{$v->goods_name}}</a>
											<span class="ke">{{$v->ypgg}}</span>
										</div>
										<div class="hover-after">
											<a target="_blank" href="{{$v->goods_url}}">
												<img src="{{$v->goods_thumb}}"/>
											</a>
											<p class="hover-name">{{$v->goods_name}}</p>
											<p class="hover-guige">{{$v->ypgg}}</p>
										</div>
									</li>
								@endif
							@endforeach
						</ul>
					</div>
				</div>
				<!--销量排行结束-->
				<div class="content-right">
					<div class="content-right-title">
						<img src="/new_zs/xpsj.png">
					</div>
					<ul class="xpsj_list">
						@foreach($type2 as $v)
							<li>
								<a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
									<div class="text">
										<p class="name" title="{{$v->goods_name}}">{{str_limit($v->goods_name,26)}}</p>
										<p class="gg">{{$v->ypgg}}</p>
										<p class="company" title="{{$v->sccj}}">{{str_limit($v->sccj,32)}}</p>
									</div>
									<div class="img_box">
										<img style="width: 205px;" class="lazy"
											 src="{{get_img_path($v->goods->goods_thumb)}}"/>
									</div>
								</a>
							</li>
						@endforeach
					</ul>
					{{--@foreach($ad168 as $k=>$v)--}}
						{{--@if($k==0)--}}
							{{--<div class="right_img">--}}
								{{--<a target="_blank" href="{{$v->ad_link}}">--}}
									{{--<img src="{{$v->ad_code}}"/>--}}
								{{--</a>--}}
							{{--</div>--}}
						{{--@endif--}}
					{{--@endforeach--}}
					<div class="content-right-title">
						<img src="/new_zs/djrx.png">
					</div>
					<ul class="xpsj_list">
						@foreach($type3 as $v)
							<li>
								<a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
									<div class="text">
										<p class="name" title="{{$v->goods_name}}">{{str_limit($v->goods_name,26)}}</p>
										<p class="gg">{{$v->ypgg}}</p>
										<p class="company" title="{{$v->sccj}}">{{str_limit($v->sccj,32)}}</p>
									</div>
									<div class="img_box">
										<img style="width: 205px;" class="lazy"
											 src="{{get_img_path($v->goods->goods_thumb)}}"/>
									</div>
								</a>
							</li>
						@endforeach
					</ul>
					{{--@foreach($ad169 as $k=>$v)--}}
						{{--@if($k==0)--}}
							{{--<div class="right_img">--}}
								{{--<a target="_blank" href="{{$v->ad_link}}">--}}
									{{--<img src="{{$v->ad_code}}"/>--}}
								{{--</a>--}}
							{{--</div>--}}
						{{--@endif--}}
					{{--@endforeach--}}
				</div>
			</div>
		</div>
		<!--/新品上架-->

		<!--footer-->
		@include('layouts.new_footer')
		<!--/footer-->
	</div>
	<script type="text/javascript">
        //返回顶部
        $('.btn-top').click(function() {
            $('html,body').animate({
                'scrollTop': 0
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
//                alert('搜索关键词"' + val + '"...');
                window.location.href = "http://www.jyeyw.com/category?keywords="+val+"&showi=0";
            },
            $('.search-btn')
        );

        $('.menu_list li').hover(function() {
            index = $(this).index();
            $(this).addClass('active');
            $(this).prev().find('.text').css('border-bottom', 'none')
        }, function() {
            $(this).removeClass('active');
            $(this).prev().find('.text').css('border-bottom', '1px dashed #b2d1c1')
        })

        //	轮播
        $('#carousel').carouselEvent({
            auto: true,
            time: 4000
        });

        //	左侧排名鼠标悬停显示图片
        $('.paihang-bottom ul li').hover(function () {
            $('.paihang-bottom ul li').css('height', '32px');
            $('.paihang-bottom ul li span:first-child').css({
                'border': '1px solid #bbb',
                'color': '#666666'
            });
            $('.paihang-bottom ul li').children('.hover-before').show();
            $('.paihang-bottom ul li').children('.hover-after').hide();
            $(this).css('height', '68px');
            $(this).find('.hover-before').hide();
            $(this).find('.hover-after').show();
            $(this).find('span:first-child').css({
                'border': '1px solid #e70000',
                'color': '#e70000'
            })
        })
	</script>
	@endsection


