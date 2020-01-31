<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}" />
    <meta name="Description" content="{{shopConfig('shop_desc')}}" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>重置密码-{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}" />
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif" />
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/log_reg_com.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/confirm_psw.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
@include('layout.auth_header')
<div class="main_2">
    <h2>重置密码</h2>

    <form action="{{url('password/reset')}}" method="post" name="getPassword2" class="refer" >
        {!! csrf_field() !!}
        <input type="hidden" name="token" value="{{ $token }}">
        <label class="input_box fn_clear">
            <span class="input_box_before">email：</span>
            <p>
                <input class="psw2" type="email" name="email" value="{{old('email')}}"/>
                <span class="prompt"></span>
            </p>
        </label>
        <label class="input_box fn_clear">
            <span class="input_box_before">新密码：</span>
            <p>
                <input class="psw2" type="password" name="password"/>
                <span class="prompt"></span>
            </p>
        </label>
        <label class="input_box psw_label fn_clear">
            <span class="input_box_before">密码确认 ：</span>
            <p>
                <input class="psw3" type="password" name="password_confirmation"/>
                <span class="prompt margin_problem"></span>
            </p>

        </label>
        <span class="tip_txt"></span>
        <div class="btn">
            <input  type="submit" class="psw_btn" value="确认密码"/>
        </div>

    </form>
</div>
@include('layout.auth_footer')
</body>

</html>
