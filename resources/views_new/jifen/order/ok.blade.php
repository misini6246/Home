@extends('jifen.layouts.body')
@section('links')
    <link href="{{path('css/jifen/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jifen/gwc_3.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/jifen/lb.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('jifen.layouts.header')
    @include('jifen.layouts.nav')
    <!--container-->
    <div class="container content">
        <div class="content_box">
            <div class="top_title">
                <img src="http://images.hezongyy.com/images/jf/address_03.png?1"/>
                <span>当前位置：<a href="{{route('jifen.index')}}">积分首页</a> > 兑换成功</span>
            </div>
            <div class="jiesuan_box">
                <div class="img_title">
                    <img src="http://images.hezongyy.com/images/jf/gwc_3.jpg?1"/>
                </div>
                <div class="jiesuan_content">
                    <div class="fl">
                        <img src="http://images.hezongyy.com/images/jf/success.png?1"/>
                    </div>
                    <div class="fr">
                        <div class="success_title">
                            恭喜您，您的礼品已兑换成功！
                        </div>
                        <p class="txt">
                            随后我们将以快递的形式把您的礼品发出，您可在订单详情里面查看相关物流信息。
                        </p>
                        <div class="dingdan">
                            <div class="ddbh">
                                订单编号：<span>{{$order->order_sn}}</span>
                            </div>
                            <div class="lpqd">
                                <div class="lpqd_left">
                                    礼品清单：
                                </div>
                                <ul class="lpqd_right">
                                    @foreach($order->order_goods as $v)
                                        <li>{{$v['goods_name']}} x{{$v['goods_num']}}</li>
                                    @endforeach
                                </ul>
                                <div class="link">
                                    <a href="{{route('jifen.index')}}" class="go_index">返回首页</a><a
                                            href="{{route('jifen.order.show',['id'=>$order->id])}}">订单详情</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('jifen.layouts.wntj')
        </div>
    </div>
    <!--container-->
    @include('jifen.layouts.footer')
@endsection
