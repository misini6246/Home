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
    <style type="text/css">

        .zhijisong-box{width: 978px;border: 1px solid #e5e5e5;}
        .zhijisong-box ul.title-box li{float: left;border-right:1px solid #e5e5e5;height: 38px;line-height: 38px;text-align: center;font-size: 12px;width: 180px;border-bottom: 1px solid #e5e5e5}
        .list-box{position: relative;}
        .zhijisong-box ul.title-box li.title{width: 144px;background-color: #f5f5f5;font-weight: bold;}

        .dingdanxixi{width: 230px;float: left;height:552px;background-color:#fff;overflow:hidden;}

        .dingdanxixi li.list{width: 180px;height: 30px;position: relative;background-color: #dafdd4; cursor:pointer;line-height: 30px;border-bottom: 1px solid #fff;}
        .dingdanxixi li.list h3{font-size: 24px;font-weight: normal;text-indent: 15px;color: #555555;}
        .dingdanxixi li.list p{font-size: 16px;text-indent: 15px;color: #666;}
        .xinxi-list{width: 733px;background-color: #f5f5f5;float: left;display: none;height: 100%;}
        .xinxi-list .zjs{font-size: 16px;color: #333333;margin-left: 25px;height: 30px;line-height: 30px;border-bottom: 1px solid #e5e5e5;}
        .xinxi-list .zjs span{color: #f60;font-size: 16px;}
        .x-list{color: #555;margin: 0;margin-left: 30px;width: 702px;margin-bottom: 50px;background: url(http://images.hezongyy.com/images/sjz.png) 0px 22px no-repeat;border: 0;}
        .x-list tr td{border:0;border-bottom: 1px solid #e5e5e5;position: relative;padding-left: 5px;height: 54px;text-align: left;line-height: 28px;}
        .x-list tr td .date{font-size: 12px;}
        .x-list tr td .dio{width: 15px;height: 15px;border-radius: 50%;position: absolute;left: -2px;top:24px;background-color: #1b9a07;display: none;}
        .dingdanxixi li.checked{background: url(http://images.hezongyy.com/images/sjz-ico.png) 212px 19px no-repeat;background-color: #1b9a07;}
        .dingdanxixi li.checked h3 ,.dingdanxixi li.checked p{color: #feef02;}
        .x-list tr td.sj{text-align: center;padding-left: 0;width: 90px;}
        .x-list tr:hover td{color: #3ebb2b;cursor: pointer;}
        .x-list tr:hover td .dio{display: block;}
        .x-list tr.yqs td{color: #f00;}
        .x-list tr.yqs td .dio{background-color: #f00;display: block;}



    </style>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')

    <div class="main fn_clear">

        <div class="main fn_clear">
            <div class="top">
                <span class="title">我的药易购</span> <a>>　<span>交易管理</span> </a> <a href="{{route('user.orderList')}}" class="end">>　<span>订单物流信息</span></a> </div>
            @include('layout.user_menu')
            <div class="main_right1">
                <div class="top_title">
                    <h3>订单物流信息</h3>
                    <span class="ico"></span>
                </div>


                <div class="zhijisong-box fn_clear" >
                    <ul class="title-box fn_clear">
                        <li class="title">订单号</li>
                        <li>{{$order->order_sn}}</li>
                        <li class="title">下单时间</li>
                        <li>{{date('Y-m-d H:i:s',$order->add_time)}}</li>
                        <li class="title">收货人</li>
                        <li>{{$order->consignee}}</li>
                    </ul>
                    @if(count($orders)>0)
                    <div class="list-box fn_clear">
                        <ul class="dingdanxixi fn_clear" >
                            @foreach($orders as $k=>$v)
                                <li class="list @if($k==0) checked @endif zjs{{$k+1}}" >

                                    <p>运单号：{{$v['mailNo']}}</p>

                                </li>
                            @endforeach

                        </ul>
                        <div class="xinxi-box fn_clear" style="background-color:#f5f5f5">
                            @foreach($orders as $k=>$v)
                            <div class="xinxi-list xx{{$k}}" @if($k==0)style="display:block;"@endif>
                                <p class="zjs">本数据由<span>宅急送</span>提供。</p>
                                <table class="x-list">
                                    @foreach($v['steps'] as $val)
                                        <tr @if(strpos($val['acceptAddress'],'已签收')!==false)class="yqs"@endif>
                                            <td style="border-bottom:0;width:30px;"> <span class="dio"></span> </td>
                                            <td class="sj"><p  style="font-size:16px;">{{date('H:i:s',strtotime($val['acceptTime']))}}</p><p class="date">{{date('Y-m-d',strtotime($val['acceptTime']))}}</p></td>
                                            <td>{{$val['acceptAddress']}}</td>
                                        </tr>
                                    @endforeach
                                </table>

                            </div>
                            @endforeach
                            {{--<div class="xinxi-list xx1" >--}}
                                {{--<p class="zjs">本数据由<span>宅急送</span>提供。</p>--}}
                                {{--<table class="x-list">--}}
                                    {{--<tr class="yqs">--}}
                                        {{--<td style="border-bottom:0;width:30px;"> <span class="dio"></span> </td>--}}
                                        {{--<td class="sj"><p  style="font-size:16px;">12:27</p><p class="date">2016-11-15</p></td>--}}
                                        {{--<td>已签收2</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td style="border-bottom:0;width:30px;"> <span class="dio"></span> </td>--}}
                                        {{--<td class="sj"><p style="font-size:16px;">12:27</p><p class="date">2016-11-15</p></td>--}}
                                        {{--<td>离开[重庆_配送区部_达州分拨站_通川加盟商] 派送中，递送员[小件员2]，电话:18111798125</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td style="border-bottom:0;width:30px;"> <span class="dio"></span></td>--}}
                                        {{--<td class="sj"><p  style="font-size:16px;">12:27</p><p class="date">2016-11-15</p></td>--}}
                                        {{--<td>离开[重庆_配送区部_达州分拨站_通川加盟商] 派送中，派送中派送中派送中递送员[小件员2]，电话:18111798125</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td style="border-bottom:0;width:30px;"><span class="dio"></span></td>--}}
                                        {{--<td class="sj"><p  style="font-size:16px;">12:27</p><p class="date">2016-11-15</p></td>--}}
                                        {{--<td>离开[重庆_配送区部_达州分拨站_通川加盟商] 派送中，递送员[小件员2]，电话:18111798125</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td style="border-bottom:0;width:30px;"><span class="dio"></span></td>--}}
                                        {{--<td class="sj"><p style="font-size:16px;">12:27</p><p class="date">2016-11-15</p></td>--}}
                                        {{--<td>离开[重庆_配送区部_达州分拨站_通川加盟商] 派送中，递送员[小件员2]，电话:18111798125</td>--}}
                                    {{--</tr>--}}


                                {{--</table>--}}

                            {{--</div>--}}


                        </div>





                    </div>
                    @endif




                </div>
            </div>
        </div>

    </div>
    @include('layout.page_footer')
    <script type="text/javascript">

        $(function(){



            $(".dingdanxixi li").click(function(){

                var _index=$(this).index();
                $(this).addClass("checked").siblings().removeClass("checked");
                $(".xx"+_index).show().siblings().hide();



            })

        })




    </script>
@endsection
