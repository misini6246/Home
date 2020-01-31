<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}" />
    <meta name="Description" content="{{shopConfig('shop_desc')}}" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>注册-{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}" />
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif" />
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/register.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/log_reg_com.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/register.js')}}"></script>
</head>
<body>
@include('layout.auth_header')

<div class="site-content">

    <div class="content-container clear_float">

        <form id="register" action="{{url('auth/register')}}" method="post">
            {!! csrf_field() !!}
            <div class="user-type-radio">

                <span class="input-box-before">用户类型：</span>

                <input type="radio" name="ls_lx" class="user-type" value="2" checked ="checked"/>药店

                <input type="radio" name="ls_lx" class="user-type" value="5"/>诊所

                <input type="radio" name="ls_lx" class="user-type"  value="1"/>连锁公司

                <input type="radio" name="ls_lx" class="user-type" value="7"/>商业公司

            </div>

            <label class="input_box" for="username">

                <span class="input-box-before">用户名：</span>

                <input name="user_name" type="text" class="username input-com" id="username" value=" " autocomplete="off"/>

                <span class="prompt" >*</span>
                <span class="prompt2" >请输入2-30个字符组成的用户名</span>

            </label>

            <label class="input_box" for="password">

                <span class="input-box-before" for="password">密码：</span>

                <input name="password" type="password" id="password" class="password input-com"/>

                <span class="prompt">*</span>
                <span class="prompt2">请输入6-24位英文、数字、"_"组成的密码</span>

            </label>

            <div class="pass_safe clear">

                <span class="input-box-before">密码强度：</span>

                <p class="after_clear"><span class="safe_level"> </span><span class="safe_level"> </span><span class="safe_level"> </span></p>

            </div>

            <label class="input_box" for="confirm_password">

                <span class="input-box-before">确认密码：</span>

                <input name="password_confirmation" type="password" id="confirm_password"  class="sure_pass input-com"/>

                <span class="prompt">*</span>

            </label>

            <label class="input_box email_label" for="email">

                <span class="input-box-before">电子邮箱：</span>

                <input name="email" type="text" class="email input-com" id="email" value="" autocomplete="off"/>

                <span class="prompt">*</span>
                <span class="prompt2">请输入有效的电子邮箱</span>

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

            <label class="input_box" for="ls_name">

                <span class="input-box-before">真实姓名：</span>

                <input name="ls_name" type="text" id="ls_name"  class="real_name input-com" value="" autocomplete="off"/>

                <span class="prompt"></span>

            </label>

            <label class="input_box" for="enterprise">

                <span class="input-box-before">企业名称：</span>

                <input class="enterprise input-com" type="text" name="msn" id="enterprise" value="" autocomplete="off"/>

                <span class="prompt ">*</span>
                <span class="prompt2">请填写与营业执照上名称一致，以便尽快通过审核</span>

            </label>

            <label class="input_box" for="extend_field2">

                <span class="input-box-before">QQ：</span>

                <input class="qq input-com" type="text" name="qq" id="extend_field2" value="" autocomplete="off"/>

                <span class="prompt ">*</span>

            </label>

            <label class="input_box" for="extend_field5">

                <span class="input-box-before">联系电话：</span>

                <input class="phone input-com" type="text" name="mobile_phone" id="extend_field5" value="" autocomplete="off"/>

                <span class="prompt">*</span>
                <span class="prompt2">请输入正确的电话号码，座机格式：xxx-xxxxxx</span>

            </label>



            <div class="choose_address fn_clear">

                <span class="ca_tip">所在地区：</span>

                <div class="select choose_select province" style="margin-left: 0px;">

                    <div class="select_choose"><span data-id="0">请选择</span><i></i></div>

                    <ul class="select_options">

                        <li data-id="0" style="border: 0">请选择</li>
                        @foreach(\App\Region::where('region_type',1)->get() as $v)
                            <li data-id="{{$v->region_id}}">{{$v->region_name}}</li>
                        @endforeach

                    </ul>

                </div>

                <div class="select choose_select city" style="margin-left: 0px;">

                    <div class="select_choose"><span data-id="0">请选择</span><i></i></div>

                    <ul class="select_options"></ul>

                </div>

                <div class="select choose_select district" style="margin-left: 0px;margin-right:40px;">

                    <div class="select_choose"><span data-id="0">请选择</span><i></i></div>

                    <ul class="select_options"></ul>

                </div>

                <span class="prompt margin_problem">*</span>
                <input type="hidden" name="province" value="" id="province"/>
                <input type="hidden" name="city" value="" id="city"/>
                <input type="hidden" name="district" value="" id="district"/>
            </div>





            <label class="agree">

                <span class="input-box-before">&nbsp;</span>

                <input name="agreement" type="checkbox" value="1" checked="checked" />

                我已看过并接受<a href="{{route('articleInfo',['id'=>73])}}" target="_blank">《用户协议》</a>				</label>

            <a href="javascript:;" id="submit" /><img src="{{path('images/reg-btn.jpg')}}"> </a>

            <p class="reg_other">

                <span class="input-box-before">&nbsp;</span>

                <a href="{{url('auth/login')}}" class="want_login after_clear">我已有账号，我要登录</a>&nbsp;&nbsp;

                <a href="{{url('password/email')}}">您忘记密码了吗？</a>

            </p>

        </form>

    </div>

</div>
@include('layout.auth_footer')
</body>
<script type="text/javascript">
    $(function(){


        $(".input-com").focus(function(){


            $(this).parent().find(".prompt2").addClass("hide");

        })







    })

</script>
</html>
