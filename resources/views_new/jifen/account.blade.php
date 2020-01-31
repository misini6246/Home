<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>积分商城-个人中心-我的积分</title>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/jfen/jfsc-js/jquery.singlePageNav.min.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/common.css"/>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/gerenzhongxin.css"/>
    <script src="/jfen/jfsc-js/lb.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
@include('jifen.layouts.header')
@include('jifen.layouts.nav')
<!--container-->
<div class="container content">
    <div class="content_box">
        <div class="top_title">
            <img src="http://images.hezongyy.com/images/jf/address_03.png?1"/>
            <span>当前位置：<a href="{{route('jifen.index')}}">积分首页</a> > <a
                        href="{{route('jifen.user.index')}}">个人中心</a>> 我的积分</span>
        </div>
        <div class="vip">
            @include('jifen.layouts.user_menu')
            <div class="vip_right">
                <div class="vip_right_title">
                    <img src="http://images.hezongyy.com/images/jf/dian_03.png?1"/>
                    <span>我的积分</span>
                </div>
                <div class="vip_right_container">
                    <div class="account">
                        <div class="kyjf">
                            <span>可用积分：</span><span class="jf">{{$user->pay_points}}</span>
                            <a href="{{route('jifen.index')}}" class="dh">去兑换礼品</a>
                            <a href="{{route('index')}}" class="zq">去赚取积分</a>
                        </div>
                        <div class="yyjf">
                            已用积分：<span>{{abs($use_points)}}</span>
                        </div>
                    </div>
                    <div class="jfjl">
                        <div class="jfjl_title">
                            积分记录
                        </div>
                        @if(count($result)>0)
                            <table>
                                <thead>
                                <tr>
                                    <th class="time">操作时间</th>
                                    <th class="jfbd">积分变动</th>
                                    <th class="jfjy">积分结余</th>
                                    <th class="bz">备注</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($result as $v)
                                    <tr>
                                        <td class="time">{{date('Y-m-d H:i:s',$v->change_time)}}</td>
                                        <td class="jfbd">@if($v->pay_points>0)
                                                +@else-@endif {{abs($v->pay_points)}}</td>
                                        <td class="jfjy">{{$v->now_points}}</td>
                                        <td class="bz">{{$v->change_desc}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @include('user.pages',['pages'=>$result])
                        @else
                            @include('user.empty',['type'=>4])
                        @endif
                    </div>
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