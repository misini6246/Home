@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>我的消息</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <link rel="stylesheet" type="text/css" href="/user/wodexiaoxi.css"/>
    <!--layer-->
    {{--<link rel="stylesheet" type="text/css" href="common/layer/layer.css" />--}}

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/placeholderfriend.js" type="text/javascript" charset="utf-8"></script>
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
        <form id="search_form" name="search_form" action="{{route('member.wodexiaoxi.index')}}">
            <input type="hidden" name="type" value="{{$type}}">
        </form>
        <div class="container_box">
            <div class="top_title">
                <img src="/user/img/详情页_01.png"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="/user/img/right_03.png"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的今瑜e药网</a><img
                        src="/user/img/right_03.png" class="right_icon"/><span>我的消息</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="/new_gwc/jiesuan_img/椭圆.png"/>
                    <span>我的消息</span>
                    <ul>
                        <li @if($type==0)class="active"@endif><a href="{{route('member.wodexiaoxi.index')}}"
                                                                 style="display: inline-block">系统通知@if($xttz>0)
                                    <span class="xttz">{{$xttz}}</span>@endif</a>
                        </li>
                        <li @if($type==1)class="active"@endif><a href="{{route('member.wodexiaoxi.index',['type'=>1])}}"
                                                                 style="display: inline-block">求购消息@if($qgxx>0)
                                    <span class="qgxx">{{$qgxx}}</span>@endif</a>
                        </li>
                        <li @if($type==2)class="active"@endif><a href="{{route('member.wodexiaoxi.index',['type'=>2])}}"
                                                                 style="display: inline-block">反馈消息@if($fkxx>0)
                                    <span class="fkxx">{{$fkxx}}</span>@endif</a>
                        </li>
                    </ul>
                </div>
                <div id="xxbox">
                    @include('user.xxbox',['result'=>$result,'type'=>$type])
                </div>
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <script type="text/javascript">
        var xttz = '{{$xttz}}';
        var qgxx = '{{$qgxx}}';
        var fkxx = '{{$fkxx}}';
        var msg_count = '{{msg_count()}}';
        var type = '{{$type}}';
        $(function () {
            var url = '{{route('member.wodexiaoxi.destroy',['id'=>'','type'=>$type])}}';
            $('input[type=checkbox]').click(function () {
                var str = '';
                $('.danxuan:checked').each(function () {
                    str = str + $(this).val() + ',';
                });
                var config = $('#plsc').data('config');
                var new_url = url.replace('?', '/' + str + '?');
                config.url = new_url;
                console.log(new_url);
            })
        });
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
        function cknr(id) {
            $.ajax({
                url: '/member/wodexiaoxi/' + id
                , type: 'put'
                , dataType: 'json'
                , success: function (data) {
                    if (data.error == 0) {
                        $('#msg' + id).replaceWith(data.html);
                        if (type == 0 && xttz > 0) {
                            xttz--;
                        } else if (type == 1 && qgxx > 0) {
                            qgxx--;
                        } else if (type == 2 && fkxx > 0) {
                            fkxx--;
                        }
                        if (msg_count > 0) {
                            msg_count--;
                        }
                        $('.xttz').text(xttz);
                        $('.qgxx').text(qgxx);
                        $('.fkxx').text(fkxx);
                        $('.msg_count').text(msg_count);
                    }
                }
            });
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
