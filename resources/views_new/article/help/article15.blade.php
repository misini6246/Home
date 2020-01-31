@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_pwd.css')}}"/>
@endsection
@section('content')
    @include('article.header')
    @include('article.help_nav')
    <div id="help_title" class="container">
        <div class="container_box">
            <ul class="help_title_list">
                @foreach($articles as $k=>$v)
                    <li @if($k==$article_id)class="active"@endif><a
                                href="{{route('xin.help',['cat_id'=>$cat_id,'article_id'=>$k])}}">{{$v}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div id="content" class="container">
        <div class="container_box">
            <div class="help_title">找回密码</div>
            <div class="step">
                <div class="content_step">
                    第一步，进入找回密码功能页
                </div>
                <div class="pwd_content">
                    <div class="pwd_content_left">
                        <p>如果忘记密码，在登录页（点击顶部登录按钮可进入）点击右下角“忘记密码” 进入找回密码功能页。如右图所示。</p>
                    </div>
                    <div class="pwd_content_right">
                        <img src="{{get_img_path('images/help/pwd_03.jpg')}}"/>
                    </div>
                </div>
            </div>
            <div class="step">
                <div class="content_step">
                    第二步，按步骤找回密码
                </div>
                <div class="pwd_content">
                    <p>填写绑定的手机号，验证通过后，即可进入修改登录密码。</p>
                    <div class="img_box">
                        <img src="{{get_img_path('images/help/pwd_04.jpg')}}"/>
                    </div>
                    <p class="red">*注：为了安全考虑，找回密码功能仅适用于绑定了手机号的客户使用，未绑定的客户，请联系客服人员。也请尽早绑定手机号。</p>
                </div>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
