@extends('layouts.app')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/cuxiaozhuanqu.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        #znq-daohang {
            right: 45px !important;
            bottom: 20px !important;
        }

    </style>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')


    <div class="cxzq-top" style="width:100%;min-width:1200px;margin:0 auto;">
        @if(isset($link))
            <a target="_blank" href="{{$link}}">
                <img style="width: 100%;height: 100%;display: block" src="{{$img_url}}" alt=""/>
            </a>
        @else
            <img style="width: 100%;height: 100%;display: block" src="{{$img_url}}" alt=""/>
        @endif
    </div>

    <div class="cxzq-box">
        <div class="cxzq-list">
            <ul class="list-first fn_clear" style="padding-bottom:60px;">
                @foreach($mz as $v)
                    <li>
                        <a @if(!empty($v->url)) href="{{$v->url}}"
                           @else href="{{route('goods.index',['id'=>$v->goods_id])}}" @endif target="_blank"><img
                                    src="{{get_img_path($v->goods_img)}}" alt=""/></a>
                    </li>
                @endforeach

            </ul>

        </div>

    </div>
    @include('layouts.new_footer')
    @if(isset($daohang)&&$daohang==1)
        @include('miaosha.daohang')
    @endif
@endsection
