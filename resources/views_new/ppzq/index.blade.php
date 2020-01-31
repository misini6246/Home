@extends('layouts.app')
@section('title')

<title>品牌专区——{{$title}}</title>
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
    .czhg_list li {
        height: 440px;
    }

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
<div class="banner_box" style="width: 100%;min-width: 1190px;">
    <img style="width: 100%;height: 100%;display: block;transform:none;" src="{{$img}}"
        alt="" />
</div>
<!--/banner-->

<!--商品列表-->
<div id="bgcolor_1" class="container">
    <div class="container_box">
        <div id="tejia" class="cxzq_section">
            <ul class="czhg_list">
                @foreach($goods as $v)
                <li>
                    @if ($v->is_promote==1&&$v->promote_start_date<time()&&$v->promote_end_date>time())
                        <div class="tejia layer_tips" style="background: #ff5d60">特价</div>
                    @elseif($v->zyzk>0&&$v->preferential_start_date<time()&&$v->preferential_end_date>time())
                        <div class="tejia layer_tips" style="background: #418ed2" id="dt_yh{{$v->goods_id}}"
                            data-msg="￥{{$v->zyzk}}">
                            优惠
                        </div>
                    @endif
                    <div class="img_box">
                        <a target="_blank" href="/goods?id={{$v->goods_id}}">
                            <img src="http://112.74.176.233/{{$v->goods_thumb}}" />
                        </a>
                    </div>
                    <p class="name">{{$v->goods_name}}</p>
                    <p class="gg">{{$v->spgg}}</p>
                    <p class="company">{{$v->sccj}}</p>
                    <div class="hd" style="height:auto;margin-top:10px">
                        @if ($v->zyzk>0&&$v->preferential_start_date<time()&&$v->preferential_end_date>time())
                            <div class="fl" style="width:30px;">满减</div>
                            @if($user&&$user->ls_review==1)
                            <div class="fr" style="width:210px;" id="{{$v->goods_id}}">
                                满￥{{$v->shop_price}}减￥{{$v->zyzk}}
                            </div>
                            @endif
                        @endif
                    </div>
                    {{-- 限购 --}}
                    {{-- 价格 --}}
                    <div class="btn">
                    {{-- 判断是否为特价 --}}
                    @if ($v->is_promote==1&&$v->promote_start_date<time()&&$v->promote_end_date>time())
                        <div class="fl">
                            @if($user&&$user->ls_review==1)
                            {{formated_price($v->promote_price)}}
                            @else
                            会员可见
                            @endif
                        </div>
                        <a target="_blank" href="/goods?id={{$v->goods_id}}" class="fr">
                            立即抢购
                        </a>
                    @else
                        <div class="fl">
                            @if($user&&$user->ls_review==1)
                            {{formated_price($v->shop_price)}}
                            @else
                            会员可见
                            @endif
                        </div>
                        <a target="_blank" href="/goods?id={{$v->goods_id}}" class="fr">
                            立即抢购
                        </a>
                    @endif
                    </div>
                </li>
                @endforeach
            </ul>
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
		
</script>
@endsection