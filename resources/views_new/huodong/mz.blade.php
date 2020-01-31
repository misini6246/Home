@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/cuxiaozhuanqu.css')}}" rel="stylesheet" type="text/css" />



    <script src="{{path('js/modernizr-custom-v2.7.1.min.js')}}" type="text/javascript"></script>
    <script src="{{path('js/jquery-finger-v0.1.0.min.js')}}" type="text/javascript"></script>

    <script src="{{path('js/flickerplate.min.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function(){

            $('.flicker-example').flicker();
        });
    </script>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="flicker-example" data-block-text="false">
        <ul>
            @foreach($cxzq as $v)
                <li data-background="{{$v->ad_code}}">
                    <a style="width:100%;height:350px;display:block;" href="{{$v->ad_link}}" target="_blank"></a>
                </li>
            @endforeach
        </ul>
    </div>



    <div class="cxzq-top" style="width:1200px;height:145px;margin:0 auto;">
        <div class="title" style="width:430px;height:145px;margin: 0 auto;"><img src="{{get_img_path('images/new-cuxiao.jpg')}}" alt="" /></div>

    </div>

    <div class="cxzq-box">
        <div class="cxzq-list">
            <ul class="list-first fn_clear" style="padding-bottom:60px;">
                @foreach($mz as $v)
                    <li>
                        <a href="{{route('goods.index',['id'=>$v->goods_id])}}" target="_blank"><img src="{{get_img_path($v->goods_img)}}" alt="" /></a>
                    </li>
                @endforeach

            </ul>

        </div>

    </div>
    @include('layout.page_footer')

@endsection
