@extends('layout.body')
@section('links')
    @include('layout.token')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('bailing/css/cuxiaozhuanqu.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{path('bailing/js/modernizr-custom-v2.7.1.min.js')}}" type="text/javascript"></script>
    <script src="{{path('bailing/js/jquery-finger-v0.1.0.min.js')}}" type="text/javascript"></script>

    <script src="{{path('bailing/js/flickerplate.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function(){

            $('.flicker-example').flicker();
        });
    </script>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    {{--<div class="flicker-example" data-block-text="false" style="height:399px;">--}}
        {{--<ul>--}}
            {{--<li data-background="{{path('bailing/images/banner.jpg')}}">--}}
                {{--<a href="#" style="width:100%;display:block;"></a>--}}
            {{--</li>--}}
            {{--<!--<li data-background="images/cuxiao02.jpg">--}}
             {{--<a href="#" style="width:100%;height:350px;display:block;"></a>--}}
            {{--</li>--}}
            {{--<li data-background="images/cuxiao03.jpg">--}}
                {{--<a href="#" style="width:100%;height:350px;display:block;"></a>--}}
            {{--</li>-->--}}
        {{--</ul>--}}

    {{--</div>--}}

    <div class="banner">
        <!--<img src="images/banner.jpg" alt="" />-->
    </div>

    <!--<div class="cxzq-top" style="width:1200px;height:145px;margin:0 auto;">-->
    <!--<div class="title" style="width:430px;height:145px;margin: 0 auto;"><img src="./images/new-cuxiao.jpg" alt="" /></div>-->

    <!--</div>-->

    <div class="cxzq-box">
        <div class="tejiaqu" style="margin:0 auto;width:176px;height:56px;">
        </div>

        <div class="cxzq-list1" style="text-align: center">
            <ul class="list-first1">
                <li>
                    <a target="_blank" href="http://www.hezongyy.com/goods?id=27205">
                        <img src="{{path('bailing/images/tihuan2.jpg')}}" alt="" />
                    </a>
                </li>
            </ul>
        </div>
        <div class="huangouqu" style="margin:0 auto;width:176px;height:56px;padding: 30px;">
        </div>

        <div class="cxzq-list">
            <ul class="">
                <li>
                    <a target="_blank" href="http://www.hezongyy.com/goods?id=27207"><img src="{{path('bailing/images/tihuan3.jpg')}}" alt="" /></a>
                </li>
                <li>
                    <a target="_blank" href="http://www.hezongyy.com/goods?id=27211"><img src="{{path('bailing/images/tihuan4.jpg')}}" alt="" /></a>
                </li>
                <li>
                    <a target="_blank" href="http://www.hezongyy.com/goods?id=20315"><img src="{{path('bailing/images/tihuan5.jpg')}}" alt="" /></a>
                </li>
                <li>
                    <a target="_blank" href="http://www.hezongyy.com/goods?id=27208"><img src="{{path('bailing/images/tihuan6.jpg')}}" alt="" /></a>
                </li>
                <li>
                    <a target="_blank" href="http://www.hezongyy.com/goods?id=12900"><img src="{{path('bailing/images/tihuan7.jpg')}}" alt="" /></a>
                </li>
                <li>
                    <a target="_blank" href="http://www.hezongyy.com/goods?id=17242"><img src="{{path('bailing/images/tihuan8.jpg')}}" alt="" /></a>
                </li>
                <li>
                    <a target="_blank" href="http://www.hezongyy.com/goods?id=27206"><img src="{{path('bailing/images/tihuan9.jpg')}}" alt="" /></a>
                </li>
            </ul>

        </div>

    </div>
    @include('layout.weixin')
    @include('layout.page_footer')
@endsection