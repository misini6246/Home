@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>我的订单</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <link rel="stylesheet" type="text/css" href="/user/wodedingdan.css"/>
    <!--layer-->
    {{--<link rel="stylesheet" type="text/css" href="/user/layer/layer.css" />--}}

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/placeholderfriend.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/user/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="/user/img/详情页_01.png"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="/user/img/right_03.png"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的今瑜e药网</a><img
                        src="/user/img/right_03.png" class="right_icon"/><span>我的订单</span>
            </div>
            {{--@include('user_layout.user_left')--}}
            @include('user.left')
            <div class="right">
                <div class="right_top">
                    <div class="right_top_title">
                        <img src="/new_gwc/jiesuan_img/椭圆.png">
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
                                    <img src="/pyzq/img/icon_42.jpg"/>
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
                                    @if(strpos($v->shipping_name,'今瑜直配')!==false&&$v->shipping_status>=3&&$v->add_time>=strtotime(20180401))
                                        &nbsp;<a style="color: #FF6102" target="_blank"
                                                 href="{{route('member.order.wlxx',['id'=>$v->order_id])}}">物流跟踪</a>
                                    @elseif(strpos($v->shipping_name,'成都万联国通物流有限公司')!==false&&$v->add_time>=strtotime(20180719)&&!empty($v->invoice_no))
                                        &nbsp;<a style="color: #FF6102" target="_blank"
                                                 href="{{route('member.order.guotong',['id'=>$v->order_id])}}">物流跟踪</a>
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
                                       @if ($v->is_sync==1 && $v->fanli==1 && $v->is_mhj !=1&&$v->goods_amount>=500)
                                       <a style="color:#00a1e9;display:block;" class="confirm" data-id="{{$v->order_id}}">确认收货</a>
                                    @endif
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

    <!--主体内容结束-->

    <!--footer-->
    <!--/footer-->
    @include('layouts.new_footer')
    <script type="text/javascript">
    // 订单返利
    $('.confirm').click(function(){
            var order_id=$(this).attr('data-id');
            $.ajax({
                url:'/user/rebate',
                data:{id:order_id},
                dataType:'JSON',
                success: function(res) {
                    console.log(res)
                    if(res.jine!=undefined){
                        layer.alert('已确认收货，该笔订单返利'+res.jine+'元')
                    }else{
                        layer.alert('已确认收货，未返利')
                    }
                    $(this).remove();
                }
            })
        })
        /**
         * searchEvent 初始化搜索功能
         * 参数1 获取数据方法
         * 参数2 回调方法
         * 参数3 按钮元素(执行搜索)(可选)
         * 参数4 搜索结果列表显示或隐藏的回调  返回true/false(可选)
         */
        $('.search').searchEvent(
            function(_target, _val) { //获取数据方法 val:搜索框内输入的值
                var data = [
                ]
                /**
                 * searchDataShow 将数据渲染至页面
                 * 参数1:数据数组
                 * 参数2:数据数组内下标名
                 */
                _target.searchDataShow(data, 'value')
            },
            function(val) { //回调方法 val:返回选中的值
                alert('搜索关键词"' + val + '"...');
            },
            $('.search-btn')
        );
        //返回顶部
        $('.btn-top').click(function() {
            $('html,body').animate({
                'scrollTop': 0
            })
        });
    </script>

@endsection
