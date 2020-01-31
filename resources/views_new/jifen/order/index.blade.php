<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>积分商城-个人中心-我的积分</title>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/jfen/jfsc-js/jquery.singlePageNav.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/jifendingdan.css"/>
    <script src="/jfen/jfsc-js/lb.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
@include('jifen.layouts.header')
@include('jifen.layouts.nav')
<!--container-->
<div class="container content">
    <div class="content_box">
        <div class="top_title">
            <img src="http://images.hezongyy.com/images/jf/address_03.png?1" />
            <span>当前位置：<a href="https://www.hezongyy.com/jifen">积分首页</a> > <a
                        href="https://www.hezongyy.com/jifen/user">个人中心</a>> 我的积分</span>
        </div>
        <div class="vip">
            @include('jifen.layouts.user_menu')
            <div class="vip_right">
                <div class="vip_right_title">
                    <img src="http://images.hezongyy.com/images/jf/dian_03.png?1"/>
                    <span>积分订单</span>
                </div>
                <div class="vip_right_container">
                    @if(count($result)>0)
                        <ul class="dingdan_title">
                            <li class="lpxx">礼品信息</li>
                            <li class="ze">总额</li>
                            <li class="ddzt">订单状态</li>
                            <li class="cz">操作</li>
                        </ul>
                        <ul class="dingdan_list" style="margin-bottom: 20px;">
                            @foreach($result as $v)
                                <li>
                                    <div class="dingdan_list_title">
										<span class="dd_num">
											订单编号：{{$v->order_sn}}
										</span>
                                        <span class="dd_time">
											下单时间：{{date('Y-m-d H:i:s',$v->add_time)}}
										</span>
                                        <span class="dd_user">
											收货人：{{$v->address->name or ''}}<img
                                                    src="http://images.hezongyy.com/images/jf/zhankai.png?1" alt=""/>
											<div class="dd_user_box">
												<img src="http://images.hezongyy.com/images/jf/alert_box_sanjiao.png?1"
                                                     class="sanjiao_icon"/>
												<p class="name">
													<img src="http://images.hezongyy.com/images/jf/zhuizong_dian.png?1"/>
													<span class="left">收货人：</span>
													<span class="right">{{$v->address->name or ''}}</span>
												</p>
												<p class="name">
													<img src="http://images.hezongyy.com/images/jf/zhuizong_dian.png?1"/>
													<span class="left">
														联系电话：
													</span>
													<span class="right">{{$v->address->mob_phone or ''}}</span>
												</p>
												<p class="name">
													<img src="http://images.hezongyy.com/images/jf/zhuizong_dian.png?1"/>
													<span class="left">
														收货地址：
													</span>
													<span class="right">{{$v->address->address or ''}}</span>
												</p>
											</div>
										</span>
                                    </div>
                                    <div class="dingdan_content">
                                        <div class="dingdan_content_left">
                                            @foreach($v->goods as $goods)
                                                <div class="ct">
                                                    <div class="img_box">
                                                        <a href="{{route('jifen.goods.show',['id'=>$goods->goods_id])}}"><img
                                                                    style="width: 100%;height: 100%;"
                                                                    src="http://jf.jyeyw.com.{{substr($goods->goods_image,1)}}"/></a>
                                                    </div>
                                                    <div class="text">
                                                        <p class="name">{{$goods->goods_name}}</p>
                                                        <p class="jifen">
                                                            <span class="fr">数量：<span>{{$goods->goods_num}}</span></span>
                                                            积分：{{$goods->jf}}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="dingdan_content_right">
                                            <div class="ze">{{$v->goods_amount}}</div>
                                            <div class="ddzt">{!! $v->order_state !!}</div>
                                            <div class="cz">
                                                <a href="{{route('jifen.order.show',['id'=>$v->id])}}">订单详情</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @include('user.pages',['pages'=>$result])
                    @else
                        @include('user.empty',['type'=>4])
                    @endif
                </div>
            </div>
            @include('jifen.layouts.wntj')
        </div>
    </div>
</div>
<!--container-->
@include('jifen.layouts.footer')
</body>

</html>