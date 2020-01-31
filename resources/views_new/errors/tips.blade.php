@extends('layouts.app')
@section('links')
    <meta http-equiv="refresh" content="30;URL={{$link or route('index')}}"/>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>基本信息</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <!--layer-->
    {{--<link rel="stylesheet" type="text/css" href="common/layer/layer.css" />--}}
    <!--时间选择器-->
    <link rel="stylesheet" type="text/css" href="/user/date/date_input.css"/>

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
    <!--IE兼容-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 7]>
    <script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
    <style type="text/css">
        .ts_page {
            height: 240px;
            border: 1px solid #b2cdff;
            width: 1200px;
            margin: 10px auto 40px auto;
            box-shadow: 10px 10px 16px rgba(61, 121, 254, 0.2);
            text-align: center;
        }

        .ts_page p {
            color: #ff1919;
            font-size: 20px;
            margin-top: 65px;
        }

        .ts_page a {
            font-size: 16px;
            color: #fff;
            display: inline-block;
            width: 120px;
            height: 40px;
            line-height: 40px;
            border-radius: 5px;
            background: #3dbb2b;
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div class="ts_page">
        <p>{{$exception->getMessage()}}</p>
        @if(count($exception->getLinks())==0)
            <a href="{{route('index')}}">返回首页</a>
        @else
            @foreach($exception->getLinks() as $k=>$v)
                <a href="{{$v}}">{{$k}}</a>
            @endforeach
        @endif
    </div>
    @include('layouts.new_footer')
@endsection
