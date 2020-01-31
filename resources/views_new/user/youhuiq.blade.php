@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/youhuijuan.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>我的优惠券</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
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
    @include('common.footer')
@endsection
