@extends('layouts.app')
@section('title')
<title>中药专区</title>
@endsection
@section('links')
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />

<link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
<link rel="stylesheet" type="text/css" href="/index/css/index/index.css" />
<link rel="stylesheet" type="text/css" href="/new_zyzq/zyzq1.css" />
{{-- swiper --}}
<link href="https://cdn.bootcss.com/Swiper/4.5.0/css/swiper.min.css" rel="stylesheet">

<script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
{{-- swiper --}}
<script src="https://cdn.bootcss.com/Swiper/4.5.0/js/swiper.min.js"></script>

<style type="text/css">

</style>
@endsection
@section('content')
<div class="big-container">
    <!--头部-->
    @include('layouts.header')
    <!--/头部-->

    <!--搜索导航-->
    @include('layouts.search')
    <!--/搜索导航-->

    @include('layouts.youce')

    <!--导航-->
    @include('layouts.nav')
    <!--/导航-->

    <!--banner-->
<div class="swiper-container banner">
    <div class="swiper-wrapper">
        @foreach ($ad187 as $k=>$ad)
        <div class="swiper-slide">
            <a href="{{$ad->ad_link}}" target="_blank">
                <img src="{{$ad->ad_code}}" /></a>
            </a>
        </div>
        @endforeach
    </div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-pagination"></div>
</div>
<!--/banner-->

<div class="header">
    <div class="container">
        {{-- 导航 --}}
        <div class="nav">
            <ul class="clear-float">
                <li>
                    <a href="/zy_category?pid=448" target="_blank">普通配方饮片</a>
                </li>
                <li>
                    <a href="/zy_category?pid=449" target="_blank">贵细摆盘系列</a>
                </li>
                <li>
                    <a href="/zy_category?pid=474" target="_blank">定型包装系列</a>
                </li>
                <li>
                    <a href="/zy_category?pid=484" target="_blank">中药粉剂系列</a>
                </li>
                <li>
                    <a href="/zy_category?pid=1070" target="_blank">花茶系列</a>
                </li>
            </ul>
        </div>
        {{-- 特价专区 --}}
        <div class="tjzq section">
            <div class="container">
                <div class="title">特价专区</div>
                <div class="content">
                    @if(isset($ad188))
                    <ul class="clear-float">
                        @foreach ($ad188 as $k=>$v)
                        <li>
                            {{-- 商品图片 --}}
                            <div class="thumb">
                                <a target="_blank" href="{{$v->ad_link}}">
                                    <img src="{{$v->ad_code}}" />
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
{{-- 新品热卖卖 --}}
<div class="xprm section">
    <div class="container">
        <div class="title">新品热卖</div>
        <div class="content">
            @if(isset($zp[17]) )
            <ul class="clear-float">
                @foreach ($zp[17] as $k=>$v)
                <li>
                    {{-- 商品图片 --}}
                    <div class="thumb">
                        <a target="_blank" href="{{route('goods.zyyp',['id'=>$v->goods_id])}}">
                            <img src="{{$v->goods_thumb}}" />
                        </a>
                    </div>
                    <div class="info">
                        <p class="name">{{$v->goods_name}}</p>
                        <p class="gg">{{$v->ypgg}}</p>
                        <p class="sccj">{{$v->sccj}}</p>
                        <div class="bottom">
                            <p class="price">{{$v->format_price}}</p>
                            <p class="to-goods">
                                <a target="_blank" href="{{route('goods.zyyp',['id'=>$v->goods_id])}}">查看详情</a>
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
{{-- end 新品热卖 --}}
{{-- 花茶专区 --}}
<div class="hczq section">
    <div class="container">
        <div class="title">花茶专区</div>
        <div class="content">
            @if(isset($zp[19]))
            {{--  {{dd($ad194)}} --}}
            <ul class="clear-float">
                @foreach ($zp[19] as $k=>$v)
                <li>
                    {{-- 商品图片 --}}
                    <div class="thumb">
                        <a target="_blank" href="{{route('goods.zyyp',['id'=>$v->goods_id])}}">
                            <img src="{{$v->goods_thumb}}" />
                        </a>
                    </div>
                    <div class="info">
                        <p class="name">{{$v->goods_name}}</p>
                        <p class="gg">{{$v->ypgg}}</p>
                        <p class="sccj">{{$v->sccj}}</p>
                        <div class="bottom">
                            <p class="price">{{$v->format_price}}</p>
                            <p class="to-goods">
                                <a target="_blank" href="{{route('goods.zyyp',['id'=>$v->goods_id])}}">查看详情</a>
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
{{-- end 花茶专区 --}}
{{--  粉剂热卖  --}}
<div class="fjrm section">
    <div class="container">
        <div class="title">粉剂热卖</div>
        <div class="content">
            @if(isset($zp[20]) )
            <ul class="clear-float">
                @foreach ($zp[20] as $k=>$v)
                <li>
                    {{-- 商品图片 --}}
                    <div class="thumb">
                        <a target="_blank" href="{{route('goods.zyyp',['id'=>$v->goods_id])}}">
                            <img src="{{$v->goods_thumb}}" />
                        </a>
                    </div>
                    <div class="info">
                        <p class="name">{{$v->goods_name}}</p>
                        <p class="gg">{{$v->ypgg}}</p>
                        <p class="sccj">{{$v->sccj}}</p>
                        <div class="bottom">
                            <p class="price">{{$v->format_price}}</p>
                            <p class="to-goods">
                                <a target="_blank" href="{{route('goods.zyyp',['id'=>$v->goods_id])}}">查看详情</a>
                            </p>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
{{--  end 粉剂热卖  --}}

<!--礼盒订购区-->
<div class="lhdg section">
    <div class="container">
        <div class="title">
            礼盒订购区
        </div>
        <div class="content">
            <ul class="clear-float">
                @foreach($ad196 as $k=>$v)
                <li>
                    <a target="_blank" href="{{$v->ad_link}}"><img src="{{$v->ad_code}}"></a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!--/礼盒订购区-->
<!--footer-->
@include('layouts.new_footer')
<!--/footer-->
</div>
<script type="text/javascript">
    //	轮播
    var banner = new Swiper('.banner', {
        autoplay: true,//可选选项，自动滑动
        loop:true,
        pagination:{
            el:'.swiper-pagination'
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    })
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
</script>
@endsection