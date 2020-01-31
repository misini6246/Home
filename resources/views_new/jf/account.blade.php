@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_page_common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_account.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_user.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_page.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/table_click.js')}}"></script>

@endsection
@section('content')
@include('layout.jf_header')
<div class="content_main">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">我的账户</span></p>
    <div class="content_main_all clear_float">
        <p><span class="vip_center">会员中心</span><span class="address_manage">交易中心</span><span class="add_address">你好 {{$user->user_name}} ,欢迎回来</span></p>
        @include('layout.jfMenu')
        <div class="manage_all_address">
            <div class="user">
                <div class="user_msg">
                    <p class="about_users">用户信息</p>
                    <!--<p>您的兑换总数量：<span class="exchange_count color_d">0</span>笔</p>-->
                    <p>总消费积分：<span class="used_record color_d">{{$totalAmount}}</span>分</p>
                    <p>剩余积分：<span class="left_record color_d">{{$user->pay_points}}</span>分</p>
                    <!--<p class="other_msg">
                        <span class="evaluate">待评价商品（<span class="color_d">1</span>）</span>
                        <span class="wait_order">待兑换订单（<span class="color_d">0</span>）</span>
                        <span class="wait_sure">待确认收货（<span class="color_d">0</span>）</span>
                    </p>-->
                </div>
                <div class="all_address clear_float" id="pages">
                    <p class="about_users">我的订单</p>
                    <table>
                        <thead>
                        <tr>
                            <td>订单编号</td>
                            <td>下单日期</td>
                            <!--<td>收货人</td>-->
                            <td>兑换积分</td>
                            <td>订单状态</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pages as $v)
                        <tr style="background: rgb(249, 249, 249) none repeat scroll 0% 0%; color: rgb(75, 75, 75);">
                            <td class="orderid"><a style="color: rgb(75, 75, 75);" href="{{route('jf.orderInfo',['id'=>$v->id])}}" target="_blank">{{$v->order_sn}}</a></td>
                            <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                            <!--<td>哪个</td>-->
                            <td style="color: rgb(249, 87, 6);" class="color_f9">{{$v->order_amount}}分</td>
                            <td style="color: rgb(8, 154, 202);" class="status">{!! $orderState[$v->order_state] !!}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if($pages->lastPage()>1)
                    <div class='order_pagination'>
                        <div class='pagination'>
                            @include('layout.jfPages')
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            {{--<script type="text/javascript">--}}
                {{--function setPage(url) {--}}
                    {{--$.ajax({--}}
                        {{--type: "GET",--}}
                        {{--dataType: 'HTML' ,--}}
                        {{--url: url,--}}
                        {{--success: function(content){--}}
                            {{--$('#J_my_order').html(content) ;--}}
                        {{--}--}}
                    {{--})--}}
                {{--}--}}

                {{--setPage('member.php?act=ajax_get_order&page=1')--}}
            {{--</script>--}}
            @include('layout.tj8')
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function(){//已兑换变蓝色
        $(".status").each(function(n,e){
            if($(e).text()=="已兑换"){
                $(e).css({"color": "#089aca"});
            }
        });
    })
</script>
@include('layout.jf_footer')
@endsection
