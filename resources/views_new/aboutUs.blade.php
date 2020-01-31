@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/about_us_c.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/about_jiajie.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
@endsection
@section('content')
@include('layout.page_header')
@include('layout.nav')
<div class="com div1">
</div>
<div class="com div2" >

</div>
<div class="com div3">
</div>

<div class="com div4" >
</div>
<div class="com div5">
</div>
<div class="com div6" >
</div>
<div class="com div7"  >
    <div class="btm" style="width: 1200px;margin: 0 auto;position: relative">
        <a href="javascript:;" class="chengdou" style="position: absolute;width: 125px;height: 40px;left: 763px;top:128px;"></a>
        <a href="javascript:;" class="xinjiang" style="position: absolute;width: 125px;height: 40px;left: 944px;top:128px;"></a>
    </div>




</div>

<script type="text/javascript">
    $(".chengdou").click(function () {
        $(this).parents(".div7").removeClass("checked_on");
    });
    $(".xinjiang").click(function () {
        $(this).parents(".div7").addClass("checked_on");

    });





</script>

@include('layout.page_footer')
@endsection
