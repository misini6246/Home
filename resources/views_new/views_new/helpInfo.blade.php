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
@endsection
@section('content')
@include('layout.page_header_help')

<div class="help_container">
    <div class="main_left">
        @include('layout.articleTree')
    </div>
    {!! $article !!}
</div>

@include('layout.page_footer_help')
@endsection
