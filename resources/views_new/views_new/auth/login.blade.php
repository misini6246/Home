<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}" />
    <meta name="Description" content="{{shopConfig('shop_desc')}}" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>登录-{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}" />
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif" />
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/log_reg_com.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/confirm_psw.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/login.js')}}"></script>
</head>
<body>
@if(time()<strtotime('20161112'))
@include('shuang11.auth_header')
@else
@include('layout.auth_header')
@endif
<form action="{{url('auth/login')}}" method="post" id="form">
    {!! csrf_field() !!}
<div class="site-content">
    <div class="content-box">

        <div class="right">
            <div class="right-title fn_clear">
                <h2>欢迎登录</h2>
                <div class="wangji">
                    <span>还没有账号？<a href="{{url('auth/register')}}">快速注册</a> </span>
                </div>
            </div>

            <p class="input-box">
                <span class="ico"></span><label for="username"> <span class="codes2" style="display: block;">用户名</span>
                    <input class="username txt" id="username" name="user_name" type="text" style="color: rgb(51, 51, 51);"></label>
                <span class="prompt2">请输入用户名</span>
            </p>
            <p class="input-box"><span class="ico pas"></span> <label for="password"> <span class="codes" style="display: block;">密　码</span> <input class="password txt" id="password" name="password" type="password" style="color: rgb(51, 51, 51);"></label>
                <span class="prompt2">请输入密码</span>
            </p>

            <a href="javascript:void(0)" class="login">登　录</a>
            <input type="hidden" name="act" class="act" value="ajax_act_login">
            <input type="hidden" name="back_act" class="back_act" value="http://www.hezongyy.com/index.php">

            <div class="box"><span><input type="checkbox" value="1" name="remember" id="remember">&nbsp;&nbsp;记住账号</span><a href="{{url('password/email')}}">忘记密码</a></div>
        </div>



    </div>



</div>

</form>
@include('layout.auth_footer')
</body>

</html>
