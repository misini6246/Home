<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="Keywords" content="{{shopConfig('shop_keywords')}}" />
    <meta name="Description" content="{{shopConfig('shop_desc')}}" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title>注册成功-{{shopConfig('shop_title')}}</title>
    <link rel="shortcut icon" href="{{path('images/favicon.ico')}}" />
    <link rel="icon" href="{{path('images/animated_favicon.gif')}}" type="image/gif" />
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/login.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/log_reg_com.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/confirm_psw.css')}}" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .block_1{height:auto;width: 1200px;margin: 30px auto; box-shadow: 0 0 10px rgb(179,177,178);border: 1px solid #e5e5e5;overflow: hidden ;line-height:30px;}
        .block_1 p a{color:#006acd; text-decoration:underline;}
        .block_1 .box_22{background:#f1f1f1; padding-bottom:2px; overflow:hidden;}
        .block_1 .box_1{border:1px solid #CBCBCB; background-color:#fff;}
        .block_1 h6{height: 39px;line-height: 39px;border-bottom: 1px solid #e5e5e5;background-color: #f5f5f5;color: #333333;text-indent: 20px;}
        .block_1 h6 span{float:left; padding-left:15px;}
        .block_1 .RelaArticle a,.alone{background:url(images/bg.gif) no-repeat 0px -170px; padding:0px 0px 0px 10px; color:#3f3f3f; text-decoration:none;}
        .block_1 .RelaArticle a:hover{background:url(images/bg.gif) no-repeat 0px -170px; padding:0px 0px 0px 10px; color:#ff6600; text-decoration:none;}
    </style>
</head>
<body>
@include('layout.auth_header')
<div class="block_1">
    <div class="box_22">
        <div class="box_1">
            <h6><span>系统提示</span></h6>
            <div class="boxCenterList RelaArticle" align="center">
                <div style="margin:20px auto; width:550px; text-align:left;">
                    <p style="font-size: 14px;"><font style="font-size: 14px; font-weight:bold; color: red;">{{$user->user_name}}</font>,请按照如下要求将相关资质材料邮寄给我们进行认证！</p>
                    <p style="font-size: 14px; font-weight:bold">诊所：</p>
                    <p>1、《医疗机购执业许可证》</p>
                    <p>2、年检《营业执照》</p>
                    <p>3、采购、提货、收货委托书及身份证复印件</p>
                    <p style="font-size: 14px; font-weight:bold">药店：</p>
                    <p>1、《药品经营许可证》</p>
                    <p>2、年检《营业执照》</p>
                    <p>3、《GSP证书》</p>
                    <p>4、采购、提货、收货委托书及身份证复印件</p>
                    <p>注：以上资料在有效期之内并盖公司章鲜章</p>
                    <p><a style="font-size:14px;font-weight:bold;color:#FF6600;" href="/uploads/2016采购委托书模板.doc">2016采购委托书模板下载</a>　<a style="font-size:14px;font-weight:bold;color:#FF6600;" href="/uploads/购买特殊管理药品委托书格式.doc">购买特殊管理药品委托书格式下载</a></p>
                    <p style="font-size: 14px; font-weight:bold">邮寄地址：成都市金牛区金丰路6号7栋（量力钢铁交易大厦）二楼48-63号</p>
                    <p style="font-size: 14px; font-weight:bold">收件人：兰秋菊&nbsp;&nbsp;&nbsp;&nbsp;电话：028-69932957&nbsp;&nbsp;&nbsp;&nbsp;QQ：409404980</p>
                    <p style="text-align:center">
                        <a href="{{route('index')}}">返回首页</a>&nbsp;&nbsp;
                        <a href="{{route('user.index')}}">前往会员中心</a>&nbsp;&nbsp;
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@include('layout.auth_footer')
</body>

</html>
