@extends('layouts.app')
@section('links')
    <meta http-equiv="refresh" content="3;URL={{$link or route('index')}}"/>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
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
        <p>{{$content}}</p>
        @if($messageInfo!='')
            @foreach($messageInfo as $v)
                <a href="{{$v['url']}}">{{$v['info']}}</a>
            @endforeach
        @endif
    </div>
    @include('layouts.new_footer')
@endsection
