@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/order_msg2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/pay.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/submit_order.js')}}"></script>
    @include('common.ajax_set')
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>交易管理</span> </a> <a
                    href="{{route('user.orderList')}}" class="end">>　<span>充值订单</span></a></div>
        @include('layout.user_menu')
        <div class="main_right_box">
            <div class="top_title">
                <h3>充值订单</h3>
                <span class="ico"></span>
            </div>

            <table class="table1">
                <tr>
                    <th colspan="2">订单状态</th>

                </tr>
                <tr>
                    <td class="tb1_td1 al_right">订单号：</td>
                    <td>{{$order->order_sn}}
                        <a href="{{route('user.messageOrder',['id'=>$order->order_id])}}">[发送/查看商家留言]</a>
                    </td>
                </tr>
                <tr>
                    <td class="tb1_td1 al_right">订单状态：</td>
                    <td>{{oStatus($order->order_status)}}&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
                <tr>
                    <td class="tb1_td1 al_right">付款状态：</td>
                    <td>
                        <div style="width: 150px; float: right; height: 50px;">
                            <p style="line-height: 50px;"><a href="{{route('articleInfo',['id'=>91])}}"
                                                             class="payonline_notice" target="_blank"
                                                             style=" font-size: 14px; color: #39a817; display: inline; line-height: 25px; margin-right: 20px;">银联在线支付说明</a>
                            </p>
                        </div>
                        <div style='width:450px;float:left;height:50px;'>
                            <span style="line-height: 50px;">{{pStatus($order->pay_status)}}</span>
                            @if($order->pay_status==0&&$order->order_status==1&&$order->o_paid==0&&$order->order_amount>0)
                                <form id="pay_form" action="/cz/pay" method="post" target="_blank">
                                    {!! csrf_field() !!}
                                    <input name="order_id" type="hidden" id="order_id" value="{{$order->order_id}}"/>
                                    <input name="pay_id" type="hidden" id="pay_id" value="4"/>
                                    <input class="J_payonline" value="银联支付"
                                           onclick="search_pay_status('{{$order->order_id}}',4)"
                                           searchurl="http://newyyg.com/union/search?id=1" type="submit">
                                </form>
                                <form name="pay_form" action="/cz/pay" method="post" target="_blank">
                                    {!! csrf_field() !!}
                                    <input class="J_payonline" style="left: 200px;;" value="快捷支付"
                                           onclick="search_pay_status('{{$order->order_id}}',6)"
                                           searchurl="http://newyyg.com/xyyh/search?id=1&amp;type=0" type="submit">
                                    <input name="order_id" type="hidden" id="order_id" value="{{$order->order_id}}"/>
                                    <input name="pay_id" type="hidden" id="pay_id" value="6"/>
                                </form>
                                <form name="pay_form" action="http://newyyg.com/weixin/pay" method="get"
                                      target="_blank">
                                    <input class="J_payonline" style="left: 300px;;" value="微信支付"
                                           onclick="weixin('{{$order->order_id}}',7)"
                                           searchurl="http://newyyg.com/weixin/search?id=1&amp;type=0" type="button">
                                </form>
                            @endif
                        </div>
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
                    </td>
                </tr>
                <tr>
                    <td class="al_right com">
                        @if($order->money_paid>0)
                            - 已付款金额:<span class="price">{{formated_price($order->money_paid)}}</span>
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
            </table>
        </div>
    </div>
    <script>
        $(".table2 tr td.tb2_td6").hover(function () {

            $(this).find(".tip-box").show();
        }, function () {

            $(this).find(".tip-box").hide();
        });
        function weixin(order_id, pay_id) {
            var mask = $("<div class=mask></div>");
            $("body").append(mask);
            $.ajax({
                url: "/cz/pay",
                data: {order_id: order_id, pay_id: pay_id},
                dataType: "json",
                success: function (data) {
                    $("body").find(".mask").remove();
                    if (data.status === 500) {
                        alert(data.msg);
                    }
                    else if (data.status === 200) {
                        window.location = "/user/payOk?id=304829&type=4";
                    }
                    else {
                        $("#code_img_url").attr("src", data.code_img_url);
                        $(".pop-wraper").show();
                        int = setInterval("search_pay_status(" + order_id + "," + pay_id + ")", 3000)
                    }
                }
            })
        }
        function search_pay_status(order_id, pay_id) {
            $.ajax({
                url: "/cz/search",
                data: {order_id: order_id, pay_id: pay_id},
                success: function ($result) {
                    if ($result == 0) {
                        window.location = "/user/payOk?id=" + order_id + "&type=4";
                    }
                }
            });
        }
    </script>
    @include('layout.weixin')
    @include('layout.page_footer')
@endsection
