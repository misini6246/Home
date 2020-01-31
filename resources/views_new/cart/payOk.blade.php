@extends('layout.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link href="{{path('css/cart/jiesuan_common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/cart/gwc_4.css')}}12" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/cart/lb.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('layouts.header')
    <div class="jiesuan">
        <div class="jiesuan_nav">
            <div class="jiesuan_box">
                <a href="/">
                    <img src="{{asset('images/logo-new.png')}}"  style="margin: 30px;"/>
                </a>
                <div class="jiesuan_nav_title">
                    购物流程
                </div>
                <div class="jiesuan_nav_step">
                    <img src="{{get_img_path('images/cart/step_4.jpg')}}"/>
                </div>
            </div>
        </div>
        <div class="jiesuan_box container">
            <div class="zhuangtai">
                <div class="img_box">
                    <img src="{{get_img_path('images/cart/success.png')}}"/>
                </div>
                <div class="text">
                    <div class="text_title">
                        恭喜您已成功完成付款
                    </div>
                    <div class="gwc4_tishi">
                        我们将及时处理您的订单，请耐心等待；所有货物请在送货员在场时开箱验货再签收，如有破损及时联系客服人员，如未当面开箱验货，破损不予赔付，自行承担。
                    </div>
                    <p>
                        订单编号：<a href="{{route('member.order.show',['id'=>$info->order_id])}}"><span>{{$info->order_sn}}</span></a>
                    </p>
                    <p>
                        实付金额：<span class="red">{{formated_price($info->o_paid)}}</span>
                    </p>
                    <p>
                        支付方式：<span class="red">{{$info->pay_name}}</span>
                    </p>
                    @if(time()>=strtotime('2019-11-01'))
                    <p>
                        <input id="cj" style="
                                position:absolute;
                                left:0;
                                top:0;
                                margin-left:0;
                                background-color:#FF2A3E; 
                                width: 110px;
                                height: 36px;
                                color: #fff;
                                text-align: center;
                                line-height: 26px;
                                background-color: #FF2A3E;
                                border-radius: 5px;
                                font-size: 16px;
                                margin-left: 0px;
                                *margin-left: 0px;
                                cursor: pointer;" 
                            value="去抽奖" type="button" onclick="goCj()">
                    </p>
                    @endif
                    <p class="link">
                        您可以<a href="{{route('index')}}">返回首页</a><a
                                href="{{route('member.collection.index')}}">查看我的收藏</a><a
                                href="{{route('member.order.index')}}">查看我的订单</a>
                    </p>
                </div>

            </div>
            <div id="ban2">
                <div class="banner">
                    <div class="banner_title">
                        <img src="{{get_img_path('images/cart/dian.png')}}"/>
                        <span>为您推荐</span>
                    </div>
                    <ul class="img">
                        <li>
                            @foreach($wntj as $k=>$v)
                                @if($k<5)
                                    <div class="wntj-cp first-wntj-cp">
                                        <div class="wntj-img-box">
                                            <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                        src="{{$v->goods_thumb}}"/></a>
                                        </div>
                                        <p class="name">{{$v->goods_name}}</p>
                                        <p class="gg">{{$v->ypgg}}</p>
                                        <p class="wntj-cp-jiage">{{formated_price($v->real_price)}}</p>
                                    </div>
                                @endif
                            @endforeach
                        </li>
                        <li>
                            @foreach($wntj as $k=>$v)
                                @if($k>=5&&$k<10)
                                    <div class="wntj-cp first-wntj-cp">
                                        <div class="wntj-img-box">
                                            <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                        src="{{$v->goods_thumb}}"/></a>
                                        </div>
                                        <p class="name">{{$v->goods_name}}</p>
                                        <p class="gg">{{$v->ypgg}}</p>
                                        <p class="wntj-cp-jiage">{{formated_price($v->real_price)}}</p>
                                    </div>
                                @endif
                            @endforeach
                        </li>
                    </ul>

                    <div class="btn btn_l">
                        <img src="{{get_img_path('images/cart/tj_prev_03.png')}}"/>
                    </div>
                    <div class="btn btn_r">
                        <img src="{{get_img_path('images/cart/tj_next_03.png')}}"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#cj').click(function(){
            window.location.href="/11.1/choujiang"
        })
    </script>
    @include('layouts.new_footer')
@endsection

