@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>我的收藏</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <link rel="stylesheet" type="text/css" href="/user/wodeshoucang.css"/>
    <!--layer-->
    {{--<link rel="stylesheet" type="text/css" href="common/layer/layer.css" />--}}

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')


    <div class="container" id="user_center">
        <form id="search_form" name="search_form" action="{{route('member.collection.index')}}">
            <input type="hidden" name="show_area" value="{{$show_area}}">
        </form>
        <div class="container_box">
            <div class="top_title">
                <img src="/user/img/详情页_01.png"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="/user/img/right_03.png"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的今瑜e药网</a><img
                        src="/new_gwc/jiesuan_img/椭圆.png" class="right_icon"/><span>我的收藏</span>
            </div>
            @include('user.left')
            <div class="right" id="sc1">
                @include('user.sc1',['result'=>$result])
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
        });

        function pljr() {
            var len = $('.danxuan:checked').length;
            if (len == 0) {
                layer.msg('请至少选中一个商品', {icon: 0})
                return false;
            }
            $('#pl_buy').submit();
        }

        function plsc(_obj) {
            var len = $('.danxuan:checked').length;
            if (len == 0) {
                layer.msg('请至少选中一个商品', {icon: 0})
                return false;
            }
            var str = '';
            $('.danxuan:checked').each(function () {
                str = $(this).val() + ',';
            });
            del(_obj);
        }
        //返回顶部
        $('.btn-top').click(function() {
            $('html,body').animate({
                'scrollTop': 0
            })
        });
    </script>
    @include('layouts.new_footer')
@endsection
