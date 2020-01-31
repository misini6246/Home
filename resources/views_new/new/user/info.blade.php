@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>基本信息</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <link rel="stylesheet" type="text/css" href="/user/jibenxinxi.css"/>
    <!--layer-->
    {{--<link rel="stylesheet" type="text/css" href="common/layer/layer.css" />--}}
    <!--时间选择器-->
    <link rel="stylesheet" type="text/css" href="/user/date/date_input.css"/>

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/placeholderfriend.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
    <!--上传预览-->
    <script src="/user/uploadPreview.min.js" type="text/javascript" charset="utf-8"></script>
    <!--时间选择器-->
    <script src="/user/date/jquery.date_input.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="/user/img/详情页_01.png"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="/user/img/right_03.png"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的今瑜e药网</a><img
                        src="/user/img/right_03.png" class="right_icon"/><span>基本信息</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="/new_gwc/jiesuan_img/椭圆.png"/>
                    <span>基本信息</span>
                </div>
                <div class="ziliao_box">
                    <div class="gerenziliao">
                        <div class="ziliao_title">
                            个人资料
                        </div>
                        <form action="{{route('member.update')}}" enctype="multipart/form-data"
                              method="post" onsubmit="return yzxx()">
                            {!! csrf_field() !!}
                            {!! method_field('put') !!}
                            <div class="ziliao">
                                <div class="shangchuanIMG">
                                    <div id="preview">
                                        <img id="imghead"
                                             src="@if($user->ls_file!=''){{get_img_path('data/feedbackimg/'.$user->ls_file)}}@else{{get_img_path('images/user/user_03.jpg')}}@endif">
                                    </div>
                                    <div class="upload">
                                        <input type="file" id="up_img" name="ls_file"/>
                                        <p class="p2">请上传小于200KB的JPG、GIF或PNG图片</p>
                                    </div>
                                </div>
                                {{--<div class="sex">--}}
                                    {{--<span class="xinxi_left">性别：</span>--}}
                                    {{--<input type="radio" name="sex" id="sexb" value="0"--}}
                                           {{--@if($user->sex==0)checked="checked"@endif>--}}
                                    {{--<label for="sexb">保密</label>--}}
                                    {{--<input type="radio" name="sex" id="sexm" value="1"--}}
                                           {{--@if($user->sex==1)checked="checked"@endif>--}}
                                    {{--<label for="sexm">男</label>--}}
                                    {{--<input type="radio" name="sex" id="sexw" value="2"--}}
                                           {{--@if($user->sex==2)checked="checked"@endif>--}}
                                    {{--<label for="sexw">女</label>--}}
                                {{--</div>--}}
                                <ul>
                                    {{--<li class="calendar_1">--}}
                                    {{--<span class="xinxi_left">出生日期:</span>--}}
                                    {{--<input id="birthday" readonly name="birthday" value="{{$user->birthday}}"/>--}}
                                    {{--</li>--}}
                                    <li>
                                        <span class="xinxi_left">Email地址:</span>
                                        <input type="email" id="mail" name="email" value="{{$user->email}}"/>
                                    </li>
                                    <li>
                                        <span class="xinxi_left">企业名称:</span>
                                        <input type="text" id="company" disabled="" value="{{$user->msn}}"/> *
                                        <p class="ts">企业名称如需修改请联系客服。</p>
                                    </li>
                                    <li>
                                        <span class="xinxi_left">QQ:</span>
                                        <input type="text" id="qq" name="qq" value="{{$user->qq}}"/>
                                    </li>
                                    <li>
                                        <span class="xinxi_left">联系电话:</span>
                                        <input type="text" id="phone" name="mobile_phone"
                                               value="{{$user->mobile_phone}}"/> *
                                    </li>
                                    <li>
                                        <input type="submit" value="确认修改" class="xiugai"/>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                    <div class="xgmm">
                        <div class="ziliao_title">
                            密码修改
                        </div>
                        <form action="{{route('member.update')}}" enctype="multipart/form-data"
                              method="post" onsubmit="return yzmm()">
                            <input type="hidden" name="act" value="pwd">
                            {!! csrf_field() !!}
                            {!! method_field('put') !!}
                            <ul>
                                <li class="calendar_1">
                                    <span>原密码：</span>
                                    <input type="password" name="old_password"/>*
                                </li>
                                <li>
                                    <span>新密码：</span>
                                    <input type="password" name="password"/>*
                                </li>
                                <li>
                                    <span>确认密码：</span>
                                    <input type="password" name="confirm_password"/>*
                                </li>
                                <li>
                                    <input type="submit" value="确认修改" class="xiugai"/>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <script>
        window.onload = function () {
            new uploadPreview({
                UpBtn: "up_img",
                DivShow: "preview",
                ImgShow: "imghead"
            });
        }
        $.fn.datetimepicker.dates['zh-CN'] = {
            days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],
            daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],
            daysMin: ["日", "一", "二", "三", "四", "五", "六", "日"],
            months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
            today: "今天",
            suffix: [],
            meridiem: ["上午", "下午"],
            //rtl: true // 从右向左书写的语言你可以使用 rtl: true 来设置
        };
        $('#birthday').datetimepicker({
            format: 'yyyy-mm-dd'
            , language: 'zh-CN'
            , minView: 2
            , autoclose: true
            , startView: 4
        });

        function yzxx() {
            return yzyx() && yzqq() && yzdh();
        }

        function yzmm() {
            var mm = $('input[name=password]').val();
            var o_mm = $('input[name=old_password]').val();
            var is_mm = /^[a-zA-Z\d_]{6,}$/;
            if (!is_mm.test(mm) || !is_mm.test(o_mm)) {
                layer.msg('密码只能包含大小写数字及下划线,最短六位', {icon: 2});
                return false;
            }
            var c_mm = $('input[name=confirm_password]').val();
            if (c_mm != mm) {
                layer.msg('两次输入密码不一致', {icon: 2});
                return false;
            }
        }

        function yzyx() {
            var email = $('input[name=email]').val();
            var is_email = /^[A-Za-z\d]+([-_.][A-Za-z\d]+)*@([A-Za-z\d]+[-.])+[A-Za-z\d]{2,4}$/;
            if (email == '' || is_email.test(email)) {
                return true;
            }
            layer.msg('请输入正确的邮箱', {icon: 2});
            return false;
        }
        function yzqq() {
            var qq = $('input[name=qq]').val();
            var is_qq = /^\d{5,10}$/;
            if (qq == '' || is_qq.test(qq)) {
                return true;
            }
            layer.msg('请输入正确的qq号', {icon: 2});
            return false;
        }
        function yzdh() {
            var dh = $('input[name=mobile_phone]').val();
            var isPhone = /^([0-9]{3,4}-)?[0-9]{7,8}$/;
            var isMob = /^((\+?86)|(\(\+86\)))?(13[012356789][0-9]{8}|15[012356789][0-9]{8}|18[012356789][0-9]{8}|147[0-9]{8}|134[0-9]{8}|17[0-9]{9})$/;
            if (isPhone.test(dh) || isMob.test(dh)) {
                return true;
            }
            layer.msg('请输入正确的联系电话', {icon: 2});
            return false;
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
