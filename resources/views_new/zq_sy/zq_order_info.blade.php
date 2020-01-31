@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/order_msg2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/pay.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/submit_order.js')}}"></script>

@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>交易管理</span> </a> <a href="{{route('user.orderList')}}" class="end">>　<span>{{$pages_top}}</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right_box">
            <div class="top_title">
                <h3 style="width: 200px;">{{$pages_top}}</h3>
                <span class="ico" style="left: 60px;"></span>
            </div>

            <table class="table1">
                <tr>
                    <th  colspan="2">订单状态</th>

                </tr>
                <tr>
                    <td class="tb1_td1 al_right">订单号：</td>
                    <td>{{$order->order_sn}}
                    </td>
                </tr>
                <tr>
                    <td class="tb1_td1 al_right">订单状态：</td>
                    <td>{{oStatus($order->order_status)}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td class="tb1_td1 al_right">付款状态：</td>
                    <td>
                        <div style="width: 150px; float: right; height: 50px;line-height: normal;">
                            <p style=""><a href="{{route('articleInfo',['id'=>91])}}" class="payonline_notice" target="_blank" style="font-family: &quot;Microsoft yahei&quot;; font-size: 14px; color: #39a817; display: inline; line-height: 25px; margin-right: 20px;">银联在线支付说明</a></p>
                            <p><a href="{{route('articleInfo',['id'=>276])}}" class="payonline_notice" target="_blank" style="margin-right: 20px; display: inline; font-family: &quot;Microsoft yahei&quot;; font-size: 14px; color: #39a817; line-height: 20px;">农行在线支付说明</a></p></div>
                        <div style='width:450px;float:left;height:50px;'>
                            <span style="line-height: 50px;">{{pStatus($order->pay_status)}}</span>
                            {!! $unionpay or '' !!}
                            {{--{!! $abcpay or '' !!}--}}
                            {!! $xyyh or '' !!}
                            {!! $weixin or '' !!}
                            {!! $tip or '' !!}
                        </div>
                    </td>
                </tr>

            </table>
            <table class="table2">
                <tr>
                    <th class="case1" colspan="5">订单列表</th>
                </tr>
                <tr class="title">
                    <td class="tb2_td1">订单编号</td>
                    <td class="tb2_td2">下单时间</td>
                    <td class="tb2_td3">订单总金额</td>
                    <td class="tb2_td4">订单应付金额</td>
                    <td class="tb2_td5">操作</td>
                </tr>
                @foreach($order->order_info as $v)
                <tr>
                    <td class="tb2_td1">

                        <a href="{{route('user.orderInfo',['id'=>$v->order_id])}}" target="_blank" style="color: #FF6102">{{$v->order_sn}}</a>

                    </td>
                    <td class="tb2_td3">{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                    <td class="tb2_td2">{{formated_price($v->goods_amount)}}</td>
                    <td class="tb2_td4">{{formated_price($v->order_amount)}}</td>
                    <td class="tb2_td5">
                        {!!order_status($v->order_id,$v->order_status,$v->pay_status,$v->shipping_status,'handle')!!}&nbsp;&nbsp;
                        <a href="{{route('user.orderInfo',['id'=>$v->order_id])}}" class="f6">查看订单</a>
                    </td><!-- 2015-7-9 -->
                </tr>
                @endforeach
                <tr>
                    <td class="al_right com" colspan="5">
                        <form action="{{route('user.sureShipping')}}" method="post" name="formFee" id="formFee" style="float: right;width: 80px;height: 39px;margin-left: 20px;@if($order->order_status==1&&$order->pay_status==2&&$order->shipping_status==4)display: block;@else display: none; @endif">
                            <input type="submit" name="Submit" class="submit_1" value="确认收货" style="margin-top: 5px;"/>
                            <input type="hidden" name="id" value="{{$order->zq_id}}" />
                            {!! csrf_field() !!}
                        </form>
                        <span style="width: 200px;height: 39px;display: block;float:right;">
                        商品总价:<span class="price">{{formated_price($order->goods_amount)}}</span>
                        </span>


                    </td>

                </tr>
            </table>

            <table class="table3">
                <tr>
                    <th>费用总计</th>
                </tr>
                <tr>
                    <td class="al_right com">
                        商品总价:{{formated_price($order->goods_amount)}}
                        @if($order->discount>0)
                            - 折扣:{{formated_price($order->discount)}}
                        @endif
                        @if($order->shipping_fee>0)
                            + 物流费用:{{formated_price($order->shipping_fee)}}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="al_right com">
                        @if($order->money_paid>0)
                            - 已付款金额:<span class="price">{{formated_price($order->money_paid)}}</span>
                        @endif
                        @if($order->surplus>0)
                            - 使用余额:<span class="price">{{formated_price($order->surplus)}}</span>
                        @endif
                        @if($order->zyzk>0)
                            - 优惠金额:<span class="price">{{formated_price($order->zyzk)}}</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="al_right com">
                        应付款金额: <span class="price">{{formated_price($order->order_amount)}}</span>
					{{--<!-- {if $order.extension_code eq "group_buy"} --><br />--}}
						{{--{$lang.notice_gb_order_amount}--}}
					{{--<!-- {/if} --></span>--}}
                    </td>
                </tr>
                {{--@if($order->is_mhj==0&&$order->order_amount>0)--}}
                {{--<tr>--}}
                    {{--<td class="al_right com">--}}
                        {{--<form action="{{route('user.useSurplus')}}" method="post" name="formFee" id="formFee">追加使用余额:--}}
                            {{--<input name="surplus" type="text" size="8" value="0" style="border:1px solid #ccc;"/>（您的帐户余额：{{formated_price($user->user_mongy)}}）--}}
                            {{--<input type="submit" name="Submit" class="submit_1" value="确定" />--}}
                            {{--<input type="hidden" name="orderId" value="{{$order->order_id}}" />--}}
                            {{--{!! csrf_field() !!}--}}
                        {{--</form>--}}
                    {{--</td>--}}
                {{--</tr>--}}
                {{--@endif--}}
            </table>
        </div>
    </div>
    @include('layout.weixin')
    @include('layout.page_footer')
@endsection
