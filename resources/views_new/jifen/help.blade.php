@extends('jifen.layouts.body')
@section('links')
    <link href="{{path('css/jifen/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jifen/gerenzhongxin.css')}}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/jfen/jfsc-css/common.css"/>
    <script src="{{path('js/jifen/lb.js')}}" type="text/javascript" charset="utf-8"></script>
    <style>
        .vip_right_container p {
            font-size: 14px;
        }
    </style>
@endsection
@section('content')
    @include('jifen.layouts.header')
    @include('jifen.layouts.nav')
    <!--container-->
    <div class="container content">
        <div class="content_box">
            <div class="top_title">
                <img src="http://images.hezongyy.com/images/jf/address_03.png?1"/>
                <span>当前位置：<a href="{{route('jifen.index')}}">积分首页</a> > <a
                            href="{{route('jifen.help')}}">帮助中心</a>> {{$info->name}}</span>
            </div>
            <div class="vip">
                <div class="vip_left">
                    <div class="vip_left_title">
                        帮助中心
                    </div>
                    <ul class="title_list">
                        @foreach($result as $v)
                            <li @if($id==$v->id)class="active"@endif><a
                                        href="{{route('jifen.help',['id'=>$v->id])}}">{{$v->name}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="vip_right">
                    <div class="vip_right_title">
                        <img src="http://images.hezongyy.com/images/jf/dian_03.png?1"/>
                        <span>{{$info->name}}</span>
                    </div>
                    <div class="vip_right_container" style="min-height: 120px;padding: 20px;">
                        {!! $info->content !!}
                    </div>
                </div>
                @include('jifen.layouts.wntj')
            </div>
        </div>
    </div>
    <!--container-->
    @include('jifen.layouts.footer')
@endsection
