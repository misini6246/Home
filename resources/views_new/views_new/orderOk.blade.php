@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/cart.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/confirm_order.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/pay.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/submit_order.js')}}"></script>

    <style>
        .back_a a{text-align: center;border-radius: 5px;color: #fff;background-color: #33cc33;margin: 0 5px;padding: 2px 10px;}
        .back_a a.home{padding: 2px 20px;}

        #J_payonline{
            width: 110px;
            height: 36px;
            color: #fff;
            text-align: center;
            line-height: 26px;
            background-color: #33cc33;
            border-radius: 5px;
            font-size: 16px;
            margin-left: 0px;
            *margin-left: 0px;
            cursor: pointer;
            position: absolute;
            left: 200px !important;
            top: -29px;

        }
    </style>
@endsection
@section('content')
    @include('layout.page_header_cart')
    <div class="content_2" style="position: relative;">

        <div class="ico"><img src="{{path('images/order33.png')}}" alt=""/></div>
        <div class="info-box">
            <div class="title-txt">感谢您在本店购买商品，订单已成功提交！</div>
            {{--<div style="font-size: 16px; color: red; margin-bottom:10px;">温馨提示:为了您的货款安全,请不要将货款转到公司指定以外的账户!</div>--}}
            <div class="info">
                @if($order['zj_type']>0)
                    <div style="margin-left: -25px;width: 890px;margin-top: -10px;">
                        @if($order['zj_type']==1)
                            <img src="{{get_img_path('images/shuang11-zj-ts01.jpg')}}"/>
                        @elseif($order['zj_type']==2)
                            <img src="{{get_img_path('images/shuang11-zj-ts03.jpg')}}"/>
                        @elseif($order['zj_type']==3)
                            <img src="{{get_img_path('images/shuang11-zj-ts02.jpg')}}"/>
                        @endif
                    </div>
                @elseif(!empty($order['new_yhq']))
                    <div style="background:url('{{get_img_path('images/shuang11-zhongyao-01.jpg')}}') no-repeat;height:100px;width:890px;margin-left: -20px;margin-top: -10px;">

                        <p style="color:#fff;font-size:30px;width:430px;margin:0px 0 0 230px;padding-top:15px;">
                            恭喜您，获得 <span style="color:#fff607;font-size:30px;">{{intval($order['new_yhq']->je)}}</span>元中药优惠券
                        </p>

                    </div>

                @endif
                <p> <span class="box"><span class="title">您的订单号：</span>
                <a href="{{route('user.orderInfo',['id'=>$order['order_id']])}}" target="_blank" class="important-info">{{$order['order_sn']}}</a>&nbsp; &nbsp; &nbsp;
                        @if(isset($order['order_sn_sy']))
                            <a href="{{route('user.orderInfo',['id'=>$order['order_id_sy']])}}" target='_blank' class="important-info">{{$order['order_sn_sy']}}(控销商品订单)</a>&nbsp; &nbsp; &nbsp;
                        @endif
                        @if(isset($order['order_sn_mhj']))
                            <a href="{{route('user.orderInfo',['id'=>$order['order_id_mhj']])}}" target='_blank' class="important-info">{{$order['order_sn_mhj']}}(麻黄碱订单)</a>
                        @endif
            </span></p>
                <p> <span class="box"><span class="title">商品总金额：</span><span class="important-info price_txt">{{formated_price($order['goods_amount'])}}</span></span></p>
                <p @if($order['shipping_fee']<=0) style="display: none;" @endif id='shipping_fee'> <span class="box"><span class="title">物流费用：</span><span class="important-info price_txt">{{formated_price($order['shipping_fee'])}}</span></span></p>
                <p> <span class="box"><span class="title">折扣金额：</span><span class="important-info price_txt">{{formated_price($order['discount'])}}</span></span></p>
                <p> <span class="box"><span class="title">优惠金额：</span><span class="important-info price_txt">{{formated_price($order['zyzk'])}}</span></span></p>
                @if($order['surplus']>0)
                <p> <span class="box"><span class="title">使用余额：</span><span class="important-info price_txt">{{formated_price($order['surplus'])}}</span></span></p>
                @endif
                @if($order['pack_fee']>0)
                    <p> <span class="box"><span class="title">使用优惠券：</span><span class="important-info price_txt">{{formated_price($order['pack_fee'])}}</span></span></p>
                @endif
                @if($order['jnmj']>0)
                    <p> <span class="box"><span class="title">使用充值余额：</span><span class="important-info price_txt">{{formated_price($order['jnmj'])}}</span></span></p>
                @endif
                <p> <span class="box"><span class="title">应付总金额：</span><span class="important-info price_txt">{{formated_price($order['order_amount'])}}</span></span></p>
                <div style="position: relative;margin: 5px 0px;">   <span class="box"><span class="title" style="font-size: 16px;
