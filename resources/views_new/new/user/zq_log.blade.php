@extends('layout.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/wodedingdan.css')}}1" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
    <!--[if lte IE 9]>
    <style type="text/css">
        .genzong {
            border: 1px solid #e5e5e5;
        }


    </style>
    <![endif]-->
    <!--[if IE 8]>
    <style type="text/css">
        .right_top_search select {
            padding: 5px 0;
        }
    </style>
    <![endif]-->
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

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>账期变动记录</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_top">
                    <div class="right_top_title">
                        <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                        <span>账期变动记录</span>
                    </div>
                </div>
                @if(count($result)>0)
                    <form id="search_form" name="search_form" action="{{route('member.zq_log')}}">
                    </form>
                    <table>
                        <tr>
                            <th class="ddh">操作时间</th>
                            <th class="xdsj">类型</th>
                            <th class="zje">
                                <span>金额</span>
                            </th>
                            <th class="ddzt">
                                操作备注
                            </th>
                        </tr>
                        @foreach($result as $v)
                            <tr>
                                <td class="ddh">
                                    {{date('Y-m-d H:i:s',$v->change_time)}}
                                </td>
                                <td>@if($v->change_amount>0)增加@else减少@endif</td>
                                <td class="zje">{{formated_price(abs($v->change_amount))}}</td>
                                <td style="line-height: 25px;">
                                    {{$v->change_desc}}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    @include('user.pages',['pages'=>$result])
                @else
                    @include('user.empty',['type'=>4,'emsg'=>'没有查询到记录，这里是空的'])
                @endif
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            $('#num').focus(function () {
                $('.placeholder').hide();
            });
            $('#num').blur(function () {
                if ($(this).val() != "") {
                    $('.placeholder').hide();
                } else {
                    $('.placeholder').show();
                }
            });
        })
    </script>
    @include('layouts.old_footer')
@endsection
