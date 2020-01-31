@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/wodexiaoxi.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="container" id="user_center">
        <form id="search_form" name="search_form" action="{{route('member.wodexiaoxi.index')}}">
            <input type="hidden" name="type" value="{{$type}}">
        </form>
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>我的消息</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
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
    </script>
    @include('common.footer')
@endsection
