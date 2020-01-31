@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/yueguanli.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/yueguanli.js')}}"></script>
    <script type="text/javascript" src="{{path('js/user/placeholder.js')}}"></script>
    <link rel="stylesheet" href="{{path('nprogress/0.2.0/nprogress.min.css')}}">
    <script src="{{path('nprogress/0.2.0/nprogress.min.js')}}"></script>
    <!--[if lte IE 9]>
    <style type="text/css">
        .xxck-xiangqing, .tx-zhuangtai {
            border: 1px solid #e5e5e5;
        }
    </style>
    <![endif]-->
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
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>余额管理</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                    <span>余额管理</span>
                    <ul>
                        <li class="active">我的余额</li>
                        <li>提现管理</li>
                    </ul>
                </div>
                <div class="wodeyue">
                    <ul class="yue">
                        <li class="zhye active" id="jl0">
                            <a style="display: inline-block;width: 100%;height: 100%;"
                               onclick="get_data('{{route('member.money')}}')">
                                <p class="ye">
                                    {{--<img src="{{get_img_path('images/user/gantanhao.png')}}" title="提示信息"/>--}}
                                    账户余额
                                </p>
                                <p class="money">
                                    ￥<span>{{number_format($user->user_money,2,'.','')}}</span>
                                </p>
                                @if($user->user_money>0)
                                    <p class="tixian_btn" onclick="$('.right_title ul li').eq(1).click();">申请提现</p>
                                @endif
                            </a>
                        </li>
                        @if($user_jnmj&&$user_jnmj->jnmj_amount>0)
                            <li class="yzy" id="jl1">
                                <a style="display: inline-block;width: 100%;height: 100%;"
                                   onclick="get_data('{{route('member.money',['type'=>1])}}')">
                                    <p class="ye">
                                        {{--<img src="{{get_img_path('images/user/gantanhao.png')}}" title="提示信息"/>--}}
                                        {{trans('common.jnmj')}}
                                    </p>
                                    <p class="money">
                                        ￥<span>{{number_format($user_jnmj->jnmj_amount,2,'.','')}}</span>
                                    </p>
                                </a>
                            </li>
                        @endif
                        @if($cz_money)
                            <li class="yue_119" id="jl2">
                                <a style="display: inline-block;width: 100%;height: 100%;"
                                   onclick="get_data('{{route('member.money',['type'=>2])}}')">
                                    <p class="ye">
                                        {{--<img src="{{get_img_path('images/user/gantanhao.png')}}" title="提示信息"/>--}}
                                        {{trans('common.cz_money')}}
                                    </p>
                                    <p class="money">
                                        ￥<span>{{number_format($cz_money->money,2,'.','')}}</span>
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                    <ul class="choose">
                        <li class="zhye active">
                            <span></span>
                        </li>
                        <li class="yzy">
                            <span></span>
                        </li>
                        <li class="yue_119">
                            <span></span>
                        </li>
                    </ul>
                    <div class="jilu">
                        <div class="jilu_title">变动记录</div>
                        <div class="table_box" id="log">
                            {{--@include('user.log',['result'=>$account_log,'type'=>$type])--}}
                        </div>
                    </div>
                </div>
                <form action="{{route('user.tixian.store')}}" method="post" name="theForm">
                    {!! csrf_field() !!}
                    <div class="tixian">
                        <div class="tixian_title">
                            提现金额
                        </div>
                        <div class="tixian_jine">
                            <input type="text" placeholder="请输入提现金额" name="money"/>
                            当前可用余额：<span>{{number_format($user->user_money,2,'.','')}}</span>元
                            <input type="button" value="全部提现" id="quanbu"/>
                        </div>
                        <div class="tixian_title">
                            银行信息
                        </div>
                        <ul class="bank">
                            <li>
                                <input type="text" placeholder="开户行信息" name="bank"/>
                                <span>*请输入正确的银行卡开户行信息，如遗忘请联系银行客服确认后再输入。</span>
                            </li>
                            <li>
                                <input type="text" placeholder="银行卡号" onkeyup="formatBankNo(this)"
                                       onkeydown="formatBankNo(this)" name="bank_sn"/>
                                <span>*请输入正确的银行卡号。</span>
                            </li>
                            <li>
                                <input type="text" placeholder="户名" name="bank_user"/>
                                <span>*请输入上面银行卡号对应的户名。</span>
                            </li>
                            <li class="tijiao">
                                <input type="submit" value="提交申请"/>
                                <span>提交申请后，我们将及时为您审核（工作日1-3天，遇节假日顺延），你可随时关注您的提现进度。</span>
                            </li>
                        </ul>
                        <div class="tixian_jilu">
                            @include('user.tixian',['result'=>$tixian])
                        </div>
                    </div>
                </form>
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    @include('common.footer')
    <script>
        function get_data(url, t) {
            $.ajax({
                url: url
                , type: 'get'
                , dataType: 'json'
                , beforeSend: function () {
                    NProgress.start();
                }
                , complete: function () {
                    NProgress.done();
                }
                , success: function (data) {
                    if (data.error == 0) {
                        $('#log').html(data.html);
                    }
                }
            });
        }
        function formatBankNo(BankNo) {
            if (BankNo.value == "") return;
            var account = new String(BankNo.value);
            account = account.substring(0, 32);
            /*帐号的总数, 包括空格在内 */
            if (account.match(".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}") == null) {
                /* 对照格式 */
                if (account.match(".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}|" + ".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}|" +
                        ".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}|" + ".[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{7}") == null) {
                    var accountNumeric = accountChar = "", i;
                    for (i = 0; i < account.length; i++) {
                        accountChar = account.substr(i, 1);
                        if (!isNaN(accountChar) && (accountChar != " ")) accountNumeric = accountNumeric + accountChar;
                    }
                    account = "";
                    for (i = 0; i < accountNumeric.length; i++) {
                        if (i == 4) account = account + " - ";
                        if (i == 8) account = account + " - ";
                        if (i == 12) account = account + " - ";
                        if (i == 16) account = account + " - ";
                        account = account + accountNumeric.substr(i, 1)
                    }
                }
            }
            else {
                account = " " + account.substring(1, 5) + " " + account.substring(6, 10) + " " + account.substring(14, 18) + "-" + account.substring(18, 25);
            }
            if (account != BankNo.value) BankNo.value = account;
        }

        $(function () {
            $('#quanbu').click(function () {
                var user_money = '{{$user->user_money}}';
                $('input[name=money]').val(user_money);
            });
            var type = '{{$type}}';
            $('#jl' + type + ' a').click();
        });
    </script>
@endsection
