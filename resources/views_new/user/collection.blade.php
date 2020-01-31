@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/wodeshoucang.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="container" id="user_center">
        <form id="search_form" name="search_form" action="{{route('member.collection.index')}}">
            <input type="hidden" name="show_area" value="{{$show_area}}">
        </form>
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>我的收藏</span>
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
    </script>
    @include('common.footer')
@endsection
