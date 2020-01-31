
@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <style type="text/css">

        /* 会员中心站内信样式开始 */
        .ico3{width: 24px;height: 22px;position: absolute;left: 0;top: 4px;background: url(http://images.hezongyy.com/images/msg-02.png) no-repeat;}
        .zhanneixx-box{width: 986px;float: right;}
        .t-title{border-bottom:1px solid #c7c7c7;height: 40px; margin-top: 10px;}
        .t-title .weidu{width: 160px;float: left;padding-left: 15px;}
        .t-title  .r-xinxi{width: 220px;float: right;text-align: right;}
        .t-title  .r-xinxi span{cursor: pointer;}
        .l-xinxi{width: 180px;float: left;text-align: left;padding-left: 15px;}
        .l-xinxi span{cursor: pointer;}
        .youjian{border: 0;border-bottom: 1px solid #c7c7c7;width: 100%;text-align: center;color: #666666;}
        .youjian tr td{border: 0;line-height: 24px;}
        .youjian tr .td1{width: 40px;}
        .youjian tr .td2{width: 60px;}
        .youjian tr .td3{width: 770px;}
        .youjian tr .td4{width: 110px;}
        .pageList{width: 590px;}
        input[type="checkbox"]{width: 15px;height: 15px;}

        /* 会员中心站内信样式开始 */

    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear">

        <div class="top"><span class="title">我的药易购</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.messageList')}}" class="end">>　<span>系统消息</span></a> </div>

        @include('layout.user_menu')

        <div class="main_right1">
            <div class="top_title">
                <h3>系统消息</h3>
                <span class="ico"></span>
            </div>


            <div class="zhanneixx-box">
                <h3 style="font-size: 16px;text-align: center;">{{$info->message->title or ''}}</h3>
                <div style="padding: 10px;text-indent: 25px;">
                    {!! $info->message->text or '' !!}
                </div>
            </div>
        </div>
    </div>
    @include('common.footer')
@endsection
