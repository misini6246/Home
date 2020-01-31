@extends('layouts.app')
@section('title')
	<title>促销专区-特价专区</title>
@endsection
@section('links')
	<link rel="stylesheet" type="text/css" href="/pyzq/pyzq-css/pyzq.css" />
	<link rel="stylesheet" type="text/css" href="/new_cxzq/tejia.css" />
	<!--layer-->
	<link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css"/>
	{{-- layui --}}
	<link rel="stylesheet" href="/layui/css/layui.css">
	<script src="/layui/layui.js"></script>
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
		<img style="width: 100%;height: 100%;display: block;transform:none;" src="/new_cxzq/tejiazq.jpg" alt=""/>
	</div>
	<!--/banner-->

	<!--商品列表-->
	<div id="bgcolor_1" class="container">
        <div class="container_box">
            <div id="tejia" class="cxzq_section">
                <ul class="czhg_list">
                    @foreach($tejia as $v)
                        <li>
                            <div class="tejia">特价</div>
                            {{-- 2019 6.18 
                            <div class="tejia" style="background:#fff;top:0;left:0">
                                <a target="_blank" href="{{$v->goods_url}}">
                                    <img src="/new_cxzq/label618.png" style="transform:none;width:80px" alt="">
                                </a>
                            </div> --}}
                            <div class="img_box">
                                <a target="_blank" href="{{$v->goods_url}}"><img
                                            src="{{$v->goods_thumb}}"/></a>
                            </div>
                            <p class="name">{{$v->goods_name}}</p>
                            <p class="gg">{{$v->spgg}}</p>
                            <p class="company">{{$v->sccj}}</p>
                            <div class="origin-price">
                                <p>原价:
                                    @if($user&&$user->ls_review==1)
                                    <span>￥{{$v->shop_price}}</span>
                                    @else
                                    会员可见
                                    @endif
                                </p>
                            </div>
                            {{-- 限购 --}}
                            <p class="xg">
                                @if ($v->xg_type==1)
                                单张订单限购数量：{{$v->ls_ggg}}                        
                                @elseif($v->xg_type==2)
                                {{date("Y-m-d",$v->xg_start_date)}}至{{date("Y-m-d",$v->xg_end_date)}}限购数量：{{$v->ls_ggg}}
                                @elseif($v->xg_type==3)
                                每天限购数量：{{$v->ls_ggg}}
                                @elseif($v->xg_type==4)
                                每周限购数量：{{$v->ls_ggg}}
                                @endif
                            </p>
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
                @if(!empty($tejia))
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
						window.location.href='/cxhd/tejia?page='+obj.curr;
					}
				}
  			});
		});
	</script>
	@endsection



