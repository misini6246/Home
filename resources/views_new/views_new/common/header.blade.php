<link href="{{path('new/css/header.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('new/css/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('new/css/main.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('new/js/index.js')}}"></script>
<div id="header">
    <!--登陆注册一栏-->
    <div class="top_box" style="border: none;">
        <div class="top">
            <div class="top_left">
                @if($user)
                    <div class="login_after" style="display:block;">

                        <div class="username" alt="#" title="#">
                            <div class="UserId">{{str_limit($user->user_name,15)}}</div>
                            <div class="gerenxinxi">
                                <div class="touxiangimg">
                                    <a href="#"><img src="{{path('new/images/gerentouxiang.png')}}"/></a>
                                </div>
                                <div class="weizhi" style="color: #767676;">
                                    <a href="#">{{$user->msn}}</a>
                                </div>
                                <div class="mingzi">
                                    <a href="#" style="color:#999999;">{{get_region_name([$user->province])}}
                                        -{{rank_name($user->user_rank)}}</a>
                                </div>
                                <ul class="userfunc">
                                    <li><a href="/user/orderList" style="color: white;">我的订单</a></li>
                                    <li><a target="_blank" href="/jf" style="color: white;">我的积分</a></li>
                                    <li style="border: none;"><a href="/user/zncg" style="color: white;">智能采购</a></li>
                                </ul>
                            </div>
                        </div>

                        <a href="/auth/logout" class="out">[&nbsp;退出&nbsp;]</a>
                        <span class="separate2"></span>
                        <a href="http://www.hezongyy.com/user" class="my_name">我的药易购</a>
                    </div>
                @else
                    <div class="login_before">
                        <!--<span>您好，欢迎来到合纵医药网会员中心！</span><span class="separate">|</span>-->
                        <a href="/auth/login">
                            <div class="loginbtn">登录</div>
                        </a> <span class="separate2"></span><a href="/auth/register" class="reg"
                                                               style="color:#777777;margin-left: 10px;">注册</a>
                    </div>
                @endif
                    @if(isset($show_area_url))
                        <div class="add">
                            <div class="add-box">
                                <img src="{{path('new/images/dingwei.png')}}" style="position: absolute;top:12px;left: 5px;"/>
                                <div id="morenAdd">@if($show_area==26)四川@else新疆@endif</div>
                                <img src="{{path('new/images/dizhixuanze.png')}}"
                                     style="position: absolute;top:12px;left: 52px;"/>
                            </div>
                            @if(!auth()->check())
                                <div class="addselect">
                                    {!! $show_area_url !!}
                                </div>
                            @endif
                        </div>
                    @endif
            </div>

            <div id="top-right">
                <ul>
                    <li>
                        <div style="border-right:1px solid #cecece ;">
                            <a target="_blank" href="/dzfp" style="color: #3dbb2b;">电子发票查询</a>
                        </div>
                    </li>
                    <li>
                        <div style="border-right:1px solid #cecece ;">
                            <a target="_blank" href="/zhijian">质检报告查询</a>
                        </div>
                    </li>
                    <li>
                        <div class="qiugou" style="border: none;">
                            <a target="_blank" href="/requirement">求购专区</a>
                        </div>
                    </li>
                    <li style="position: relative;" class="app-yaoyigou">
                        <div class="hehe1">
                            <img src="{{path('new/images/bgerweima_05.png')}}"
                                 style="position: absolute;top: 11px;left: 10px;"/>
                            <a href="#" style="text-align:center;">
                                <p style="width: 12px;height: 12px;border: 1px solid transparent;display: inline-block;"></p>

                                手机药易购
                                <p style="width: 12px;height: 12px;border: 1px solid transparent;display: inline-block;"></p>
                                <img src="{{path('new/images/dizhixuanze.png')}}"
                                     style="position: absolute;top:10px;right:10px;"/>
                            </a>

                        </div>

                    </li>
                    <li>
                        <div>
                            <a target="_blank" href="/article?id=3">帮助中心</a>
                        </div>
                    </li>
                    <li class="tousuTS">
                        <div class="hehe2">
                            <a href="#">
                                投诉
                                <p style="width: 15px;height: 12px;border: 1px solid transparent;display: inline-block;"></p>
                                <img src="{{path('new/images/dizhixuanze.png')}}"
                                     style="position: absolute;top:11px;right:10px;"/>
                            </a>
                        </div>
                    </li>
                </ul>
                <p id="yaoyigou-app">
                    <img src="{{path('new/images/yaoyigou.png')}}"/>
                <p/>
                <p id="TSdianhua">
                    15208485597
                </p>
            </div>
            <script type="text/javascript">
                $(function () {
                    $('.app-yaoyigou').hover(function () {
                        $('#yaoyigou-app').show();
                        $('#yaoyigou-app').css('z-index', '9999');
                        $('.hehe1').css({
                            'border-right': '1px solid #f1f1f1',
                            'border-left': '1px solid #f1f1f1'
                        });


                        $('.app-yaoyigou').css({
                            'border-right': '1px solid #cecece',
                            'border-left': '1px solid #cecece'
                        })

//			            			$('.hehe1').css('height','39px');
                    }, function () {
                        $('#yaoyigou-app').hide();
                        $('.hehe1').css({
                            'border-right': '1px solid #cecece',
                            'border-left': '1px solid #cecece'
                        })

                        $('.app-yaoyigou').css({
                            'border-right': '1px solid #f1f1f1',
                            'border-left': '1px solid #f1f1f1'
                        })

                    })


                    $('.tousuTS').hover(function () {
                        $('#TSdianhua').show();
//			            			$('#TSdianhua').css('z-index','999');
                        $('.hehe2').css({
                            'border-right': '1px solid #f1f1f1',
                            'border-left': '1px solid #f1f1f1'
                        });


                        $('.tousuTS').css({
                            'border-right': '1px solid #cecece',
                            'border-left': '1px solid #cecece'
                        })

//			            			$('.hehe1').css('height','39px');
                    }, function () {
                        $('#TSdianhua').hide();
                        $('.hehe2').css({
                            'border-right': '1px solid #cecece',
                            'border-left': '1px solid #cecece'
                        })
                        $('.tousuTS').css({
                            'border-right': '1px solid #f1f1f1',
                            'border-left': '1px solid #f1f1f1'
                        })

                    })


                })
            </script>


        </div>
    </div>
    <!--登陆注册一栏结束-->

