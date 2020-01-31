@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <style>
        .pingpai-box{width: 100%;padding: 20px 0 20px 0;}
        .pingpai-box .pingpai-list{width: 1200px;margin: 0 auto;overflow: hidden;}
        .pingpai-box .pingpai-list ul{width: 1240px;}
        .pingpai-box .pingpai-list ul li{position: relative;width: 290px;height: 450px;float: left;background-color: #f0f0f0;margin:0 10px 20px 0;}
        .pingpai-box .pingpai-list ul li .li-box img{width: 290px;height: 450px;}
    </style>

@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    @if($ad117)
    <div class="pingpaizq"  style="background: url('{{$ad117->ad_code}}') no-repeat scroll center top;height: 400px;min-width: 1200px;overflow: hidden;width: 100%;">

    </div>
    @endif





    <div class="pingpai-box">
        <div class="pingpai-list">
            <ul class="list-first fn_clear" >
                @foreach($ad118 as $v)
                    <li>
                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}" alt="" /></a>
                    </li>
                @endforeach
            </ul>

        </div>

    </div>

    {{--<div class="banner" style="width:1200px;height:95px;margin: 0 auto;position:relative;">--}}
        {{--<img src="{{get_img_path('images/pingpai.gif')}}" alt="" />--}}
        {{--<a href="#" style="width:130px;height:50px;position:absolute;top:20px;right:50px;"></a>--}}
    {{--</div>--}}


    <div class="tebietj" style="width:1200px;margin: 50px auto;position:relative;" >
        <div style="width:330px;height:70px;margin:20px auto;"><img src="{{get_img_path('images/pingpai-title.jpg')}}" alt="" /></div>
        <div style="width:1200px;height:440px;position:relative;">
            @if($ad119)
            <img src="{{$ad119->ad_code}}" alt="" />
            @endif
            <a href="#"  style="width:140px;height:50px;position:absolute;bottom:40px;left:38px;"> </a>
        </div>



    </div>

    @include('layout.page_footer')

@endsection
