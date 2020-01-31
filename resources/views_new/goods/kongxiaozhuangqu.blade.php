@extends('layouts.body')
@section('links')
    {{--<meta http-equiv="refresh" content="3;URL={{$link or route('index')}}"/>--}}
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
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
            height: 820px;
            border: 1px solid #b2cdff;
            width: 1200px;
            margin: 10px auto 40px auto;
            box-shadow: 10px 10px 16px rgba(61, 121, 254, 0.2);
            text-align: center;
        }

        .ts_page p {
            color: #ff1919;
            font-size: 20px;
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

        .box {
            width: 1000px;
            height: 100%;
            margin: 10px auto;
        }
        .box .img-box {
            width: 198px;
            height: 240px;
            float: left;
            border: 1px solid #e5e5e5;
        }
        .box .img-box img {
            display: block;
            width: 100%;
            height: 100%;
        }
        .box .name {
            display: block;
            width: 100%;
            height: 40px;
            line-height: 40px;
            text-align: center;
        }
    </style>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div class="ts_page">
        {{--<p style="margin-top: 65px;">{{'控销专区建设中。。。。需要购买请联系客服人员：15183920537'}}</p>--}}
        <div class="box">
            @foreach($ads as $ad)
            <div class="img-box">
                <a href="{{$ad->ad_link}}" style="width: 100%;height: 200px;margin: 0;">
                    <img style="width: 100%;height: 100%;" src="{{$ad->ad_code}}"/>
                </a>
                <span class="name">{{$ad->ad_name}}</span>
            </div>
                @endforeach
        </div>
    </div>
    @include('layouts.old_footer')
@endsection
