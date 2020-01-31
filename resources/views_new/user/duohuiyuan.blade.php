@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/duohuiyuan.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
    <script type="text/javascript" src="{{path('js/user/placeholder.js')}}"></script>
    <script type="text/javascript" src="{{path('js/user/duohuiyuan.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>多会员管理</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                    <span>多会员管理</span>
                </div>
                @if($mobile_login)
                    <div class="qiehuan">
                        <div class="qiehuan_title">
                            尊敬的<span>用户名</span>，下列账号是绑定手机号（<span>{{$mobile_login->mobile_phone}}</span>）的所有账号：
                        </div>
                        <ul class="users">
                            @foreach($result as $v)
                                <li @if($v->user_id==$user->user_id)class="active"@endif>
                                    <p class="user">
                                        会员名：<span>{{$v->user_name}}</span>
                                    </p>
                                    <p class="company">
                                        单位名：<span>{{$v->msn}}</span>
                                    </p>
                                    <p class="use_user">
                                        @if($v->user_id==$user->user_id)
                                            <span>当前使用会员</span>
                                        @else
                                            <a href="/change_login_user?user_id={{$v->user_id}}"><span>切换为该会员</span></a>
                                        @endif
                                    </p>
                                    <img src="{{get_img_path('images/user/choose.png')}}"/>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @else
                    <div class="bangding">
                        <div class="bangding_title">
                            尊敬的<span>{{$user->user_name}}</span>，通过完成下面2个步骤完成手机号绑定后可以使用多会员管理您名下多个账号。
                        </div>
                        <ul class="bz">
                            <li id="send_code">
                                <div class="img">
                                    <img src="{{get_img_path('images/user/yanzheng_1.png')}}"/>
                                </div>
                                <div class="sj">
                                    <span>手机号：</span>
                                    <input type="text" placeholder="请输入手机号" class="yz phone" name="mobile_phone"/>
                                    <img class="zt"/>
                                </div>
                                <div class="yzm">
                                    <span>验证码：</span>
                                    <input type="text" placeholder="请输入验证码" class="yz yazhengma" name="code"/>
                                    <input type="button" value="点击获取验证码" id="submit"/>
                                    <img class="zt"/>
                                </div>
                                <div class="tijiao">
                                    <input type="button" name="" id="next" value="下一步" disabled="disabled"/>
                                </div>
                            </li>
                            <li id="set_pwd" style="display: none;">
                                <div class="img">
                                    <img src="{{get_img_path('images/user/yanzheng_2.png')}}"/>
                                </div>
                                <form action="{{route('member.duohuiyuan.set_pwd')}}" method="post">
                                    {!! csrf_field() !!}
                                    <div class="sj">
                                        <span>密码：</span>
                                        <input type="password" placeholder="请输入登录密码" class="password mima" id="mima"
                                               name="password"/>
                                        <p class="mm_tishi">请输入6-24位英文、数字、"_"组成的密码</p>
                                        <img class="zt"/>
                                    </div>
                                    <div class="sj qrmm">
                                        <span>确认密码：</span>
                                        <input type="password" placeholder="请再次输入登录密码" class="password queren"
                                               id="queren"
                                               name="confirm_password"/>
                                        <p class="mm_tishi"></p>
                                        <img class="zt"/>
                                    </div>
                                    <div class="tijiao">
                                        <input type="submit" name="" id="btn" value="确定" disabled="disabled"/>
                                    </div>
                                </form>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    @include('common.footer')
@endsection
