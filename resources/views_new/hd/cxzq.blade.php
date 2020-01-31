@extends('layouts.app')
@section('title')
    <title>促销专区</title>
@endsection
@section('links')
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/index/css/index/index.css" />
    <link rel="stylesheet" type="text/css" href="/new_cxzq/cuxiaozhuanqu.css" />
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/new_cxzq/cuxiaozhuanqu.js" type="text/javascript" charset="utf-8"></script>

    <!--倒计时-->
    <script src="/new_cxzq/remaintime.min.js" type="text/javascript" charset="utf-8"></script>
    <!--电梯导航-->
    <script src="/new_cxzq/jquery.singlePageNav.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/new_cxzq/navigation.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css"/>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')

    <div class="cxzq_banner">
        @foreach($ad155 as $v)
        @if($v->ad_name == '促销专区')
        <img src="{{ $v->ad_code }}"/>
            @endif
        @endforeach
    </div>

    <div class="title_list_box">
        <ul class="title_list">
            <li class="active">
                <a href="#mzjx">每周精选</a>
            </li>
            {{--<li>--}}
                {{--<a href="#czhg">超值换购</a>--}}
            {{--</li>--}}
            <li>
                <a href="#jpmz">精品买赠</a>
            </li>
            
            <li>
                <a href="#tejia">特价专区</a>
            </li>
            {{--<li class="" style="cursor: pointer;">--}}
                {{--<a onclick="location.href='/yhq'" class="">领券专区</a>--}}
            {{--</li>--}}
        </ul>
    </div>
    <input type="hidden" id="daojs" value=""/>
    <div id="bgcolor_1" class="container">
        <div class="container_box">
            <div class="cxzq_section" id="mzjx">
                <div class="section_title">
                    <img src="/index/img/cxzq_title.png"/>
                    <span>每周精选</span>
                    <img src="/index/img/cxzq_title.png"/>
                </div>
                {{--<div class="remaintime" data-start_time="10800" data-end_time="0">--}}
                    {{--当前场次--}}
                    {{--<span class="d"></span><span class="mh">:</span><span class="h"></span><span--}}
                            {{--class="mh">:</span><span class="m"></span><span class="mh">:</span><span--}}
                            {{--class="s"></span> 后结束--}}
                {{--</div>--}}


                {{--<script>--}}

                    {{--var start_time = $('.remaintime').attr('data-start_time');--}}
                    {{--var end_time = $('.remaintime').attr('data-end_time');--}}
                    {{--start_djs(start_time-end_time,$('.remaintime'),function(){--}}
{{--//                        start_djs()--}}
                    {{--});--}}
                    {{--//开始倒计时--}}
                    {{--function start_djs(_time, _e, _fun) {--}}
                        {{--var t = $.leftTime(_time, function(d) {--}}
                            {{--if(d.status) {--}}
                                {{--var $dateShow = _e;--}}
                                {{--$dateShow.find(".d").html(d.d);--}}
                                {{--$dateShow.find(".h").html(d.h);--}}
                                {{--$dateShow.find(".m").html(d.m);--}}
                                {{--$dateShow.find(".s").html(d.s);--}}
                            {{--} else { //倒计时结束--}}
                                {{--if(typeof _fun == 'function') _fun();--}}
                            {{--}--}}
                        {{--},false);--}}
                    {{--}--}}
                {{--</script>--}}


                <ul class="mzjx_list">
                    @foreach($menu as $key=>$v)
                        <li>
                            <div class="img_box">
                                <a target="_blank" href="{{$v->ad_link}}"><img
                                            src="{{get_img_path($v->goods_thumb)}}"/></a>
                            </div>
                            <div class="text">
                                <p class="name">{{$v->goods_name}}</p>
                                <p class="gg">{{$v->spgg}}</p>
                                <p class="company">{{$v->sccj}}</p>
                                <div class="btn">
                                    <div class="money">
                                        @if($user&&$user->ls_review==1)
                                            @if($v->promote_price<=0)
                                            {{formated_price($v->shop_price)}}
                                            @else
                                            {{formated_price($v->promote_price)}}
                                            @if($user->is_zhongduan==1)
                                                <span>{{formated_price($v->shop_price)}}</span>
                                            @endif
                                        @else
                                            会员可见
                                        @endif
                                    </div>
                                    <a target="_blank" href="{{$v->goods_url}}">立即购买</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    {{--<div id="bgcolor_2" class="container">--}}
        {{--<div class="container_box">--}}
            {{--<div id="czhg" class="cxzq_section">--}}
                {{--<div class="section_title">--}}
                    {{--<img src="/index/img/cxzq_title.png"/>--}}
                    {{--<span>超值换购</span>--}}
                    {{--<img src="/index/img/cxzq_title.png"/>--}}
                {{--</div>--}}
                {{--<ul class="czhg_list">--}}
                    {{--@foreach($czhg as $v)--}}
                        {{--<li>--}}
                            {{--<div class="img_box">--}}
                                {{--<a target="_blank" href="{{$v->goods_url}}"><img--}}
                                            {{--src="{{$v->goods_thumb}}"/></a>--}}
                            {{--</div>--}}
                            {{--<p class="name">{{$v->goods_name}}</p>--}}
                            {{--<p class="gg">{{$v->spgg}}</p>--}}
                            {{--<p class="company">{{$v->sccj}}</p>--}}
                            {{--<div class="hd">--}}
                                {{--<div class="fl">活动</div>--}}
                                {{--<div class="fr layer_tips" data-msg="{{$v->cxxx}}"--}}
                                     {{--id="{{$v->goods_id}}">{{$v->cxxx}}</div>--}}
                            {{--</div>--}}
                            {{--<div class="btn">--}}
                                {{--<div class="fl">--}}
                                    {{--@if($user&&$user->ls_review==1)--}}
                                        {{--{{formated_price($v->real_price)}}--}}
                                    {{--@else--}}
                                        {{--会员可见--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                                {{--<a target="_blank" href="{{$v->goods_url}}" class="fr">--}}
                                    {{--立即抢购--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
                {{--@if(!empty($czhg))--}}
                {{--<div class="readmore">--}}
                    {{--<a target="_blank" href="/cxhd/czhg">点击查看更多</a>--}}
                {{--</div>--}}
                    {{--@else--}}
                    {{--<div class="readmore">--}}
                        {{--<a target="_blank">敬请期待</a>--}}
                    {{--</div>--}}
                {{--@endif--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}

    {{-- 精品买赠 --}}
    <div id="bgcolor_1" class="container">
        <div class="container_box">
            <div id="jpmz" class="cxzq_section">
                <div class="section_title">
                    <img src="/index/img/cxzq_title.png"/>
                    <span>精品买赠</span>
                    <img src="/index/img/cxzq_title.png"/>
                </div>
                <ul class="czhg_list">
                    @foreach($jpmz as $v)
                        <li>
                            <div class="img_box">
                                <a target="_blank" href="{{$v->goods_url}}"><img
                                            src="{{$v->goods_thumb}}"/></a>
                            </div>
                            <p class="name">{{$v->goods_name}}</p>
                            <p class="gg">{{$v->spgg}}</p>
                            <p class="company">{{$v->sccj}}</p>
                            <div class="hd">
                                <div class="fl">活动</div>
                                <div class="fr layer_tips" data-msg="{{$v->cxxx}}"
                                     id="{{$v->goods_id}}">{{$v->cxxx}}</div>
                            </div>
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
                @if(!empty($jpmz))
                <div class="readmore">
                    <a target="_blank" href="/cxhd/jpmz">点击查看更多</a>
                </div>
                    @else
                    <div class="readmore">
                        <a target="_blank">敬请期待</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 特价专区 --}}
    <div id="bgcolor_1" class="container">
        <div class="container_box">
            <div id="tejia" class="cxzq_section">
                <div class="section_title">
                    <img src="/index/img/cxzq_title.png"/>
                    <span>特价专区</span>
                    <img src="/index/img/cxzq_title.png"/>
                </div>
                <ul class="czhg_list">
                    @foreach($tejia as $v)
                        <li>
                            <div class="tejia">特价</div>
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
                <div class="readmore">
                    <a target="_blank" href="/cxhd/tejia">点击查看更多</a>
                </div>
                    @else
                    <div class="readmore">
                        <a target="_blank">敬请期待</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

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
