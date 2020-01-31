@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('new/css/index.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/cart.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/confirm_order.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/shopping_flow.js')}}"></script>
    <style>
        .table7 tr td {
            width: 20%;
        }

        .table7 tr td .check {
            display: none;
        }

        .table7 tr td .check-bg {
            display: block;
        }

        .zengpin {
            /*border: 1px solid red;*/
            height: 29px;
            line-height: 29px;
            overflow: hidden;
        }

        .zengpin span {
            /*display: inline-block;*/
            /*border: 1px solid red;*/
            text-align: center;
            float: left;
            border-top: 1px solid transparent;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: middle;
            color: #666666;
        }

        .zengpin .biaoshi {
            width: 29px;
            margin-left: 10px;
            height: 14px;
            line-height: 14px;
            text-align: center;
            border: 1px solid #fb9c31;
            background: #ffebd4;
            color: #fb9c31;
            border-radius: 3px;
            margin: 8px 5px 0 20px;
        }

        .zengpin .name {
            width: 190px;
            text-align: left;
            padding-left: 17px;
        }

        .zengpin .changjia {
            width: 220px;
            text-align: left;
            *width: 210px;
        }

        .zengpin .guige {
            width: 120px;
            *width: 140px;
        }

        .zengpin .xiaoqi {
            width: 140px;
            *width: 125px;
        }

        .zengpin .zhunzi {
            width: 154px;
            *width: 180px;
        }

        .zengpin .danjia {
            width: 75px;
        }

        .zengpin .shuliang {
            width: 60px;
            margin-left: 20px;
            *margin-left: 35px;
            color: red;
        }

        .zengpin .xiaoji {
            width: 75px;
            /**width: 60px;*/
            color: black;
        }

        .zengpin .sl {
            width: 60px;
            *width: 30px;
        }
    </style>
