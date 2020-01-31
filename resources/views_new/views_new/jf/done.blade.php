@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/dialog.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/sure_exchange.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/sure_exchange.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/dialog.js')}}"></script>

@endsection
@section('content')
@include('layout.jf_header')
<div class="sure_order">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">我的礼品车</span></p>
    <div class="look_step">
        <ul class="clear_float cross">
            <li>1.查看礼品车</li>
            <li>2.确认订单信息</li>
            <li style="color: #fff">3.确认兑换</li>
            <li>4.确认收货</li>
        </ul>
    </div>
    <div class="sure_order_real">
        <div class="user_msg">
            <img src="{{path('jfen/images/head_icon.png')}}" alt=""/>
            <span>用户信息</span>
        </div>
        <div class="message">
            <table>
                <thead>
                <tr>
                    <td>订单编号</td>
                    <td>所需积分</td>
                    <!--
                    <td>收货人</td>
                    <td>手机</td>
                    <td>邮编</td>
                    <td>街道地址</td>-->
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$orderSn}}</td>
                    <td>{{$totalJf}}</td>
                </tr>
                </tbody>
            </table>
            <button class="sure_btn reset_btn" data-o="{{$orderId}}"></button>
        </div>
    </div>
</div>
</div>
@include('layout.jf_footer')
@endsection
