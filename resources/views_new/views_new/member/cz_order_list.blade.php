@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_order2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/my_order.js')}}"></script>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')

    <div class="main fn_clear">

        <div class="main fn_clear">
            <div class="top">
                <span class="title">我的药易购</span> <a>>　<span>交易管理</span> </a> <a href="{{route('user.orderList')}}" class="end">>　<span>充值订单</span></a> </div>
            @include('layout.user_menu')
            <div class="main_right1">
                <div class="top_title">
                    <h3>充值订单</h3>
                    <span class="ico"></span>
                </div>

                <table id="se">
                    <tr>
                        <th>订单号</th>
                        <th>下单时间</th>
                        <th>订单总金额</th>
                        <th>订单状态</th>
                        <th> 操作 </th>
                    </tr>
                    @if(count($pages)>0)
                    @foreach($pages as $v)
                    <tr>
                        <td class="nub tb1_td1" data-id="{{$v->order_id}}"><a href="{{route('user.orderInfo',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}">{{$v->order_sn}}</a></td>
                        <td class="date tb1_td2">{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                        <td class="score tb1_td4">{{formated_price($v->goods_amount)}}</td>
                        <td class="data tb1_td5">
                            <span class="no_pay" style="color: #e70000;">@if($v->pay_status==2) 已付款 @else 未付款 @endif</span>
                        </td>
                        <td class="result tb1_td6">
                            <a href="{{route('user.cz_order_info',['id'=>$v->order_id])}}" class="f6">查看订单</a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7">暂无任何订单！</td>
                    </tr>
                    @endif

                </table>
                @if($pages->lastPage()>0)
                {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,[

                    'url'=>'user.orderList',
                    ]) !!}
                @endif
            </div>
        </div>

    </div>
    @include('layout.page_footer')
@endsection
