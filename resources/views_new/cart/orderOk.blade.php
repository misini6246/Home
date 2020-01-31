@extends('layout.body')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>支付订单</title>
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/base.css"/>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css"/>
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/common_gwc.css" />
    <link rel="stylesheet" type="text/css" href="/new_gwc/jiesuan_common.css"/>
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc_3.css"/>
    <link rel="stylesheet" type="text/css" href="/user/pay.css"/>

    <!--layer-->
    <link rel="stylesheet" type="text/css" href="/new_gwc/layer.css" />

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/new_gwc/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        .top-box {
            height: 120px;
            width: 100%;
            border-bottom: 2px solid #0090D2;
        }

        .top-box .box-container .left {
            height: 100%;
            width: 370px;
            float: left;
        }

        .top-box .box-container .left img {
            display: block;
            width: 100%;
            height: 100%;
        }

        .top-box .box-container .right {
            height: 100%;
            width: 620px;
            float: right;
        }

        .top-box .box-container .right img {
            display: block;
            width: 100%;
            height: 100%;
        }
    </style>
@endsection
@section('content')

    <div class="big-container">
        <!--头部-->
    @include('layouts.header')
        <!--/头部-->

        <div class="top-box" style="background-color: #fff;">
            <div class="box-container">
                <div class="left"><a href="{{route('index')}}"><img src="/new_gwc/img/购物车_01.jpg" /></a></div>
                <div class="right"><img src="/new_gwc/img/订单支付_01.jpg" /></div>
            </div>
        </div>

        <!--主体内容开始-->
        <div class="jiesuan">
            <div class="jiesuan_box container">
                <div class="container_title">
                    成功提交订单
                </div>
                <div class="success">
                    <div class="success_title">
                        <img src="/index/img/success.png"/>
                        <p class="success_title_top">
                            感谢您在本网站购买商品，您的订单已成功提交！
                        </p>
                        {{--<p class="success_title_bottom">--}}
                        {{--（如果您要对订单进行修改，请与客服人员联系。）--}}
                        {{--</p>--}}
                    </div>
                    <style>
                        .choujiang {
                            width: 990px;
                            height: 360px;
                            background: url('http://47.106.142.169:8103/images/hd/choujiang_bg.jpg?110112') no-repeat;
                            margin: 0 0 20px 160px;
                            position: relative;
                            display: none;
                        }

                        .choujiang_btn {
                            display: inline-block;
                            width: 240px;
                            height: 70px;
                            position: absolute;
                            top: 268px;
                            left: 375px;
                            cursor: pointer;
                        }

                        .choujiang_result_box {
                            text-align: center;
                            height: 360px;
                            width: 100%;
                            background: rgba(0, 0, 0, .5);
                            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#7f000000, endColorstr=#7f000000);
                            position: relative;
                            z-index: 2;
                        }

                        .choujiang_result {
                            display: inline-block;
                            width: 389px;
                            height: 305px;
                            background: url('http://47.106.142.169:8103/images/hd/choujiang_result.png?110112') no-repeat;
                            margin-top: 30px;
                        }

                        .choujiang_result .lx {
                            margin-top: 187px;
                        }

                        .choujiang_result .lx,
                        .choujiang_result .lx span {
                            font-size: 30px;
                        }

                        .choujiang_result .lx span {
                            color: #ff4b5c;
                        }

                        .choujiang_result .txt {
                            font-size: 18px;
                            margin-top: 5px;
                        }

                        .choujiang_result .number {
                            color: #666;
                            font-size: 14px;
                            margin-top: 20px;
                        }
                    </style>
                    {{-- <div class="choujiang">

                    </div> --}}
                    {{-- <script>
                        
                        $(function() {
                            $.ajax({
                                url: '/jp/check_log_count',
                                data: {
                                    id: 1
                                },
                                dataType: 'json',
                                success: function(data) {
                                    if(data.error == 0) {
                                        $('.choujiang').html(data.msg);
                                        $('.choujiang').hide();
                                    }
                                }
                            })
                        });

                        function cj() {
                            $.ajax({
                                url: '/jp',
                                data: {
                                    order_id: '2279'
                                },
                                dataType: 'json',
                                success: function(data) {
                                    if(data.error == 0) {
                                        $('.choujiang').html(data.msg);
                                    } else {
                                        layer.msg(data.msg, {
                                            icon: data.error + 1
                                        })
                                    }
                                }
                            })
                        }
                    </script> --}}
                    <div class="dingdanxinxi" style="border-color: #0090D2;">
                        <p>
                        <span class="left">
								订单编号：
							</span>
                            <a href="{{route('member.order.show',['id'=>$order['order_id']])}}" class="order_sn"><span
                                        class="right">{{$order['order_sn'] or ''}}
                                    &nbsp;@if(isset($order['order_sn_mhj'])||isset($order['order_sn_sy']))<span
                                            style="color: red;font-size: 16px;">(应付金额：{{formated_price($info->order_amount)}}
                                        )</span>
                                    @endif
                            </span></a>
                            @if((isset($order['order_sn_mhj'])||isset($order['order_sn_sy']))&&$order['order_amount']>0)
                                <a target="_blank" href="{{route('member.order.show',['id'=>$order['order_id']])}}"
                                   class="fendan_a">去支付</a>
                            @endif
                        </p>
                        @if(isset($order['order_sn_mhj']))
                            <p>
                            <span class="left">
								订单编号：
							</span>
                                <a href="{{route('member.order.show',['id'=>$order['order_id_mhj']])}}"
                                   class="order_sn"><span
                                            class="right">
                                    {{$order['order_sn_mhj'] or ''}}&nbsp;<span
                                                style="color: red;font-size: 16px;">(麻黄碱订单，应付金额：{{formated_price($order['order_amount_mhj'])}}
                                            )</span>
                                </span></a>
                                <a target="_blank" href="{{route('member.order.show',['id'=>$order['order_id_mhj']])}}"
                                   class="fendan_a">去支付</a>
                            </p>
                        @endif
                        @if(isset($order['order_sn_sy']))
                            <p>
                            <span class="left">
								订单编号：
							</span>
                                <a href="{{route('member.order.show',['id'=>$order['order_id_sy']])}}"
                                   class="order_sn"><span
                                            class="right">
                                    {{$order['order_sn_sy'] or ''}}&nbsp;<span
                                                style="color: red;font-size: 16px;">(血液制品订单，应付金额：{{formated_price($order['order_amount_sy'])}}
                                            )</span>
                                </span></a>
                                <a target="_blank" href="{{route('member.order.show',['id'=>$order['order_id_sy']])}}"
                                   class="fendan_a">去支付</a>
                            </p>
                        @endif
                        <p>
							<span class="left">
								商品总金额：
							</span>
                            <span class="right red">
								{{formated_price($order['goods_amount'])}}
							</span>
                        </p>
                        @if($order['shipping_fee']>0)
                            <p>
							<span class="left">
								运费：
							</span>
                                <span class="right red">
							{{formated_price($order['shipping_fee'])}}&nbsp;(重庆市单张订单满1000包邮)
							</span>
                            </p>
                        @endif
                        @if($order['zyzk'])
                            <p>
							<span class="left">
								优惠金额：
							</span>
                                <span class="right red">
							{{formated_price($order['zyzk'])}}
							</span>
                            </p>
                        @endif
                        @if($order['surplus'])
                            <p>
							<span class="left">
								使用余额：
							</span>
                                <span class="right red">
							{{formated_price($order['surplus'])}}
							</span>
                            </p>
                        @endif
                        @if($order['pack_fee'])
                            <p>
							<span class="left">
								{{trans('common.pack_fee')}}：
							</span>
                                <span class="right red">
							{{formated_price($order['pack_fee'])}}
							</span>
                            </p>
                        @endif
                        @if(isset($order['cz_money'])&&$order['cz_money']>0)
                            <p>
							<span class="left">
								使用{{trans('common.cz_money')}}：
							</span>
                                <span class="right red">
			                {{formated_price($order['cz_money'])}}
							</span>
                            </p>
                        @endif
                        @if(isset($order['jf_money'])&&$order['jf_money']>0)
                            <p>
							<span class="left">
								使用{{trans('common.jf_money')}}：
							</span>
                                <span class="right red">
			                {{formated_price($order['jf_money'])}}
							</span>
                            </p>
                        @endif
                        @if(isset($order['hongbao_money'])&&$order['hongbao_money']>0)
                            <p>
							<span class="left">
								使用{{trans('common.hongbao_money')}}：
							</span>
                                <span class="right red">
			                {{formated_price($order['hongbao_money'])}}
							</span>
                            </p>
                        @endif
                        @if($order['jnmj']>0)
                            <p>
							<span class="left">
								使用{{trans('common.jnmj')}}：
							</span>
                                <span class="right red">
			                {{formated_price($order['jnmj'])}}
							</span>
                            </p>
                        @endif
                        <p>
							<span class="left">
								应付金额：
							</span>
                            <span class="right red">
								{{formated_price($order['order_amount'])}}
							</span>
                        </p>
                        <p>
							<span class="left">
								支付方式：
							</span>
                            <span class="right">
								<a href="#">
									{{$order['pay_name']}}
								</a>
							</span>
                        </p>
                        @if(!empty($info->consignee))
                            <p>
							<span class="left">
								配送信息：
							</span>
                                <span class="right">
                                @if(!empty($info->shipping_name))
                                        {{$info->shipping_name}}
                                        /
                                    @endif
                                    {{$info->consignee}}  {{$info->tel or $info->mobile}}  {{get_region_name([$info->province,$info->city,$info->district],' ')}} {{$info->address}}
							</span>
                            </p>
                        @endif
                    </div>
                    @if(!isset($order['order_sn_mhj'])&&!isset($order['order_sn_sy'])&&$order['order_amount']>0&&$order['pay_name']!='银行汇款/转帐'&&$order['pay_name']!='月结')
                        <div class="fukuan" style="height: 50px;width: 200px;position: relative;">
                            {!! $onlinePay !!}
                        </div>
                    @endif
                    <div class="tsok">
                        <div class="tsok_title">
                            温馨提示：
                        </div>
                        <div class="tsok_right">
                            <p>
                                <img src="/index/img/zfdd_dian.png">为保证你所选的商品库存，请尽快付款，未付款订单系统会在<span>48小时以后</span>自动取消。
                            </p>
                            <p><img src="/index/img/zfdd_dian.png">为了您的货款安全，请不要将货款转到公司指定以外的账户！</p>
                            @if(isset($order['mhj_tip'])&&!empty($order['mhj_tip']))
                                <p><img src="/index/img/zfdd_dian.png">{{$order['mhj_tip']}}</p>
                            @endif
                        </div>
                        <div style="clear: both;"></div>
                    </div>
{{--                    @if($order['pay_name']=='银行汇款/转帐')--}}
{{--                        <div class="bank-list" style="margin-top: 20px;">--}}
{{--                            <p style="font-size: 16px;color: #333">支持以下转账/汇款方式：</p>--}}
{{--                            <img src="/index/yhzz.jpg">--}}
{{--                        </div>--}}
{{--                    @endif--}}
                </div>
                <div class="link" style="clear: both;">
                    返回<a href="{{route('index')}}">首页</a>或者返回<a href="/member">我的今瑜e药网</a>
                </div>
            </div>
        </div>

        <!--主体内容结束-->

        <!--footer-->
        @include('layouts.new_footer')
        <!--/footer-->
    </div>
@endsection

