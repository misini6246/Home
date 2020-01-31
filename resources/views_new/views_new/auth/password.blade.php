<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}" />
    <meta name="Description" content="{{shopConfig('shop_desc')}}" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>密码找回-{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}" />
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif" />
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/log_reg_com.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/retrieve_psw.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
@include('layout.auth_header')
<div class="main_1">
    <h2>找回密码</h2>
    <form action="{{url('password/email')}}" method="post" name="getPassword2" onSubmit="return submitPwd()">
        {!! csrf_field() !!}
        <div action="test.php" type="post" class="refer">
            <label class="input_box fn_clear">
                <span class="input_box_before">用户名：</span>
                <p>
                    <span class="ico ico1"></span>
                    <input class="username_1" type="text" name="user_name" value="{{ old('user_name') }}"/>
                    <span class="prompt">请输入您的用户名！</span>
                </p>
            </label>
            <label class="input_box email_label fn_clear">
                <span class="input_box_before">Email ：</span>
                <p>
                    <span class="ico ico2"></span>
                    <input class="email_1" type="text" name="email" value="{{ old('email') }}"/>
                    <span class="prompt margin_problem">请输入您的邮箱地址！</span>
                </p>
                <div class="cemail">
                    <ul>
                        <li>@qq.com</li>
                        <li>@163.com</li>
                        <li>@126.com</li>
                        <li>@sohu.com</li>
                        <li>@sina.com</li>
                        <li>@hotmail.com</li>
                        <li>@gmail.com</li>
                        <li>@foxmail.com</li>
                        <li>@139.com</li>
                        <li>@189.cn</li>
                    </ul>
                </div>
            </label>
            <span class="tip_txt">注：请输入您正确的用户名，再输入您注册时填写的手机号或邮箱，系统修改完成后会把新密码发送到您的手机或邮箱里！</span>
            <div class="btn">
                <input type="submit" value="找回密码" class="psw_btn" />
                <input type="button" value="返回上一页" onclick="history.back()" class="back" name="button">
            </div>
        </div>
    </form>
</div>
@include('layout.auth_footer')
</body>

</html>
