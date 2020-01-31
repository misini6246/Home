<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}"/>
    <meta name="Description" content="{{shopConfig('shop_desc')}}"/>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>登录-{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}"/>
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif"/>
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/login.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/log_reg_com.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/confirm_psw.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
</head>
<body>
@if(time()<strtotime('20161112'))
    @include('shuang11.auth_header')
@else
    @include('layout.auth_header')
@endif
<form action="{{url('auth/login')}}" method="post" id="form">
    {!! csrf_field() !!}
    <div class="site-content"
         @if(isset($ad157)&&!empty($ad157->ad_code)) style='background: url("{{$ad157->ad_code}}") no-repeat scroll center top;' @endif>
        <div class="content-box">
            @if(isset($ad157)&&!empty($ad157->ad_link))<a target="_blank" href="{{$ad157->ad_link}}"
                                                          style="display: block;width: 100%;height: 546px;position: absolute;right: 400px;"></a>@endif
            <div class="right">
                <div class="right-title fn_clear">
                    <h2>欢迎登录</h2>
                    <div class="wangji">
                        <span>还没有账号？<a href="{{url('auth/register')}}">快速注册</a> </span>
                    </div>
                </div>

                <p class="input-box">
                    <span class="ico"></span><label for="username"> <span class="codes2"
                                                                          style="display: block;">用户名</span>
                        <input class="username txt" id="username" name="user_name" type="text"
                               style="color: rgb(51, 51, 51);"></label>
                    <span class="prompt2">请输入用户名</span>
                </p>
                <p class="input-box" style="width: 100px;display: inline-block"><span class="ico pas"></span> <label
                            for="password"> <span class="codes"
                                                  style="display: block;">验证码</span>
                        <input class="password txt" id="password" name="password" type="text"
                               style="color: rgb(51, 51, 51);width: 80px;"></label>
                    <span class="prompt2">请输入验证码</span>
                </p>
                <a style="padding: 14px;background-color: #55d75b;color: #fff" onclick="get_code()">获取验证码</a>
                <a href="javascript:void(0)" class="login">登　录</a>
                <input type="hidden" name="act" class="act" value="ajax_act_login">
                <input type="hidden" name="back_act" class="back_act" value="http://www.hezongyy.com/index.php">

                <div class="box"><span><input type="checkbox" value="1" name="remember"
                                              id="remember">&nbsp;&nbsp;记住账号</span><a href="{{url('password/email')}}">忘记密码</a>
                </div>
            </div>


        </div>


    </div>

</form>
@include('layout.auth_footer')
</body>
<script type="text/javascript">


    $(function () {


        $(".login").click(function () {

            goLogin();

        });


        $(document).keydown(function (e) {

            if (e.keyCode == 13) {

                goLogin()
            }

        });


        $("input[name=user_name]").focus(function () {

            $(this).parent().find(".prompt2").hide();

            $(".codes2").hide();

            $(this).css("color", "#333");

            $(this).parents(".input-box").addClass("border-color-blue");

        });


        $("input[name=password]").focus(function () {

            $(".prompt2").hide();

            $(".codes").hide();

            $(this).css("color", "#333");

            $(this).parents(".input-box").addClass("border-color-blue");

        })

        $("input[name=user_name]").blur(function () {

            if ($(this).val() == "") {

                $(".codes2").show();


            }
            if ($(this).val() != "") {


                $(this).parents(".input-box").removeClass("border-color-red");


            }

            $(this).parents(".input-box").removeClass("border-color-blue");


        });


        $("input[name=password]").blur(function () {


            if ($(this).val() == "") {

                $(".codes").show();


            }

            if ($(this).val() != "") {

                $(this).parents(".input-box").removeClass("border-color-red");

            }

            $(this).parents(".input-box").removeClass("border-color-blue");


        })


    });


    function goLogin() {

        var username = $(".username").val(),

            password = $(".password").val();

        if (username == "") {


            $(".username").parent().next().show();
            $(".username").parents(".input-box").addClass("border-color-red");


        } else if (password == "") {

            $(".password").parent().next().show();
            $(".password").parents(".input-box").addClass("border-color-red");


        }

        else {

            $(".username").parent().next().hide();
            $(".password").parent().next().hide();

            var act = $(".act").val();

            var back_act = $(".back_act").val();

            var remember = $("#remember").val();

            var url = "/mobile_login";

            $.ajax({
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },
                url: url,

                type: 'post',

                dataType: 'JSON',

                data: {

                    act: act,

                    mobile_phone: username,

                    code: password,

                    back_act: back_act,

                    remember: remember

                },

                success: function (data) {
                    if (data.error == 0) {

                        location.href = data.back;

                    }

                    if (data.error == 1) {

                        $(".prompt2").eq(0).show().html(data.msg);

                    }
                    if (data.error == 2) {

                        $(".prompt2").eq(1).show().html(data.msg);

                    }

                }

            });

        }


        $("input[type=text]").blur();

    }

    function get_code() {

        var user_name = $(".username").val();

        if (user_name == "") {


            $(".username").parent().next().show();
            $(".username").parents(".input-box").addClass("border-color-red");


        }

        else {

            $(".username").parent().next().hide();

            var url = "/login_code";

            $.ajax({
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

                },
                url: url,

                type: 'post',

                dataType: 'JSON',

                data: {

                    mobile: user_name

                },

                success: function (data) {
                    if (data.error >= 1) {

                        $(".prompt2").eq(0).show().html(data.msg);

                    }
                }

            });

        }


        $("input[type=text]").blur();

    }
</script>
</html>
