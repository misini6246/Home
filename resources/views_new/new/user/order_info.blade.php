@extends('layouts.app')

@section('title')
    <title>我的订单-订单详情</title>
    @endsection
    @section('links')
        <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
        <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
        <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
        <link rel="stylesheet" type="text/css" href="/user/dingdanxiangqing.css"/>
        <link rel="stylesheet" type="text/css" href="/user/pay.css"/>
        <!--layer-->
        <link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />

        <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
        <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
        <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
        <script src="/user/placeholderfriend.js" type="text/javascript" charset="utf-8"></script>
        <!--layer-->
        <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
        <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
        <style type="text/css">
            table tr th {
                text-align: center;
            }
        </style>
        @endsection

@section('content')
    <div class="big-container">
        <!--头部-->
       @include('layouts.header')
        <!--/头部-->

        <!--搜索导航-->
       @include('layouts.search')
        <!--/搜索导航-->

        <!--导航-->
        @include('layouts.nav')
        <!--/导航-->

        <!--主体内容开始-->
        <div class="container" id="user_center">
            <div class="container_box">
                <div class="top_title">
                    <img src="/user/img/详情页_01.png"/><span>当前位置：</span>
                    <a href="{{route('index')}}">首页</a><img src="/user/img/right_03.png"
                                                            class="right_icon"/><a
                            href="{{route('member.index')}}">我的今瑜e药网</a><img
                            src="/user/img/right_03.png" class="right_icon"/><span>订单详情</span>
                </div>
                @include('user.left')
                <div class="right">
                    <div class="right_title">
                        <img src="/new_gwc/jiesuan_img/椭圆.png"/>
                        <span>订单详情</span>
                    </div>
                    <div class="right_content">
                        <div class="zt_1">
                            <div class="f">
                                <span>订单编号：</span>
                                <span class="span_right">{{$info->order_sn}}</span>
                            </div>
                            <div class="f">
                                <span>下单时间：</span>
                                <span class="span_right">{{date('Y-m-d H:i:s',$info->add_time)}}</span>
                            </div>
                            <div class="f">
                                <span>订单状态：</span>
                                <span class="span_right zt">
                                @if($info->order_status==2)
                                        已取消
                                    @elseif($info->pay_status==0)
                                        待付款
                                        @if($info->is_mhj==2)
                                            (该订单含血液制品，请法人转款到公司对公账户！)
                                        @elseif($info->is_mhj==1&&$user->is_zhongduan==0)
                                            (按GSP要求，含麻品种必须公对公转账！)
                                        @endif
                                    @elseif($info->pay_status==2)
                                        已付款
                                    @else
                                        已确认
                                    @endif
                            </span>
                            </div>
                            <div class="f">
                                <span>订单跟踪：</span>
                                <span class="span_right">{{$info->ddgz->get('end')['time']}}
                                    &nbsp;&nbsp;&nbsp;{{$info->ddgz->get('end')['content']}}</span>
                                <span class="zhuizong">
									查看全部跟踪
                                    @include('user.genzong')
								</span>
                            </div>
                        </div>
                        <div class="zt_2">
                            <div class="zt_2_top">
                                <div class="zt_2_top_left">
                                    <div class="zt_2_title">
                                        费用总计
                                    </div>
                                    <ul>
                                        <li>
                                            <span>商品金额：</span>
                                            <span>{{formated_price($info->goods_amount)}}</span>
                                        </li>
                                        <li>
                                            <span>+ 运费：</span>
                                            <span>{{formated_price($info->shipping_fee)}}</span>
                                        </li>
                                        <li>
                                            <span>- 优惠券：</span>
                                            <span>{{formated_price($info->pack_fee)}}</span>
                                        </li>
                                        @if($info->money_paid>0)
                                            <li>
                                                <span>- 已付款金额：</span>
                                                <span>{{formated_price($info->money_paid)}}</span>
                                            </li>
                                        @endif
                                        @if($info->jf_money>0)
                                            <li>
                                                <span>- 积分金币：</span>
                                                <span>{{formated_price($info->jf_money)}}</span>
                                            </li>
                                        @endif
                                        @if($info->jnmj>0)
                                            <li>
                                                <span>- {{trans('common.jnmj')}}：</span>
                                                <span>{{formated_price($info->jnmj)}}</span>
                                            </li>
                                        @endif
                                        @if($info->cz_money>0)
                                            <li>
                                                <span>- {{trans('common.cz_money')}}：</span>
                                                <span>{{formated_price($info->cz_money)}}</span>
                                            </li>
                                        @endif
                                        <li>
                                            <span>- 使用余额：</span>
                                            <span>{{formated_price($info->surplus)}}</span>
                                            @if($info->jnmj==0&&$info->is_mhj==0&&$info->pay_xz==1&&$user->user_money>0)
                                                <span class="zhuijia" style="font-size: 12px;">
                                            <form style="display: inline-block"
                                                  action="{{route('member.order.update',['id'=>$info->order_id])}}"
                                                  method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="_method" value="put">
												追加使用：<input style="border: 1px solid #ccc;box-sizing: border-box"
                                                            type="text" value="0" name="surplus"/><input type="submit"
                                                                                                         name="" id=""
                                                                                                         value="确定"/>
                                                </form>
												<span class="keyong">可用余额：{{formated_price($user->user_money)}}</span>
											</span>
                                            @endif
                                        </li>
                                        <li>
                                            <span style="color: #ff2424">应付款金额：</span>
                                            <span style="color: #ff2424">{{formated_price($info->order_amount)}}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="zt_2_right">
                                    <div class="zt_2_title" style="height: 150px;">
                                        支付方式
                                        @if($info->pay_xz==1&&!($user->is_zhongduan==0&&$info->is_mhj==1)&&($info->order_status != 2 ))
                                            <p class="xz">选择支付方式：</p>
{{--                                            <a style="float: left;margin-right: 40px;">{!! $xyyh or '' !!}</a>--}}
                                            <a style="float: left;margin-right: 40px;">{!! $weixin or '' !!}</a>
                                            <a style="float: left;margin-right: 40px;position: relative;">{!! $alipay or '' !!}</a>
                                        @else
                                            <p class="xz">已选择支付方式：{{$info->pay_name}}</p>
                                        @endif
                                    </div>

                                    <div style="clear: both"></div>
                                    <p class="shuoming" style="float: right;margin: 0 25px 0 0;">
                                        <a target="_blank" href="/articleInfo?id=15">在线支付说明</a>
                                    </p>
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                            <div class="zt_2_bottom">
                                <div class="zt_2_top_left">
                                    <div class="zt_2_title">
                                        收货信息
                                    </div>
                                    <ul>
                                        <li>
                                            <span>收货人：</span>
                                            <span>{{$info->consignee}} （{{$info->tel or $info->mobile}}）</span>
                                        </li>
                                        <li>
                                            <span>收货地址：</span>
                                            <span>{{$info->region_name}} {{$info->address}}</span>
                                        </li>
                                        <li>
                                            <span>配送方式：</span>
                                            <span>{{$info->shipping_name}}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="zt_2_right">
                                    <div class="zt_2_title">
                                        发票信息
                                    </div>
                                    <ul>
                                        {{--@if($info->dzfp!=1)--}}
                                        {{--<li>--}}
                                        {{--<span>发票类型：</span>--}}
                                        {{--<span>电子发票</span>--}}
                                        {{--</li>--}}
                                        {{--@endif--}}
                                        <li>
                                            <span>发票类型：</span>
                                            <span>{{$info->dzfp_name}}</span>
                                        </li>
                                        {{--<li>--}}
                                        {{--<span>开票状态：</span>--}}
                                        {{--@if($info->order_status==1&&$info->shipping_status==1)--}}
                                        {{--<span>已开票</span>--}}
                                        {{--<a href="{{route('user.dzfp')}}">点击去查看</a>--}}
                                        {{--@else--}}
                                        {{--<span>未开票</span>--}}
                                        {{--@endif--}}
                                        {{--</li>--}}
                                    </ul>
                                </div>
                                <div style="clear: both;"></div>
                            </div>
                        </div>
                        <div class="spxx">
                            <div class="spxx_title">
                                <span>商品信息</span>
                                <span><a style="color: #3dbb2b"
                                         href="{{route('user.orderBuy',['id'=>$info->order_id])}}">全部加入购物车</a></span>
                            </div>
                            <table>
                                <tr>
                                    <th class="spbs">商品标识</th>
                                    <th class="spmc">商品名称</th>
                                    <th class="sccj">生产厂家</th>
                                    <th class="gg">规格</th>
                                    <th class="xq">效期</th>
                                    <th class="spdj">商品单价</th>
                                    <th class="sl">数量</th>
                                    <th class="xj">小计</th>
                                    <th class="cz">操作</th>
                                </tr>
                                @foreach($info->order_goods as $k=>$v)
                                    <tr @if($k>=10) style="display: none" class="xyyc" @endif>
                                        <td>
                                            @if($v->is_jp==1)
                                                <div class="spbs">
                                                    <span>精</span>
                                                </div>
                                            @elseif($v->zyzk>0)
                                                <div class="spbs">
                                                    <span>惠</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                                <div class="spmc">{{$v->goods_name}}</div>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="sccj">{{$v->sccj}}</div>
                                        </td>
                                        <td>
                                            <div class="gg">{{$v->ypgg}}</div>
                                        </td>
                                        <td>
                                            <div class="xq">{{$v->xq}}</div>
                                        </td>
                                        <td>
                                            <div class="spdj">{{formated_price($v->goods_price)}}</div>
                                        </td>
                                        <td>
                                            <div class="sl">{{$v->goods_number}}</div>
                                        </td>
                                        <td>
                                            <div class="xj">{{formated_price($v->goods_price*$v->goods_number)}}</div>
                                        </td>
                                        <td>
                                            <img style="display:none;" src="{{$v->goods_thumb}}"
                                                 class="fly_img{{$v->goods_id}}">
                                            <div class="cz fly_to_cart{{$v->goods_id}}"
                                                 onclick="tocart({{$v->goods_id}})"><img
                                                        src="/user/img/jrgwc.png"/></div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            @if(count($info->order_goods)>10)
                                <div class="zhankai true zk">
                                    <span>展开余下<span>{{count($info->order_goods) - 10}}</span>个商品</span>
                                    <img src="/pyzq/img/icon_42.jpg"/>
                                </div>
                                <div class="zhankai false sq" style="display: none">
                                    <span>收起商品信息</span>
                                    <img src="/pyzq/img/icon_43.jpg">
                                </div>
                            @endif
                            <div class="heji">
                                商品合计：<span>{{formated_price($info->goods_amount)}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both"></div>
            </div>

        </div>

        <!--主体内容结束-->

        <!--footer-->
       @include('layouts.new_footer')
        <!--/footer-->
        <script type="text/javascript">
            /**
             * searchEvent 初始化搜索功能
             * 参数1 获取数据方法
             * 参数2 回调方法
             * 参数3 按钮元素(执行搜索)(可选)
             * 参数4 搜索结果列表显示或隐藏的回调  返回true/false(可选)
             */
            $('.search').searchEvent(
                function(_target, _val) { //获取数据方法 val:搜索框内输入的值
                    $.get('/ajax/cart/searchKey',{keyword:_val},function(data){
                        _target.searchDataShow(data, 'value')
                    },'json');
                    /**
                     * searchDataShow 将数据渲染至页面
                     * 参数1:数据数组
                     * 参数2:数据数组内下标名
                     */
                },
                function(val) { //回调方法 val:返回选中的值
//                alert('搜索关键词"' + val + '"...');
                    window.location.href = "http://47.107.103.86/category?keywords="+val+"&showi=0";
                },
                $('.search-btn')
            );
            //返回顶部
            $('.btn-top').click(function() {
                $('html,body').animate({
                    'scrollTop': 0
                })
            });
			$('.zk').click(function () {
            $('.xyyc').show();
            $(this).hide();
            $('.sq').show();
        })
        $('.sq').click(function () {
            $('.xyyc').hide();
            $(this).hide();
            $('.zk').show();
        })
        </script>
    </div>

    @endsection


