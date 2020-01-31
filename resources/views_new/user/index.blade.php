@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuanzhongxin.css')}}1" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
    <script type="text/javascript" src="{{path('js/user/lb.js')}}"></script>
    <style>
        /*add*/
        .bangding img {
            vertical-align: middle;
        }

        .chakan {
            width: 100px;
            height: 20px;
            line-height: 20px;
            text-align: center;
            background: #3dbb2b;
            color: #fff !important;
            display: inline-block;
            border-radius: 30px;
            cursor: pointer;
            position: relative;
        }

        .lxfs {
            position: absolute;
            top: 110px;
            left: 330px;
            padding: 10px;
            background: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.3);
            z-index: 3;
            display: none;
        }

        .lxfs li {
            height: 30px;
            line-height: 30px;
        }

        .lxfs li span.num {
            font-weight: bold;
            color: #3dbb2b;
            font-size: 14px;
        }

        .lxfs li span.left_title {
            display: inline-block;
            width: 60px;
            text-align: right;
            color: #666;
            font-size: 14px;
            font-family: "宋体";
        }

        .lxfs_sanjiao {
            position: absolute;
            top: 7px;
            left: -4px;
        }

    </style>
    <!--[if lte IE 9]>
    <style type="text/css">
        .genzong {
            border: 1px solid #e5e5e5;
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
                                                        class="right_icon"/><span>我的太星医药网</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="user">
                    <div class="l">
                        <div class="img_box">
                            <img alt="{{$user->msn}}" title="{{$user->msn}}"
                                 style="border-radius: 50%;width: 80px;height: 80px;display: block;"
                                 src="@if($user->ls_file!=''){{asset('data/feedbackimg/'.$user->ls_file)}}@else{{get_img_path('images/user/user_03.jpg')}}@endif"/>
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
                                    <img src="{{get_img_path('images/user/shouji_03.png')}}"/>
                                    <span>去绑定手机号</span>
                                </a>
                            @else
                                <a href="{{route('user.mobile_login')}}" class="bangding">
                                    <img src="{{get_img_path('images/user/bind.png')}}"/>
                                    <span>已绑定({{$mobile_phone}})</span>
                                </a>
                            @endif

                        </div>
                    </div>
                    <div class="r">
                        <ul class="img_box">
                            <a href="{{route('member.order.index',['status'=>1])}}">
                                <li>
                                    <img src="{{get_img_path('images/user/user_1_03.png')}}"/>
                                    <p>待付款订单</p>
                                    <div class="xiaoxi">{{$dfk}}</div>
                                </li>
                            </a>
                            <a href="{{route('member.order.index',['status'=>2])}}">
                                <li>
                                    <img src="{{get_img_path('images/user/user_2_03.png')}}"/>
                                    <p>待收货订单</p>
                                    <div class="xiaoxi">{{$dsh}}</div>
                                </li>
                            </a>
                            <a href="{{route('user.znx_list')}}">
                                <li>
                                    <img src="{{get_img_path('images/user/user_3_03.png')}}"/>
                                    <p>未读消息</p>
                                    <div class="xiaoxi">{{msg_count()}}</div>
                                </li>
                            </a>
                            <a href="#">
                                <li>
                                    <img src="{{get_img_path('images/user/user_4_03.png')}}"/>
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
                <img src="{{get_img_path('images/user/shu.png')}}" class="shu"/>
                <ul class="zhanghu">
                    <li>
                        <a href="{{route('user.accountInfo')}}">
                            <div class="img_box">
                                <img src="{{get_img_path('images/user/zichan_1.png')}}"/>
                            </div>
                            <div class="txt">
                                <p class="wenzi">账户余额</p>
                                <p class="xq">{{formated_price($user->user_money)}}</p>
                            </div>
                        </a>
                    </li>
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
                    <li>
                        <div class="img_box">
                            <img src="{{get_img_path('images/user/zichan_2.png')}}"/>
                        </div>
                        <div class="txt">
                            <p class="wenzi">可兑换积分</p>
                            <p class="xq">{{intval($user->pay_points)}}分</p>
                        </div>
                    </li>
                    <li>
                        <div class="img_box">
                            <img src="{{get_img_path('images/user/zichan_3.png')}}"/>
                        </div>
                        <div class="txt">
                            <p class="wenzi">精品专区积分</p>
                            <p class="xq">{{intval($user->jp_points)}}分</p>
                        </div>
                    </li>
                    <li>
                        <div class="img_box">
                            <a href="{{route('user.youhuiq')}}"><img
                                        src="{{get_img_path('images/user/zichan_4.png')}}"/></a>
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
                <div class="near_order">
                    <div class="title">
                        <a href="{{route('member.order.index')}}" class="readmore">查看全部订单</a>
                        <img src="{{get_img_path('images/user/dian_03.png')}}"/>
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
                                        @if(strpos($v->fhwl_m,'宅急送')!==false&&$v->shipping_status>=4)
                                            &nbsp;<a style="color: #FF6102" target="_blank"
                                                     href="{{route('zjs',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}">物流跟踪</a>
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
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        @include('user.empty',['type'=>0,'emsg'=>'您近期没有下过单，这里是空的'])
                    @endif
                </div>
                <div class="shoucang" id="sc">
                    @include('user.sc',['result'=>$collection])
                </div>
                <div class="user_tuijian">
                    <div class="title">
                        <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                        <span class="bt">为您推荐</span>
                    </div>
                    <div id="ban2">
                        <div class="banner">
                            <ul class="img">
                                <li>
                                    @foreach($wntj as $k=>$v)
                                        @if($k<6)
                                            <div class="wntj-cp wntj-cp-first">
                                                <div class="wntj-img-box">
                                                    <a href="{{$v->goods_url}}">
                                                        <img style="width: 110px;height: 110px;"
                                                             src="{{$v->goods_thumb}}"/>
                                                    </a>
                                                </div>
                                                <p class="mingzi">{{$v->goods_name}}</p>
                                                <p class="jiage">{{formated_price($v->real_price)}}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </li>
                                <li>
                                    @foreach($wntj as $k=>$v)
                                        @if($k>=6)
                                            <div class="wntj-cp wntj-cp-first">
                                                <div class="wntj-img-box">
                                                    <a href="{{$v->goods_url}}">
                                                        <img style="width: 110px;height: 110px;"
                                                             src="{{$v->goods_thumb}}"/>
                                                    </a>
                                                </div>
                                                <p class="mingzi">{{$v->goods_name}}</p>
                                                <p class="jiage">{{formated_price($v->real_price)}}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </li>
                            </ul>
                            <div class="btn btn_l">
                                <img src="{{get_img_path('images/user/lb_left_03.png')}}"/>
                            </div>
                            <div class="btn btn_r">
                                <img src="{{get_img_path('images/user/lb_right_03.png')}}"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <script type="text/javascript">
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
    @include('common.footer')
@endsection