</div>

<!--搜索框开始-->
<div class="search">
    <div class="search_box">
        <div>
            <a href="#">
                <img src="{{path('new/images/logo.png')}}"/>
            </a>
            <div class="search_box fn_clear">
                <input id="suggest" name="userSearch" type="text" value="药品名称(拼音缩写)或厂家名称" class="search_input suggest"/>
                <a href="javascript:void(0)" class="btn search_btn">搜 索</a>


                <div id="suggestions_wrap" class="search_show list_box suggestions_wrap"
                     style="display:none;margin-left: 330px;margin-top: -46px;left:auto;top: auto;">

                    <ul class="search_list suggestions" id="suggestions">
                        <li class="" style="cursor: pointer;">(简)复方氨基酸注射液(18AA-V)</li>
                        <li class="" style="cursor: pointer;">(精)复方氨基酸注射液(18AA-V)</li>
                        <li class="" style="cursor: pointer;">(精)盐酸氨溴索葡萄糖注射液</li>
                        <li class="" style="cursor: pointer;">(精)盐酸氨溴索葡萄糖注射液(给欣)</li>
                        <li class="active" style="cursor: pointer;">(高邦爱无忧延缓)天然胶乳橡胶避孕套</li>
                        <li>*复方福尔可定口服溶液(奥特斯)</li>
                        <li>*小儿伪麻美芬滴剂(艾畅)</li>
                        <li>*氨酚伪麻片(Ⅱ)</li>
                        <li>*氨酚伪麻美芬片Ⅱ/氨麻苯美片(白加黑)</li>
                        <li>*氨酚伪麻胶囊(II)</li>
                    </ul>
                </div>
            </div>


            <a href="/cart">
                <div class="gouwuche" style="float: right;">
                    <img src="{{path('new/images/gouwuche.png')}}"/>
                    购物车
                    <span style="color: red;">({{cart_info()}})</span>
                </div>
            </a>

            <a href="/user/orderList">
                <div class="dingdan" style="float: right;">
                    <img src="{{path('new/images/xiangqing.png')}}"/>
                    订单查询
                </div>
            </a>

            <div class="cuxiao">
                <a href="#">儿童退热贴</a>&nbsp;&nbsp;
                <a href="#">促销专区</a>&nbsp;&nbsp;
                <a href="#">效期品种</a>
            </div>
            <marquee class="gundong" onmouseover=this.stop() onmouseout=this.start() direction="down" scrollamount="2">
                <a target="_blank" href="http://www.hezongyy.com/images/zgz1.jpg">
                    <div>药品交易服务证书:川B20130002</div>
                </a>
            </marquee>
        </div>
    </div>
</div>
