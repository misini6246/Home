@extends('jf.layouts.body')
@section('links')
    <link href="{{path('css/jf/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jf/gwc_3.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/jf/lb.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('jf.layouts.header')
    @include('jf.layouts.nav')
    <!--container-->
    <div class="container content">
        <div class="content_box">
            <div class="top_title">
                <img src="{{get_img_path('images/jf/address_03.png')}}"/>
                <span>当前位置：<a href="{{route('jf.index')}}">积分首页</a> > 兑换成功</span>
            </div>
            <div class="jiesuan_box">
                <div class="img_title">
                    <img src="{{get_img_path('images/jf/gwc_3.jpg')}}"/>
                </div>
                <div class="jiesuan_content">
                    <div class="fl">
                        <img src="{{get_img_path('images/jf/success.png')}}"/>
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
                                    <a href="{{route('jf.index')}}" class="go_index">返回首页</a><a
                                            href="{{route('jf.order.show',['id'=>$order->id])}}">订单详情</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('jf.layouts.wntj')
        </div>
    </div>
    <!--container-->
    @include('jf.layouts.footer')
@endsection
