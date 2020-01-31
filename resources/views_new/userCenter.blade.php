@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/slides.jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/my_order.js')}}"></script>

    <style>
        .main .main_left {
            border-right: 0;
        }

        .main {
            margin-top: 12px;
        }

        .ddgz-alert {
            margin-left: -90px !important;
        }

        .hover_underline:hover {
            text-decoration: underline;
        }

        .main_mid ul.ul_list li {
            width: 150px;
            text-align: center;
        }

        .main_mid ul li .ico_com {
            margin: 0;
            float: none;;
            vertical-align: middle;
            display: inline-block;
            margin-right: 5px;
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="main fn_clear">

        @include('layout.user_menu')

        <div class="main_mid">
            <ul class="fn_clear ul_list">
                <a href="{{route('user.accountInfo')}}" style="color: #666;">
                    <li><span class="ico_com ico_1"></span>账户余额<p>{{formated_price($user->user_money)}}</p></li>
                </a>
                <a href="{{route('jf.member')}}" style="color: #666;">
                    <li><span class="ico_com ico_2"></span>可用积分<p>{{$user->pay_points}}分</p></li>
                </a>
                <a style="color: rgb(102, 102, 125);" href="{{route('user.czjl')}}">
                    <li><span class="ico_com ico_3"></span>易诊云充值余额
                        <p>{{formated_price(collect($user_jnmj)->get('jnmj_amount',0))}}</p>
                    </li>
                </a>
                <a style="color: rgb(102, 102, 125);" href="{{route('cz_money.log')}}">
                    <li><span class="ico_com ico_3"></span>119充值余额
                        <p>{{formated_price(collect($user->cz_money)->get('money',0))}}</p>
                    </li>
                </a>
                <li class="end"><span class="ico_com ico_4"></span>待付款金额<p>{{$wait_amount}}</p></li>
            </ul>
            <div class="infor">
                <div class="title_name">
                    {{--<a class="hover_underline" href="{{route('user.youhuiq')}}" style="font-size: 18px;color: #FF6102;">优惠券管理&nbsp;&gt;&gt;</a>--}}
                    <ul>
                        <li style="float: left;font-size: 18px;">我的优惠劵：<a href="/user/youhuiq"
                                    style="float: none;display: inline;font-size: 18px;color:#FF6102;margin-left: 5px;">{{$yhq_count}}
                                张</a>
                        </li>
                        <li style="float: left;font-size: 18px;margin-left: 50px;">我的积分金币：<a href="/jf_money/log"
                                    style="float: none;display: inline;font-size: 18px;color:#FF6102;margin-left: 5px;">{{intval(collect($user->jf_money)->get('money',0))}}
                                个</a></li>
                    </ul>

                </div>
            </div>
            @if($user->is_zq==1||$user->is_zq==2)
                <div class="infor">
                    <div class="title_name"><h4>账期信息</h4><span class="medal"></span></div>
                    <table>
                        <tr class="first">
                            <td><span class="title">账期总额度</span> {{formated_price($user->zq_je)}} </td>
                            <td><span class="title">账期消费额度</span> {{formated_price($user->zq_amount)}}</td>
                            <td><span class="title">账期还款日期</span> 每月 <font style="color:#f00;">{{$user->zq_rq}}</font> 日
                            </td>
                        </tr>
                        <tr>
                            {{--<td><span class="title">账期业务员</span> {{$user->zq_ywy}}  </td>--}}
                            <td class="num"><span class="title">上月账期是否结清 </span> <span class="num">@if($user->zq_has==1)
                                        未结清@else已结清@endif</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </table>


                </div>
            @endif
            @if(isset($sy_zq->is_zq)&&$sy_zq->is_zq==1)
                <div class="infor">
                    <div class="title_name"><h4 style="width: 150px;">尚医账期信息</h4><span class="medal"></span></div>
                    <table>
                        <tr class="first">
                            <td><span class="title">账期总额度</span> {{formated_price($sy_zq->zq_je)}} </td>
                            <td><span class="title">账期消费额度</span> {{formated_price($sy_zq->zq_amount)}}</td>
                            <td><span class="title">账期还款日期</span> 每月 <font style="color:#f00;">{{$sy_zq->zq_rq}}</font>
                                日
                            </td>
                        </tr>
                    </table>


                </div>
            @endif
            <div class="infor">
                <div class="title_name"><h4>会员信息</h4> <span class="name">当前单位：{{$user->msn}}</span> <span class="txt">(精品专区可兑换积分:{{$user->jp_points}}
                        )</span> <span class="medal"></span></div>
                <table>
                    @if($user->user_rank==2)
                        <tr class="first">
                            <td><span class="title">您的委托书已经审核</span> @if($user->ls_review==1)通过@else未通过@endif </td>
                            <td><span class="title">营业执照</span> @if($yyzz_time==1)未过期@else<font
                                        style="color:#f00;">已过期</font>@endif @if(!empty($user->yyzz_time))
                                    ({{$user->yyzz_time}})@endif</td>
                            <td><span class="title">药品经营许可证</span> @if($xkz_time==1)未过期@else<font style="color:#f00;">已过期</font>@endif @if(!empty($user->xkz_time))
                                    ({{$user->xkz_time}})@endif</td>
                        </tr>
                        <tr>
                            <td><span class="title">GSP证书</span> @if($zs_time==1)未过期@else<font
                                        style="color:#f00;">已过期</font>@endif  @if(!empty($user->zs_time))
                                    ({{$user->zs_time}})@endif</td>
                            <td class="num"><span class="title">可用含麻委托书数量 </span> <span class="num">{{$user->mhj_number}}
                                    份</span></td>
                            <td></td>
                        </tr>
                    @elseif($user->user_rank==5)
                        <tr class="first">
                            <td><span class="title">您的委托书已经审核</span> @if($user->ls_review==1)通过@else未通过@endif </td>
                            <td><span class="title">营业执照</span> @if($yyzz_time==1)未过期@else<font
                                        style="color:#f00;">已过期</font>@endif @if(!empty($user->yyzz_time))
                                    ({{$user->yyzz_time}})@endif</td>
                            <td><span class="title">医疗机构执业许可证</span> @if($yljg_time==1)未过期@else<font
                                        style="color:#f00;">已过期</font>@endif @if(!empty($user->yljg_time))
                                    ({{$user->yljg_time}})@endif</td>
                        </tr>
                        <tr>
                            <td class="num"><span class="title">可用含麻委托书数量 </span> <span class="num">{{$user->mhj_number}}
                                    份</span></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @else
                        <tr class="first">
                            <td><span class="title">您的资质已经审核</span> @if($user->ls_review==1)通过@else未通过@endif </td>
                            <td class="num"><span class="title">可用含麻委托书数量 </span> <span class="num">{{$user->mhj_number}}
                                    份</span></td>
                            <td></td>
                        </tr>
                    @endif
                </table>


            </div>

            <div class="order fn_clear">
                <div class="title">
                    <h4>最近订单</h4>
                    <p class="title"><a href="{{route('user.orderList',['status'=>100])}}">待付款 <span
                                    class="num">{{$wait_order}}</span></a> |</p>
                    <p class="title"><a href="{{route('user.orderList',['status'=>101])}}">待收货 <span
                                    class="num">{{$pay_order}}</span></a>
                    <p class="title" style="float: right"><a class="hover_underline" href="{{route('user.orderList')}}"
                                                             style="font-size: 12px;color: #39a817;line-height: 30px;">更多&gt;&gt;</a>
                    </p>

                </div>
                @if(count($near_order)==0)
                    <div class="tip">
                        <span class="tip_ico"></span>
                        <span>您买的东西太少了，这里空空的，快去挑选合适的商品吧！</span>
                    </div>
                @else
                    <table class="table_order clips">
                        <tr>
                            <th>订单号</th>
                            <th>下单时间</th>
                            <th>订单总金额</th>
                            <th>订单状态</th>
                            <th> 操作</th>
                        </tr>
                        @foreach($near_order as $v)
                            <tr>
                                <td class="nub tb1_td1" data-id='{{$v->order_id}}'><a
                                            href="{{route('user.orderInfo',['id'=>$v->order_id])}}">{{$v->order_sn}}</a>
                                </td>
                                <td class="date tb1_td2">{{date('Y-m-d H:i:s',$v->add_time)}}    </td>
                                <td class="score tb1_td4">{{formated_price($v->goods_amount)}}</td>
                                <td class="data tb1_td5">
                                    {{order_status($v->order_id,$v->order_status,$v->pay_status,$v->shipping_status,'tip')}}
                                    &nbsp; &nbsp; <span class="stat" style="color:#39A817;cursor:pointer;" id="ddgz"
                                                        dd-url="{{route('user.ddgz')}}">订单跟踪</span>
                                    @if(strpos($v->fhwl_m,'宅急送')!==false&&$v->shipping_status>=4)
                                        &nbsp; &nbsp;<a style="color: #FF6102" target="_blank"
                                                        href="{{route('zjs',['id'=>$v->order_id,'is_zq'=>$v->is_zq,'is_separate'=>$v->is_separate])}}">物流跟踪</a>
                                    @endif
                                </td>
                                <td class="result tb1_td6">
                                    {!!order_status($v->order_id,$v->order_status,$v->pay_status,$v->shipping_status,'handle')!!}
                                    &nbsp;&nbsp;
                                    <a href="{{route('user.orderInfo',['id'=>$v->order_id])}}" class="f6">查看订单</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
            <div class="collect fn_clear">
                <div class="title">
                    <h4>我的收藏</h4>
                    <p class="title" style="float: right;margin-right: 27px;"><a class="hover_underline"
                                                                                 href="{{route('user.collectList')}}"
                                                                                 style="font-size: 12px;color: #39a817;line-height: 30px;">更多&gt;&gt;</a>
                    </p>
                </div>
                @if(count($collection)==0)
                    <div class="tip">
                        <span class="tip_ico"></span>
                        <p>您还没有收藏任何商品，看到感兴趣的商品就果断收藏吧！</p>
                    </div>
                @else
                    <table class="table_order table_collect">
                        <tr>
                            <th>商品名称</th>
                            <th>生产厂家</th>
                            <th>规格</th>
                            <th>价格</th>
                            <th> 操作</th>
                        </tr>
                        @foreach($collection as $v)
                            <tr>
                                <td class="nub tb1_td1"><a
                                            href="{{route('goods.index',['id'=>$v->goods_id])}}">{{str_limit($v->goods->goods_name,14)}}</a>
                                </td>
                                @foreach($v->goods->goods_attr as $val)
                                    @if($val->attr_id==1)
                                        <td class="date tb1_td2">{{str_limit($val->attr_value,20)}}</td>@endif
                                    @if($val->attr_id==3)
                                        <td class="score tb1_td4">{{str_limit($val->attr_value,14)}}</td>@endif
                                @endforeach
                                <td class="data tb1_td5">@if($user->ls_review==1){{formated_price($v->goods->shop_price)}}@else
                                        会员可见@endif</td>
                                <td class="result tb1_td6">
                                    <a class="goshopping"
                                       href="javascript:addToCart1({{$v->goods_id}},{{$v->goods->zbz or 1}})">加入购物车</a>
                                    <a href="javascript:if (confirm('您确定要从收藏夹中删除选定的商品吗?')) location.href='{{route('user.deleteCollect',['id'=>$v->rec_id])}}'"
                                       class="f6">取消收藏</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>

            <div class="groom fn_clear">
                <div class="title">
                    <h4>为您推荐</h4>

                </div>
                <div id="slides" class="visual3 slides">
                    <ul class="slides_container" style="display: block;">
                        @foreach($wntj as $k=>$v)
                            @if($k==4)
                                <li class="common">
                                    <div>
                                        @foreach($wntj as $key=>$val)
                                            @if($key<5)
                                                <div class="base">
                                                    <a href="{{route('goods.index',['id'=>$val->goods_id])}}"> <img
                                                                src="{{$val->goods_thumb}}"/></a>
                                                    <div>
                                                        <p alt="{{$val->goods_name}}"
                                                           title="{{$val->goods_name}}">{{str_limit($val->goods_name,8)}}</p>
                                                        <p alt="{{$val->shop_price}}"
                                                           title="{{$val->shop_price}}">{{formated_price($val->shop_price)}}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </li>
                            @elseif($k==5)
                                <li class="common">
                                    <div>
                                        @foreach($wntj as $key=>$val)
                                            @if($key>=5)
                                                <div class="base">
                                                    <a href="{{route('goods.index',['id'=>$val->goods_id])}}"> <img
                                                                src="{{$val->goods_thumb}}"/></a>
                                                    <div>
                                                        <p alt="{{$val->goods_name}}"
                                                           title="{{$val->goods_name}}">{{str_limit($val->goods_name,8)}}</p>
                                                        <p alt="{{$val->shop_price}}"
                                                           title="{{$val->shop_price}}">{{formated_price($val->shop_price)}}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="slideControl slideContro_tab">
                        <p class="slide_lBt"><a href="javascript:void(0);" class="prev"></a></p>
                        <p class="slide_rBt"><a href="javascript:void(0);" class="next"></a></p>
                    </div>
                </div>

            </div>
        </div>

        {{--<div class="main_right">--}}
        {{--<h4>公告</h4>--}}
        {{--<ul class="fn_clear">--}}
        {{--@foreach($gg as $v)--}}
        {{--<li><a href="{{route('articleInfo',['id'=>$v->article_id])}}" title="{{$v->title}}">--}}
        {{--<span class="ico"></span>--}}
        {{--<span class="text">{{$v->title}}</span>--}}
        {{--<em>[{{date('m-d',$v->add_time)}}]</em>--}}
        {{--</a></li>--}}
        {{--@endforeach--}}
        {{--</ul>--}}
        {{--</div>--}}
        <div class="content-right">

            <ul class="fn_clear">
                @foreach(ads(156) as $v)
                    <li>
                        <a target="_blank" href="{{$v->ad_link}}">
                            <img src="{{$v->ad_code}}">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <script type="text/javascript">
        //滚动播放
        $(function () {
            $('#slides').slides({
                container: 'slides_container',
                preload: true,
                play: 3000,
                pause: 1500,
                hoverPause: true,
                effect: 'slide',
                slideSpeed: 850
            });
        })
    </script>
    @include('common.footer')
@endsection
