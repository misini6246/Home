@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/order_msg2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/pay.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/submit_order.js')}}"></script>

@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>交易管理</span> </a> <a
                    href="{{route('user.orderList')}}" class="end">>　<span>我的订单</span></a></div>
        @include('layout.user_menu')
        <div class="main_right_box">
            <div class="top_title">
                <h3>订单信息</h3>
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
                            <a href="{{route('articleInfo',['id'=>91])}}" class="payonline_notice" target="_blank"
                               style=" font-size: 14px; color: #39a817; display: inline; line-height: 50px; margin-right: 20px;">银联在线支付说明</a>
                        </div>
                        <div style='width:450px;float:left;height:50px;'>
                            <span style="line-height: 50px;">{{pStatus($order->pay_status)}}</span>
                            {!! $unionpay or '' !!}
                            {{--{!! $abcpay or '' !!}--}}
                            {!! $xyyh or '' !!}
                            {!! $weixin or '' !!}
                            {{--{!! $alipay or '' !!}--}}
                            {!! $zfbzz or '' !!}
                            @if($order->is_mhj==2&&$order->order_id>380700)
                                <span style="line-height: 50px;margin-left: 10px;color:red;">(该订单含血液制品，请法人转款到公司对公账户！)</span>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="tb1_td1 al_right">配送状态：</td>
                    <td>{{sStatus($order->shipping_status)}}&nbsp;&nbsp;&nbsp;&nbsp;
                        @if(strpos($order->fhwl_m,'宅急送')!==false&&$order->shipping_status>=4)
                            <a target="_blank"
                               href="{{route('zjs',['id'=>$order->order_id,'is_zq'=>$order->is_zq,'is_separate'=>$order->is_separate])}}">物流跟踪</a>
                        @endif
                    </td>
                </tr>
                @if($order->invoice_no)
                    <tr>
                        <td class="tb1_td1 al_right">发货物流公司名：</td>
                        <td>{{$order->fhwl_m}}</td>
                    </tr>
                    <tr>
                        <td class="tb1_td1 al_right">发货物流公司电话：</td>
                        <td>{{$order->fhwl_d}}</td>
                    </tr>
                    <tr>
                        <td class="tb1_td1 al_right">物流单号：</td>
                        <td>{{$order->invoice_no}}</td>
                    </tr>

                    <tr>
                        <td class="tb1_td1 al_right">发货件数：</td>
                        <td>{{$order->send_num}}</td>
                    </tr>
                    <tr>
                        <td class="tb1_td1 al_right">发货时间：</td>
                        <td>{{date('Y-m-d H:i:s',$order->shipping_time)}}</td>
                    </tr>
                @endif
                @if($order->to_buyer)
                    <tr>
                        <td class="tb1_td1 al_right">给商家留言：</td>
                        <td>{{$order->to_buyer}}</td>
                    </tr>
                @endif

                {{--<!--{if $virtual_card}-->--}}
                {{--<tr>--}}
                {{--<td class="tb1_td1 al_right">{$lang.virtual_card_info}：</td>--}}
                {{--<td>--}}
                {{--<!--{foreach from=$virtual_card item=vgoods}-->--}}
                {{--<!--{foreach from=$vgoods.info item=card}-->--}}
                {{--<!--{if $card.card_sn}-->{$lang.card_sn}:<span style="color:red;">{$card.card_sn}</span><!--{/if}-->--}}
                {{--<!--{if $card.card_password}-->{$lang.card_password}:<span style="color:red;">{$card.card_password}</span><!--{/if}-->--}}
                {{--<!--{if $card.end_date}-->{$lang.end_date}:{$card.end_date}<!--{/if}--><br />--}}
                {{--<!--{/foreach}-->--}}
                {{--<!--{/foreach}-->--}}
                {{--</td>--}}
                {{--</tr>--}}
                {{--<!--{/if}-->--}}
            </table>
            <table class="table2">
                <tr>
                    <th class="case1" colspan="7">商品列表</th>
                </tr>
                <tr class="title">
                    <td class="tb2_td6">商品标识</td>
                    <td class="tb2_td1">商品名称</td>
                    <td class="tb2_td7">效期</td>
                    <td class="tb2_td2">商品价格</td>
                    <td class="tb2_td3">数量</td>
                    <td class="tb2_td4">小计</td>
                    <td class="tb2_td5">操作</td>
                </tr>
                @foreach($order->order_goods as $v)
                    @if($v->parent_id==0)
                        <tr>
                            <td class="tb2_td6" style="color:#3ebb2b;cursor:pointer;position:relative;z-index: 1">
                                @if($v->goods)
                                    <img style="display: none;" class="fly_img{{$v->goods_id}}"
                                         src="{{get_img_path($v->goods->goods_thumb)}}" alt=""/>
                                @endif
                                @if($v->is_jp==1)
                                    精
                                    <div class="tip-box"
                                         style="border:1px solid #e5e5e5;border-radius:5px;line-height:24px;padding:5px;position:absolute;width:180px;color:#666;top:-28px;left:54px;background-color:#fff;border-left:4px solid #6C0;display:none;z-index:999;text-align:left;">
                                        此商品为精品专区商品
                                    </div>
                                @elseif($v->zyzk>0)
                                    惠
                                    <div class="tip-box"
                                         style="border:1px solid #e5e5e5;border-radius:5px;line-height:24px;padding:5px;position:absolute;width:180px;color:#666;top:-28px;left:54px;background-color:#fff;border-left:4px solid #6C0;display:none;z-index:999;text-align:left;">
                                        此商品优惠{{formated_price($v->zyzk)}}
                                    </div>
                                @endif
                            </td>
                            <td class="tb2_td1">
                                <a href="{{route('goods.index',['id'=>$v->goods_id])}}" target="_blank"
                                   style="color: #FF6102">{{$v->goods_name}}</a>
                            </td>
                            <td class="tb2_td7">{{$v->xq}}</td>
                            <td class="tb2_td2">{{formated_price($v->goods_price)}}</td>
                            <td class="tb2_td3">{{$v->goods_number}}</td>
                            <td class="tb2_td4">{{formated_price($v->goods_price*$v->goods_number)}}</td>
                            <td class="tb2_td5">@if($v->parent_id==0)<a class="fly_to_cart{{$v->goods_id}}"
                                                                        href="@if($user->ls_review==1)javascript:addToCart1({{$v->goods_id}},1)@else javascript:addToCart2({{$v->goods_id}},1)@endif">加入购物车</a>@endif
                            </td><!-- 2015-7-9 -->
                        </tr>
                        @if($v->user_bz)
                            <tr>
                                <td colspan="7" style="color:#F00; font-size:12px;" bgcolor="#ffffff" align="left">
                                    备注：{{$v->user_bz}}(下单数量：{{$v->goods_number_f or 0}})
                                </td>
                            </tr>
                        @endif
                    @else
                        <tr>
                            <td class="tb2_td6" style="color:#3ebb2b;cursor:pointer;position:relative;z-index: 1">
                                赠
                            </td>
                            <td class="tb2_td1">
                                <a href="javascript:;"
                                   style="color: #FF6102">{{$v->goods_name}}</a>
                            </td>
                            <td class="tb2_td7"></td>
                            <td class="tb2_td2">{{formated_price($v->goods_price)}}</td>
                            <td class="tb2_td3">{{$v->goods_number}}</td>
                            <td class="tb2_td4">{{formated_price($v->goods_price*$v->goods_number)}}</td>
                            <td class="tb2_td5"></td><!-- 2015-7-9 -->
                        </tr>
                    @endif
                @endforeach
                <tr>
                    <td class="al_right com" colspan="7">
                        <form action="{{route('user.sureShipping')}}" method="post" name="formFee" id="formFee"
                              style="float: right;width: 80px;height: 39px;margin-left: 20px;@if($order->order_status==1&&$order->pay_status==2&&$order->shipping_status==4)display: block;@else display: none; @endif">
                            <input type="submit" name="Submit" class="submit_1" value="确认收货" style="margin-top: 5px;"/>
                            <input type="hidden" name="id" value="{{$order->order_id}}"/>
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
                        @if($order->cz_money>0)
                            - 使用119充值余额:<span class="price">{{formated_price($order->cz_money)}}</span>
                        @endif
                        @if($order->jf_money>0)
                            - 使用积分金币:<span class="price">{{formated_price($order->jf_money)}}</span>
                        @endif
                        @if($order->surplus>0)
                            - 使用余额:<span class="price">{{formated_price($order->surplus)}}</span>
                        @endif
                        @if($order->pack_fee>0)
                            - 使用优惠券:<span class="price">{{formated_price($order->pack_fee)}}</span>
                        @endif
                        @if($order->zyzk>0)
                            - 优惠金额:<span class="price">{{formated_price($order->zyzk)}}</span>
                        @endif
                        @if($order->jnmj>0)
                            - 使用充值余额:<span class="price">{{formated_price($order->jnmj)}}</span>
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
                @if($order->is_mhj==0&&$order->order_amount>0&&$order->is_zq==0&&$order->jnmj==0&&$order->is_separate==0)
                    <tr>
                        <td class="al_right com">
                            <form action="{{route('user.useSurplus')}}" method="post" name="formFee" id="formFee">
                                追加使用余额:
                                <input name="surplus" type="text" size="8" value="0" style="border:1px solid #ccc;"/>（您的帐户余额：{{formated_price($user->user_money)}}
                                ）
                                <input type="submit" name="Submit" class="submit_1" value="确定"/>
                                <input type="hidden" name="orderId" value="{{$order->order_id}}"/>
                                {!! csrf_field() !!}
                            </form>
                        </td>
                    </tr>
                @endif
            </table>
            <table class="table4">
                <tr>
                    <th colspan="4">收货人信息</th>
                </tr>
                <tr>
                    <td class="al_right tb4_td1">收货人姓名：</td>
                    <td class="tb4_td2">{{$order->consignee}}</td>
                    <td class="al_right tb4_td3">电子邮件地址：</td>
                    <td class="tb4_td4">{{$order->email}}</td>
                </tr>
                <tr>
                    <td class="al_right tb4_td1">详细地址：</td>
                    <td colspan="3">{{$order->address}}
                        @if($order->zipcode)
                            [邮政编码: {{$order->zipcode}}]
                        @endif
                    </td>
                </tr>

                <tr>
                    <td class="al_right tb4_td1">手机：</td>
                    <td class="tb4_td2">{{$order->tel}}</td>
                    <td class="al_right tb4_td3">电话：</td>
                    <td class="tb4_td4">{{$order->mobile}}</td>

                </tr>
                <tr>
                    <td class="al_right tb4_td1">备注：</td>
                    <td class="tb4_td2">{{$order->sign_building}}</td>
                    <td class="al_right tb4_td3">最佳送货时间：</td>
                    <td class="tb4_td4">{{$order->best_time}}</td>

                </tr>


            </table>
            <table class="table5">
                <tr>
                    <th>支付方式</th>
                </tr>
                <tr>
                    <td>所选支付方式: {{$order->pay_name}}。应付款金额:
                        <strong>{{formated_price($order->order_amount)}}</strong><br/>
                        {!! $order->pay_desc !!}</td>
                </tr>
            </table>
            <table class="table6">
                <tr>
                    <th colspan="3">其他信息</th>
                </tr>
                @if($order->shipping_id>0)
                    <tr>
                        <td class="al_right tb6_td1">配送方式：</td>
                        <td class="tb6_td2" colspan="3">{{$order->shipping_name}}</td>
                    </tr>
                @endif
                <tr>
                    <td class="al_right tb6_td1">支付方式：</td>
                    <td class="tb6_td2" colspan="3">{{$order->pay_name}}</td>
                </tr>
                @if($order->postscript)
                    <tr>
                        <td class="al_right tb6_td1">订单附言：</td>
                        <td class="tb6_td2" colspan="3">{{$order->postscript}}</td>
                    </tr>
                @endif
                <tr>
                    <td class="al_right tb6_td1">缺货处理：</td>
                    <td class="tb6_td2" colspan="3">{{$order->how_oos}}</td>
                </tr>
            </table>
        </div>
    </div>
    <script>
        $(".table2 tr td.tb2_td6").hover(function () {

            $(this).find(".tip-box").show();
        }, function () {

            $(this).find(".tip-box").hide();
        })

    </script>
    @include('common.footer')
@endsection
