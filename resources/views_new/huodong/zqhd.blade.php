@extends('layout.body')
@section('links')
    @include('layout.token')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        body{
            margin: 0;
            padding: 0;
        }
        .container-zq{
            width:100%;
            height:2920px;
        }
        .container-box{
            width: 1200px;
            margin: 0 auto;
            height: 3099px;
            position: relative;
        }
        .ZQURL1,.ZQURL2,.ZQURL3,.ZQURL4{
            width:560px;
            height:280px;
            cursor:pointer
        }
        .ZQURL1{
            position: absolute;
            top: 757px;

        }
        .ZQURL2{
            position: absolute;
            top: 757px;
            left: 640px;

        }
        .ZQURL3{
            position: absolute;
            top:1130px;
            left:0px;

        }
        .ZQURL4{
            position: absolute;
            top:1130px;
            left:640px;

        }
        .maiwan{
            font-size: 30px;
            height: 80px;
            line-height: 80px;
            width: 277px;
            text-align: center;
            background: rgba(0,0,0,0.5);
            filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#7f000000,endColorstr=#7f000000);
            color: white;
            margin: 182px 0 0 2px;
        }

    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="container-zq" @if(time()<strtotime(20170413)) style="background: url('{{get_img_path('images/zhengqing.jpg')}}') no-repeat scroll center top;" @else style="background: url('{{get_img_path('images/zhengqing-2.jpg')}}') no-repeat scroll center top;" @endif>
        <div class="container-box">
            <a target="_blank" href="/goods?id=27155" class="ZQURL1"></a>
            <a target="_blank" href="/goods?id=27371" class="ZQURL2"></a>
            <a target="_blank" href="/goods?id=27156" class="ZQURL3">
                <div class="maiwan">已卖完</div>
            </a>
            <a target="_blank" href="/goods?id=27154" class="ZQURL4"></a>
        </div>
    </div>
    @include('common.footer')
@endsection