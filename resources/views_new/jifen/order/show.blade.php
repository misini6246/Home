@extends('jifen.layouts.body')
@section('links')
    <link href="{{path('css/jifen/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jifen/dingdanxiangqing.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/jifen/lb.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('jifen.layouts.header')
    @include('jifen.layouts.nav')
    <!--container-->
    <div class="container content">
        <div class="content_box">
            <div class="top_title">
                <img src="{{get_img_path('images/jf/address_03.png')}}"/>
                <span>当前位置：<a href="{{route('jifen.index')}}">积分首页</a> > <a
                            href="{{route('jifen.user.index')}}">个人中心</a>> 订单详情</span>
            </div>
            <div class="vip">
                @include('jifen.layouts.user_menu')
                <div class="vip_right">
                    <div class="vip_right_title">
                        <img src="{{get_img_path('images/jf/dian_03.png')}}"/>
                        <span>订单详情</span>
                    </div>
                    <div class="xiangqing">
                        <div class="xiangqing_zt">
                            <ul class="ddbh">
                                <li>
                                    订单编号：<span>{{$info->order_sn}}</span>
                                </li>
                                <li>
                                    下单时间：<span>{{date('Y-m-d H:i:s',$info->add_time)}}</span>
                                </li>
                                {{--<li class="or">--}}
                                {{--物流状态：<span>已发货</span><span>圆通快递</span><span>快递单号：24522123365413</span>--}}
                                {{--</li>--}}
                            </ul>
                            <div class="ddzt">
                                <p class="ddzt_title">
                                    订单状态：
                                </p>
                                <p class="ddzt_result">
                                    {!! $info->order_state !!}
                                </p>
                            </div>
                        </div>
                        <div class="shdz">
                            <div class="shdz_title">
                                收货地址
                            </div>
                            <div class="shxx">
                                <div class="username">
                                    <img src="{{get_img_path('images/jf/user_icon.png')}}"/>
                                    <span>{{$info->address->name or ''}}</span>
                                </div>
                                <div class="user_phone">
                                    <img src="{{get_img_path('images/jf/phone_icon.png')}}"/>
                                    <span>{{$info->address->mob_phone or ''}}</span>
                                </div>
                                <div class="user_add">
                                    <img src="{{get_img_path('images/jf/add_icon.png')}}"/>
                                    <span>{{$info->address->address or ''}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="lpqd">
                            <div class="shdz_title">
                                礼品清单
                            </div>
                            <table>
                                <tr>
                                    <th class="lpxx">礼品信息</th>
                                    <th class="sl">数量</th>
                                    <th class="xj">小计</th>
                                </tr>
                                @foreach($info->goods as $goods)
                                    <tr>
                                        <td class="lpxx">
                                            <div class="img_box">
                                                <img src="{{get_img_path('jf/'.substr($goods->goods_image,1))}}"/>
                                            </div>
                                            <div class="text">
                                                {{$goods->goods_name}}
                                            </div>
                                        </td>
                                        <td class="sl">
                                            {{$goods->goods_num}}
                                        </td>
                                        <td class="xj">
                                            {{$goods->jf}}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="heji">
									<span class="lipin">
										共<span>{{count($info->goods)}}</span>个礼品
									</span>
                                <span class="jifen">
										积分合计：<span>{{$info->goods_amount}}</span>
									</span>
                            </div>
                        </div>
                    </div>
                </div>
                @include('jifen.layouts.wntj')
            </div>
        </div>
    </div>
    <!--container-->
    @include('jifen.layouts.footer')
@endsection