@endsection
@section('content')
    @include('layout.page_header_cart')
    <form action="{{route('cart/order')}}" method="post" name="theForm" id="theForm">
        <div class="content_1">
            <div class="content_1_top">
                <div class="left"><h3>确认订单信息</h3></div>
                <div class="right"> 四川满 <span class="text">800</span> 元即可免运费</div>
            </div>
            <table class="table1" cellpadding="0" cellspacing="0">
                <tr style="background-color: #f5f5f5">
                    <th colspan="5">商品列表</th>
                    <th colspan="4"><a href="{{route('cart.index')}}">返回修改购物车 </a></th>
                </tr>
                <tr class="title">
                    <td class="tb1_td1">商品名称</td>
                    <td class="tb1_td2">生产厂家</td>
                    <td class="tb1_td3">药品规格</td>
                    <td class="tb1_td4" style="width: 100px;">效期</td>
                    <td class="tb1_td9" style="width: 130px;">国药准字</td>
                    <td class="tb1_td5">建议零售价</td>
                    <td class="tb1_td6">单价</td>
                    <td class="tb1_td7"> 数量</td>
                    <td class="tb1_td8">小计</td>
                </tr>
                @foreach($goods_list as $v)
                    <tr>
                        <td class="tb1_td1">
                    <span class="small_img">
                        <a href="{{$v->goods->goods_url}}" target="_blank"><img src="{{$v->goods->goods_thumb}}"
                                                                                title="{{$v->goods->goods_name}}"/></a>
                    </span>
                            <span class="txt">{{$v->goods->goods_name}}</span>
                        </td>
                        <td class="tb1_td2" style="width: 120px;">

                            <span class="txt">{{$v->goods->sccj}}</span>
                        </td>
                        <td class="tb1_td3">

                            <span class="txt">{{$v->goods->spgg}}</span>
                        </td>

                        <td class="tb1_td4">

                            <span class="txt"
                                  @if($v->goods->is_xq_red==1) style="color:#e70000;" @endif>{{$v->goods->xq}}</span>
                        </td>
                        <td class="tb1_td9">

                            <span class="txt">{{$v->goods->gyzz}}</span>
                        </td>
                        <td class="tb1_td5">{{formated_price($v->goods->market_price)}}</td>
                        <td class="price tb1_td6">{{formated_price($v->goods->real_price)}}</td>
                        <td class="tb1_td7">{{$v->goods_number}}</td>
                        <td class="tb1_td8">{{formated_price($v->goods->real_price*$v->goods_number)}}</td>
                    </tr>
                    @if($v->goods->is_zx==1&&count($v->child)>0)
                        @foreach($v->child as $child)
                            <tr class="td-tip">
                                <td colspan="9">
                                    <div class="zengpin">
                                        <span class="biaoshi">赠品</span>
                                        <span class="name">{{$child->zp_goods->goods_name}}</span>
                                        <span class="changjia">{{$child->zp_goods->product_name}}</span>
                                        <span class="guige">{{$child->zp_goods->ypgg}}</span>
                                        <span class="xiaoqi"></span>
                                        <span class="zhunzi"></span>
                                        <span class="danjia"></span>
                                        <span class="shuliang">{{formated_price($child->goods_price)}}</span>
                                        <span class="sl">{{$child->goods_number}}</span>
                                        <span class="xiaoji">{{formated_price($child->goods_price*$child->goods_number)}}</span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endforeach
            </table>


        @if(count($hg_goods)>0)
            @foreach($hg_goods as $v)
                {{--<div class="huangou fn_clear" style="width:1200px;border:1px solid #e5e5e5;margin-bottom:20px;min-height: 200px;";>--}}
                {{--<h3 style="height:34px;line-height:34px;font-size:12px;color:#1a1a1a;text-indent:18px;background-color:#f5f5f5;border-bottom:1px solid #e5e5e5;">下单送</h3>--}}
                {{--<div class="huangou-box">--}}
                {{--@if($hg_type==1)--}}
                {{--<div class="tip-left" style="width:540px;float:left;padding:50px 0 0 30px;">--}}
                {{--<div style="float:left;width:75px;height:32px;color:#02ad0a;font-weight:bold;font-size:14px;">温馨提示：</div>--}}
                {{--<div style="float:left;width:250px;">--}}
                {{--<p style="margin-bottom:10px;font-size:14px;">您已购买复方甘草片 <span style="color:#fd0303;font-size:14px;">{{$v->num}}瓶</span> ，已享受</p>--}}
                {{--<p style="margin-bottom:10px;font-size:14px;"><span style="color:#fd0303;font-size:14px;">{{$v->hg_goods_price*$v->hg_goods_number}}元</span>换购复方丹参肠溶胶囊<span style="color:#fd0303;font-size:14px;">{{$v->hg_goods_number}}盒</span>。</p>--}}
                {{--<p style="color:#fd0303;font-size:14px;">含有换购商品订单需现款支付</p>--}}

                {{--</div>--}}


                {{--</div>--}}
                {{--@else--}}
                {{--<div class="tip-left" style="width:540px;float:left;padding:50px 0 0 30px;">--}}
                {{--<div style="float:left;width:75px;height:32px;color:#02ad0a;font-weight:bold;font-size:14px;">温馨提示：</div>--}}
                {{--<div style="float:left;width:250px;">--}}
                {{--<p style="margin-bottom:10px;font-size:14px;">您的单笔订单已满<span style="color:#fd0303;font-size:14px;">{{$v->num}}元</span> ，已享受</p>--}}
                {{--<p style="margin-bottom:10px;font-size:14px;"><span style="color:#fd0303;font-size:14px;">{{$v->hg_goods_price*$v->hg_goods_number}}元</span>换购{{$v->goods->goods_name}}<span style="color:#fd0303;font-size:14px;">{{$v->hg_goods_number}}盒</span>。</p>--}}
                {{--<p style="color:#fd0303;font-size:14px;">含有换购商品订单需现款支付</p>--}}

                {{--</div>--}}


                {{--</div>--}}

                {{--@endif--}}
                {{--<div class="tip-mid" style="width:150px;float:left;">--}}
                {{--<img src="{{($v->goods->goods_img)}}" alt="" style="width:120px;height:120px;border:1px solid #e5e5e5;margin-top:20px;" />--}}

                {{--</div>--}}
                {{--<div class="tip-right" style="width:142px;text-align:center;margin-top:30px;float:left;">--}}
                {{--<p style="margin-bottom:15px;">{{$v->hg_goods_name}}</p>--}}
                {{--<p style="margin-bottom:20px;">{{$v->spgg}}</p>--}}
                {{--@if(!empty($v->goods->xq))--}}
                {{--<p style="margin-bottom:20px;">效期：{{$v->goods->xq}}</p>--}}
                {{--@endif--}}
                {{--<p style="margin-bottom:20px;color:#39a817">{{$v->hg_goods_price*$v->hg_goods_number}}元换购{{$v->hg_goods_number}}盒</p>--}}
                {{--<p>是否换购:--}}
                {{--<label style="margin-right:10px;color:#fe0101"><input id="hg_true" name="huangou" type="radio"  value="1" onclick="if(!confirm('若原订单中含有换购商品,原商品将会被删除!')){--}}
                {{--return false;--}}
                {{--};hg_check(true,{{$surplus}})"/>是 </label>--}}
                {{--<label style="color:#fe0101"><input id="hg_false" name="huangou" type="radio" value="0" checked=true onclick="hg_check(false,{{$surplus}})"/>否</label>--}}
                {{--<input type="hidden" id="hg_amount" value="{{$v->hg_goods_price*$v->hg_goods_number}}"/>--}}
                {{--</p>--}}

                {{--</div>--}}

                {{--</div>--}}

                {{--</div>--}}
            @endforeach
        @endif

        <!-- 礼品列表 start -->
            @if(count($gifts)>0)
                <dl class="gift fn_clear" style="border: 1px solid #e5e5e5;width: 1196px;;">
                    <dt style="background-color: #f5f5f5">礼品列表</dt>
                    <dt style="border: none;color:#e70000">您的订单已达到精品专区买赠金额，可点击换取以下任意一款礼品，也可选择最后一个累积积分换取大礼：</dt>
                    @foreach($gifts as $v)
                        <dd>
                            <img src="{{get_img_path($v->img)}}" alt="{{$v->gift_name}}"/>
                            <p>
                                <input type="radio" name="gift" id="gift" value="{{$v->gift_name}}"/>{{$v->gift_name}}
                            </p>
                        </dd>
                @endforeach
                <!-- 累计积分 -->
                    <dd>
                        <img src="{{path('images/lj_points.jpg')}}" alt="累计本次精品积分"/>
                        <p>
                            <input type="radio" name="gift" id="gift" value="累计积分"/>累计本次精品积分
                        </p>
                    </dd>
                </dl>
            @endif
            <input type="hidden" name="gift_status" id="gift_staus" value="     @if(count($gifts)>0) 1 @endif"/>
            <input type="hidden" name="gift_lj_jf" value="{{$jp_amount}}"/> <!-- 累计积分 -->
            @if($pack_fee>0||count($yhq_list)>0||(isset($jf_money)&&$jf_money>0))
                <div class="youhuiquan-box"
                     style="width:1194px;margin:0 auto 10px auto;border:1px solid #e5e5e5;overflow:hidden;">
                    <h3 style="height: 36px;line-height: 36px;text-indent: 20px;text-align: left;border-bottom: 1px solid #e5e5e5;position: relative;background-color:#f5f5f5;">
                        可用优惠券</h3>
                    <div class="xinxi-box" style="padding:10px 20px;">
                        <p style="border-bottom:1px solid #e5e5e5;padding-bottom:10px;font-size: 16px;color: #e70000">
                            此订单商品总金额：<span
                                    style="color:#e70000;font-size: 16px;">{{formated_price($goods_amount)}}</span>，
                            {{--此订单可参与优惠券金额（不含麻黄碱、血液制品及秒杀商品）：<span--}}
                            {{$yhq_tip}}：<span
                                    style="color:#e70000;font-size: 16px;">{{formated_price($ty_amount)}}</span>
                            <a style="padding: 5px 10px;color:#fff;background-color: #39A817;margin-left: 100px;border-radius: 5px;"
                               href="{{route('index')}}">继续购物 </a>
                        </p>
                        @if(isset($jf_money)&&$jf_money>0)
                            <p style="padding: 10px 0">
                            <span class="title" style="font-size: 16px;">  使用积分金币：
                                <input name="jf_money" type="hidden" class="text" id="jf_money" size="10"
                                       value="{{$jf_money}}"/></span>
                                <span class="price jf_money"
                                      style="font-size: 16px;">{{formated_price($jf_money)}}</span>
                                （<span class="title" style="font-size: 16px;"> 当前积分金币：</span>
                                <span class="price" id="user_jf_money"
                                      style="font-size: 16px;">{{formated_price($user->jf_money->money)}}</span>）
                            </p>
                        @endif
                        @if(count($yhq_list)>0)
                            <div style="padding-top:10px;padding-bottom:10px;">
                                    <span style="color:#3a3a3a;font-weight:bold;font-size: 16px;">
                                        {{--请<span style="color:#e70000;font-size: 16px;">点击</span>选择要使用的优惠券：--}}
                                        根据优惠券使用规则，系统已自动为您选取可使用优惠券：
                                    </span>
                                <a target="_blank"
                                   style="padding: 5px 10px;color:#fff;background-color: #39A817;margin-left: 100px;border-radius: 5px;"
                                   href="{{route('user.youhuiq')}}">查看优惠券 </a>
                                {{--<a target="_blank" style="padding: 5px 10px;color:#fff;background-color: #39A817;margin-left: 10px;border-radius: 5px;" href="/znq.html#gz">查看优惠券使用规则 </a>--}}
                                {{--（<span style="color:#e70000">“□”标记的可供选择</span>）--}}
                            </div>
                            @if(isset($yhq_list[0])&&$pack_fee==0)
                                <div class="flq">
                                    <div class="title" style="border-bottom:1px solid #adadad;height:18px;">
                                        <span><img style="width:70px;height:18px;"
                                                   src="{{get_img_path('images/ganenquan01.jpg')}}" alt=""/></span>
                                    </div>
                                    <ul class="fn_clear" style="width:1300px;">
                                        @foreach($yhq_list[0] as $k=>$v)
                                            @if($k<5)
                                                <li style="width:204px;height:120px;position:relative;float:left;margin:20px 28px 0 0;cursor: pointer;"
                                                    union_type="1"
                                                    je="{{$v->je}}" min_je="{{$v->min_je}}">
                                                    <p style="color:#e70000;font-size: 16px;">@if($v->is_can_use_yhq==1)
                                                            &nbsp; @else不满足使用条件@endif</p>
                                                    <img src="@if($v->is_can_use_yhq==1){{get_img_path('images/ganenquan02.jpg')}}@else{{get_img_path('images/pc-yhq-016.jpg')}}@endif"
                                                         alt="" style="width:208px;height:94px;"/>
                                                    <span style="width:12px;height:11px;border:1px solid #898989;right:8px;top:34px;position:absolute;background-color:#fff;border-radius:2px;"></span>
                                                    <p style="position:absolute;left:35px;top:28px;color:#fff;font-size:40px;">{{intval($v->je)}}</p>
                                                    <p style="position:absolute;left:96px;top:50px;color:#fff;">
                                                        【满{{intval($v->min_je)}}可用】</p>
                                                    <p style="position:absolute;left:0px;top:80px;color:#fffee3;width:100%;text-align:center;">@if($v->end-$v->start>3600*24)
                                                            限{{date('Y.m.d',$v->start)}}
                                                            -{{date('Y.m.d',$v->end - 1)}}@else
                                                            仅限{{date('Y.m.d',$v->start)}}@endif使用</p>
                                                    <div class="check check-bg yhq_bg_{{$v->yhq_id}}"
                                                         style="width:208px;height:120px;position:absolute;left:0;top:22px;background:url('{{get_img_path('images/keyongyouhuiquan01-ck.png')}}') no-repeat;
                                                         @if($v->use==0)
                                                                 display: none;
                                                         @endif">
                                                    </div>
                                                    <input type="hidden" name="yhq_id[]" class="yhq_id_1"
                                                           value="{{$v->use}}"
                                                           id="yhq_id_{{$v->yhq_id}}"/>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                        @if(count($yhq_list)>0)
                            @if(isset($yhq_list[1]))
                                <div class="flq">
                                    <div class="title" style="border-bottom:1px solid #adadad;height:18px;">
                                        <span><img style="width:70px;height:18px;"
                                                   src="{{get_img_path('images/ganenquan01.jpg')}}" alt=""/></span>
                                    </div>
                                    <ul class="fn_clear" style="width:1300px;">
                                        @foreach($yhq_list[1] as $k=>$v)
                                            @if($k<5)
                                                <li style="width:204px;height:120px;position:relative;float:left;margin:20px 28px 0 0;cursor: pointer;"
                                                    union_type="1"
                                                    je="{{$v->je}}" min_je="{{$v->min_je}}">
                                                    <p style="color:#e70000;font-size: 16px;">@if($v->is_can_use_yhq==1)
                                                            &nbsp; @else不满足使用条件@endif</p>
                                                    <img src="@if($v->is_can_use_yhq==1){{get_img_path('images/ganenquan02.jpg')}}@else{{get_img_path('images/pc-yhq-016.jpg')}}@endif"
                                                         alt="" style="width:208px;height:94px;"/>
                                                    <span style="width:12px;height:11px;border:1px solid #898989;right:8px;top:34px;position:absolute;background-color:#fff;border-radius:2px;"></span>
                                                    <p style="position:absolute;left:30px;top:40px;color:#fff;font-size:24px;">{{intval($v->je)}}</p>
                                                    <p style="position:absolute;left:95px;top:50px;color:#fff;">
                                                        【{{$v->yhq_cate->title}}】</p>
                                                    <p style="position:absolute;left:0px;top:80px;color:#fffee3;width:100%;text-align:center;">@if($v->end-$v->start>3600*24)
                                                            限{{date('Y.m.d',$v->start)}}
                                                            -{{date('Y.m.d',$v->end - 1)}}@else
                                                            仅限{{date('Y.m.d',$v->start)}}@endif使用</p>
                                                    {{--<p style="position:absolute;left:0px;top:80px;color:#fffee3;width:100%;text-align:center;">--}}
                                                    {{--仅限2017.07.26使用</p>--}}
                                                    <div class="check check-bg yhq_bg_{{$v->yhq_id}}"
                                                         style="width:208px;height:120px;position:absolute;left:0;top:22px;background:url('{{get_img_path('images/keyongyouhuiquan01-ck.png')}}') no-repeat;
                                                         @if($v->use==0)
                                                                 display: none;
                                                         @endif">
                                                    </div>
                                                    <input type="hidden" name="yhq_id[]" class="yhq_id_1"
                                                           value="{{$v->use}}"
                                                           id="yhq_id_{{$v->yhq_id}}"/>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                        @if(count($yhq_list)>0)
                            @if(isset($yhq_list[2]))
                                <div class="jfq">
                                    <div class="title" style="border-bottom:1px solid #adadad;;height:18px;">
                                        {{--<span><img style="width:70px;height:18px;" src="{{get_img_path('images/pc-yhq-011.jpg')}}" alt="" /></span>--}}
                                        <span><img style="width:70px;height:18px;"
                                                   src="{{get_img_path('images/ganenquan01.jpg')}}" alt=""/></span>
                                    </div>
                                    <ul class="fn_clear" style="width:1300px;">
                                        @foreach($yhq_list[2] as $k=>$v)
                                            @if($k<5)
                                                <li style="width:204px;height:120px;position:relative;float:left;margin:20px 28px 0 0;cursor: pointer;"
                                                    union_type="2"
                                                    @if($v->is_can_use_yhq==1)
                                                    class="kysy"
                                                    @endif je="{{$v->je}}" min_je="{{$v->min_je}}">
                                                    <p style="color:#e70000;font-size: 16px;">@if($v->is_can_use_yhq==1)
                                                            &nbsp; @else不满足使用条件@endif</p>
                                                    <img src="@if($v->is_can_use_yhq==1){{get_img_path('images/ganenquan02.jpg')}}@else{{get_img_path('images/pc-yhq-016.jpg')}}@endif"
                                                         alt="" style="width:208px;height:94px;"/>
                                                    <span style="width:12px;height:11px;border:1px solid #898989;right:8px;top:34px;position:absolute;background-color:#fff;border-radius:2px;"></span>
                                                    <p style="position:absolute;left:30px;top:28px;color:#fff;font-size:40px;">{{intval($v->je)}}</p>
                                                    <p style="position:absolute;left:96px;top:50px;color:#fff;">
                                                        【满{{intval($v->min_je)}}可用】</p>
                                                    <p style="position:absolute;left:0px;top:80px;color:#fffee3;width:100%;text-align:center;">@if($v->end-$v->start>3600*24)
                                                            限{{date('Y.m.d',$v->start)}}
                                                            -{{date('Y.m.d',$v->end - 1)}}@else
                                                            仅限{{date('Y.m.d',$v->start)}}@endif使用</p>
                                                    <div class="check check-bg yhq_bg_{{$v->yhq_id}}"
                                                         style="width:208px;height:120px;position:absolute;left:0;top:22px;background:url('{{get_img_path('images/keyongyouhuiquan01-ck.png')}}') no-repeat;
                                                         @if($v->use==0)
                                                                 display: none;
                                                         @endif">
                                                    </div>
                                                    <input type="hidden" name="yhq_id[]" class="yhq_id_2"
                                                           value="{{$v->use}}"
                                                           id="yhq_id_{{$v->yhq_id}}"/>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif


                    </div>


                </div>
            @endif
            {{--<!-- 礼品列表 end -->--}}
            <table class="table22" cellpadding="0" cellspacing="0" style="margin-top: 10px;">
                {{--<tr>--}}
                {{--<th colspan="2">收货人信息<a href="{{route('address.edit')}}">修改</a></th>--}}
                {{--</tr>--}}
                <tr>
                    <td class="tb22_td12"><img src="{{path('images/confirm4.png')}}" alt=""/></td>
                    <td class="tb22_td22">
                        <p class="address">
                            <input type="radio" name="address_id" value="{{$address->address_id}}" checked="checked"/>
                            <span class="country">
						中国
						</span>
                            <span class="province">
					    {{$province->region_name}}
						</span>
                            <span class="city">
					    {{$city->region_name}}
						</span>
                            @if(isset($district->region_name))
                                <span class="district">
                                {{$district->region_name}}
                                </span>
                            @endif
                            <span class="adds">{{$address->address}}</span> （ <span
                                    class="name">{{$address->consignee}}</span> <span>收</span>)
                        </p>
                        <p class="msg">
                            <span class="title_name">手机：</span> <span class="text">{{$address->tel}}</span>
                            <span class="title_name">电子邮件地址：</span> <span class="text">{{$address->email}}</span>
                            @if($address->zipcode)<span class="title_name">邮政编码：</span> <span
                                    class="text">{{$address->zipcode}}</span>@endif
                            @if($address->mobile)<span class="title_name">电话：</span> <span
                                    class="text">{{$address->mobile}}</span>@endif
                            @if($address->best_time)<span class="title_name">最佳送货时间：</span> <span
                                    class="text">{{$address->best_time}}</span>@endif
                        </p>
                    </td>
                </tr>
            </table>
            <table class="table3" cellpadding="0" cellspacing="0" id="shippingTable">
                <tr>
                    <th><p style="background-color: #f5f5f5">配送方式</p></th>
                </tr>
                <tr>
                    <td class="sel">
                        @if($user->shipping_id!=0)
                            <span class="name">物流：<span class="text">{{$user->shipping_name}}</span></span>
                            @if($user->wl_dh!='')
                                <span class="name">物流电话：<span class="text">{{$user->wl_dh}}</span></span>
                            @endif
                            <input type="hidden" name="shipping_id" value="{{$user->shipping_id}}"/>
                            <input type="hidden" name="ps_wl" id="ps_wl" value="{{$user->shipping_name}}"/>
                            <input type="hidden" name="ps_dh" id="ps_dh" value="{{$user->wl_dh}}"/>
                            <input type="hidden" name="shipping" value="{{$user->shipping_id}}" checked="checked"/>
                        @else
                            <p class="ways">
                                {{--循环配送方式--}}
                                @foreach($shipping as $k=>$v)
                                    @if($v->shipping_id==9)
                                        <label for="list{{$k}}"><input name="shipping" type="radio"
                                                                       value="{{$v->shipping_id}}"
                                                                       supportCod="{{$v->support_cod or ''}}"
                                                                       insure="{{$v->insure or ''}}"
                                                                       onclick="selectShipping(this)"
                                                                       id="ps_{{$k}}"/>{{$v->shipping_name}}
                                            <select name="area_name" id="area_name">
                                                <option value='0'>请选择...</option>
                                                <option value='都江堰'>都江堰</option>
                                                <option value='邛崃'>邛崃</option>
                                                <option value='金堂'>金堂</option>
                                                <option value='双流'>双流</option>
                                                <option value='简阳'>简阳</option>
                                                <option value='郫县'>郫县</option>

                                                <option value='新津'>新津</option>

                                                <option value='仁寿'>仁寿</option>
                                                <option value='新都'>新都</option>
                                                <option value='彭州'>彭州</option>
                                                <option value='什邡'>什邡</option>
                                                <option value='绵阳'>绵阳</option>
                                                <option value='德阳'>德阳</option>
                                                <option value='温江'>温江</option>
                                                <option value='青白江'>青白江</option>
                                                <option value='宜宾'>宜宾</option>
                                                {{--<option value='江油' >江油</option>--}}
                                            </select>
                                        </label>
                                    @elseif($v->shipping_id==13)
                                        <label for="list{{$k}}"><input name="shipping" type="radio"
                                                                       value="{{$v->shipping_id}}"
                                                                       supportCod="{{$v->support_cod or ''}}"
                                                                       insure="{{$v->insure or ''}}"
                                                                       onclick="selectShipping(this)"/>{{$v->shipping_name}}
                                            <select name="kf_name" id="kf_name">
                                                <option value='郫县库房'>郫县库房</option>
                                            </select>
                                        </label>
                                    @else
                                        <label for="list{{$k}}" title="{{$v->shipping_name}}"
                                               alt="{{$v->shipping_name}}"><input name="shipping" type="radio"
                                                                                  value="{{$v->shipping_id}}"
                                                                                  @if($v->shipping_id==12)data-val="{$district_name}的配送区域为：{$zjs_townlist_str}"
                                                                                  @endif  supportCod="{{$v->support_cod or ''}}"
                                                                                  insure="{{$v->insure or ''}}"
                                                                                  onclick="selectShipping(this)"
                                                                                  id="ps_{{$k}}"
                                                                                  checked/>{{str_limit($v->shipping_name,20)}}@if($v->shipping_id==12)
                                                <a style="float:left;margin-left:10px;display:inline;font-family:'Microsoft yahei';font-weight:normal;color:#4E9249;"
                                                   href="http://www.hezongyy.com/upload/%E5%AE%85%E6%80%A5%E9%80%81%E6%9C%8D%E5%8A%A1%E5%8C%BA%E5%9F%9F%E8%A1%A8.xls">宅急送配送区域表</a>@endif
                                        </label>
                                    @endif
                                @endforeach
                                <label for="list6"><input name="shipping" type="radio" value="-1"
                                                          supportCod="{$shipping.support_cod}"
                                                          insure="{$shipping.insure}"
                                                          onclick="selectShipping(this)" id="qt"/>其它物流</label>
                            </p>
                        @endif
                        @if($user->shipping_id==0)
                            <p class="other" id="ps_fs">
                                <span class="title">物流公司名称:</span> <input type="text" name="ps_wl" class="texts"
                                                                          id="ps_wl"/>
                                <span class="title">物流电话:	</span> <input type="text" name="ps_dh" class="texts"
                                                                            id="ps_dh"/>
                            </p>
                        @endif
                        <p class="tip"><b>(温馨提示：请谨慎填写，配送方式填写后只能让客服修改，所有货物请在送货员在场时开箱验货再签收，如有破损及时联系客服人员，如未当面开箱验货，破损不予赔付，自行承担。)</b>
                        </p>
                    </td>
                </tr>
            </table>
            <table class="table5" cellpadding="0" cellspacing="0">
                <tr>
                    <th><p style="background-color: #f5f5f5">发票类型<span style="color: #e70000;margin-left: 10px;">(发票选择后只能由客服人员修改，如需修改请联系客服。)</span>
                        </p></th>
                </tr>
                <tr>
                    <td>
                        @if($order_num==0)
                            <p class="fn_clear" style="padding: 10px;">
                                <label>
                                    <input checked="checked" name="dzfp" value="0" type="radio">
                                    <span>增值税普通发票</span>
                                </label>
                            </p>
                            <p class="fn_clear" style="padding: 10px;">
                                <label>
                                    <input name="dzfp" value="2" type="radio">
                                    <span>增值税专用发票</span>
                                </label>
                                <span style="color: #e70000;">(如果选择了增值税专用发票，请下载开增值税专票需要信息，填好信息后打印盖上公章截图给客服人员。)</span>
                                <a href="/uploads/开增值税专票需要信息.doc"
                                   style="padding: 1px 10px;color:#fff;background-color: #39A817;margin-left: 30px;border-radius: 5px;">下载</a>
                            </p>
                        @else
                            @if($user->dzfp==2)增值税专用发票@elseif($user->dzfp==1)纸制发票@else增值税普通发票@endif
                            <input name="dzfp" value="{{$user->dzfp}}" type="hidden">
                        @endif
                    </td>
                </tr>
            </table>
            <table class="table5" cellpadding="0" cellspacing="0">
                <tr>
                    <th><p style="background-color: #f5f5f5">其他信息</p></th>
                </tr>
                <tr>
                    <td>
                        <textarea name="postscript" id="postscript" style="height: 35px;"></textarea>
                    </td>
                </tr>
            </table>
            <table class="table4" cellpadding="0" cellspacing="0">
                <tr>
                    <th><p style="background-color: #f5f5f5;width: 1196px;">支付方式</p></th>
                </tr>
                <tr>
                    <td class="tb4_td1">
                        <span class="title"> 商品总金额：</span><span id="total1"
                                                                class="price">{{formated_price($total)}}</span>
                        <span class="title"> 折扣金额：</span><span class="price">{{formated_price($discount)}}</span>
                        <span class="title"> 优惠金额：</span><span class="price">{{formated_price($zyzk)}}</span>

                    </td>


                </tr>
                @if($surplus==true)
                    <tr>
                        <td class="tb4_td2" style="padding-bottom: 10px;">
                            <span class="title">  使用余额：<input name="surplus" type="hidden" class="text" id="ECS_SURPLUS"
                                                              size="10" value="{{$surplus}}"/></span><span class="price"
                                                                                                           id="surplus">{{formated_price($surplus)}}</span>
                            （<span class="title"> 当前余额：</span><span class="price"
                                                                    id="J_surplus">{{formated_price($user->user_money)}}</span><span
                                    class="price" id="ECS_SURPLUS_NOTICE" class="notice"></span></span>）

                        </td>
                    </tr>
                @else
                    <input name="surplus" type="hidden" class="text" id="ECS_SURPLUS" size="10" value="0"/>
                @endif
                @if(isset($cz_money)&&$cz_money>0)
                    <tr>
                        <td class="tb4_td2" style="padding-bottom: 10px;">
                            <span class="title">  使用{{trans('common.cz_money')}}：</span><span class="price"
                                                                                              id="surplus">{{formated_price($cz_money)}}</span>
                            （<span class="title"> 当前{{trans('common.cz_money')}}：</span><span
                                    class="price">{{formated_price($user->cz_money->money)}}</span>）

                        </td>
                    </tr>
                @endif
                @if($order_amount>0)

                    @foreach($payment as $k=>$v)
                        <tr>
                            <td colspan="4" class="pay_way">
                                <p class="fn_clear" @if(count($payment)==($k+1)) style="margin-bottom: 10px;" @endif>
                                    <input type="radio" name="payment" value="{{$v->pay_id}}" @if($k==0) checked
                                           @endif  isCod="{{$v->is_cod}}" onclick="selectPayment(this)" id="ag_{{$k}}"/>
                                    @if($v->pay_name=='支付宝转账')
                                        <label for="ag_{{$k}}"><img alt="支付宝转账"
                                                                    src="{{get_img_path('images/zfbzz.jpg')}}"
                                                                    original="{{get_img_path('images/zfbzz.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                        <span class="tip_txt yinhang">转账成功后请及时联系客服人员确认</span>
                                    @elseif($v->pay_name=='财付通')
                                        <label for="ag_{{$k}}"><img src="{{path('images/cft.jpg')}}"
                                                                    original="{{path('images/cft.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                    @elseif($v->pay_name=='paypal')
                                        <label for="ag_{{$k}}"><img src="{{path('images/bank_paypal.jpg')}}"
                                                                    original="{{path('images/bank_paypal.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                    @elseif($v->pay_name=='银行汇款/转帐')
                                        <label for="ag_{{$k}}"><img alt="银行汇款/转帐" src="{{path('images/yhhk.jpg')}}"
                                                                    original="{{path('images/yhhk.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label><span
                                                class="tip_txt yinhang"><a href="/articleInfo?id=49" target="_blank">查看帐户</a></span>
                                    @elseif($v->pay_name=='余额支付')
                                        <label for="ag_{{$k}}"><img src="{{path('images/yezf.jpg')}}"
                                                                    original="{{path('images/yezf.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                    @elseif($v->pay_name=='货到付款')
                                        <label for="ag_{{$k}}"><img src="{{path('images/hdfk.jpg')}}"
                                                                    original="{{path('images/hdfk.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
{{--                                    @elseif($v->pay_name=='银联在线支付')--}}
{{--                                        <label for="ag_{{$k}}"><img alt="银联在线支付" src="{{path('images/yinlian01.jpg')}}"--}}
{{--                                                                    original="{{path('images/yinlian01.jpg')}}"--}}
{{--                                                                    title="{{$v->pay_name}}"></label>--}}
{{--                                        <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，单笔限额2万，单日限额5万</span>--}}
{{--                                    @elseif($v->pay_name=='农行在线支付')--}}
{{--                                        <label for="ag_{{$k}}"><img width='200' src="{{path('images/abcicon2.jpg')}}"--}}
{{--                                                                    original="{{path('images/abcicon2.jpg')}}"--}}
{{--                                                                    title="{{$v->pay_name}}"></label>--}}
{{--                                    @elseif($v->pay_name=='快捷支付')--}}
{{--                                        <label for="ag_{{$k}}"><img alt="快捷支付" src="{{get_img_path('images/xyyh.jpg')}}"--}}
{{--                                                                    original="{{get_img_path('images/xyyh.jpg')}}"--}}
{{--                                                                    title="{{$v->pay_name}}"></label>--}}
{{--                                        <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，<a--}}
{{--                                                    style="font-size:14px;font-weight:bold;color:#e70000 !important;"--}}
{{--                                                    href="/uploads/快捷支付支持银行列表.xlsx">支付方式及开通方式</a></span>--}}
                                    @elseif($v->pay_name=='微信扫码支付')
                                        <label for="ag_{{$k}}"><img alt="微信扫码支付"
                                                                    src="{{get_img_path('images/weixin.jpg')}}"
                                                                    original="{{get_img_path('images/xyyh.jpg')}}"
                                                                    title="{{$v->pay_name}}"></label>
                                        <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，<a target="_blank"
                                                                                        style="font-size:14px;font-weight:bold;color:#e70000 !important;"
                                                                                        href="https://kf.qq.com/touch/sappfaq/151210EJfUZZ151210qq2yUn.html?scene_id=kf1&platform=14">支付限额查看</a></span>
                                    @elseif($v->pay_name=='支付宝扫码支付')
                                        <label for="ag_{{$k}}"><img alt="支付宝扫码支付" src="{{get_img_path($v->pay_desc)}}"
                                                                    original="{{get_img_path($v->pay_desc)}}"
                                                                    title="{{$v->pay_name}}"></label>
                                        <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡</span>
                                    @else
                                        {{$v->pay_name}}
                                    @endif
                                </p>
                            </td>
                        </tr>
                    @endforeach
                @elseif($jnmj>0)
                    <tr>
                        <td class="tb4_td2" style="padding-bottom: 10px;">
                            <span class="title">  使用{{trans('common.jnmj')}}：<input name="jnmj" type="hidden"
                                                                                    class="text" id="ECS_SURPLUS"
                                                                                    size="10" value="{{$jnmj}}"/></span><span
                                    class="price">{{formated_price($jnmj)}}</span>
                            （<span class="title"> 当前{{trans('common.jnmj')}}：</span><span class="price"
                                                                                          id="J_surplus">{{formated_price($user_jnmj->jnmj_amount)}}</span><span
                                    class="price" id="ECS_SURPLUS_NOTICE" class="notice"></span></span>）

                        </td>
                    </tr>
                @else
                    <input name="payment" type="radio" value="7" checked="checked" style="display:none"/>
                @endif
            </table>
            <div id="ECS_ORDERTOTAL">
                <table class="table8" align="center" border="0" cellpadding="0">
                    <tr>
                        <th><p style="background-color: #f5f5f5">费用总计</p></th>
                    </tr>
                    <tr class="tb6_td1">
                        <td>
                            <p><span class="price" id="total" data="{{$total}}">{{formated_price($total)}}</span> <span
                                        class="title">商品总金额: </span></p>
                            <p @if($shipping_fee<=0) style="display: none;" @endif id='shipping_fee'><span
                                        class="price">{{formated_price($shipping_fee)}}</span><span class="title"><span
                                            style="color: #E70000">+</span>&nbsp;物流费用: </span></p>
                            <p><span class="price" id="discount">{{formated_price($discount)}}</span><span
                                        class="title"><span style="color: #E70000">-</span>&nbsp;折扣金额: </span></p>
                            <p><span class="price">{{formated_price($zyzk)}}</span><span class="title"><span
                                            style="color: #E70000">-</span>&nbsp;优惠金额: </span></p>
                            @if($jnmj>0)
                                <p><span class="price">{{formated_price($jnmj)}}</span><span class="title"><span
                                                style="color: #E70000">-</span>&nbsp;使用{{trans('common.jnmj')}}: </span>
                                </p>
                            @endif
                            @if(isset($jf_money)&&$jf_money>0)
                                <p><span class="price jf_money">{{formated_price($jf_money)}}</span><span class="title"><span
                                                style="color: #E70000">-</span>&nbsp;使用金币: </span></p>
                            @endif
                            @if(isset($cz_money)&&$cz_money>0)
                                <p><span class="price">{{formated_price($cz_money)}}</span><span class="title"
                                                                                                 style="width: 130px;"><span
                                                style="color: #E70000">-</span>&nbsp;使用{{trans('common.cz_money')}}
                                        : </span></p>
                            @endif
                            @if($surplus>0)
                                <p><span class="price" id="user_surplus"
                                         data="{{$surplus}}">{{formated_price($surplus)}}</span><span
                                            class="title"><span style="color: #E70000">-</span>&nbsp;使用余额: </span></p>
                            @endif
                            @if($pack_fee>0||count($yhq_list)>0)
                                <p><span class="price" id="pack_fee"
                                         data="{{$pack_fee}}">{{formated_price($pack_fee)}}</span><span
                                            class="title"><span style="color: #E70000">-</span>&nbsp;使用优惠券: </span></p>
                            @endif
                            @if(isset($czfl_message)&&!empty($czfl_message))
                                <p><span class="price" style="width: 50%;">{{$czfl_message}}</span><span
                                            class="title"><span style="color: #E70000"></span></span></p>
                            @endif
                            {{--@if(isset($jehg_message)&&!empty($jehg_message))--}}
                            {{--<p><span class="price" style="width: 50%;">{{$jehg_message}}</span><span class="title"><span style="color: #E70000"></span></span> </p>--}}
                            {{--@endif--}}
                        </td>
                    </tr>

                </table>
            </div>
            <table class="table6" cellpadding="0" cellspacing="0">
                <tr>
                    <td class="tb6_td2">
                        {{--<span style="color: red;margin-right: 80px;">提示：3.8日当天累计采购金额每满1000送券1张，活动结束后统一返到账户。</span>--}}
                        <span class="title subhide">应付款金额：</span> <span class="price subhide" id="amount"
                                                                        data="{{$order_amount}}">
                                    {{formated_price($order_amount)}}
                            </span>
                        <input type="submit" class="submit" value="提交订单>" id="tjdd"/>
                        <span style="color: #ef0000;display: none;font-size: 16px;" class="submit_txt" id="tjdd_text">订单正在提交中...</span>
                        <input type="hidden" id="your_surplus" value="{{$user->user_money}}">
                        <input type="hidden" id="total_amount" value="{{$order_amount}}">
                        {!! csrf_field() !!}
                    </td>
                </tr>
            </table>
        </div>
    </form>
    <input type="hidden" value="" id="tishi"/>
    <script type="text/javascript">
        $(function () {
            $('.td-tip').prev().children('td').css('border', 'none')
        })
    </script>
    <script>
        var goods_amount = {{$goods_amount}};
        var shipping_fee = {{$shipping_fee}};
        var zyzk = {{$zyzk}};
        var discount = {{$discount}};
        var surplus_yhq = {{$surplus}};
        var jnmj = {{$jnmj}};
        var pack_fee = {{$pack_fee}};
        var user_money = {{$user->user_money}};
        var new_pack_fee = pack_fee;
        var ty_amount = {{$ty_amount}};
        function hg_check(flag, surplus) {
            var total = parseFloat($('#total').attr('data'));
            var amount = parseFloat($('#amount').attr('data'));
            var hg_amount = parseFloat($('#hg_amount').val());
            var change_surplus = 0;
            if (flag == true) {
                if (surplus > 0) {//有使用余额
                    var user_money = parseFloat($('#your_surplus').val());
                    if (user_money > surplus) {
                        var new_surplus = Math.min(user_money, hg_amount + surplus);
                        change_surplus = new_surplus - surplus;
                        surplus = new_surplus;
                    }
                }
                total = total + hg_amount;
                amount = amount + hg_amount - change_surplus;
            }
            $('#total').html(price_format(total));
            $('#total1').html(price_format(total));
            $('#amount').html(price_format(amount));
            if (surplus > 0) {
                $('#user_surplus').html(price_format(surplus));
                $('#surplus').html(price_format(surplus));
            }
        }
        function price_format(money) {
            money = money.toFixed(2);
            if (money >= 0) {
                money = Math.abs(money).toFixed(2);
            }
            return '￥' + money;
        }

        function show_hide(yhq_id) {
            var show_hide = $(".yhq_bg_" + yhq_id).css('display')
            if (show_hide == 'none') {//未选中
                $("#yhq_id_" + yhq_id).val(0);
            }
        }

        /**
         * 判断优惠券
         */
        function check_sy_num(_obj, max_num, yhq_id) {
            show_hide(yhq_id);
            var new_surplus_yhq = 0;
            var order_amount = 0;
            //var sy_num = '{{$sy_num}}';
            var union_type = _obj.attr('union_type');
            //var check_num = $("input[type=checkbox]:checked").length;
            var union_num = 0;
            var id = parseInt($("#yhq_id_" + yhq_id).val());
            var je = parseInt(_obj.attr('je'));
            var min_je = parseInt(_obj.attr('min_je'));
            $("input[class=yhq_id_" + union_type + "]").each(function () {
                var val = parseInt($(this).val());
                if (val != 0) {
                    union_num++;
                }
            });
            if (id == 0) {
                if (union_type == 1) {
                    if (min_je >= ty_amount) {
                        var tishi = $('#tishi').val();
                        if (tishi != '') {
                            alert("已超出使用限额");
                        }
                        return false;
                    }
                }
                else if (union_num >= max_num) {
                    alert("该种优惠券最多使用" + max_num + "张");
                    return false;
                }
                $("#yhq_id_" + yhq_id).val(yhq_id);
                $(".yhq_bg_" + yhq_id).show();
                new_pack_fee += je;
                if (union_type == 1) {
                    ty_amount -= min_je
                }
            } else {
                $("#yhq_id_" + yhq_id).val(0);
                $(".yhq_bg_" + yhq_id).hide();
                new_pack_fee -= je;
                if (union_type == 1) {
                    ty_amount += min_je
                }
            }

            order_amount = amount(new_surplus_yhq);
            new_surplus_yhq = get_surplus(order_amount, new_surplus_yhq);
            order_amount = amount(new_surplus_yhq);
            $('#amount').html(price_format(order_amount));
            $('#pack_fee').html(price_format(new_pack_fee));
            $('#discount').html(price_format(discount));
            $('#user_surplus').html(price_format(new_surplus_yhq));
        }

        function amount(new_surplus_yhq) {
            return goods_amount + shipping_fee - zyzk - discount - new_surplus_yhq - jnmj - new_pack_fee
        }

        function get_surplus(order_amount, new_surplus_yhq) {
            if (surplus_yhq > 0) {
                return Math.min(user_money, order_amount);
            }
            return new_surplus_yhq;
        }
        $(function () {
            $('#theForm').submit(function () {

//                if(pack_fee>0&&new_pack_fee==0){//存在优惠券 但是未选择给予提示
//                    return confirm('您有可用优惠券未选择,确定提交订单吗?');
//                }
                $('#tjdd').hide();
                $('#tjdd_text').show();
                var flag = checkOrderForm(this);
                if (flag) {
                    $('#theForm').submit();
                } else {
                    $('#tjdd_text').hide();
                    $('#tjdd').show();

                    return false;
                }
                //$('#theForm').submit();
            });
            $('#tishi').val('');
            var len = $(".flq ul li").length;
            var liCollection = $(".flq ul li");
            $(".flq ul li").each(function (i) {
                liCollection.eq(i).click();
            })
            var len = $(".jfq ul .kysy").length;
            var liCollection = $(".jfq ul .kysy");
            $(".jfq ul .kysy").each(function (i) {
                if (i == 0) {
                    liCollection.eq(len - i - 1).click();
                }
            })
            $('#tishi').val('已超出使用限额');
            $('#hg_false').click();
        })
    </script>
    @include('common.footer',['hide_yc'=>1])
@endsection

