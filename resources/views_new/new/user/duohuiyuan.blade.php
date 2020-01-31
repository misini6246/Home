@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>多会员管理</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <link rel="stylesheet" type="text/css" href="/user/duohuiyuan.css"/>
    <!--layer-->
    {{--<link rel="stylesheet" type="text/css" href="common/layer/layer.css" />--}}

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/duohuiyuan.js" type="text/javascript" charset="utf-8"></script>
    <!--layer-->
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')


    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="/user/img/详情页_01.png"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="/user/img/right_03.png"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的今瑜e药网</a><img
                        src="/user/img/right_03.png" class="right_icon"/><span>多会员管理</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="/new_gwc/jiesuan_img/椭圆.png"/>
                    <span>多会员管理</span>
                </div>
                @if($mobile_login)
                    <div class="qiehuan">
                        <div class="qiehuan_title">
                            尊敬的<span>用户</span>，下列账号是绑定手机号（<span>{{$mobile_login->mobile_phone}}</span>）的所有账号：
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
                                    <img src="/user/img/choose.png"/>
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
                                    <img src="/user/img/yanzheng_1.png"/>
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
                                    <img src="/user/img/yanzheng_2.png"/>
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
    @include('layouts.new_footer')
    <script>
        //返回顶部
        $('.btn-top').click(function() {
            $('html,body').animate({
                'scrollTop': 0
            })
        });
    </script>
@endsection
