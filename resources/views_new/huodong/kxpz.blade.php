@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .main-box ul{width: 1400px;}
        .main-box ul li{width: 260px;height: 375px;margin-right: 206px;float: left;}
        .huodong-box ul li{width: 520px;height: 510px;margin: 0 25px 0 45px;float: left;}

    </style>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div  style="background: url('{{get_img_path('images/kongxiaozq01.jpg')}}') no-repeat scroll center top;height: 555px;min-width: 1200px;overflow: hidden;width: 100%;">


    </div>

    <div class="main-box" style="width:1200px;margin:55px auto;overflow:hidden;">
        <ul class="fn_clear">
            <li><a target="_blank" href="http://www.hezongyy.com/category?dis=q&showi=0"><img src="{{get_img_path('images/n-kongxiaozq01.jpg')}}" alt="" /></a></li>
            {{--<li><a target="_blank" href="http://www.hezongyy.com/category?dis=o&showi=0"><img src="{{get_img_path('images/n-kongxiaozq02.jpg')}}" alt="" /></a></li>--}}
            <li><a target="_blank" href="http://www.hezongyy.com/category?dis=p&showi=0"><img src="{{get_img_path('images/n-kongxiaozq03.jpg')}}" alt="" /></a></li>
            {{--<li><a target="_blank" href="http://www.hezongyy.com/category?dis=n&showi=0"><img src="{{get_img_path('images/n-kongxiaozq04.jpg')}}" alt="" /></a></li>--}}
        </ul>

        <div style="width:1200px;height:100px;margin:100px auto 50px auto;"><img src="{{get_img_path('images/n-kongxiaozq05.jpg')}}" alt="" /></div>

        {{--<div class="title" style="text-align:center">--}}
            {{--<h3 style="font-size:30px;color:#000000;font-weight:normal;margin-bottom:10px;">优享活动</h3>--}}
            {{--<p style="font-size:16px;color:#555">活动时间：2017年2月1日—3月31日</p>--}}
        {{--</div>--}}

        {{--<div class="huodong-box" style="width:1200px;margin:55px auto 0 auto;overflow:hidden;">--}}
            {{--<ul>--}}
                {{--<li><a target="_blank" href="/goods?id=26045"><img src="{{get_img_path('images/n-kongxiaozq06.jpg')}}" alt="" /></a></li>--}}
                {{--<li><a target="_blank" href="/goods?id=25965"><img src="{{get_img_path('images/n-kongxiaozq07.jpg')}}" alt="" /></a></li>--}}
            {{--</ul>--}}


        {{--</div>--}}

    </div>
    @include('layout.page_footer')

@endsection
