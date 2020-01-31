@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/logistics2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>

@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.pswl')}}" class="end">>　<span>配送物流</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>配送物流</h3>
                <span class="ico"></span>
            </div>

            <div class="content_box">
                <h4>配送物流</h4>
                @if($user->shipping_id!=0)
                <div class="content">
                    <p class="info">
                        <span class="box"><span class="title">物流名称：</span><span class="name" style="color: #FF6102">{{$pswl}}</span></span>
                        <span class="box"><span class="title">(修改物流请联系客户)</span></span>
                    </p>
                    <p class="info">
                        <span class="box"><span class="title">物流电话：</span><span class="name" style="color: #FF6102">{{$user->wl_dh}}</span></span>
                    </p>
                </div>
                @else
                    <div class="content">
                        <p class="info">
                            <span class="box"><span class="title">暂未选择物流配送信息。</span></span>
                        </p>
                    </div>
                @endif

            </div>



        </div>
    </div>
    @include('layout.page_footer')
@endsection
