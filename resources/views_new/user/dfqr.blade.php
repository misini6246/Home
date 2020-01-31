@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/cuxiaozhuanqu.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        ul, li, ol {
            list-style: none;
        }

        .container {
            width: 100%;
        }

        .invitation_box {
            width: 900px;
            margin: 0 auto;
            padding: 50px 0;
        }

        .invitation {
            width: 900px;
            height: 616px;
            background: url('{{get_img_path('images/user/querenhan_bg.jpg')}}') no-repeat;
            position: relative;
        }

        .invitation .money_list {
            overflow: hidden;
            text-align: center;
            position: absolute;
            top: 357px;
            left: 319px;
        }

        .invitation .money_list li {
            width: 170px;
            float: left;
            height: 50px;
            line-height: 50px;
            color: #ff1919;
            font-size: 18px;
        }

        .invitation .company, .invitation .data {
            position: absolute;
            height: 16px;
            line-height: 16px;
            color: #ff1919;
            font-size: 16px;
        }

        .invitation .company {
            top: 530px;
            left: 146px;
        }

        .invitation .data {
            top: 555px;
            right: 74px;
        }

        .invitation .data span {
            display: inline-block;
            width: 52px;
            text-align: center;
        }

        .invitation .data span.years {
            margin-right: 10px;
        }

        .btn {
            text-align: center;
            width: 100%;
        }

        .btn input {
            height: 58px;
            line-height: 58px;
            border: none;
            cursor: pointer;
            border-radius: 30px;
            color: #fff;
            font-size: 18px;
            background: #3dbb2b;
            padding: 0 40px;
            outline: none;
            margin-top: 20px;
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="container">
        <div class="invitation_box">
            <div class="invitation">
                <ul class="money_list">
                    <li>{{$user_dfqr->amount2015 or '0.00'}}</li>
                    <li>{{$user_dfqr->amount2016 or '0.00'}}</li>
                    <li>{{$user_dfqr->amount2017 or '0.00'}}</li>
                </ul>
                <div class="company">{{$user->msn}}</div>
                <div class="data">
                    <span class="years">{{date('Y')}}</span><span class="month">{{date('m')}}</span><span
                            class="day">{{date('d')}}</span>
                </div>
            </div>
            <div class="btn">
                <input type="button" value="点击确认并领取50元代金劵"/>
            </div>
        </div>
    </div>
    @include('common.footer')
@endsection
