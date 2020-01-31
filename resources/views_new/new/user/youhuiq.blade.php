@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>优惠券管理</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <link rel="stylesheet" type="text/css" href="/user/youhuijuan.css"/>
    <!--layer-->
    {{--<link rel="stylesheet" type="text/css" href="common/layer/layer.css" />--}}

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
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
                        src="/user/img/right_03.png" class="right_icon"/><span>我的优惠券</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="/new_gwc/jiesuan_img/椭圆.png"/>
                    <span>我的优惠券</span>
                </div>
                @if(count($result)>0)
                    <ul class="youhuijuan">
                        @foreach($result as $v)
                            <li>
                                <img src="{{get_img_path('images/user/juan_'.$v->img_id.'.jpg')}}"/>
                                <p class="val">{{intval($v->je)}}</p>
                                <p class="mc">【{{$v->yhq_cate->name or ''}}】</p>
                                <p class="ff">{{$v->yhq_cate->title or '满'.intval($v->min_je).'可用'}}</p>
                                <p class="riqi">@if(in_array($v->cat_id,[51,52,53,54]))
                                        限2018.03.07-08或03.27-28活动期间@elseif($v->end-$v->start>3600*24)
                                        限{{date('Y.m.d',$v->start)}}至{{date('Y.m.d',$v->end - 1)}}@else
                                        仅限{{date('Y-m-d',$v->start)}}当天@endif使用</p>
                                <p class="tiaojian">条件：{{$v->yhq_cate->msg or ''}}</p>
                                <p class="shiyong">
                                    <a href="{{route('category.index',['dis'=>1,'py'=>1])}}" class="shiyong">去使用</a>
                                </p>
                            </li>
                        @endforeach
                    </ul>
                @else
                    @include('user.empty',['type'=>3])
                @endif
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    @include('layouts.new_footer')
    <script>
        //返回顶部
        $('.btn-top').click(function() {
            $('html,body').animate({
                'scrollTop': 0
            })
        });
    </script>
@endsection
