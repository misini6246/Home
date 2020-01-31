@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />


@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="xinren" style="background: url('{{get_img_path('images/xinrenlianquan01.jpg')}}') no-repeat;height: 530px;width: 1200px;overflow: hidden;margin: 0px auto 20px auto;position:relative;">
        <a target="_blank" href="{{route('user.regMsg')}}" style="width:140px;height:45px;position:absolute;left:440px;bottom:35px;"> </a>
        <a target="_blank" href="{{route('user.youhuiq')}}" style="width:140px;height:45px;position:absolute;left:625px;bottom:35px;"> </a>


    </div>
    @include('layout.page_footer')
@endsection
