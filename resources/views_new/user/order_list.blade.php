@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
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
        .right_top_search select{
            padding: 5px 0;
        }
    </style>
    <![endif]-->

@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>我的订单</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_top">
                    <div class="right_top_title">
                        <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                        <span>我的订单</span>
                    </div>
                    <ul class="right_top_title_nav">
                        <li @if($status==0) class="active" @endif>
                            <a style="display: inline-block;width: 100%;height: 100%;"
                               href="{{route('member.order.index',['dates'=>$dates])}}">全部订单</a>
                        </li>
                        <li @if($status==1) class="active" @endif>
                            <a style="display: inline-block;width: 100%;height: 100%;"
                               href="{{route('member.order.index',['status'=>1,'dates'=>$dates])}}">待付款
                                <span>{{$dfk}}</span>
                            </a>
                        </li>
                        <li @if($status==2) class="active" @endif>
                            <a style="display: inline-block;width: 100%;height: 100%;"
                               href="{{route('member.order.index',['status'=>2,'dates'=>$dates])}}">待收货
                                <span>{{$dsh}}</span>
                            </a>
                        </li>
                    </ul>
                    <form id="search_form" name="search_form" action="{{route('member.order.index')}}">
                        <div class="right_top_search">
                            <select name="dates">
                                <option @if($dates==1) selected @endif value="1">最近三个月</option>
                                <option @if($dates==2) selected @endif  value="2">今年内</option>
                                <option @if($dates==3) selected @endif  value="3">往年订单</option>
                            </select>
                            <input type="text" placeholder="订单编号" name="keys" class="num" id="num"
                                   value="{{$keys}}"/><input type="submit"
                                                             id="btn"
                                                             value="查询" onclick="$('input[name=page]').val(1)"/>
                        </div>
                    </form>
                </div>
                @if(count($result)>0)
                    <table>
                        <tr>
                            <th class="ddbs">订单标识</th>
                            <th class="ddh">订单号</th>
                            <th class="xdsj">下单时间</th>
                            <th class="shr">收货人</th>
                            <th class="zje">
                                <span>订单总金额</span>
                                {{--<img src="{{get_img_path('images/user/tishi_03.png')}}" title="这是提示信息"/>--}}
                            </th>
                            <th class="ddzt" style="width: 250px;">
                                <div>
                                    <span>{{$status_value or '订单状态'}}</span>
                                    <img src="{{get_img_path('images/user/xia.png')}}"/>
                                    <ul class="select_zt">
                                        <li>
                                            <a href="{{route('member.order.index',['dates'=>$dates,'status'=>1])}}">待付款</a>
                                        </li>
                                        <li>
                                            <a href="{{route('member.order.index',['dates'=>$dates,'status'=>2])}}">待收货</a>
                                        </li>
                                        <li>
                                            <a href="{{route('member.order.index',['dates'=>$dates,'status'=>3])}}">待发货</a>
                                        </li>
                                        <li>
                                            <a href="{{route('member.order.index',['dates'=>$dates,'status'=>4])}}">已完成</a>
                                        </li>
                                        <li>
                                            <a href="{{route('member.order.index',['dates'=>$dates,'status'=>5])}}">已取消</a>
                                        </li>
                                    </ul>
                                </div>
                            </th>
                            <th class="cz">操作</th>
                        </tr>
                        @foreach($result as $v)
                            <tr>
                                <td>
                                    @if($v->is_zq>0)
                                        <span class="fan">账</span>
                                    @elseif($v->is_separate==1)
                                        <span class="fan">货</span>
                                    @elseif($v->jnmj>0)
                                        <span class="fan">返</span>
                                    @endif
                                </td>
                                <td class="ddh"><a style="display: block;color: #e70000"
                                                   href="{{route('user.orderInfo',['id'=>$v->order_id])}}">{{$v->order_sn}}</a>
                                </td>
                                <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                                <td>{{$v->consignee}}</td>
                                <td class="zje">{{formated_price($v->goods_amount+$v->shipping_fee)}}</td>
                                <td>
                                    @if($v->order_status==2)
                                        <span>已取消</span>
                                    @elseif($v->pay_status==0)
                                        <span class="dfk">待付款</span>
                                    @else
                                        <span>已付款</span>
                                    @endif
                                    <span class="zhuizong">
										订单跟踪
                                        @include('user.genzong',['info'=>$v])
                                </span>
                                    @if(strpos($v->fhwl_m,'宅急送')!==false&&$v->shipping_status>=4)
                                        &nbsp;<a style="color: #FF6102" target="_blank"
                                                 href="{{route('zjs',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}">物流跟踪</a>
                                    @endif
                                </td>
                                <td>
                                    @if($v->pay_status==0&&$v->pay_xz==1&&$v->order_status=1)
                                        <a href="{{route('user.orderInfo',['id'=>$v->order_id])}}"
                                           class="cz">去付款</a>
                                    @elseif($v->pay_status==2&&$v->shipping_status==4&&$v->order_status==1)
                                        <form style="display: inline-block" id="{{$v->order_id}}form"
                                              action="{{route('member.order.update',['id'=>$v->order_id])}}"
                                              method="post">
                                            {!! csrf_field() !!}
                                            <input type="hidden" name="_method" value="put">
                                            <input type="hidden" name="act" value="qrsh">
                                            <a class="cz" onclick="$('#{{$v->order_id}}form').submit();">确认收货</a>
                                        </form>
                                    @else
                                        <a class="cz"
                                           href="{{route('user.orderBuy',['id'=>$v->order_id])}}">再次购买</a>
                                    @endif
                                    <a href="{{route('user.orderInfo',['id'=>$v->order_id])}}"
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
    @include('common.footer')
@endsection
