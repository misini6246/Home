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
    <link rel="stylesheet" type="text/css" href="/user/layer/layer.css" />

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
                                                        class="right_icon"/><span>我的今瑜e药网</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="user">
                    <div class="l">
                        <div class="img_box">
                            <img alt="{{$user->msn}}" title="{{$user->msn}}"
                                 style="border-radius: 50%;width: 80px;height: 80px;display: block;"
                                 src="@if($user->ls_file!=''){{get_img_path('data/feedbackimg/'.$user->ls_file)}}@else{{get_img_path('images/user/user_03.jpg')}}@endif"/>
                            <div class="shenhe wei yi">
                                @if($user->ls_review==1)
                                    已审核
                                @else
                                    未审核
                                @endif
                            </div>
                            <a href="{{route('user.mobile_login')}}">
                                <div class="qiehuan">
                                    切换会员
                                </div>
                            </a>
                        </div>
                        <div class="xinxi">
                            <p class="username">{{$user->user_name}}</p>
                            <p class="name">{{$user->msn}}</p>
                            <p class="leibie">会员等级：<span>{{$rank_name}}</span></p>
                            @if($user->ls_zpgly!='admin')
                                {!! $gly_html or '' !!}
                            @endif
                            @if(!$mobile_phone)
                                <a href="{{route('user.mobile_login')}}" class="bangding">
                                    <img src="/user/img/shouji_03.png"/>
                                    <span>去绑定手机号</span>
                                </a>
                            @else
                                <a href="{{route('user.mobile_login')}}" class="bangding">
                                    <img src="/user/img/bind.png"/>
                                    <span>已绑定({{$mobile_phone}})</span>
                                </a>
                            @endif

                        </div>
                    </div>
                    <div class="r">
                        <ul class="img_box">
                            <a href="{{route('member.order.index',['status'=>1])}}">
                                <li>
                                    <img src="/user/img/组 1.png"/>
                                    <p>待付款订单</p>
                                    <div class="xiaoxi">{{$dfk}}</div>
                                </li>
                            </a>
                            <a href="{{route('member.order.index',['status'=>2])}}">
                                <li>
                                    <img src="/user/img/组 2.png"/>
                                    <p>待收货订单</p>
                                    <div class="xiaoxi">{{$dsh}}</div>
                                </li>
                            </a>
                            <a href="{{route('user.znx_list')}}">
                                <li>
                                    <img src="/user/img/组 3.png"/>
                                    <p>未读消息</p>
                                    <div class="xiaoxi">{{msg_count()}}</div>
                                </li>
                            </a>
                            <a href="#">
                                <li>
                                    <img src="/user/img/组 4.png"/>
                                    <p>可用含麻委托书</p>
                                    <div class="xiaoxi">{{$user->mhj_number}}</div>
                                </li>
                            </a>
                        </ul>
                        <div class="zizhi">
                            <p class="weituo">
                                @if(empty($user->cgwts_time))
                                    <span>已审核通过</span>
                                @elseif($cgwts_time==2)
                                    <span>有效期至：{{$user->cgwts_time}}</span>
                                @elseif($cgwts_time==1)
                                    <span class="jijiang">即将过期({{$user->cgwts_time}})</span>
                                @else
                                    <span class="yiguoqi">已过期({{$user->cgwts_time}})</span>
                                @endif
                                采购委托书
                            </p>
                            <p class="zhizhao">
                                @if(empty($user->yyzz_time))
                                    <span>已审核通过</span>
                                @elseif($yyzz_time==2)
                                    <span>有效期至：{{$user->yyzz_time}}</span>
                                @elseif($yyzz_time==1)
                                    <span class="jijiang">即将过期({{$user->yyzz_time}})</span>
                                @else
                                    <span class="yiguoqi">已过期({{$user->yyzz_time}})</span>
                                @endif
                                营业执照
                            </p>
                            @if($user->user_rank==5)
                                <p class="xuke">
                                    @if(empty($user->yljg_time))
                                        <span>已审核通过</span>
                                    @elseif($yljg_time==2)
                                        <span>有效期至：{{$user->yljg_time}}</span>
                                    @elseif($yljg_time==1)
                                        <span class="jijiang">即将过期({{$user->yljg_time}})</span>
                                    @else
                                        <span class="yiguoqi">已过期({{$user->yljg_time}})</span>
                                    @endif
                                    医疗机构执业许可证
                                </p>
                            @else
                                <p class="xuke">
                                    @if(empty($user->xkz_time))
                                        <span>已审核通过</span>
                                    @elseif($xkz_time==2)
                                        <span>有效期至：{{$user->xkz_time}}</span>
                                    @elseif($xkz_time==1)
                                        <span class="jijiang">即将过期({{$user->xkz_time}})</span>
                                    @else
                                        <span class="yiguoqi">已过期({{$user->xkz_time}})</span>
                                    @endif
                                    药品经营许可证
                                </p>
                            @endif
                            <p class="GSP">
                                @if(empty($user->zs_time))
                                    <span>已审核通过</span>
                                @elseif($zs_time==2)
                                    <span>有效期至：{{$user->zs_time}}</span>
                                @elseif($zs_time==1)
                                    <span class="jijiang">即将过期({{$user->zs_time}})</span>
                                @else
                                    <span class="yiguoqi">已过期({{$user->zs_time}})</span>
                                @endif
                                GSP证书
                            </p>
                            <p class="GSP">
                                @if(empty($user->org_cert_validity))
                                    <span>已审核通过</span>
                                @elseif($org_cert_validity==2)
                                    <span>有效期至：{{$user->org_cert_validity}}</span>
                                @elseif($org_cert_validity==1)
                                    <span class="jijiang">即将过期({{$user->org_cert_validity}})</span>
                                @else
                                    <span class="yiguoqi">已过期({{$user->org_cert_validity}})</span>
                                @endif
                                组织机构代码证
                            </p>
                        </div>
                    </div>
                </div>
                <img src="/user/img/shu.png" class="shu"/>
                <ul class="zhanghu">
                    <li>
                        <a href="{{route('user.accountInfo')}}">
                            <div class="img_box">
                                <img src="/user/img/zichan_1.png"/>
                            </div>
                            <div class="txt">
                                <p class="wenzi">账户余额</p>
                                <p class="xq">{{formated_price($user->user_money)}}</p>
                            </div>
                        </a>
                    </li>
                    @if($user->is_zhongduan==1&&$user->province==26)
                        {{--<li>--}}
                            {{--<a href="{{route('member.hongbao_money_log')}}">--}}
                                {{--<div class="img_box">--}}
                                    {{--<img src="{{get_img_path('images/user/zichan_1.png')}}"/>--}}
                                {{--</div>--}}
                                {{--<div class="txt">--}}
                                    {{--<p class="wenzi">红包</p>--}}
                                    {{--<p class="xq">{{formated_price(collect($user->hongbao_money)->get('money',0))}}</p>--}}
                                {{--</div>--}}
                            {{--</a>--}}
                        {{--</li>--}}
                    @endif
                    @if($user->jf_money)
                        <li>
                            <a href="{{route('member.jf_money_log')}}">
                                <div class="img_box">
                                    <img src="{{get_img_path('images/user/zichan_1.png')}}"/>
                                </div>
                                <div class="txt">
                                    <p class="wenzi">积分金币</p>
                                    <p class="xq">{{formated_price($user->jf_money->money)}}</p>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if($user_jnmj&&$user_jnmj->jnmj_amount>0)
                        <li>
                            <a href="{{route('member.money',['type'=>1])}}">
                                <div class="img_box">
                                    <img src="{{get_img_path('images/user/zichan_1.png')}}"/>
                                </div>
                                <div class="txt">
                                    <p class="wenzi">{{trans('common.jnmj')}}</p>
                                    <p class="xq">{{formated_price($user_jnmj->jnmj_amount)}}</p>
                                </div>
                            </a>
                        </li>
                    @endif
                    @if($cz_money&&$cz_money->money>0)
                        <li>
                            <a href="{{route('member.money',['type'=>2])}}">
                                <div class="img_box">
                                    <img src="{{get_img_path('images/user/zichan_1.png')}}"/>
                                </div>
                                <div class="txt">
                                    <p class="wenzi">{{trans('common.cz_money')}}</p>
                                    <p class="xq">{{formated_price($cz_money->money)}}</p>
                                </div>
                            </a>
                        </li>
                    @endif
                    {{--<li>--}}
                        {{--<div class="img_box">--}}
                            {{--<a href="{{route('jifen.user.index')}}">--}}
                                {{--<img src="{{get_img_path('images/user/zichan_2.png')}}"/>--}}
                            {{--</a>--}}
                        {{--</div>--}}
                        {{--<div class="txt">--}}
                            {{--<p class="wenzi">可兑换积分</p>--}}
                            {{--<p class="xq">{{intval($user->pay_points)}}分</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    {{--<li>--}}
                        {{--<div class="img_box">--}}
                            {{--<img src="{{get_img_path('images/user/zichan_3.png')}}"/>--}}
                        {{--</div>--}}
                        {{--<div class="txt">--}}
                            {{--<p class="wenzi">精品专区积分</p>--}}
                            {{--<p class="xq">{{intval($user->jp_points)}}分</p>--}}
                        {{--</div>--}}
                    {{--</li>--}}
                    <li>
                        <div class="img_box">
                            <a href="{{route('user.youhuiq')}}"><img
                                        src="/user/img/zichan_1.png"/></a>
                        </div>
                        <div class="txt">
                            <p class="wenzi">可用优惠券</p>
                            <p class="xq">{{$yhq_count}}张
                                {{--<a href="#">去领券</a>--}}
                            </p>
                        </div>
                    </li>
                </ul>
                @if($user->is_zq>0&&isset($zq_info))
                    <div class="zhangqi">
                        <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                        <span class="title">账期信息</span>
                        <span class="xfed">
							账期消费额度
							<span>{{formated_price($zq_info->zq_amount)}}</span>
						</span>
                        <span class="zqed">
							账期额度
							<span>{{formated_price($zq_info->zq_je)}}</span>
						</span>
                        <span class="hkrq">
							账期还款日
							<span>每月<span>{{$zq_info->zq_rq}}</span>日</span>
						</span>
                        <span class="jq">
							上月账期是否已结清
                            @if($zq_info->zq_has==0)
                                <span>已结清</span>
                            @else
                                <span>未结清</span>
                            @endif
						</span>
                    </div>
                @endif
                @if($user->is_zhongduan==1)
                    {{--<div class="sctjm-box" style="height: 60px;line-height: 50px;padding-bottom: 0;">--}}
                        {{--@if($can_see_tjm)--}}
                            {{--@include('user.tjm')--}}
                        {{--@endif--}}
                        {{--@if($user->province==26)--}}
                            {{--<div class="title" style="display: inline-block;">--}}
                                {{--<img src="http://images.hezongyy.com/images/user/dian_03.png?110112"/>--}}
                                {{--<span class="bt">--}}
								{{--您当月已采购金额--}}
								    {{--<span style="font-size: 18px;margin-left: 33px;color: #FF1919;font-weight: bold;">{{formated_price($user_level?$user_level->month_amount:0)}}</span>--}}
							    {{--</span>--}}
                            {{--</div>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                @endif
                <div class="near_order">
                    <div class="title">
                        <a href="{{route('member.order.index')}}" class="readmore">查看全部订单</a>
                        <img src="/new_gwc/jiesuan_img/椭圆.png"/>
                        <span class="bt">近期订单</span>
                        <a href="{{route('member.order.index',['status'=>1])}}"
                           class="dfk">待付款（<span>{{$dfk}}</span>）</a>
                        <a href="{{route('member.order.index',['status'=>2])}}"
                           class="dsh">待收货（<span>{{$dsh}}</span>）</a>
                    </div>
                    @if(count($near_order)>0)
                        <table>
                            <tr>
                                <th class="ddbs">
                                    订单标识
                                </th>
                                <th class="ddh">
                                    订单号
                                </th>
                                <th class="xdsj">
                                    下单时间
                                </th>
                                <th class="shr">
                                    收货人
                                </th>
                                <th class="zje">
                                    <span>订单总金额</span>
                                    {{--<img src="{{get_img_path('images/user/tishi_03.png')}}" title="这是提示信息">--}}
                                </th>
                                <th class="zz" style="width: 250px;">
                                    订单状态
                                </th>
                                <th class="cz">
                                    操作
                                </th>
                            </tr>
                            @foreach($near_order as $v)
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
                                    <td><a style="display: block;" class="order_sn"
                                           href="{{route('user.orderInfo',['id'=>$v->order_id])}}">{{$v->order_sn}}</a>
                                    </td>
                                    <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                                    <td>{{$v->consignee}}</td>
                                    <td>{{formated_price($v->goods_amount+$v->shipping_fee)}}</td>
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
                                        @if(strpos($v->shipping_name,'合纵直配')!==false&&$v->shipping_status>=3&&$v->add_time>=strtotime(20180401))
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
                                               class="fukuan">去付款</a>
                                        @elseif($v->pay_status==2&&$v->shipping_status==4&&$v->order_status==1)
                                            <form style="display: inline-block" id="{{$v->order_id}}form"
                                                  action="{{route('member.order.update',['id'=>$v->order_id])}}"
                                                  method="post">
                                                {!! csrf_field() !!}
                                                <input type="hidden" name="_method" value="put">
                                                <input type="hidden" name="act" value="qrsh">
                                                <a class="fukuan"
                                                   onclick="$('#{{$v->order_id}}form').submit();">确认收货</a>
                                            </form>
                                        @else
                                            <a class="fukuan"
                                               href="{{route('user.orderBuy',['id'=>$v->order_id])}}">再次购买</a>
                                        @endif
                                        <a href="{{route('user.orderInfo',['id'=>$v->order_id])}}"
                                           class="read">查看详情</a>
                                           @if ($v->is_sync==1 && $v->fanli==1 && $v->is_mhj !=1&&$v->goods_amount>=500)
                                           <a style="color:#00a1e9;display:block;" class="confirm" data-id="{{$v->order_id}}">确认收货</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        @include('user.empty',['type'=>0,'emsg'=>'您近期没有下过单，这里是空的'])
                    @endif
                </div>
                {{--<div class="shoucang" id="sc">--}}
                    {{--@include('user.sc',['result'=>$collection])--}}
                {{--</div>--}}
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
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
        //返回顶部
        $('.btn-top').click(function() {
            $('html,body').animate({
                'scrollTop': 0
            })
        });
        $(function () {
            var sn = '{!! $sn or '' !!}';
            var gqts = '{{$gqts or 1}}';
            if (sn != '' && gqts == 0) {
                layer.alert(sn, {icon: 0, time: 5000});
            }
        });
        if ($('.zhanghu li').length == 5) {
            $('.zhanghu li').css('width', '188px');
        } else {
            $('.zhanghu li').css('width', '235px');
        }
        $('.chakan').hover(function () {
            $('.lxfs').show();
        }, function () {
            $('.lxfs').hide();
        })

    </script>
    @include('layouts.new_footer')
@endsection
