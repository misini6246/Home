<link href="{{path('new/css/header.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('new/css/index.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{path('new/css/main.css')}}" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="{{path('new/js/index.js')}}"></script>
@include('common.topad')
<div id="header">
    <!--登陆注册一栏-->
    <div class="top_box" style="border: none;">
        <div class="top">
            <div class="top_left">
                @if($user)
                    <div class="login_after" style="display:block;">

                        <div class="username" alt="{{$user->user_name}}" title="{{$user->user_name}}">
                            <div class="UserId">{{str_limit($user->msn,14)}}<span
                                        style="color: #4c4b4b;">，欢迎来到{{config('services.web.name')}}网！</span></div>

                        </div>

                        <a href="/auth/logout" class="out">[&nbsp;退出&nbsp;]</a>
                        <span class="separate2"></span>
                        <div class="my_name-box">
                            <a href="/user" class="my_name">
                                我的太星医药网
                            </a>
                            <div class="gerenxinxi">
                                <img src="{{path('new/images/gerenxinxi-top.png')}}"
                                     style="position: absolute;top: -7px;left:30px;"/>
                                <div class="touxiangimg">
                                    <a href="#"><img src="{{path('new/images/gerentouxiang.png')}}"/></a>
                                </div>
                                <div class="weizhi" style="color: #767676;">
                                    <a style="margin-left:15px;" href="/user">{{str_limit($user->msn,18)}}</a>
                                </div>
                                <div class="mingzi">
                                    <a href="#"
                                       style="color:#999999;margin-left:15px;">{{rank_name($user->user_rank)}}</a>

                                </div>
                                <ul class="userfunc">
                                    <li><a href="/user/orderList" style="color: white;">我的订单</a></li>
                                    <li><a target="_blank" href="/jf/member" style="color: white;">我的积分</a></li>
                                    <li style="border: none;"><a href="/user/zncg" style="color: white;">智能采购</a></li>
                                </ul>
                            </div>
                        </div>

                    </div>
                @else
                    <div class="login_before">
                        <span style="float: left;">您好，欢迎来到{{config('services.web.name')}}网！</span><span style="float: left;"
                                                                             class="separate">|</span>
                        <div class="login_before1">
                            <a href="/auth/login">
                                <div class="loginbtn">登录</div>
                            </a>
                            <span class="separate2"></span>
                            <a href="/auth/register" class="reg" style="color:#777777;">
                                注册
                            </a>
                        </div>
                    </div>
                @endif
                @if(isset($show_area_url))
                    @if(auth()->check())
                        {{--<div class="show_area1">--}}
                        {{--<div class="show_area-box">--}}
                        {{--<div id="moreAdd" style="line-height: 40px;text-align:left;">--}}
                        {{--<p>@if($show_area==26)四川@else新疆@endif</p>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                    @else
                        <div class="show_area" onmouseover="this.className='show_area mv_hover2'"
                             onmouseout="this.className='show_area'">
                            <div class="show_area-box">
                                <div id="moreAdd" style="text-align:left;">
                                    <p>@if($show_area==26)四川@else新疆@endif</p>
                                    <span></span>
                                </div>
                            </div>
                            <div class="show_areaselect">
                                {!! $show_area_url !!}
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <ul class="jkn_head_t_r">
                {{--<li class="mobile_version1" onmouseover="this.className='mobile_version1 mv_hover1'"--}}
                    {{--onmouseout="this.className='mobile_version1'"><p class="mobile_anniu1"><a--}}
                                {{--href="#">投诉</a><span></span></p>--}}
                    {{--<div class="bjqr_code1">--}}

                        {{--15208485597--}}

                    {{--</div>--}}
                {{--</li>--}}

                {{--<li style="padding-left: 10px;">--}}
                    {{--<a target="_blank" href="/article?id=3">帮助中心</a>--}}
                {{--</li>--}}
                {{--<li class="mobile_version" onmouseover="this.className='mobile_version mv_hover'"--}}
                    {{--onmouseout="this.className='mobile_version'">--}}
                    {{--<p class="mobile_anniu">--}}
                        {{--<img src="{{path('new/images/bgerweima_05.png')}}"--}}
                             {{--style="display: inline-block;vertical-align: middle;margin-top: -1px;"/>--}}
                        {{--<a href="#">--}}
                            {{--手机药易购--}}
                        {{--</a>--}}
                        {{--<span></span>--}}
                    {{--</p>--}}
                    {{--<div class="bjqr_code">--}}
                        {{--<img src="{{path('new/images//yaoyigou.png')}}"/>--}}
                    {{--</div>--}}
                {{--</li>--}}
                <li class="my_jianke">
                    <a target="_blank" href="/user/collectList">
                        我的收藏
                    </a>
                </li>
                {{--<li class="my_jianke">--}}
                    {{--<a target="_blank" href="/requirement">求购专区</a>--}}
                    {{--<div style="position: absolute;left: 67px;top: 0;color: #cecece;">|</div>--}}
                {{--</li>--}}
                {{--<li class="my_jianke">--}}
                    {{--<a target="_blank" href="/ggzs.html" style="color:#46d23c;">广告合作</a>--}}
                    {{--<div style="position: absolute;left: 67px;top: 0;color: #cecece;">|</div>--}}
                {{--</li>--}}
                {{--<li class="my_jianke">--}}
                    {{--<a target="_blank" href="/zhijian">质检报告查询</a>--}}
                {{--</li>--}}
                {{--<li class="my_jianke">--}}
                    {{--<a target="_blank" href="/dzfp" style="color:#46d23c;">电子发票查询</a>--}}
                {{--</li>--}}
            </ul>


        </div>
    </div>
    <!--登陆注册一栏结束-->

</div>


<!--搜索框开始-->
<div class="search" style="position: relative;*z-index: 9999;">
    <div class="search_box">
        <div>
            @if(time()>=strtotime(20171213))
                <a href="{{route('index')}}" style="display: inline-block;height: 64px;position: relative;">
                    <img style="position: absolute;" src="{{path('images/logo-new.png')}}"/>
                </a>
            @elseif(time()>=strtotime(20171212))
                <a target="_blank" href="{{route('category.index',['step'=>'promotion'])}}"
                   style="display: inline-block;height: 64px;position: relative;">
                    <img style="position: absolute;top: -25px" src="{{get_img_path('images/hd/logo12.gif')}}"/>
                </a>
            @else
                <a target="_blank" href="{{route('category.index',['step'=>'nextpro'])}}"
                   style="display: inline-block;height: 64px;position: relative;">
                    <img style="position: absolute;top: -25px" src="{{get_img_path('images/hd/logo12.gif')}}"/>
                </a>
            @endif
            <div class="search_box fn_clear">
                <input id="suggest" name="userSearch" type="text"
                       value="@if(!isset($keywords)||empty($keywords))药品名称(拼音缩写)或厂家名称@else{{$keywords}}@endif"
                       class="search_input suggest"/>
                <a href="javascript:void(0)" class="btn search_btn">搜 索</a>


                <div id="suggestions_wrap" class="search_show list_box suggestions_wrap"
                     style="margin-left: 330px;margin-top: -46px;left:auto;top: auto;*margin-left: -503px;">

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
                    <img style="margin-top: -5px;" src="{{path('new/images/gouwuche.png')}}"/>
                    购物车
                    <span style="color: red;">(<span class="cart_number">{{cart_info()}}</span>)</span>
                </div>
            </a>

            <a href="/user/orderList">
                <div class="dingdan" style="float: right;">
                    <img src="{{path('new/images/xiangqing.png')}}"/>
                    订单查询
                </div>
            </a>

            <div class="cuxiao">
                @if(count($ad159)>0)
                    @foreach($ad159 as $v)
                        <a target="_blank" href="{{$v->ad_link}}" style="color: red;">{{$v->ad_name}}</a>
                    @endforeach
                @else
                    @if(time()<strtotime('20170622'))
                        <a target="_blank"
                           href="@if(time()>strtotime('20170621')) {{route('category.index',['step'=>'promotion'])}} @else {{route('category.index',['step'=>'nextpro'])}} @endif"
                           style="color: red;">6.21特价活动
                        </a>
                    @endif
                @endif
            </div>
            <div class="swiper_wrap">
                <ul class="font_inner">
                    <li>
                        {{--<a target="_blank" href="http://www.hezongyy.com/images/zgz1.jpg">互联网药品交易服务资格证</a>--}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        //1文字轮播(2-5页中间)开始

//        $(".font_inner li:eq(0)").clone(true).appendTo($(".font_inner"));//克隆第一个放到最后(实现无缝滚动)
        var liHeight = $(".swiper_wrap").height();//一个li的高度
        //获取li的总高度再减去一个li的高度(再减一个Li是因为克隆了多出了一个Li的高度)
        var totalHeight = ($(".font_inner li").length * $(".font_inner li").eq(0).height()) - liHeight;
        $(".font_inner").height(totalHeight);//给ul赋值高度
        var index = 0;
        var autoTimer = 0;//全局变量目的实现左右点击同步
        var clickEndFlag = true; //设置每张走完才能再点击

        function tab() {
            $(".font_inner").stop().animate({
                top: -index * liHeight
            }, 400, function () {
                clickEndFlag = true;//图片走完才会true
                if (index == $(".font_inner li").length - 1) {
                    $(".font_inner").css({top: 0});
                    index = 0;
                }
            })
        }

        function next() {
            index++;
            if (index > $(".font_inner li").length - 1) {//判断index为最后一个Li时index为0
                index = 0;
            }
            tab();
        }

        function prev() {
            index--;
            if (index < 0) {
                index = $(".font_inner li").size() - 2;//因为index的0 == 第一个Li，减二是因为一开始就克隆了一个LI在尾部也就是多出了一个Li，减二也就是_index = Li的长度减二
                $(".font_inner").css("top", -($(".font_inner li").size() - 1) * liHeight);//当_index为-1时执行这条，也就是走到li的最后一个
            }
            tab();
        }

        //自动轮播
        autoTimer = setInterval(next, 3000);
        $(".font_inner a").hover(function () {
            clearInterval(autoTimer);
        }, function () {
            autoTimer = setInterval(next, 3000);
        })

        //鼠标放到左右方向时关闭定时器
        $(".swiper_wrap .lt,.swiper_wrap .gt").hover(function () {
            clearInterval(autoTimer);
        }, function () {
            autoTimer = setInterval(next, 3000);
        })
        //1文字轮播(2-5页中间)结束
    })
</script>
