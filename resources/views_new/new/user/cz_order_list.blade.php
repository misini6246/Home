@extends('layout.app')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/wodedingdan.css')}}1" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
    <!--[if lte IE 9]>
    <style type="text/css">
        .genzong {
            border: 1px solid #e5e5e5;
        }


    </style>
    <![endif]-->
    <!--[if IE 8]>
    <style type="text/css">
        .right_top_search select {
            padding: 5px 0;
        }
    </style>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 7]>
    <script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')


    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>我的账期汇总订单</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_top">
                    <div class="right_top_title" style="width: 150px;">
                        <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                        <span>我的账期汇总订单</span>
                    </div>
                </div>
                @if(count($result)>0)
                    <form id="search_form" name="search_form" action="{{route('member.cz_order.index')}}">
                    </form>
                    <table>
                        <tr>
                            <th class="ddh">订单号</th>
                            <th class="xdsj">下单时间</th>
                            <th class="zje">
                                <span>订单总金额</span>
                                {{--<img src="{{get_img_path('images/user/tishi_03.png')}}" title="这是提示信息"/>--}}
                            </th>
                            <th class="ddzt">
                                订单状态
                            </th>
                            <th class="cz" style="width: 150px;">操作</th>
                        </tr>
                        @foreach($result as $v)
                            <tr>
                                <td class="ddh"><a style="display: block;color: #e70000"
                                                   href="{{route('member.cz_order.show',['id'=>$v->order_id])}}">{{$v->order_sn}}</a>
                                </td>
                                <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                                <td class="zje">{{formated_price($v->goods_amount+$v->shipping_fee)}}</td>
                                <td>
                                    @if($v->order_status==2)
                                        <span>已取消</span>
                                    @elseif($v->pay_status==0)
                                        <span class="dfk">待付款</span>
                                    @else
                                        <span>已付款</span>
                                    @endif
                                </td>
                                <td>
                                    @if($v->pay_status==0&&$v->order_status=1)
                                        <a href="{{route('member.cz_order.show',['id'=>$v->order_id])}}"
                                           class="cz">去付款</a>
                                    @endif
                                    <a href="{{route('member.cz_order.show',['id'=>$v->order_id])}}"
                                       class="chakan">查看详情</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @include('user.pages',['pages'=>$result])
                @else
                    @include('user.empty',['type'=>0,'emsg'=>'没有查询到订单，这里是空的'])
                @endif
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            $('#num').focus(function () {
                $('.placeholder').hide();
            });
            $('#num').blur(function () {
                if ($(this).val() != "") {
                    $('.placeholder').hide();
                } else {
                    $('.placeholder').show();
                }
            });
        })
    </script>
    @include('layouts.old_footer')
@endsection
