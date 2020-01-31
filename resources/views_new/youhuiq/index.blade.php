@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>领券中心</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/new_yhq/lyhj.css"/>
    <!--layer-->
    {{--<link rel="stylesheet" type="text/css" href="common/layer/layer.css" />--}}

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        .mask {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 9999;
            background: url(/new_yhq/img//黑色半透明背景.png);
        }

        .mask .popup {
            position: absolute;
            z-index: 10;
            top: 50%;
            left: 50%;
            margin-left: -230px;
            margin-top: -206px;
            width: 460px;
            height: 412px;
            background: url(/new_yhq/img/领券中心.png) no-repeat scroll center;
            background-size: 100%;
        }
        .popup .msg {
            position: absolute;
            left: 0;
            top: 190px;
            width: 100%;
            font-family: "微软雅黑";
            font-size: 48px;
            font-weight: bold;
            color: #ff2e28;
            text-align: center;
        }

        .popup .btn-box {
            position: relative;
            height: 100%;
            width: 100%;
        }

        .popup .btn-box .btn-1 {
            position: absolute;
            bottom: 42px;
            left: 102px;
            width: 76px;
            height: 39px;
            cursor: pointer;
            cursor: hand;
            background-color: #000;
            filter: alpha(opacity=0);
            -moz-opacity: 0;
            -khtml-opacity: 0;
            opacity: 0;
        }

        .popup .btn-box .btn-2 {
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: 125px;
            margin-left: -32px;
            width: 166px;
            height: 38px;
            cursor: pointer;
            cursor: hand;
            background-color: #000;
            filter: alpha(opacity=0);
            -moz-opacity: 0;
            -khtml-opacity: 0;
            opacity: 0;
        }

        .popup .btn-box .btn-3 {
            position: absolute;
            right: 62px;
            bottom: 99px;
            width: 70px;
            height: 70px;
            cursor: pointer;
            cursor: hand;
            background-color: #000;
            filter: alpha(opacity=0);
            -moz-opacity: 0;
            -khtml-opacity: 0;
            opacity: 0;
        }
    </style>

@endsection

@section('content')
    <div class="big-container">
        <!--弹窗-->
        <div class="mask">
            <div class="popup">
                <!--<p class="msg"></p>-->
                <div class="btn-box">
                    <a href="javascript:void(0);" onclick="$('.mask').hide()"><div style="font-weight: bold;font-size: 20px;background-color: transparent;filter: alpha(opacity=1);-moz-opacity: 1;-khtml-opacity: 1;opacity: 1;width: auto;height:auto;bottom: auto;left: auto;top:78px;right:35px;" class="btn-1">X</div></a>
                    <a href="/"><div class="btn-1"></div></a>
                    <a href="http://www.jyeyw.com/member/youhuiq"><div class="btn-2"></div></a>
                    <!--<div class="btn-3"></div>-->
                </div>
            </div>
        </div>
        <!--/弹窗-->

        <!--头部-->
    @include('layouts.header')
    <!--/头部-->

        <!--搜索导航-->
    @include('layouts.search')
    <!--/搜索导航-->

        <!--导航-->
    @include('layouts.nav')
    <!--/导航-->
    @include('layouts.youce')

    <!--banner-->
        <div id="tj_banner" class="container" style="background: url('/new_yhq/img/lingyhq.jpg') no-repeat;background-position:center;">
            <div class="container_box">
            </div>
        </div>
        <!--/banner-->
    {{--@foreach($ad209 as $key=>$v)--}}
    {{--@if($key == 0)--}}
    {{--<div id="tj_banner" class="container" style="height: 300px;width:100%; ">--}}
    {{--<img src="{{$v->ad_code}}" alt="">--}}
    {{--</div>--}}
    {{--@endif--}}
    {{--@endforeach--}}

    <!--优惠券-->
        <div id="youhuiquan" class="container">
            <div class="container_box" style="width: 1190px;margin: 0 auto;">
                <!--优惠券-->
                <div class="youhuiquan">
                    <div class="title">
                        <img src="/new_yhq/img/youhuiquan_title.png">
                    </div>
                    <ul class="yhj_list">
                        @foreach($result as $value)
                            @if($value->cat_id == 56)
                                @if($order_count == 0)
                                    <li>
                                        <div class="juan_box hong">
                                            <p class="money">
                                                {{ $value->je }}<span>{{ $value->msg }}</span>
                                            </p>
                                            <p class="gz">{{ $value->title }}</p>
                                            <p class="time">使用时间： 限{{ date('Y-m-d',$value->start) }}至{{ date('Y-m-d',$value->end) }}</p>
                                            <p class="lx" style="font-size: 15px;">{{ $value->name }}</p>
                                        </div>
                                        @if($value->has == 1)
                                            <div class="quan_btn ylq">
                                                已领取
                                            </div>
                                        @else
                                            <div class="quan_btn" onclick="lq_you({{$value->cat_id}},this)">
                                                立即领取
                                            </div>
                                        @endif
                                    </li>
                                @endif
                            @else
                                <li>
                                    <div class="juan_box hong">
                                        <p class="money">
                                            {{ $value->je }}<span>{{ $value->msg }}</span>
                                        </p>
                                        <p class="gz">{{ $value->title }}</p>
                                        <p class="time">使用时间： 限{{ date('Y-m-d',$value->start) }}至{{ date('Y-m-d',$value->end) }}</p>
                                        <p class="lx" style="font-size: 15px;">{{ $value->name }}</p>
                                    </div>
                                    @if($value->has == 1)
                                        <div class="quan_btn ylq">
                                            已领取
                                        </div>
                                    @else
                                        <div class="quan_btn" onclick="lq_you({{$value->cat_id}},this)">
                                            立即领取
                                        </div>
                                    @endif
                                </li>
                            @endif





                        @endforeach
                    </ul>
                </div>
                <!--抵用券-->

            </div>
        </div>
        <!--/优惠券-->
        <!--footer-->
        @include('hd.111.nav111')
        @include('layouts.new_footer')
        <script type="text/javascript">
            //返回顶部
            $('.btn-top').click(function() {
                $('html,body').animate({
                    'scrollTop': 0
                })
            });
            function lq_you(id, obj) {
                var objs = obj;
                $.ajax({
                    url: '/yhq',
                    type: 'post',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if(data.error == 2) {
                            layer.confirm(data.msg, {
                                btn: ['注册', '登录'], //按钮
                                icon: 2
                            }, function () {
                                location.href = '/xin/register/old';
                            }, function () {
                                location.href = '/auth/login';
                                return false;
                            });

                        } else {
                            if(data.error == 0 || data.error == 3) {
                                $(objs).html('已领取');
                                $(objs).addClass('ylq');
                                if(data.error == 3) {
                                    data.error = 1;
                                    layer.open({
                                        title: '优惠券',
                                        content: data.msg
                                    });
                                } else {
                                    console.dir($(this));
//                                    layer.open({
//                                        title: '优惠券',
//                                        content: '领取成功'
//                                    });
                                    $('.mask').fadeIn(500);
                                }
                                $('#type').val(1)
                            } else {
                                layer.open({
                                    title: '优惠券',
                                    content: data.msg
                                });
                            }
                        }
                    }
                })
            }
            /**
             * searchEvent 初始化搜索功能
             * 参数1 获取数据方法
             * 参数2 回调方法
             * 参数3 按钮元素(执行搜索)(可选)
             * 参数4 搜索结果列表显示或隐藏的回调  返回true/false(可选)
             */
            $('.search').searchEvent(
                function(_target, _val) { //获取数据方法 val:搜索框内输入的值
                    $.get('/ajax/cart/searchKey',{keyword:_val},function(data){
                        _target.searchDataShow(data, 'value')
                    },'json');
                    /**
                     * searchDataShow 将数据渲染至页面
                     * 参数1:数据数组
                     * 参数2:数据数组内下标名
                     */
                },
                function(val) { //回调方法 val:返回选中的值
//                alert('搜索关键词"' + val + '"...');
                    window.location.href = "http://www.jyeyw.com/category?keywords="+val+"&showi=0";
                },
                $('.search-btn')
            );
        </script>

        <!--/footer-->
    </div>

@endsection
