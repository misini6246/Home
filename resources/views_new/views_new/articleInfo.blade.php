@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/attach_left.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/help.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.lazyload.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jump.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.boxy.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/slides.jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.cookie.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/about_us_c.js')}}"></script>
    <style type="text/css">
        .help_container{min-height:763px;}
        .help_container .main_left{min-height: 763px;}
    </style>
@endsection
@section('content')
@include('layout.page_header_help')
<style>
    .subNavBox .subNav1 {
        height: 45px;
        line-height: 45px;
        font-size: 16px;
        font-weight: bolder;
        color: #393838;
        text-indent: 42px;
        border-bottom: 1px solid #E6E3E3;
    }
</style>
<div class="help_container fn_clear">
    <div class="main_left">
        <div class="title"><img src="{{path('images/help1.png')}}"></div>
        <div class="subNavBox">
            <a href="{{route('article.index',['id'=>4])}}" title="公司动态"><div class="subNav1">公司动态</div></a>
            <a href="{{route('article.index',['id'=>12])}}" title="医药信息"><div class="subNav1">医药信息</div></a>
        </div>
    </div>
    <div class="main_right">
        {!! $top !!}
        <div class="content_box">
            <h4>{{$article->title}}</h4>
            <p>@if($article->content!='')
                    {!! $article->content !!}
                @endif</p>

        </div>

    </div>
</div>

@include('layout.page_footer_help')
@endsection
