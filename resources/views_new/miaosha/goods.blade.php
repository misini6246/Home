@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>领券中心</title>
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/my_buy2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/my_buy.js')}}"></script>

@endsection
@section('content')
{{--    @include('layout.page_header')
    @include('layout.nav')--}}
    <div class="main fn_clear">
        <div class="top"><span class="title">今瑜医药</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.buyList')}}" class="end">>　<span>秒杀商品管理</span></a> </div>
        <div class="main_right1">
            <div class="top_title">
                <h3>秒杀商品管理</h3>
                <span class="ico"></span>
            </div>
            <table>
                <tr>
                    <th class="case1">商品名称</th>
                    <th class="case1">商品id</th>
                    <th class="case1">商品货号</th>
                    <th>商品组别</th>
                    <th>限购区域</th>
                    <th>规格</th>
                    <th>商品剩余库存</th>
                    <th>商品价格</th>
                    <th>商品限购数量</th>
                    <th>商品购物车中数量</th>
                    <th>商品订单中数量</th>


                </tr>

                @if(count($team)>0)
                    @foreach($team as $k=>$val)
                        @foreach($val->goods as $v)
                            <tr>
                                <td class="case1 tb1_td1" >{{$v->goods_name}}</td>
                                <td class="case1 tb1_td1" >{{$v->goods_id}}</td>
                                <td class="case1 tb1_td1" >{{$v->goods_sn}}</td>
                                <td   class="tb1_td2">{{$v->team}}</td>
                                <td   class="tb1_td2">{{$v->xg_tip}}</td>
                                <td   class="tb1_td2">{{$v->spgg}}</td>
                                <td  class="tb1_td3">{{$v->goods_number}}</td>
                                <td  class="tb1_td4">{{formated_price($v->real_price)}}</td>
                                <td  class="tb1_td5">{{$v->cart_number or 0}}</td>
                                <td  class="tb1_td5">{{$v->gwc or 0}}</td>
                                <td  class="tb1_td5">{{$v->ddsl or 0}}</td>

                            </tr>
                        @endforeach
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">暂无任何信息！</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
@endsection
