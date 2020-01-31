@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/cart.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/confirm_order.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/shopping_flow.js')}}"></script>
    <style>
        .table7 tr td{width: 20%;}
        .table7 tr td .check{display: none;}
        .table7 tr td .check-bg{display: block;}
    </style>
@endsection
@section('content')
    @include('layout.page_header_cart')
    <form action="{{route('cart/order')}}" method="post" name="theForm" id="theForm">
        <div class="content_1">
            <div class="content_1_top">
                <div class="left"><h3>确认订单信息</h3></div>
                <div class="right"> 全川满 <span class="text">800</span> 元即可免运费</div>
            </div>

            <table class="table1" cellpadding="0" cellspacing="0">
                <tr>
                    <th colspan="5">商品列表</th>
                    <th><a href="/cart">返回修改购物车 </a></th>
                </tr>
                <tr class="title">
                    <td  class="tb1_td1">商品名称</td>
                    <td  class="tb1_td2">商品信息</td>
                    <td  class="tb1_td3">建议零售价</td>
                    <td  class="tb1_td4">单价</td>
                    <td  class="tb1_td5"> 数量</td>
                    <td  class="tb1_td6">小计</td>
                </tr>
                @foreach($goods_list as $v)
                    <tr>
                        <td class="tb1_td1">
                    <span class="small_img">
                        <a href="{{$v->goods->goods_url}}" target="_blank"><img src="{{$v->goods->goods_thumb}}" title="{{str_limit($v->goods->goods_name,20)}}"/></a>
                    </span>
                            <span class="txt">{{str_limit($v->goods->goods_name,20)}}</span>
                        </td>
                        <td class="tb1_td2">
                            {{--@foreach($v->goods->goods_attr as $val)--}}
                            {{--@if($val->attr_id==1)--}}
                            {{--<p class="factory" alt="{{$val->attr_value}}" title="{{$val->attr_value}}">{{attribute()[$val->attr_id]}}： <span class="txt">{{str_limit($val->attr_value,20)}}</span></p>--}}
                            {{--@endif--}}
                            {{--@if($val->attr_id==3||$val->attr_id==4)--}}
                            {{--<p>{{attribute()[$val->attr_id]}}： <span class="txt">{{$val->attr_value}}</span></p>--}}
                            {{--@endif--}}
                            {{--@endforeach--}}
                            @if($v->goods->product_name)
                                <p>生产厂家：<span class="txt">{{$v->goods->product_name}}</span></p>
                            @endif
                            @if($v->goods->spgg)
                                <p>药品规格：<span class="txt">{{$v->goods->spgg}}</span></p>
                            @endif
                            @if($v->goods->gyzz)
                                <p>批准文号：<span class="txt">{{$v->goods->gyzz}}</span></p>
                            @endif
                            @if($v->goods->xq)
                                <p>效期：<span class="txt">{{$v->goods->xq}}</span></p>
                            @endif
                        </td>
                        <td class="tb1_td3">{{formated_price($v->goods->market_price)}}</td>
                        <td class="price tb1_td4">{{formated_price($v->goods->real_price)}}</td>
                        <td class="tb1_td5">{{$v->goods_number}}</td>
                        <td class="tb1_td6">{{formated_price($v->goods->real_price*$v->goods_number)}}</td>
                    </tr>
                @endforeach
            </table>
            @if($type1->type>0||$type2->type>0)
                <table class="table-liping" cellpadding="0" cellspacing="0">
                    <tr>
                        <th colspan="5">七夕有礼</th>

                    </tr>
                    @if($type2->type>0)
                        <tr>
                            <td class="liping_td1" style="color:#02ad0a;font-size:14px;width:108px;text-align:right;">温馨提示：</td>
                            <td class="liping_td2" style="width:440px;padding-left:5px;padding-top:49px;">
                                <div class="factory" style="font-size:14px;" >
                                    <p style="font-size:14px;">您的单笔 <span style="color:#e70505;font-size:14px;"> 非中药</span>订单已满 <span style="color:#e70505;font-size:14px;">{{formated_price($type2->amount)}}</span>，</p>
                                    <p style="font-size:14px;">享受赠品多乐士避孕套 <span style="color:#e70505;font-size:14px;">{{$type2->num}}</span>盒。</p>
                                    <p style="font-size:14px;">赠品随货同行。</p>

                                </div>

                            </td>

                            <td class="liping_td3" style="width:150px;">

                                <a href="#" target="_blank" ><img src="{{get_img_path('images/pc_qixi_01.jpg')}}" title="多乐士避孕套" style="width:120px;height:120px;border:1px solid #e1e1e1;" /></a>

                            </td>
                            <td class="liping_td4" style="border-right:1px solid #e1e1e1;">

                                <span class="txt" style="color:#39a817;font-size:14px;">多乐士避孕套</span>
                            </td>

                        </tr>
                    @endif
                    @if($type1->type>0)
                        <tr>
                            <td class="liping_td1" style="color:#02ad0a;font-size:14px;width:108px;text-align:right;">温馨提示：</td>
                            <td class="liping_td2" style="width:440px;padding-left:5px;padding-top:49px;">
                                <div class="factory" style="font-size:14px;" >
                                    <p style="font-size:14px;">您的单笔 <span style="color:#e70505;font-size:14px;"> 中药</span>订单已满 <span style="color:#e70505;font-size:14px;">{{formated_price($type1->amount)}}</span>，</p>
                                    <p style="font-size:14px;">享受赠品菊花茶 <span style="color:#e70505;font-size:14px;">{{$type1->num}}</span>盒。</p>
                                    <p style="font-size:14px;">赠品随货同行。</p>

                                </div>

                            </td>

                            <td class="liping_td3" style="width:150px;">

                                <a href="#" target="_blank" ><img src="{{get_img_path('images/pc_qixi_02.jpg')}}" title="菊花茶" style="width:120px;height:120px;border:1px solid #e1e1e1;" /></a>

                            </td>
                            <td class="liping_td4" style="border-right:1px solid #e1e1e1;">

                                <span class="txt" style="color:#39a817;font-size:14px;">菊花茶</span>
                            </td>

                        </tr>
                    @endif


                </table>
            @endif
            @if(count($hg_goods)>0)
                @foreach($hg_goods as $v)
                    <div class="huangou fn_clear" style="width:1200px;border:1px solid #e5e5e5;margin-bottom:20px;min-height: 200px;";>
                        <h3 style="height:34px;line-height:34px;font-size:12px;color:#1a1a1a;text-indent:18px;background-color:#f5f5f5;border-bottom:1px solid #e5e5e5;">下单送</h3>
                        <div class="huangou-box">
                            @if($hg_type==1)
                                <div class="tip-left" style="width:540px;float:left;padding:50px 0 0 30px;">
                                    <div style="float:left;width:75px;height:32px;color:#02ad0a;font-weight:bold;font-size:14px;">温馨提示：</div>
                                    <div style="float:left;width:250px;">
                                        <p style="margin-bottom:10px;font-size:14px;">您已购买复方甘草片 <span style="color:#fd0303;font-size:14px;">{{$v->num}}瓶</span> ，已享受</p>
                                        <p style="margin-bottom:10px;font-size:14px;"><span style="color:#fd0303;font-size:14px;">{{$v->hg_goods_price*$v->hg_goods_number}}元</span>换购复方丹参肠溶胶囊<span style="color:#fd0303;font-size:14px;">{{$v->hg_goods_number}}盒</span>。</p>
                                        {{--<p style="color:#fd0303;font-size:14px;">含有换购商品订单需现款支付</p>--}}

                                    </div>


                                </div>
                            @else
                                <div class="tip-left" style="width:540px;float:left;padding:50px 0 0 30px;">
                                    <div style="float:left;width:75px;height:32px;color:#02ad0a;font-weight:bold;font-size:14px;">温馨提示：</div>
                                    <div style="float:left;width:250px;">
                                        <p style="margin-bottom:10px;font-size:14px;">您的单笔订单已满<span style="color:#fd0303;font-size:14px;">{{$v->num}}元</span> ，已享受</p>
                                        <p style="margin-bottom:10px;font-size:14px;"><span style="color:#fd0303;font-size:14px;">{{$v->hg_goods_price*$v->hg_goods_number}}元</span>换购{{$v->goods->goods_name}}<span style="color:#fd0303;font-size:14px;">{{$v->hg_goods_number}}盒</span>。</p>
                                        {{--<p style="color:#fd0303;font-size:14px;">含有换购商品订单需现款支付</p>--}}

                                    </div>


                                </div>

                            @endif
                            <div class="tip-mid" style="width:150px;float:left;">
                                <img src="{{get_img_path($v->goods->goods_img)}}" alt="" style="width:120px;height:120px;border:1px solid #e5e5e5;margin-top:20px;" />

                            </div>
                            <div class="tip-right" style="width:142px;text-align:center;margin-top:30px;float:left;">
                                <p style="margin-bottom:15px;">{{$v->hg_goods_name}}</p>
                                <p style="margin-bottom:20px;">0.5g*12粒*2板</p>
                                <p style="margin-bottom:20px;">效期：{{$v->goods->xq}}</p>
                                <p style="margin-bottom:20px;color:#39a817">{{$v->hg_goods_price*$v->hg_goods_number}}元换购{{$v->hg_goods_number}}盒</p>
                                {{--<p>是否换购:--}}
                                {{--<label style="margin-right:10px;color:#fe0101"><input name="huangou" type="radio"  value="1" onclick="if(!confirm('若原订单中含有换购商品,原商品将会被删除!')){--}}
                                {{--return false;--}}
                                {{--};hg_check(true,{{$surplus}})"/>是 </label>--}}
                                {{--<label style="color:#fe0101"><input name="huangou" type="radio" value="0" checked=true onclick="hg_check(false,{{$surplus}})"/>否</label>--}}
                                {{--<input type="hidden" id="hg_amount" value="{{$v->hg_goods_price*$v->hg_goods_number}}"/>--}}
                                {{--</p>--}}

                            </div>

                        </div>

                    </div>
                    @endforeach
                    @endif

                            <!-- 礼品列表 start -->
                    @if($gift_status==1)
                        <dl class="gift fn_clear">
                            <dt>礼品列表</dt>
                            @foreach($gifts as $v)
                                <dd>
                                    <img src="{{get_img_path($v->img)}}" alt="{{$v->gift_name}}"/>
                                    <p>
                                        <input type="radio" name="gift" id="gift" value="{{$v->gift_name}}" />{{$v->gift_name}}
                                    </p>
                                </dd>
                                @endforeach
                                        <!-- 累计积分 -->
                                <dd>
                                    <img src="{{path('images/lj_points.jpg')}}" alt="累计本次精品积分"/>
                                    <p>
                                        <input type="radio" name="gift" id="gift" value="累计积分" />累计本次精品积分
                                    </p>
                                </dd>
                        </dl>
                    @endif
                    <input type="hidden" name="gift_status" id="gift_staus" value="@if($gift_status==1) 1 @endif" />
                    <input type="hidden" name="gift_lj_jf" value="{{$jp_amount}}" /> <!-- 累计积分 -->
                    {{--<!-- 礼品列表 end -->--}}
                    @if(count($yhq_list)>0)
                        <table class="table7" cellpadding="0" cellspacing="0">
                            <tr>
                                <th colspan="5">可用优惠券</th>
                            </tr>
                            <tr>
                                @foreach($yhq_list as $k=>$v)
                                    <td >
                                        <div class="youhuiquan-box check_bg" style="width:204px;height:120px;position:relative;" yhq_id="{{$v->yhq_id}}" yhq_je="{{$v->je}}">
                                            <img src="{{get_img_path('images/keyongyouhuiquan01.jpg')}}" alt="" />
                                            <p style="position:absolute;left:88px;top:30px;color:#fff;">【满{{intval($v->min_je)}}可用】</p>
                                            <p style="position:absolute;left:22px;top:65px;color:#fffee3;">{{date('Y.m.d',$v->start)}}—{{date('Y.m.d',$v->end)}}</p>
                                            <p style="position:absolute;left:20px;bottom:7px;color:#59d4d4;"><span style="padding-right:30px;">[{{$v->user_rank}}]</span> <span> [{{$v->area}}]</span></p>

                                            <div class="check " style="width:206px;height:120px;position:absolute;left:0;top:0;background:url('{{get_img_path('images/keyongyouhuiquan01-ck.png')}}') no-repeat;">
                                            </div>
                                            {{--@if($k==0) check-bg  @endif--}}

                                        </div>

                                    </td>
                                @endforeach
                                @for($i=count($yhq_list);$i<5;$i++)
                                    <td>
                                        <div class=" check_bg" style="width:204px;height:120px;position:relative;">

                                        </div>
                                    </td>
                                @endfor
                            </tr>
                            <input type="hidden" name="yhq_id" id="yhq_id" value="{{$yhq_id or 0}}"/>
                        </table>
                    @endif


                    <table class="table22" cellpadding="0" cellspacing="0">
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
                                    <span class="adds">{{$address->address}}</span> （ <span class="name">{{$address->consignee}}</span>  <span>收</span>)
                                </p>
                                <p class="msg">
                                    <span class="title_name">手机：</span> <span class="text">{{$address->tel}}</span>
                                    <span class="title_name">电子邮件地址：</span> <span class="text">{{$address->email}}</span>
                                    @if($address->zipcode)<span class="title_name">邮政编码：</span> <span class="text">{{$address->zipcode}}</span>@endif
                                    @if($address->mobile)<span class="title_name">电话：</span> <span class="text">{{$address->mobile}}</span>@endif
                                    @if($address->best_time)<span class="title_name">最佳送货时间：</span> <span class="text">{{$address->best_time}}</span>@endif
                                </p>
                            </td>
                        </tr>
                    </table>
                    <table class="table3" cellpadding="0" cellspacing="0" id="shippingTable">
                        <tr>
                            <th>配送方式</th>
                        </tr>
                        <tr>
                            <td class="sel">
                                @if($user->shipping_id!=0)
                                    <span class="name">物流：<span class="text">{{$user->shipping_name}}</span></span>
                                    @if($user->wl_dh!='')
                                        <span class="name">物流电话：<span class="text">{{$user->wl_dh}}</span></span>
                                    @endif
                                    <input type="hidden" name="shipping_id" value="{{$user->shipping_id}}" />
                                    <input type="hidden" name="ps_wl" id="ps_wl" value="{{$user->shipping_name}}" />
                                    <input type="hidden" name="ps_dh"  id="ps_dh" value="{{$user->wl_dh}}" />
                                    <input type="hidden" name="shipping" value="{{$user->shipping_id}}"checked="checked" />
                                @else
                                    <p class="ways">
                                        {{--循环配送方式--}}
                                        @foreach($shipping as $k=>$v)
                                            @if($v->shipping_id==9)
                                                <label for="list{{$k}}"><input name="shipping" type="radio" value="{{$v->shipping_id}}" supportCod="{{$v->support_cod or ''}}" insure="{{$v->insure or ''}}" onclick="selectShipping(this)" id="ps_{{$k}}"/>{{$v->shipping_name}}
                                                    <select name="area_name" id="area_name">
                                                        <option value='0' >请选择...</option>
                                                        <option value='都江堰' >都江堰</option>
                                                        <option value='邛崃' >邛崃</option>
                                                        <option value='金堂' >金堂</option>
                                                        <option value='双流' >双流</option>
                                                        <option value='简阳' >简阳</option>
                                                        <option value='郫县' >郫县</option>

                                                        <option value='新津' >新津</option>


                                                        <option value='仁寿' >仁寿</option>
                                                    </select>
                                                </label>
                                            @elseif($v->shipping_id==13)
                                                <label for="list{{$k}}"><input name="shipping" type="radio" value="{{$v->shipping_id}}" supportCod="{{$v->support_cod or ''}}" insure="{{$v->insure or ''}}" onclick="selectShipping(this)"/>{{$v->shipping_name}}
                                                    <select name="kf_name" id="kf_name">
                                                        <option value='郫县库房' >郫县库房</option>
                                                    </select>
                                                </label>
                                            @else
                                                <label for="list{{$k}}" title="{{$v->shipping_name}}" alt="{{$v->shipping_name}}"><input name="shipping" type="radio" value="{{$v->shipping_id}}" @if($v->shipping_id==12)data-val="{$district_name}的配送区域为：{$zjs_townlist_str}"@endif  supportCod="{{$v->support_cod or ''}}" insure="{{$v->insure or ''}}" onclick="selectShipping(this)" id="ps_{{$k}}" checked/>{{str_limit($v->shipping_name,20)}}@if($v->shipping_id==12)<a style="float:left;margin-left:10px;display:inline;font-family:'Microsoft yahei';font-weight:normal;color:#4E9249;" href="http://www.hezongyy.com/upload/%E5%AE%85%E6%80%A5%E9%80%81%E6%9C%8D%E5%8A%A1%E5%8C%BA%E5%9F%9F%E8%A1%A8.xls">宅急送配送区域表</a>@endif</label>
                                            @endif
                                        @endforeach
                                        <label for="list6"><input name="shipping" type="radio" value="-1" {if $order.shipping_id eq $shipping.shipping_id}checked="true"{/if} supportCod="{$shipping.support_cod}" insure="{$shipping.insure}" onclick="selectShipping(this)" id="qt" />其它物流</label>
                                    </p>
                                @endif
                                @if($user->shipping_id==0)
                                    <p class="other" id="ps_fs">
                                        <span class="title">物流公司名称:</span> <input type="text" name="ps_wl" class="texts" id="ps_wl"/>
                                        <span class="title">物流电话:	</span>  <input type="text" name="ps_dh" class="texts" id="ps_dh"/>
                                    </p>
                                @endif
                                <p class="tip"><b>(温馨提示：请谨慎填写，配送方式填写后只能让客服修改，所有货物请在送货员在场时开箱验货再签收，如有破损及时联系客服人员，如未当面开箱验货，破损不予赔付，自行承担。)</b></p>
                            </td>
                        </tr>
                    </table>
                    <table class="table5" cellpadding="0" cellspacing="0">
                        <tr>
                            <th>其他信息</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea name="postscript" id="postscript"></textarea>
                            </td>
                        </tr>
                    </table>
                    <table class="table4" cellpadding="0" cellspacing="0">
                        <tr>
                            <th >支付方式 </th>
                        </tr>
                        <tr>
                            <td class="tb4_td1" >
                                <span class="title"> 商品总金额：</span><span class="price">{{formated_price($total)}}</span>
                                <span class="title"> 折扣金额：</span><span class="price">{{formated_price($discount)}}</span>
                                <span class="title"> 优惠金额：</span><span class="price">{{formated_price($zyzk)}}</span>

                            </td>


                        </tr>
                        @if($surplus==true)
                            <tr>
                                <td class="tb4_td2" style="padding-bottom: 10px;">
                                    <span class="title">  使用余额：<input name="surplus" type="hidden" class="text" id="ECS_SURPLUS" size="10" value="{{$surplus}}" /></span><span class="price" id="surplus">{{formated_price($surplus)}}</span>
                                    （<span class="title"> 当前余额：</span><span class="price" id="J_surplus">{{formated_price($user->user_money)}}</span><span class="price" id="ECS_SURPLUS_NOTICE" class="notice"></span></span>）

                                </td>
                            </tr>
                        @else
                            <input  name="surplus" type="hidden" class="text" id="ECS_SURPLUS" size="10" value="0"/>
                        @endif
                        @if($order_amount>0)

                            @foreach($payment as $k=>$v)
                                <tr>
                                    <td colspan="4" class="pay_way">
                                        <p class="fn_clear" @if(count($payment)==($k+1)) style="margin-bottom: 10px;" @endif>
                                            <input type="radio" name="payment" value="{{$v->pay_id}}" @if($k==0) checked @endif  isCod="{{$v->is_cod}}" onclick="selectPayment(this)"  id="ag_{{$k}}" />
                                            @if($v->pay_name=='支付宝转账')
                                                <label for="ag_{{$k}}"><img src="{{get_img_path('images/zfbzz.jpg')}}" original="{{get_img_path('images/zfbzz.jpg')}}" title="{{$v->pay_name}}"></label>
                                                <span class="tip_txt yinhang">转账成功后请及时联系客服人员确认</span>
                                            @elseif($v->pay_name=='财付通')
                                                <label for="ag_{{$k}}"><img src="{{path('images/cft.jpg')}}" original="{{path('images/cft.jpg')}}" title="{{$v->pay_name}}"></label>
                                            @elseif($v->pay_name=='paypal')
                                                <label for="ag_{{$k}}"><img src="{{path('images/bank_paypal.jpg')}}" original="{{path('images/bank_paypal.jpg')}}" title="{{$v->pay_name}}"></label>
                                            @elseif($v->pay_name=='银行汇款/转帐')
                                                <label for="ag_{{$k}}"><img src="{{path('images/yhhk.jpg')}}" original="{{path('images/yhhk.jpg')}}" title="{{$v->pay_name}}"></label><span class="tip_txt yinhang"><a href="/articleInfo?id=49" target="_blank">查看帐户</a></span>
                                            @elseif($v->pay_name=='余额支付')
                                                <label for="ag_{{$k}}"><img src="{{path('images/yezf.jpg')}}" original="{{path('images/yezf.jpg')}}" title="{{$v->pay_name}}"></label>
                                            @elseif($v->pay_name=='货到付款')
                                                <label for="ag_{{$k}}"><img src="{{path('images/hdfk.jpg')}}" original="{{path('images/hdfk.jpg')}}" title="{{$v->pay_name}}"></label>
                                            @elseif($v->pay_name=='银联在线支付')
                                                <label for="ag_{{$k}}"><img src="{{path('images/yinlian01.jpg')}}" original="{{path('images/yinlian01.jpg')}}" title="{{$v->pay_name}}"></label>
                                                <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，单笔限额2万，单日限额5万</span>
                                            @elseif($v->pay_name=='农行在线支付')
                                                <label for="ag_{{$k}}"><img width='200' src="{{path('images/abcicon2.jpg')}}" original="{{path('images/abcicon2.jpg')}}" title="{{$v->pay_name}}"></label>
                                            @elseif($v->pay_name=='快捷支付')
                                                <label for="ag_{{$k}}"><img src="{{get_img_path('images/xyyh.jpg')}}" original="{{get_img_path('images/xyyh.jpg')}}" title="{{$v->pay_name}}"></label>
                                                <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，<a style="font-size:14px;font-weight:bold;color:#e70000 !important;" href="/uploads/快捷支付支持银行列表.xlsx">支付方式及开通方式</a></span>
                                            @elseif($v->pay_name=='微信扫码支付')
                                                <label for="ag_{{$k}}"><img src="{{get_img_path('images/weixin.jpg')}}" original="{{get_img_path('images/xyyh.jpg')}}" title="{{$v->pay_name}}"></label>
                                                <span class="tip_txt yinhang">无手续费，支持储蓄卡、信用卡，<a target="_blank" style="font-size:14px;font-weight:bold;color:#e70000 !important;" href="https://kf.qq.com/touch/sappfaq/151210EJfUZZ151210qq2yUn.html?scene_id=kf1&platform=14">支付限额查看</a></span>
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
                                    <span class="title">  使用充值余额：<input name="jnmj" type="hidden" class="text" id="ECS_SURPLUS" size="10" value="{{$jnmj}}" /></span><span class="price">{{formated_price($jnmj)}}</span>
                                    （<span class="title"> 当前充值余额：</span><span class="price" id="J_surplus">{{formated_price($user_jnmj->jnmj_amount)}}</span><span class="price" id="ECS_SURPLUS_NOTICE" class="notice"></span></span>）

                                </td>
                            </tr>
                        @else
                            <input name = "payment" type="radio" value = "-1" checked="checked"  style="display:none"/>
                        @endif
                    </table>
                    <div id="ECS_ORDERTOTAL">
                        <table class="table8" align="center" border="0" cellpadding="0">
                            <tr>
                                <th>费用总计</th>
                            </tr>
                            <tr class="tb6_td1">
                                <td>
                                    <p><span class="price" id="total" data="{{$total}}">{{formated_price($total)}}</span> <span class="title">商品总金额: </span> </p>
                                    <p @if($shipping_fee<=0) style="display: none;" @endif id='shipping_fee'><span class="price">{{formated_price($shipping_fee)}}</span><span class="title"><span style="color: #E70000">+</span>&nbsp;物流费用: </span> </p>
                                    <p><span class="price" id="discount" data="{{$discount}}">{{formated_price($discount)}}</span><span class="title"><span style="color: #E70000">-</span>&nbsp;折扣金额: </span> </p>
                                    <p><span class="price">{{formated_price($zyzk)}}</span><span class="title"><span style="color: #E70000">-</span>&nbsp;优惠金额: </span> </p>
                                    @if($jnmj>0)
                                        <p><span class="price">{{formated_price($jnmj)}}</span><span class="title"><span style="color: #E70000">-</span>&nbsp;使用充值余额: </span> </p>
                                    @endif
                                    @if($surplus>0)
                                        <p><span class="price" id="user_surplus" data="{{$surplus}}">{{formated_price($surplus)}}</span><span class="title"><span style="color: #E70000">-</span>&nbsp;使用余额: </span> </p>
                                    @endif
                                    @if(count($yhq_list)>0)
                                        <p><span class="price" id="pack_fee" data="{{$pack_fee}}">{{formated_price($pack_fee)}}</span><span class="title"><span style="color: #E70000">-</span>&nbsp;使用优惠券: </span> </p>
                                    @endif
                                    @if(isset($czfl_message)&&!empty($czfl_message))
                                        <p><span class="price" style="width: 50%;">{{$czfl_message}}</span><span class="title"><span style="color: #E70000"></span></span> </p>
                                    @endif
                                    {{--@if(isset($jehg_message)&&!empty($jehg_message))--}}
                                    {{--<p><span class="price" style="width: 50%;">{{$jehg_message}}</span><span class="title"><span style="color: #E70000"></span></span> </p>--}}
                                    {{--@endif--}}
                                    @if($xztj==1)
                                        <p><span class="price" style="width: 50%;">中药商品金额：{{formated_price($zy_amount)}}</span><span class="title"><span style="color: #E70000"></span></span> </p>
                                        <p><span class="price" style="width: 50%;">非中药商品金额：{{formated_price($fzy_amount)}}</span><span class="title"><span style="color: #E70000"></span></span> </p>
                                    @elseif(!empty($ts_message))
                                        <p><span class="price" style="width: 50%;">{{$ts_message}}</span><span class="title"><span style="color: #E70000"></span></span> </p>
                                    @endif
                                </td>
                            </tr>

                        </table>
                    </div>
                    <table class="table6" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="tb6_td2">
                                <span class="title subhide">应付款金额：</span> <span class="price subhide" id="amount" data="{{$order_amount}}">
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
    <script>
        $(function(){
            $('#theForm').submit(function(){
                $('#tjdd').hide();
                $('#tjdd_text').show();
                var flag = checkOrderForm(this);
                if(flag) {
                    $('#theForm').submit();
                }else{
                    $('#tjdd_text').hide();
                    $('#tjdd').show();

                    return false;
                }
                //$('#theForm').submit();
            })
        })
        function hg_check(flag,surplus){
            var total = parseFloat($('#total').attr('data'));
            var amount = parseFloat($('#amount').attr('data'));
            var hg_amount = parseFloat($('#hg_amount').val());
            var change_surplus = 0;
            if(flag==true){
                if(surplus>0){//有使用余额
                    var user_money = parseFloat($('#your_surplus').val());
                    if(user_money>surplus){
                        var new_surplus = Math.min(user_money,hg_amount+surplus);
                        change_surplus = new_surplus - surplus;
                        surplus = new_surplus;
                    }
                }
                total = total + hg_amount;
                amount = amount + hg_amount - change_surplus;
            }
            $('#total').html(price_format(total));
            $('#amount').html(price_format(amount));
            if(surplus>0) {
                $('#user_surplus').html(price_format(surplus));
                $('#surplus').html(price_format(surplus));
            }
        }
        function price_format(money){
            return '￥'+money.toFixed(2);
        }
    </script>
    <script>
        $(function(){

            $(".youhuiquan-box").click(function(){
                var yhq_id = parseInt($(this).attr('yhq_id'));
                var old_yhq_id = parseInt($('#yhq_id').val());
                var yhq_je = parseInt($(this).attr('yhq_je'));
                if(old_yhq_id>0&&old_yhq_id==yhq_id){
                    $(this).find(".check").removeClass("check-bg");
                    $(this).parents("td").siblings().find(".check").removeClass("check-bg");
                    $("#yhq_id").val(0);
                    yhq_check(false,yhq_je);
                }else {

                    $(this).find(".check").addClass("check-bg");
                    $(this).parents("td").siblings().find(".check").removeClass("check-bg");
                    $("#yhq_id").val(yhq_id);
                    yhq_check(true,yhq_je);
                }


            })



        })
        function yhq_check(flag,je){
            var amount = parseFloat($('#amount').attr('data'));
            var discount = parseFloat($('#discount').attr('data'));
            var surplus = parseFloat($('#user_surplus').attr('data'));
            var change_je = 0;
            var new_discount = 0;
            if(flag==true){//选中优惠券
                change_je = je;
                amount = amount - change_je + discount;
                if(surplus>0){//有使用余额
                    if(amount<0){
                        surplus = surplus + amount;
                    }
                }
            }else{
                change_je = -je;
                amount = amount - change_je - discount;
                if(surplus>0){//有使用余额
                    if(amount<0){
                        surplus = surplus + amount;
                    }
                }
                je = 0;
                new_discount = discount;
            }
            $('#amount').html(price_format(amount));
            $('#amount').attr('data',amount)
            $('#pack_fee').html(price_format(je));
            $('#pack_fee').attr('data',je)
            $('#discount').html(price_format(new_discount));
            if(surplus>0) {
                $('#user_surplus').html(price_format(surplus));
                $('#user_surplus').attr('data',surplus)
                $('#surplus').html(price_format(surplus));
                $('#surplus').attr('data',surplus)
            }
        }
    </script>
    @include('layout.page_footer')
@endsection

