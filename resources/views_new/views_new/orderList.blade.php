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
                <span class="title">我的太星医药网</span> <a>>　<span>交易管理</span> </a> <a href="{{route('user.orderList')}}" class="end">>　<span>我的订单</span></a> </div>
            @include('layout.user_menu')
            <div class="main_right1">
                <div class="top_title">
                    <h3>我的订单</h3>
                    <span class="ico"></span>
                    <div class="right_box">
                        <form action="{{route('user.orderList')}}" enctype="multipart/form-data" method="get">
                            <div class="search_box" id="search_box">
                                <input type="text" name="keys" class="keys" value="{{$keys}}" placeholder="订单编号"/>
                                <input type="submit" class="search" value="查询"><span class="ico"></span>
                            </div>
                            <select name="dates">
                                {{--<option value="0">今天</option>--}}
                                <option value="1" @if($dates==1) selected @endif>最近三个月</option>
                                <option value="2" @if($dates==2) selected @endif>今年内</option>
                                {{--<option value="{{date('Y',strtotime('-1 year'))}}" @if($dates==date('Y',strtotime('-1 year'))) selected @endif>{{date('Y',strtotime('-1 year'))}}年</option>--}}
                                <option value="3" @if($dates==3) selected @endif>往年订单</option>
                            </select>
                        </form>
                    </div>
                </div>

                <table id="se">
                    <tr>
                        <th>订单标识</th>
                        <th>订单号</th>
                        <th>下单时间</th>
                        <th>收货人</th>
                        <th>订单总金额</th>
                        <th>订单状态</th>
                        <th> 操作 </th>
                    </tr>
                    @if(count($pages)>0)
                    @foreach($pages as $v)
                    <tr>
                        <td>
                            @if($v->jnmj>0)
                                <a>返</a>
                            @elseif($v->is_zq>0)
                                <a>账</a>
                            @elseif($v->is_separate==1)
                                <a>货</a>
                            @endif</td>
                        <td class="nub tb1_td1" data-id="{{$v->order_id}}"><a href="{{route('user.orderInfo',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}">{{$v->order_sn}}</a></td>
                        <td class="date tb1_td2">{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                        <td class="name tb1_td3">{{$v->consignee}}</td>
                        <td class="score tb1_td4">{{formated_price($v->goods_amount)}}</td>
                        <td class="data tb1_td5">
                            <span class="no_pay" style="color: #e70000;">@if($v->pay_status==2) 已付款 @else 未付款 @endif</span>
                            <span class="stat" style="color:#339900;cursor:pointer;position: relative;padding:0 5px;" id="ddgz" dd-url="{{route('user.ddgz')}}">订单跟踪</span>
                            @if(strpos($v->fhwl_m,'宅急送')!==false&&$v->shipping_status>=4)
                                <a target="_blank" href="{{route('zjs',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}">物流跟踪</a>
                            @endif
                        </td>
                        <td class="result tb1_td6">
                            {!!ddzt($v)!!}&nbsp;&nbsp;
                            <a href="{{route('user.orderInfo',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}" class="f6">查看订单</a>
                            <a href="{{route('user.orderBuy',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}" class="f6">再次购买</a>
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
                    'dates'=>$dates,
                    'url'=>'user.orderList',
                    ]) !!}
                @endif
            </div>
        </div>

    </div>
    @include('layout.page_footer')
@endsection
