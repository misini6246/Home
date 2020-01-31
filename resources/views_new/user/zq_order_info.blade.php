@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/dingdanxiangqing.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/pay.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/submit_order.js')}}"></script>
    <!--[if lte IE 9]>
    <style type="text/css">
        .genzong {
            border: 1px solid #e5e5e5;
        }

        .right_top_search #num {
            position: relative;
            top: 1px;
        }
    </style>
    <![endif]-->
    <!--[if IE 8]>
    <style type="text/css">
        .right_top_search select {
            position: relative;
            top: 6px;
        }

        .zt_2_top_left ul li span.zhuijia input[type="button"] {
            position: relative;
            top: -2px;
        }
    </style>
    <![endif]-->
    <style>
        #zfbsm {
            left: -190px !important;
            top: -205px !important;
        }

        .zt_2_top_left ul li span:first-child {
            width: 100px;
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><a
                        href="{{route('member.zq_order.index')}}">我的账期汇总订单</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>订单详情</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                    <span>订单详情</span>
                </div>
                <div class="right_content">
                    <div class="zt_1">
                        <div class="f">
                            <span>订单编号：</span>
                            <span class="span_right">{{$info->order_sn}}</span>
                        </div>
                        {{--<div class="f">--}}
                        {{--<span>下单时间：</span>--}}
                        {{--<span class="span_right">{{date('Y-m-d H:i:s',$info->add_time)}}</span>--}}
                        {{--</div>--}}
                        <div class="f">
                            <span>订单状态：</span>
                            <span class="span_right zt">
                                @if($info->order_status==2)
                                    已取消
                                @elseif($info->pay_status==0)
                                    待付款
                                    @if(isset($tips))
                                        {!! $tips !!}
                                    @endif
                                @elseif($info->pay_status==2)
                                    已付款
                                @else
                                    已确认
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="zt_2">
                        <div class="zt_2_top">
                            <div class="zt_2_top_left">
                                <div class="zt_2_title">
                                    费用总计
                                </div>
                                <ul>
                                    <li>
                                        <span>商品金额：</span>
                                        <span>{{formated_price($info->goods_amount)}}</span>
                                    </li>
                                    @if($info->money_paid>0)
                                        <li>
                                            <span>- 已付款金额：</span>
                                            <span>{{formated_price($info->money_paid)}}</span>
                                        </li>
                                    @endif
                                    <li>
                                        <span>- 使用余额：</span>
                                        <span>{{formated_price($info->surplus)}}</span>
                                    </li>
                                    <li>
                                        <span style="color: #ff2424">应付款金额：</span>
                                        <span style="color: #ff2424">{{formated_price($info->order_amount)}}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="zt_2_right">
                                <div class="zt_2_title" style="min-height: 110px;">
                                    支付方式
                                    @if(!isset($tips))
                                        <p class="xz">选择支付方式：</p>
                                        <a style="float: left;margin-right: 40px;">{!! $unionpay or '' !!}</a>
                                        <a style="float: left;margin-right: 40px;">{!! $xyyh or '' !!}</a>
                                        <a style="float: left;margin-right: 40px;">{!! $weixin or '' !!}</a>
                                    @else
                                        <p class="xz">已选择支付方式：{{$info->pay_name}}</p>
                                    @endif
                                </div>
                                <div style="clear: both"></div>
                                <p class="shuoming" style="float: right;margin: 0 25px 0 0;">
                                    <a target="_blank" href="{{route('articleInfo',['id'=>91])}}">在线支付说明</a>
                                </p>
                            </div>
                            <div style="clear: both;"></div>
                        </div>
                    </div>
                    <div class="spxx">
                        <div class="spxx_title">
                            <span>订单列表</span>
                        </div>
                        <table style="width: 100%">
                            <tr>
                                <th>订单编号</th>
                                <th>下单时间</th>
                                <th>订单总金额</th>
                                <th>应付金额</th>
                                <th style="text-align: center">操作</th>
                            </tr>
                            @foreach($info->order_info as $k=>$v)
                                <tr>
                                    <td>
                                        <a style="color: red;" target="_blank"
                                           href="{{route('member.order.index',['id'=>$v->order_id])}}">
                                            {{$v->order_sn}}
                                        </a>
                                    </td>
                                    <td>
                                        {{date('Y-m-d H:i:s',$v->add_time)}}
                                    </td>
                                    <td>
                                        {{formated_price($v->goods_amount)}}
                                    </td>
                                    <td>
                                        {{formated_price($v->order_amount)}}
                                    </td>
                                    <td>
                                        <a target="_blank"
                                           href="{{route('member.order.index',['id'=>$v->order_id])}}">查看详情</a>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="heji">
                            订单总计：<span>{{formated_price($info->goods_amount)}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    @include('common.footer')
@endsection
