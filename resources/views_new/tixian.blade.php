@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/new/tixian.css')}}" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的药易购</span> <a>>　<span>我的账户</span> </a> <a
                    href="{{route('user.tixian.index')}}"
                    class="end">>　<span>提现申请</span></a>
        </div>
        @include('layout.user_menu')
        <div class="tixian-right">
            <div class="top_title">
                <h3>提现申请</h3>
                <span class="ico"></span>
            </div>
            <form action="{{route('user.tixian.store')}}" method="post" name="theForm">
                {!! csrf_field() !!}
                <div class="tixian-xinxi">
                    <ul>
                        <li>
                            提现金额
                            <input id="money" name="money" type="text" class="tixian-input-1" placeholder="请输入提现金额"/>
                            <span class="now-money">当前可用余额：<span>{{$user->user_money}}</span>&nbsp;元<div
                                        class="tixian-all">全部提现</div></span>
                        </li>
                        <li>
                            银行信息
                            <input type="text" class="tixian-input-2" placeholder="开户银行信息" name="bank"/>
                            <span>*请输入正确的银行卡开户行信息，如遗忘请联系银行客服确认后再输入。</span>
                        </li>
                        <li>
                            <!--<input type="text"  class="tixian-input-2"   oninput="inputAccount()"/>-->
                            <input type="text" placeholder="银行卡号" onkeyup="formatBankNo(this)"
                                   onkeydown="formatBankNo(this)" name="bank_sn" id="account" class="tixian-input-2">
                            <span>*请输入正确的银行卡号。</span>
                        </li>
                        <li>
                            <input name="bank_user" type="text" class="tixian-input-2" placeholder="户名"/>
                            <span>*请输入上面银行卡号对应的户名。</span>
                        </li>
                    </ul>
                    <button type="submit" class="tixian-tijiao">
                        提交申请
                    </button>
                    <p>提交申请后，我们将及时为您审核（工作日1-3天，遇节假日顺延），你可随时关注您的提现进度。</p>
                </div>
            </form>
            <div class="sqjl" id="sqjl">
                <p class="sqjl-title">申请记录</p>
                <ul class="sqjl-zhuangtai">
                    <li uid="quanbu" @if($type==0)class="sqjl-on"@endif>全部</li>
                    <li uid="jinxing" @if($type==1)class="sqjl-on"@endif>正在进行</li>
                    <li uid="wancheng" @if($type==2)class="sqjl-on"@endif>已完成</li>
                </ul>
                <ul id="quanbu" class="sqjl-xinxi">
                    <li class="sqjl-xinxi-title">
                        <ul>
                            <li>申请时间</li>
                            <li>金额</li>
                            <li>银行信息</li>
                            <li>状态</li>
                            <li>操作</li>
                        </ul>
                    </li>
                    @foreach($result as $k=>$v)
                        <li @if($k==0) style="border-top: none;" @endif>
                            <ul>
                                <li class="sqsj">{{$v->create_time->format('Y-m-d H:i:s')}}</li>
                                <li class="sqje">{{$v->money}}</li>
                                <li class="xxck">
                                    查看
                                    <div class="xxck-xiangqing">
                                        <img src="{{path('images/new/chankan.png')}}" class="chakan"/>
                                        <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												开户行：
											</span>
                                            <div class="khh-bank">
                                                {{$v->bank}}
                                            </div>
                                        </div>
                                        <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												卡号：
											</span>
                                            <div class="khh-bank kahao">
                                                {{str_replace(' ','',$v->bank_sn)}}
                                            </div>
                                        </div>
                                        <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												户名：
											</span>
                                            <div class="khh-bank">
                                                {{$v->bank_user}}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="ztjg @if($v->sh_type==5) yiquxiao @endif">
                                    {{$v->sh_type_text}}
                                    {{--<div class="tx-zhuangtai">--}}
                                    {{--<ul>--}}
                                    {{--<li>处理时间</li>--}}
                                    {{--<li>订单追踪信息</li>--}}
                                    {{--</ul>--}}
                                    {{--<div class="tx-zhuangtai-xinxi">--}}
                                    {{--<span class="zhuangtai-shijian">--}}
                                    {{--<img src="img/dian.jpg"/>--}}
                                    {{--2017-05-15 09:01:49--}}
                                    {{--</span>--}}
                                    {{--<span class="dingdan-xiangqing">--}}
                                    {{--您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消--}}
                                    {{--</span>--}}
                                    {{--</div>--}}
                                    {{--</div>--}}
                                </li>
                                @if($v->sq_type==0&&($v->sh_type==5||$v->sh_type==0))
                                    <li class="qxsq">取消</li>
                                    <form action="{{route('user.tixian.update',['id'=>$v->tx_id])}}" method="POST">
                                        <input name="_method" value="PUT" type="hidden">
                                        {!! csrf_field() !!}
                                        <div class="tx-queding tx-tcc" style="line-height: 12px;">
                                            <div>您确定要取消此次金额为<span>{{$v->money}}元</span>提现申请吗？</div>
                                            <button type="submit" class="tx-quxiao-queding">
                                                确定
                                            </button>
                                            <div class="tx-quxiao-quxiao" style="top: 12px;">
                                                取消操作
                                            </div>
                                        </div>
                                    </form>
                                @elseif($v->sq_type==2&&($v->sh_type==4))
                                    <li class="qxsq-again">再次申请</li>
                                    <form action="{{route('user.tixian.store')}}" method="post">
                                        <input type="hidden" name="id" value="{{$v->tx_id}}"/>
                                        {!! csrf_field() !!}
                                        <div class="tx-quxiao tx-tcc" style="line-height: 12px;">
                                            <div>您确定要以这个提现申请的数据为模板再次申请提现吗？</div>
                                            <button type="submit" class="tx-quxiao-queding">
                                                确定
                                            </button>
                                            <div class="tx-quxiao-quxiao" style="top: 12px;">
                                                取消操作
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </ul>
                        </li>
                    @endforeach
                </ul>
                <ul id="jinxing" class="sqjl-xinxi" style="display: none">
                    <li class="sqjl-xinxi-title">
                        <ul>
                            <li>申请时间</li>
                            <li>金额</li>
                            <li>银行信息</li>
                            <li>状态</li>
                            <li>操作</li>
                        </ul>
                    </li>
                    @foreach($result->jinxing as $k=>$v)
                        @if($v->sq_type==0&&$v->sh_type!=4&&$v->sh_type!=5)
                            <li @if($k==0) style="border-top: none;" @endif>
                                <ul>
                                    <li class="sqsj">{{$v->create_time->format('Y-m-d H:i:s')}}</li>
                                    <li class="sqje">{{$v->money}}</li>
                                    <li class="xxck">
                                        查看
                                        <div class="xxck-xiangqing">
                                            <img src="{{path('images/new/chankan.png')}}" class="chakan"/>
                                            <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												开户行：
											</span>
                                                <div class="khh-bank">
                                                    {{$v->bank}}
                                                </div>
                                            </div>
                                            <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												卡号：
											</span>
                                                <div class="khh-bank kahao">
                                                    {{str_replace(' ','',$v->bank_sn)}}
                                                </div>
                                            </div>
                                            <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												户名：
											</span>
                                                <div class="khh-bank">
                                                    {{$v->bank_user}}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="ztjg @if($v->sh_type==5) yiquxiao @endif">
                                        {{$v->sh_type_text}}
                                        {{--<div class="tx-zhuangtai">--}}
                                        {{--<ul>--}}
                                        {{--<li>处理时间</li>--}}
                                        {{--<li>订单追踪信息</li>--}}
                                        {{--</ul>--}}
                                        {{--<div class="tx-zhuangtai-xinxi">--}}
                                        {{--<span class="zhuangtai-shijian">--}}
                                        {{--<img src="img/dian.jpg"/>--}}
                                        {{--2017-05-15 09:01:49--}}
                                        {{--</span>--}}
                                        {{--<span class="dingdan-xiangqing">--}}
                                        {{--您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消--}}
                                        {{--</span>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                    </li>
                                    @if($v->sq_type==0&&($v->sh_type==5||$v->sh_type==0))
                                        <li class="qxsq">取消</li>
                                        <form action="{{route('user.tixian.update',['id'=>$v->tx_id])}}" method="POST">
                                            <input name="_method" value="PUT" type="hidden">
                                            {!! csrf_field() !!}
                                            <div class="tx-queding tx-tcc" style="line-height: 12px;">
                                                <div>您确定要取消此次金额为<span>{{$v->money}}元</span>提现申请吗？</div>
                                                <button type="submit" class="tx-quxiao-queding">
                                                    确定
                                                </button>
                                                <div class="tx-quxiao-quxiao" style="top: 12px;">
                                                    取消操作
                                                </div>
                                            </div>
                                        </form>
                                    @elseif($v->sq_type==2&&($v->sh_type==4))
                                        <li class="qxsq-again">再次申请</li>
                                        <form action="{{route('user.tixian.store')}}" method="post">
                                            <input type="hidden" name="id" value="{{$v->tx_id}}"/>
                                            {!! csrf_field() !!}
                                            <div class="tx-quxiao tx-tcc" style="line-height: 12px;">
                                                <div>您确定要以这个提现申请的数据为模板再次申请提现吗？</div>
                                                <button type="submit" class="tx-quxiao-queding">
                                                    确定
                                                </button>
                                                <div class="tx-quxiao-quxiao" style="top: 12px;">
                                                    取消操作
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <ul id="wancheng" class="sqjl-xinxi" style="display: none">
                    <li class="sqjl-xinxi-title">
                        <ul>
                            <li>申请时间</li>
                            <li>金额</li>
                            <li>银行信息</li>
                            <li>状态</li>
                            <li>操作</li>
                        </ul>
                    </li>
                    @foreach($result->wancheng as $k=>$v)
                        @if($v->sq_type==2&&$v->sh_type==4)
                            <li @if($k==0) style="border-top: none;" @endif>
                                <ul>
                                    <li class="sqsj">{{$v->create_time->format('Y-m-d H:i:s')}}</li>
                                    <li class="sqje">{{$v->money}}</li>
                                    <li class="xxck">
                                        查看
                                        <div class="xxck-xiangqing">
                                            <img src="{{path('images/new/chankan.png')}}" class="chakan"/>
                                            <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												开户行：
											</span>
                                                <div class="khh-bank">
                                                    {{$v->bank}}
                                                </div>
                                            </div>
                                            <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												卡号：
											</span>
                                                <div class="khh-bank kahao">
                                                    {{str_replace(' ','',$v->bank_sn)}}
                                                </div>
                                            </div>
                                            <div class="khh">
											<span class="khh-title">
												<img src="{{path('images/new/dian.jpg')}}"/>
												户名：
											</span>
                                                <div class="khh-bank">
                                                    {{$v->bank_user}}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="ztjg @if($v->sh_type==5) yiquxiao @endif">
                                        {{$v->sh_type_text}}
                                        {{--<div class="tx-zhuangtai">--}}
                                        {{--<ul>--}}
                                        {{--<li>处理时间</li>--}}
                                        {{--<li>订单追踪信息</li>--}}
                                        {{--</ul>--}}
                                        {{--<div class="tx-zhuangtai-xinxi">--}}
                                        {{--<span class="zhuangtai-shijian">--}}
                                        {{--<img src="img/dian.jpg"/>--}}
                                        {{--2017-05-15 09:01:49--}}
                                        {{--</span>--}}
                                        {{--<span class="dingdan-xiangqing">--}}
                                        {{--您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消您的订单已经取消--}}
                                        {{--</span>--}}
                                        {{--</div>--}}
                                        {{--</div>--}}
                                    </li>
                                    @if($v->sq_type==0&&($v->sh_type==5||$v->sh_type==0))
                                        <li class="qxsq">取消</li>
                                        <form action="{{route('user.tixian.update',['id'=>$v->tx_id])}}" method="POST">
                                            <input name="_method" value="PUT" type="hidden">
                                            {!! csrf_field() !!}
                                            <div class="tx-queding tx-tcc" style="line-height: 12px;">
                                                <div>您确定要取消此次金额为<span>{{$v->money}}元</span>提现申请吗？</div>
                                                <button type="submit" class="tx-quxiao-queding">
                                                    确定
                                                </button>
                                                <div class="tx-quxiao-quxiao" style="top: 12px;">
                                                    取消操作
                                                </div>
                                            </div>
                                        </form>
                                    @elseif($v->sq_type==2&&($v->sh_type==4))
                                        <li class="qxsq-again">再次申请</li>
                                        <form action="{{route('user.tixian.store')}}" method="post">
                                            <input type="hidden" name="id" value="{{$v->tx_id}}"/>
                                            {!! csrf_field() !!}
                                            <div class="tx-quxiao tx-tcc" style="line-height: 12px;">
                                                <div>您确定要以这个提现申请的数据为模板再次申请提现吗？</div>
                                                <button type="submit" class="tx-quxiao-queding">
                                                    确定
                                                </button>
                                                <div class="tx-quxiao-quxiao" style="top: 12px;">
                                                    取消操作
                                                </div>
                                            </div>
                                        </form>
                                    @endif
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @include('common.footer')
    <script>
        $(function () {
            //兼容不支持placeholder的浏览器[ie浏览器，并且10以下均采用替代方式处理]
            if ((navigator.appName == "Microsoft Internet Explorer") && (document.documentMode < 10 || document.documentMode == undefined)) {
                var $placeholder = $("input[placeholder]");
                for (var i = 0; i < $placeholder.length; i++) {
                    if ($placeholder.eq(i).attr("type") == "password") {
                        $placeholder.eq(i).siblings("label").text($placeholder.eq(i).attr("placeholder")).show()
                    } else {
                        $placeholder.eq(i).val($placeholder.eq(i).attr("placeholder")).css({"color": "#ccc"})
                    }
                }
                $placeholder.focus(function () {
                    if ($(this).attr("type") == "password") {
                        $(this).siblings("label").hide()
                    } else {
                        if ($(this).val() == $(this).attr("placeholder")) {
                            $(this).val("").css({"color": "#333"})
                        }
                    }
                }).blur(function () {
                    if ($(this).attr("type") == "password") {
                        if ($(this).val() == "") {
                            $(this).siblings("label").text($(this).attr("placeholder")).show()
                        }
                    } else {
                        if ($(this).val() == "") {
                            $(this).val($(this).attr("placeholder")).css({"color": "#ccc"})
                        }
                    }
                });
                $(".clone_input_text").live("focus", function () {
                    $(this).siblings("label").hide()
                }).live("blur", function () {
                    if ($(this).val() == "") {
                        $(this).siblings("label").text($(this).attr("placeholder")).show()
                    }
                });
                $placeholder.siblings("label").click(function () {
                    if ($(this).parent("div").siblings(".see_pwd_btn").attr("data-flag") == "1") {
                        $(this).hide().next("input").next("input").focus()
                    } else {
                        $(this).hide().next("input").focus()
                    }
                })
            }
            $('.qxsq').click(function () {
                $('.tx-tcc').hide();
                $(this).next().children('.tx-queding').show()
            })
            $('.qxsq-again').click(function () {
                $('.tx-tcc').hide();
                $(this).next().children('.tx-quxiao').show()
            })
            $('.tx-quxiao-queding').click(function () {
                $(this).parent().hide()
            })
            $('.tx-quxiao-quxiao').click(function () {
                $(this).parent().hide()
            })
            $('.tixian-xinxi ul li input').focus(function () {
                $(this).css({
                    'boder': '1px solid #3ebb2b',
                    'box-shadow': '0 0 4px rgba(62,187,43,0.6)'
                })
            })
            $('.tixian-xinxi ul li input').blur(function () {
                $(this).css({
                    'boder': '1px solid #ccc',
                    'box-shadow': 'none'
                })
            })
            $('.tixian-all').click(function () {
                var user_money = '{{$user->user_money}}';
                $('#money').val(user_money);
            });
            $('.sqjl-zhuangtai li').click(function () {
                $('.sqjl-zhuangtai li').removeClass('sqjl-on');
                $(this).addClass('sqjl-on')
                var uid = $(this).attr('uid');
                $('.sqjl-xinxi').hide();
                $('#' + uid).show();
            })
        });
        //     银行卡输入整理
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
    </script>
@endsection
