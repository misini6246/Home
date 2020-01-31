<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>找回密码</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/new_common.css" />
    <link rel="stylesheet" type="text/css" href="/login/login.css" />
    <link rel="stylesheet" type="text/css" href="/login/retrieve_psw.css" />

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>

    <!--layer-->
    <link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
</head>
<style type="text/css">
    .input_box {
        padding-left: 1px;
    }
    .username_1 {
        margin-left: 10px !important;
    }

    label p {
        text-align: left;
    }

    .m-tip {
        color: #999;
        width: 200px;
        height: 30x;
        text-align: center;
        line-height: 30px;
        cursor: pointer;
        background: #F00;
    }

    .u-flyer {
        display: block;
        width: 50px;
        height: 50px;
        border-radius: 50px;
        position: fixed;
        z-index: 9999;
    }
    .input_box input[type=text] {border: none;}

</style>

<body>
<div class="big-container" style="background-color: #fff;">
    <!--头部开始-->
@include('layout.auth_header')
<!--头部结束-->

    <!--表单开始-->
    <div class="main_1">
        <h2>找回密码</h2>
        <form action="{{route('reset_pwd')}}" method="get" name="getPassword2" onSubmit="return check_code()" id="form">
            <div class="refer">
                {!! csrf_field() !!}
                {{--<label class="input_box fn_clear">--}}
                {{--<span class="input_box_before">用户名：</span>--}}
                {{--<p>--}}
                {{--<input id="user_name" class="username_1" type="text" name=""--}}
                {{--value="{{ old('user_name') }}"/>--}}
                {{--<span class="prompt">请输入您的用户名！</span>--}}
                {{--</p>--}}
                {{--</label>--}}
                <label class="input_box fn_clear">
                    <span class="input_box_before">手机号：</span>
                    <p>
                        <input id="mobile_phone" class="username_1" type="text" name="mobile_phone"
                               value="{{ old('mobile_phone') }}"/>
                        <span class="prompt">请输入您的绑定手机号！</span>
                    </p>
                </label>
                <label class="input_box fn_clear">
                    <span class="input_box_before">验证码：</span>
                    <p style="width: 100px;">
                        <input id="reset_code" style="width: 80px;" class="username_1" type="text" name="code"
                               value="{{ old('reset_code') }}"/>
                        <button id="submit"
                                style="right: -130px;width: 120px;padding: 0 10px;cursor: pointer;
                            border: 1px solid #1d54d0;background: #4478ec;color: white;text-align: center"
                                class="prompt" onclick="sendMessage()" type="button">点击发送验证码
                        </button>
                    </p>
                </label>
                {{--<label class="input_box email_label fn_clear">--}}
                {{--<span class="input_box_before">Email ：</span>--}}
                {{--<p>--}}
                {{--<span class="ico ico2"></span>--}}
                {{--<input class="email_1" type="text" name="email" value="{{ old('email') }}"/>--}}
                {{--<span class="prompt margin_problem">请输入您的邮箱地址！</span>--}}
                {{--</p>--}}
                {{--<div class="cemail">--}}
                {{--<ul>--}}
                {{--<li>@qq.com</li>--}}
                {{--<li>@163.com</li>--}}
                {{--<li>@126.com</li>--}}
                {{--<li>@sohu.com</li>--}}
                {{--<li>@sina.com</li>--}}
                {{--<li>@hotmail.com</li>--}}
                {{--<li>@gmail.com</li>--}}
                {{--<li>@foxmail.com</li>--}}
                {{--<li>@139.com</li>--}}
                {{--<li>@189.cn</li>--}}
                {{--</ul>--}}
                {{--</div>--}}
                {{--</label>--}}
                {{--<span class="tip_txt">注：请输入您正确的用户名，再输入您注册时填写的手机号，点击获取验证码！</span>--}}
                <div class="btn">
                    <input type="submit" value="找回密码" class="psw_btn" style="border-radius: 6px;
    background-color: rgb(61, 187, 43);
    width: 110px;
    height: 40px;background-image: none;line-height: 40px;"/>
                    <input style="line-height: 40px;color: #666" type="button" value="返回上一页" onclick="history.back()"
                           class="back" name="button">
                </div>
            </div>
        </form>
    </div>

    <!--/表单开始-->

    <!--footer开始-->
@include('layout.auth_footer')
    <!--footer结束-->
</div>
</body>

</html>
<script type="text/javascript">
    var InterValObj;
    var count = 120;
    var curCount;

    function sendMessage() {
        var mobile_phone = $('#mobile_phone').val();
        var user_name = $('#user_name').val();
        if(user_name == '') {
            layer.msg("用户名不能为空", {
                icon: 2
            });
            return false;
        }
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile_phone))) {
            layer.msg("手机号码有误，请重填", {
                icon: 2
            });
            return false;
        }
        $.ajax({
            url: '/reset_code',
            type: 'post',
            data: {
                mobile_phone: mobile_phone,
                user_name: user_name
            },
            dataType: 'json',
            success: function(data) {
                if(data.error == 0) {
                    curCount = count;

                    $("#submit").css({
                        'border': '1px solid #ccc',
                        'background': '#f5f5f5',
                        'color': '#999'
                    });
                    $("#submit").attr("disabled", "true");
                    $("#submit").text(+curCount + "s后再次发送");
                    InterValObj = window.setInterval(SetRemainTime, 1000);
                } else if(data.error == 2) {
                    curCount = data.s;

                    $("#submit").css({
                        'border': '1px solid #ccc',
                        'background': '#f5f5f5',
                        'color': '#999'
                    });
                    $("#submit").attr("disabled", "true");
                    $("#submit").text(+curCount + "s后再次发送");
                    InterValObj = window.setInterval(SetRemainTime, 1000);
                    data.error = -1;
                }
                layer.msg(data.msg, {
                    icon: data.error + 1
                })
            }
        })
    }

    function SetRemainTime() {
        if(curCount == 0) {
            window.clearInterval(InterValObj);
            $("#submit").removeAttr("disabled");
            $("#submit").css({
                'border': '1px solid #1d54d0',
                'background': '#4478ec',
                'color': 'white'
            })
            $("#submit").text("点击发送验证码");
        } else {
            curCount--;
            $("#submit").text(+curCount + "s后再次发送");
        }
    }

    function check_code() {
        var mobile_phone = $('#mobile_phone').val();
        var user_name = $('#user_name').val();
        var reset_code = $('#reset_code').val();
        if(user_name == '') {
            layer.msg("用户名不能为空", {
                icon: 2
            });
            return false;
        }
        if(!(/^1(3|4|5|7|8)\d{9}$/.test(mobile_phone))) {
            layer.msg("手机号码有误，请重填", {
                icon: 2
            });
            return false;
        }
        if(reset_code == '') {
            layer.msg("验证码不能为空", {
                icon: 2
            });
            return false;
        }
        var flag = false;
        $.ajax({
            url: '/check_reset_code',
            type: 'post',
            async: false,
            data: {
                mobile_phone: mobile_phone,
                user_name: user_name,
                reset_code: reset_code
            },
            dataType: 'json',
            success: function(data) {
                if(data.error == 1) {
                    layer.msg(data.msg, {
                        icon: data.error + 1
                    })
                } else {
                    flag = true;
                }
            }
        });
        return flag;
    }
</script>