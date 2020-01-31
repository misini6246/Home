@extends('layout.body')
@section('links')
    @include('layout.token')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('huodong/css/huodongchongzhi.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/pay.css')}}" rel="stylesheet" type="text/css" />
    <!--[if  IE 6]>
    <script type="text/javascript" src="{{path('huodong/js/DD_belatedPNG_0.0.8a-min.js')}}"></script>
    <![endif]-->
    <script type="text/javascript" src="{{path('huodong/js/huodongchongzhi.js')}}"></script>
    <style>
        #znq-daohang{
            right: 45px !important;
            bottom: 20px !important;
        }

    </style>
    @include('common.ajax_set')
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="container">
        <div id="top"></div>
        <div class="bgimg" style="position: relative;text-align: center">
            <a target="_blank" href="/znq.html#gz" id="wxts" style="left: 50%;position: absolute;width: 150px;height: 33px;bottom: 50px;margin-left: -74px;">
            </a>
        </div>
        <!--充值金额-->
        <div class="chongzhiImg"></div>
        <div class="choose">
            @foreach($result as $k=>$v)
                <label for="choose{{$k+1}}">
                    <div>
                        <div class="tihuan" cat_id="{{$v->cat_id}}" id="tihuan{{$k}}">
                            <img src="{{path('huodong/images/xuanze.jpg')}}" alt="" class="chooseimg">
                            <img src="{{path('huodong/images/gou.png')}}" class="gou"/>
                        </div>

                    </div>
                </label>
            @endforeach
        </div>
        <!--充值金额-->
        <!--支付方式-->
        <div class="pay">
            <ul>
                <label for="paychoose1">
                    <li class="paychoose" pay_id="7">
                        <img class="chooseimg" src="{{path('huodong/images/weixin.jpg')}}" alt="">
                        <img src="{{path('huodong/images/gou.png')}}" class="payimg chooseimg"/>
                    </li>
                </label>
                <label for="paychoose2">
                    <li class="paychoose" pay_id="4">
                        <img class="chooseimg" src="{{path('huodong/images/yinlian.jpg')}}" alt="" id="payimg2">
                        <img src="{{path('huodong/images/gou.png')}}" class="payimg chooseimg"/>
                    </li>
                </label>
                <label for="paychoose3">
                    <li class="paychoose" pay_id="6">
                        <img class="chooseimg" src="{{path('huodong/images/kuaijie.jpg')}}" alt="" id="payimg3">
                        <img src="{{path('huodong/images/gou.png')}}" class="payimg chooseimg"/>
                    </li>
                </label>
            </ul>
        </div>
        <div class="sure" id="subbtn">点击确认支付</div>
        <form action="/cz/pay" id="form" method="post" target="_blank">
            {!! csrf_field() !!}
            <input name="order_id" type="hidden" id="order_id" value=""/>
            <input name="pay_id" type="hidden" id="pay_id" value=""/>
        </form>
        <!--支付方式-->

        <!--提交成功后的弹框-->
        <div class="Bombbox" style="z-index: 1000000">
            <img src="{{path('huodong/images/tishi_03.jpg')}}" alt="">
            <div class="close"></div>
            <a id="chakan" href="javascript:;" class="suc">查看订单</a>
            <a target="_blank" href="http://www.hezongyy.com/articleInfo?id=91" class="err">查看支付帮助</a>
        </div>
        <!--提交成功后的弹框-->

        <!--------右侧导航-------->
        @include('common.znqdh')
    </div>
    @include('layout.weixin')
    @include('layout.page_footer')
@endsection