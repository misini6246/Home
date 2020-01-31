@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/qiehuan.css')}}" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <style>
        .bind_label {
            font-size: 16px;
            width: 100px;
            text-align: right;
            display: inline-block;
        }

        .hide {
            display: none;
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>我的账户</span> </a> <a
                    href="{{route('user.mobile_login')}}"
                    class="end">>　<span>@if($mobile_login)切换会员@else绑定会员@endif</span></a>
        </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>@if($mobile_login)切换会员@else绑定会员@endif</h3>
                <span class="ico"></span>
            </div>
            <div class="content">
                @if($mobile_login)
                    <div class="qiehuan">
                        <div class="user">
                            下列会员为绑定手机号为： <span>{{$mobile_login->mobile_phone}}</span> 的所有会员
                        </div>
                        <ul>
                            @foreach($users as $v)
                                <li @if($v->user_id==$user->user_id)class="on"@endif>
                                    <div class="name">
                                        会员名：<span>{{$v->user_name}}</span>
                                    </div>
                                    <div class="unit">
                                        单位名：<span>{{$v->msn}}</span>
                                    </div>
                                    <div class="input_box">
                                        @if($v->user_id==$user->user_id)
                                            <a class="btn-bg" type="button" name=""
                                               id="">当前使用会员</a>
                                        @else
                                            <a class="btn-bg" href="/change_login_user?user_id={{$v->user_id}}"
                                               type="button" name=""
                                               id="">切换为该会员</a>
                                        @endif
                                    </div>
                                    <img src="{{get_img_path('images/choose.png')}}"/>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <form action="{{route('bind_mobile')}}" method="post">
                        {!! csrf_field() !!}
                        <div class="bangding">
                            <div class="user">
                                <label class="bind_label">
                                    会员名：
                                </label>
                                <span>{{$user->user_name}}</span>
                            </div>
                            <div class="unit">
                                <label class="bind_label">
                                    单位名：
                                </label>
                                <span>{{$user->msn}}</span>
                            </div>
                            <div class="phone_num">
                                <label class="bind_label">
                                    手机号：
                                </label>
                                <input name="mobile_phone" id="mobile" type="text" placeholder="请填写要绑定的手机号"
                                       has="1"/>
                                <input type="button" value="点击发送验证码" id="submit" onClick="sendMessage()"/>
                            </div>
                            <div class="Code_num">
                                <label class="bind_label">
                                    验证码：
                                </label>
                                <input id="code" name="code" type="text" placeholder="请填写收到的验证码"/>
                            </div>
                            <div class="Code_num hide">
                                <label class="bind_label">
                                    密码：
                                </label>
                                <input id="password" name="password" type="password" placeholder=""/>
                            </div>
                            <div class="Code_num hide">
                                <label class="bind_label">
                                    确认密码：
                                </label>
                                <input id="confirm_password" name="confirm_password" type="password" placeholder=""/>
                            </div>
                            <div class="qr">
                                <input style="margin-left: 115px;" type="button" name="btn" id="btn" value="确认绑定"
                                       onclick="bind_mobile()"/>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    @include('common.footer')
    <script type="text/javascript">
        $(function () {
            $('.content .content_box ul li').click(function () {
                $(this).addClass('on').siblings().removeClass('on');
                $('.content .content_box ul li').children('img').hide();
                $(this).children('img').show();
            })
        })
        var InterValObj;
        var count = 120;
        var curCount;

        function sendMessage() {
            var mobile = $('#mobile').val();
            if (!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))) {
                layer.msg("手机号码有误，请重填", {icon: 2});
                return false;
            }
            $.ajax({
                url: '/bind_code',
                data: {mobile: mobile},
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0) {
                        if (data.has == 0) {
                            $('.hide').show();
                            $('#mobile').attr('has', 0)
                        } else {
                            $('.hide').hide();
                            $('#mobile').attr('has', 1)
                        }
                        curCount = count;

                        $("#submit").css({
                            'border': '1px solid #ccc',
                            'background': '#f5f5f5',
                            'color': '#999'
                        });
                        $("#submit").attr("disabled", "true");
                        $("#submit").val(+curCount + "s后再次发送");
                        InterValObj = window.setInterval(SetRemainTime, 1000);
                    } else if (data.error == 2) {
                        if (data.has == 0) {
                            $('.hide').show();
                            $('#mobile').attr('has', 0)
                        } else {
                            $('.hide').hide();
                            $('#mobile').attr('has', 1)
                        }
                        curCount = data.s;

                        $("#submit").css({
                            'border': '1px solid #ccc',
                            'background': '#f5f5f5',
                            'color': '#999'
                        });
                        $("#submit").attr("disabled", "true");
                        $("#submit").val(+curCount + "s后再次发送");
                        InterValObj = window.setInterval(SetRemainTime, 1000);
                        data.error = -1;
                    }
                    layer.msg(data.msg, {icon: data.error + 1})
                }
            })
        }

        function bind_mobile() {
            var mobile = $('#mobile').val();
            var has = $('#mobile').attr('has');
            var code = $('#code').val();
            var password = $('#password').val();
            var confirm_password = $('#confirm_password').val();
            if (!(/^1(3|4|5|7|8)\d{9}$/.test(mobile))) {
                layer.msg("手机号码有误，请重填", {icon: 2});
                return false;
            }
            if (code == '') {
                layer.msg("请输入验证码", {icon: 2});
                return false;
            }
            if (has == 0) {
                if (password.length < 6) {
                    layer.msg("密码最短六位数", {icon: 2});
                    return false;
                }
                if (confirm_password != password) {
                    layer.msg("两次输入密码不一致", {icon: 2});
                    return false;
                }
            }
            $.ajax({
                url: '/bind_mobile',
                data: {mobile: mobile, code: code, password: password, confirm_password: confirm_password},
                dataType: 'json',
                success: function (data) {
                    if (data.error == 2) {
                        data.error = 1;
                    } else if (data.error == 0) {
                        location.reload();
                    }
                    layer.msg(data.msg, {icon: data.error + 1})
                }
            })
        }

        function SetRemainTime() {
            if (curCount == 0) {
                window.clearInterval(InterValObj);
                $("#submit").removeAttr("disabled");
                $("#submit").css({
                    'border': '1px solid #1d54d0',
                    'background': '#4478ec',
                    'color': 'white'
                })
                $("#submit").val("点击发送验证码");
            } else {
                curCount--;
                $("#submit").val(+curCount + "s后再次发送");
            }
        }
    </script>
@endsection
