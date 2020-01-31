@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/zhaijisong.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
    <!--IE兼容-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 7]>
    <script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')
    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>物流跟踪</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <div class="fr">
                        <a href="{{route('member.order.show',['id'=>$info->order_id])}}">
                            <img src="{{get_img_path('images/user/fanhui_03.png')}}"/>
                            <span>返回订单详情</span>
                        </a>
                    </div>
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                    <span>物流跟踪</span>
                </div>
                <div class="zhaijisong">
                    <ul class="zhaijisong_title">
                        <li>
                            订单号：<span>{{$info->order_sn}}</span>
                        </li>
                        <li>
                            下单时间：<span>{{date('Y-m-d H:i:s',$info->add_time)}}</span>
                        </li>
                        <li>
                            收货人：<span>{{$info->consignee}}</span>
                        </li>
                    </ul>
                    <div class="zhaijisong_content">
                        <div class="danhao">运单号</div>
                        <ul class="danhao_list">
                            @foreach($shipping_info as $k=>$v)
                                <li @if($k==0) class="active" @endif>
                                    <div class="fr">
                                        <img src="{{get_img_path('images/user/dingdan_right_icon.png')}}"/>
                                    </div>
                                    {{$v->shipping_id}}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="zhaijisong_zt">
                        <div class="zhaijisong_zt_title">
                            <span class="fr">数据内容由<a href="javascript:;">合纵药易购</a>提供。</span>
                            物流状态
                        </div>
                        @foreach($shipping_info as $k=>$v)
                            <ul class="express @if($k==0) active @endif">
                                @foreach($v->steps as $k=>$val)
                                    <li class="@if($val['action']=='已签收') end @elseif($k==0) last @elseif($k+1==count($v->steps)) start @endif">
                                        <div class="lf">
                                            <div class="xian">
                                                @if($val['action']=='已签收')
                                                    <img src="{{get_img_path('images/user/zhaijisong_1.png')}}"/>
                                                @elseif($k==0)
                                                    <img src="{{get_img_path('images/user/zhaijisong_3.jpg')}}"/>
                                                @else
                                                    <img src="{{get_img_path('images/user/zhaijisong_2.jpg')}}"/>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="rg">
                                            <div class="fl">
                                                <p>{{date('H:i:s',$val['time'])}}</p>
                                                <p>{{date('Y-m-d',$val['time'])}}</p>
                                            </div>
                                            <div class="fr">
                                                {{$val['action']}}
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>
    </div>
    @include('layouts.old_footer')
    <script type="text/javascript">
        $(function () {
            height()
            $('.danhao_list li').on('click', function () {
                var tar = $(this).index();
                $(this).addClass('active').siblings('li').removeClass('active');
                $('.zhaijisong_zt ul').eq(tar).addClass('active').siblings('ul').removeClass('active');
                height()
            })

            function height() {
                $('.express').each(function () {
                    $(this).children('li').each(function () {
                        $(this).height($(this).find('.rg').height() + 1)
                    })
                })
            }
        })
    </script>
@endsection