color: rgb(60, 60, 60);">支付方式：</span> <span class="important-info">{{$order['pay_name']}}</span>
                        {{--@if($order['pay_name']=='银联在线支付')(<a href="{{route('articleInfo',['id'=>91])}}" class="explain" target='_blank' class="explain">银联在线支付说明</a>)@endif--}}
                    </span>
                    @if(!isset($order['order_sn_mhj'])&&$order['order_amount']>0)
                        {!! $onlinePay !!}
                    @endif
                </div>
                    <span style="color: red;">提示：转账时如果提示对方是企业账户，不支持扫码转账。,请先加“{!! $hz_zfb or 'hz@hezongyy.com' !!}”为好友然后再扫码支付。</span>
                <p>
                    <span class="box"><span class="title">您选定的配送方式为: </span> <span class="important-info">{{$order['shipping_name']}}</span></span>
                    <a href="#" class="wuliu_tip">如需要更改物流，请与客服人员联系</a></p>

                <div class="fn_clear">
                   <span style="height: 28px;
display: block;
float: left;
width: 83px;
font-size: 16px;
color: red;
line-height: 28px;">温馨提示：</span>
                    <p style="float: left;line-height: 28px;">为保证你所选的商品库存，请尽快付款，未付款订单系统会在 <span class="important-info">24小时以后 </span>自动取消。</p>
                    <p style="float: left;line-height: 28px;color: red;margin-left: 83px;">为了您的货款安全，请不要将货款转到公司指定以外的账户！</p>
                    <p style="float: left;line-height: 28px;color: red;margin-left: 83px;">充值余额低于200将自动转入账户余额，详情可咨询客服或前往余额管理查看账户明细！</p>
                    @if(isset($order['order_sn_mhj']))
                    <p style="float: left;line-height: 28px;color: red;margin-left: 83px;">根据GSP规定，该订单：{{$order['order_sn_mhj']}}只能单独转款，支持使用在线支付及转账到对公账户，并且含麻订单不能使用余额。</p>
                    @endif
                </div>
                {{--@if(isset($order['order_sn_mhj']))--}}
                {{--<div style="color: red">--}}
                    {{--温馨提示：根据GSP规定，该订单:{{$order['order_sn_mhj']}}只能单独转款，支持使用在线支付及转账到对公账户,并且含麻订单不能使用余额。--}}
                {{--</div>--}}
                {{--@endif--}}
                {{--<div style="font-size: 16px; color: red; margin-bottom:10px;">温馨提示:为了您的货款安全,请不要将货款转到公司指定以外的账户!</div>--}}
            </div>
            <div class="back_a">
                返回 <a href="{{route('index')}}" class="home">首页</a> 或者返回 <a href="{{route('user.index')}}">用户中心</a>
            </div>
        </div>
        @if($order['pay_name']=='银行汇款/转帐')
            <div class="bank-list">
                <p style="font-size: 16px;color: #333">支持以下转账/汇款方式：</p>
                <img style="margin-left: -60px;" src="{{get_img_path('images/yinhangxinxi.png')}}">
            </div>
        @endif
    </div>
    <div class="alert_mark" style="display:none;">
        <div class="content_l" >
            <div class="mark_box">
                <span class="close"> </span>
                <p class="feed_back">支付反馈</p>
                <div class="info_m">
                    <p>请您在新打开的网上银行页面进行支付，支付完成后选择：</p>
                    <p class="text"> <span class="suc_ico ico"></span> 支付成功： <a href="{{route('user.orderList')}}">查看订单</a> <a href="{{route('index')}}">继续购物</a> </p>
                    <p class="text"> <span class="fail_ico ico"></span> 支付失败： <a href="{{route('articleInfo',['id'=>49])}}">查看支付帮助</a>  </p>
                </div>


            </div>
        </div>
    </div>
    <div class="content_mark_div"></div>
    @include('layout.weixin')
    @include('layout.page_footer')
@endsection
