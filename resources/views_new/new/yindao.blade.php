@extends('layout.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <!--IE兼容-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 7]>
    <script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div style="text-align: center"><img src="{{get_img_path('adimages1/201806/yindao.jpg')}}" alt=""></div>
    @include('layouts.old_footer')
@endsection
