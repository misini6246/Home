@extends('layout.body')
@section('links')
    <link href="{{path('css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('js/slideshow.js')}}"></script>
@endsection
@section('content')

    <!-- 顶部广告结束 -->

    <!-- 头部开始 -->
    @include('layout.page_header')
    <!-- 头部结束 -->

    <!-- 导航条开始 -->
    @include('layout.nav')
    <!-- 导航条结束 -->
    <!-- 导航条右侧开始  -->
    @if(time()<strtotime('20160213'))
        <div class="pingpaizq"
             style="background: url('{{get_img_path('images/xinnianbg-02.jpg')}}') no-repeat scroll center top;min-width: 1200px;overflow: hidden;width: 100%;background-color: #ea5c4a;">


            <div class="bg-box" style="width:1200px;margin:0 auto;background-color:#fff;">
            @endif
            @include('layout.nav_right')
            <!-- 导航条结束 -->

                <!-- 主题内容部分开始 -->
                <div class="site-content-waper fn_clear">
                    {{--@include('shuang11.daojs')--}}

                    <div class="site-content-top">
                        <div class="tebietuijian-box" id="tebietuijian">
                            <div class="tuijian-title">
                                <div class="time-item" id="time-item"
                                     @if($zfdm->first()) data-id="{{$zfdm->first()->end_time-time()}}" @endif >
                                    <strong id="day_show">0</strong>
                                    <strong id="hour_show"><s id="h"></s>0</strong>
                                    <strong id="minute_show"><s></s>00</strong>
                                    <strong id="second_show"><s></s>00</strong>
                                </div>

                            </div>
                            <div class="tuijian-list1-box">
                                <ul class="tuijian-list1 fn_clear">
                                    @if($zfdm)
                                        @foreach($zfdm as $k=>$v)
                                            @if($k<3)

                                                <li class="box  grid">
                                                    <a href="{{$v->ad_link}}" target="_blank">
                                                        <figure class="effect-apollo">
                                                            <img src="{{$v->ad_code}}" alt=""/>
                                                            <figcaption>


                                                                <p></p>
                                                            </figcaption>
                                                        </figure>
                                                    </a>
                                                </li>

                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                            <div class="list-bg"></div>
                            <div class="tuijian-list2-box">
                                <ul class="tuijian-list2 fn_clear">
                                    @if($zfdm)
                                        @foreach($zfdm as $k=>$v)
                                            @if($k<6&&$k>=3)
                                                <li class="box  grid">
                                                    <a href="{{$v->ad_link}}" target="_blank">
                                                        <figure class="effect-apollo">
                                                            <img src="{{$v->ad_code}}" alt=""/>
                                                            <figcaption>


                                                                <p></p>
                                                            </figcaption>
                                                        </figure>
                                                    </a>
                                                </li>

                                            @endif
                                        @endforeach
                                    @endif
                                </ul>
                            </div>

                        </div>
                        <div class="news-list">
                            <div id="J_Notice" class="notice">
                                <div class="notice-hd">
                                    <ul>
                                        <li class="selected">
                                            <span style="width:12px;height:12px;position:absolute;left:20px;top:14px;background:url('{{get_img_path('images/index-01-ico.png')}}') no-repeat;"></span>
                                            <a href="javascript:;">{{$art1->cat_name or '公司动态'}} </a>
                                        </li>
                                        <li class="">
                                            <a href="javascript:;">{{$art2->cat_name or '医药信息'}}</a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="notice-bd">
                                    <div class="mod">

                                        <ul>
                                            @foreach($art1->article as $k=>$v)
                                                <li><a href="{{route('articleInfo',['id'=>$v->article_id])}}"
                                                       target="_blank" title="{{$v->title}}"
                                                       @if($k==0) class="first" @endif>
                                                        <span>{{str_limit($v->title,25)}}</span>
                                                        <em class="date">{{date('Y/m/d',$v->add_time)}}</em>
                                                    </a></li>
                                            @endforeach
                                        </ul>
                                        <p class="more">
                                            <a href="{{route('article.index',['id'=>4])}}" target="_blank">更多 》</a>
                                        </p>

                                    </div>
                                    <div class="mod" style="display: none;">
                                        <ul>
                                            @foreach($art2->article as $k=>$v)
                                                <li><a href="{{route('articleInfo',['id'=>$v->article_id])}}"
                                                       target="_blank" title="{{$v->title}}"
                                                       @if($k==0) class="first" @endif>
                                                        <span>{{str_limit($v->title,25)}}</span>
                                                        <em class="date">{{date('Y/m/d',$v->add_time)}}</em>
                                                    </a></li>
                                            @endforeach
                                        </ul>
                                        <p class="more">
                                            <a href="{{route('article.index',['id'=>12])}}" target="_blank">更多 》</a>
                                        </p>

                                    </div>

                                </div>
                            </div>
                            <div class="dongtai" style="overflow: hidden;height: 360px;">
                                <h3 style="position: relative;">
                                    <span style="width:12px;height:12px;position:absolute;left:20px;top:14px;background:url('{{get_img_path('images/index-01-ico.png')}}') no-repeat;"></span>
                                    <a href="/requirement" target="_blank">求购动态</a></h3>
                                <ul class="qiugou-list" id="newly" style="overflow:hidden;height: 270px;">
                                    @foreach($buy as $v)
                                        <li><a>{{$v->buy_goods}}</a></li>
                                    @endforeach

                                </ul>
                                <p class="more">
                                    <a href="/requirement" target="_blank">更多 》</a>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="site-new fn_clear" id="demo1">
                        <h3><img src="{{get_img_path('images/new-index10.jpg')}}" alt=""/></h3>
                        <div class="new-left overimg">
                            @if($ad103)
                                @foreach($ad103 as $k=>$v)
                                    @if($k==0)
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                       alt=""/></a>
                                        <i class="light"></i>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="new-mid overimg">
                            @if($ad104)
                                @foreach($ad104 as $k=>$v)
                                    @if($k==0)
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                       alt=""/></a>
                                        <i class="light2"></i>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="new-list-box">
                            <ul class="new-list fn_clear">
                                @if($ad105)
                                    @foreach($ad105 as $k=>$v)
                                        @if($k<4)
                                            <li class="overimg">
                                                <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                               alt=""/></a>
                                                <i class="light"></i>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="ad1">
                        @if($ad37)
                            @foreach($ad37 as $k=>$v)
                                @if($k<3)
                                    <a class="a{{$k+1}}" href="{{$v->ad_link}}" target="_blank"><img
                                                src="{{$v->ad_code}}" alt=""/></a>
                                @endif
                            @endforeach
                        @endif
                    </div>

                    <div class="site-tuijian fn_clear" id="demo2">
                        <h3><img src="{{get_img_path('images/new-index17.jpg')}}" alt=""/></h3>
                        <div class="tuijian-left overimg">
                            @if($ad106)
                                @foreach($ad106 as $k=>$v)
                                    @if($k==0)
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                       alt=""/></a>
                                        <i class="light"></i>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="tuijian-mid overimg">
                            @if($ad106)
                                @foreach($ad106 as $k=>$v)
                                    @if($k==1)
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                       alt=""/></a>
                                        <i class="light"></i>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="tuijian-list-box">
                            <ul class="tuijian-list fn_clear">
                                @if($ad107)
                                    @foreach($ad107 as $k=>$v)
                                        @if($k<4)
                                            <li class="overimg">
                                                <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                               alt=""/></a>
                                                <i class="light2"></i>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="ad2">
                        @if($ad38)
                            @foreach($ad38 as $k=>$v)
                                @if($k<3)
                                    <a class="a{{$k+1}}" href="{{$v->ad_link}}" target="_blank"><img
                                                src="{{$v->ad_code}}" alt=""/></a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="site-rexiao fn_clear" id="demo3">
                        <h3><img src="{{get_img_path('images/new-index29.jpg')}}" alt=""/></h3>
                        <div class="rexiao-left overimg">
                            @if($ad108)
                                @foreach($ad108 as $k=>$v)
                                    @if($k==0)
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                       alt=""/></a>
                                        <i class="light"></i>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="rexiao-list-box">
                            <ul class="rexiao-list fn_clear">
                                @if($ad109)
                                    @foreach($ad109 as $k=>$v)
                                        @if($k<4)
                                            <li class="overimg">
                                                <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                               alt=""/></a>
                                                <i class="light2"></i>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="ad3">
                        @if($ad39)
                            @foreach($ad39 as $k=>$v)
                                @if($k<3)
                                    <a class="a{{$k+1}}" href="{{$v->ad_link}}" target="_blank"><img
                                                src="{{$v->ad_code}}" alt=""/></a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="site-baojian fn_clear" id="demo4">
                        <h3><img src="{{get_img_path('images/new-index30.jpg')}}" alt=""/></h3>
                        <div class="baojian-left overimg">
                            @if($ad110)
                                @foreach($ad110 as $k=>$v)
                                    @if($k==0)
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                       alt=""/></a>
                                        <i class="light2"></i>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="baojian-list-box">
                            <ul class="baojian-list fn_clear">
                                @if($ad111)
                                    @foreach($ad111 as $k=>$v)
                                        @if($k<4)
                                            <li class="overimg">
                                                <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                               alt=""/></a>
                                                <i class="light2"></i>
                                            </li>
                                        @endif
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="ad4">
                        @if($ad41)
                            @foreach($ad41 as $k=>$v)
                                @if($k<3)
                                    <a class="a{{$k+1}}" href="{{$v->ad_link}}" target="_blank"><img
                                                src="{{$v->ad_code}}" alt=""/></a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="site-zhongyao fn_clear" id="demo5">
                        <h3><img src="{{get_img_path('images/new-index44.jpg')}}" alt=""/></h3>
                        <div class="zhongyao-one-box fn_clear">
                            @if($ad113)
                                @foreach($ad113 as $k=>$v)
                                    @if($k<2)
                                        <div class="zhongyao-left1 overimg">
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                           alt=""/></a>
                                            <i class="light"></i>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if($ad112)
                                @foreach($ad112 as $k=>$v)
                                    @if($k<2)
                                        <div class="zhongyao-left2 overimg">
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                           alt=""/></a>
                                            <i class="light2"></i>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="zhongyao-two-box fn_clear">
                            @if($ad115)
                                @foreach($ad115 as $k=>$v)
                                    @if($k==0)
                                        <div class="zhongyao-left1 overimg">
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                           alt=""/></a>
                                            <i class="light"></i>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if($ad114)
                                @foreach($ad114 as $k=>$v)
                                    @if($k==0)
                                        <div class="zhongyao-left2 overimg">
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                           alt=""/></a>
                                            <i class="light2"></i>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if($ad115)
                                @foreach($ad115 as $k=>$v)
                                    @if($k==1)
                                        <div class="zhongyao-left1 overimg">
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                           alt=""/></a>
                                            <i class="light"></i>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                            @if($ad114)
                                @foreach($ad114 as $k=>$v)
                                    @if($k==1)
                                        <div class="zhongyao-left2 overimg">
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                                           alt=""/></a>
                                            <i class="light2"></i>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <!-- 主题内容部分结束 -->
                @if(time()<strtotime('20160213'))
            </div>
        </div>
    @endif

    @if(($ad27))
        <!-- 弹出层开始 -->
        <div class="zzsc" style="display: block;z-index: 9999">
            <div class="content_tj"><a href="{{$ad27->ad_link}}" target="_blank"><img
                            src="{{get_img_path('data/afficheimg/'.$ad27->ad_code)}}" class="ad"></a>
                <span class="close"><img src="{{path('/images/close.png')}}" alt=""></span>
            </div>
        </div>

        <div class="content_mark" style="display: block;z-index: 9998"></div>
    @endif
    <!-- app扫描开始 -->
    @if(time()<strtotime('20170316')&&time()>=strtotime('20170314'))
        <div class="saoma" style="left: 10px;bottom: 50px">
            <div class="saoma-box">
                <span class="saoma-close" style="top: 0;right: 0;"></span>
                <a target="_blank"
                   href="@if(time()>strtotime('20170315')) {{route('category.index',['step'=>'gzbl_promotion'])}} @else {{route('category.index',['step'=>'gzbl_nextpro'])}} @endif">
                    <img src="{{get_img_path('images/gzbl.jpg')}}" alt=""></a>
            </div>

        </div>
    @else
        <div class="saoma">
            <div class="saoma-box">
                <span class="saoma-close"></span>
                <a target="_blank" href="javascript:;"> <img src="{{get_img_path('images/app01.png')}}" alt=""></a>
            </div>

        </div>
    @endif


    <!-- app扫描结束 -->
    <!-- 弹出层结束 -->
    @include('layout.page_footer')
    <script>
        $(function () {
            var _left = ($(window).width() - 1200) / 2 - 40;

            // @ 给窗口加滚动条事件
//        $(window).scroll(function(){
//            // 获得窗口滚动上去的距离
//            var ling = $(document).scrollTop();
//            var _index=$('#fixedNavBar ul li').index()+1;
//            // 在标题栏显示滚动的距离
//            //document.title = ling;
//            // 如果滚动距离大于1534的时候让滚动框出来
//            if(ling>1400){
//                $('#fixedNavBar').css('left',_left);
//                if(_left<40){
//                    _left=40
//                }
//
//                $('#fixedNavBar').show(300);
//            }
//
//            if(1400<ling && ling<2100){
//                // 让第一层的数字隐藏，文字显示，让其他兄弟元素的li数字显示，文字隐藏
//                // 让第一层的数字隐藏，文字显示，让其他兄弟元素的li数字显示，文字隐藏
//                $('#fixedNavBar ul li').eq(0).find('.num').hide().siblings('.word').css('display','block');
//                $('#fixedNavBar ul li').eq(0).siblings('li').find('.num').css('display','block').siblings('.word').hide();
//
//            }else if(ling<2600){
//                $('#fixedNavBar ul li').eq(1).find('.num').hide().siblings('.word').css('display','block');
//                $('#fixedNavBar ul li').eq(1).siblings('li').find('.num').css('display','block').siblings('.word').hide();
//            }else if(ling<3100){
//
//                $('#fixedNavBar ul li').eq(2).find('.num').hide().siblings('.word').css('display','block');
//                $('#fixedNavBar ul li').eq(2).siblings('li').find('.num').css('display','block').siblings('.word').hide();
//            }else if(ling<3600){
//                $('#fixedNavBar ul li').eq(3).find('.num').hide().siblings('.word').css('display','block');
//                $('#fixedNavBar ul li').eq(3).siblings('li').find('.num').css('display','block').siblings('.word').hide();
//            }else if(ling<3900){
//                $('#fixedNavBar ul li').eq(4).find('.num').hide().siblings('.word').css('display','block');
//                $('#fixedNavBar ul li').eq(4).siblings('li').find('.num').css('display','block').siblings('.word').hide();
//            }
//
//
//            if(ling>5800 || ling<1400){
//
//                $('#fixedNavBar').hide(300);
//            }
//
//        })
            $(window).scroll(function () {
                var top1 = $('#demo1').offset().top;
                var top2 = $('#demo2').offset().top;
                var top3 = $('#demo3').offset().top;
                var top4 = $('#demo4').offset().top;
                var top5 = $('#demo5').offset().top;
                var top6 = $('.site-footer').offset().top;
                // 获得窗口滚动上去的距离
                var ling = $('#fixedNavBar').offset().top;
                var _index = $('#fixedNavBar ul li').index() + 1;
                // 在标题栏显示滚动的距离
                //document.title = ling;
                // 如果滚动距离大于1534的时候让滚动框出来
                if (ling >= top1 && ling < top6) {
                    $('#fixedNavBar').css('left', _left);
                    if (_left < 40) {
                        _left = 40
                    }

                    $('#fixedNavBar').show(300);
                }

                if (top1 <= ling && ling < top2) {
                    // 让第一层的数字隐藏，文字显示，让其他兄弟元素的li数字显示，文字隐藏
                    // 让第一层的数字隐藏，文字显示，让其他兄弟元素的li数字显示，文字隐藏
                    $('#fixedNavBar ul li').eq(0).find('.num').hide().siblings('.word').css('display', 'block');
                    $('#fixedNavBar ul li').eq(0).siblings('li').find('.num').css('display', 'block').siblings('.word').hide();

                } else if (ling + 45 < top3 && ling + 45 >= top2) {
                    $('#fixedNavBar ul li').eq(1).find('.num').hide().siblings('.word').css('display', 'block');
                    $('#fixedNavBar ul li').eq(1).siblings('li').find('.num').css('display', 'block').siblings('.word').hide();
                } else if (ling + 90 < top4 && ling + 90 >= top3) {

                    $('#fixedNavBar ul li').eq(2).find('.num').hide().siblings('.word').css('display', 'block');
                    $('#fixedNavBar ul li').eq(2).siblings('li').find('.num').css('display', 'block').siblings('.word').hide();
                } else if (ling + 135 < top5 && ling + 135 >= top4) {
                    $('#fixedNavBar ul li').eq(3).find('.num').hide().siblings('.word').css('display', 'block');
                    $('#fixedNavBar ul li').eq(3).siblings('li').find('.num').css('display', 'block').siblings('.word').hide();
                } else if (ling + 180 < top6 && ling + 180 >= top5) {
                    $('#fixedNavBar ul li').eq(4).find('.num').hide().siblings('.word').css('display', 'block');
                    $('#fixedNavBar ul li').eq(4).siblings('li').find('.num').css('display', 'block').siblings('.word').hide();
                }


                if (ling >= top6 || ling < top1) {

                    $('#fixedNavBar').hide(300);
                }

            })

        })
    </script>
    <script>
        (function (d, D, v) {
            d.fn.responsiveSlides = function (h) {
                var b = d.extend({
                    auto: !0,
                    speed: 1E3,
                    timeout: 7E3,
                    pager: !1,
                    nav: !1,
                    random: !1,
                    pause: !1,
                    pauseControls: !1,
                    prevText: "Previous",
                    nextText: "Next",
                    maxwidth: "",
                    controls: "",
                    namespace: "rslides",
                    before: function () {
                    },
                    after: function () {
                    }
                }, h);
                return this.each(function () {
                    v++;
                    var e = d(this), n, p, i, k, l, m = 0, f = e.children(), w = f.size(), q = parseFloat(b.speed), x = parseFloat(b.timeout), r = parseFloat(b.maxwidth), c = b.namespace, g = c + v, y = c + "_nav " + g + "_nav", s = c + "_here", j = g + "_on", z = g + "_s",
                        o = d("<ul class='" + c + "_tabs " + g + "_tabs' />"), A = {
                            "float": "left",
                            position: "relative"
                        }, E = {"float": "none", position: "absolute"}, t = function (a) {
                            b.before();
                            f.stop().fadeOut(q, function () {
                                d(this).removeClass(j).css(E)
                            }).eq(a).fadeIn(q, function () {
                                d(this).addClass(j).css(A);
                                b.after();
                                m = a
                            })
                        };
                    b.random && (f.sort(function () {
                        return Math.round(Math.random()) - 0.5
                    }), e.empty().append(f));
                    f.each(function (a) {
                        this.id = z + a
                    });
                    e.addClass(c + " " + g);
                    h && h.maxwidth && e.css("max-width", r);
                    f.hide().eq(0).addClass(j).css(A).show();
                    if (1 <
                        f.size()) {
                        if (x < q + 100)return;
                        if (b.pager) {
                            var u = [];
                            f.each(function (a) {
                                a = a + 1;
                                u = u + ("<li><a href='#' class='" + z + a + "'>" + a + "</a></li>")
                            });
                            o.append(u);
                            l = o.find("a");
                            h.controls ? d(b.controls).append(o) : e.after(o);
                            n = function (a) {
                                l.closest("li").removeClass(s).eq(a).addClass(s)
                            }
                        }
                        b.auto && (p = function () {
                            k = setInterval(function () {
                                var a = m + 1 < w ? m + 1 : 0;
                                b.pager && n(a);
                                t(a)
                            }, x)
                        }, p());
                        i = function () {
                            if (b.auto) {
                                clearInterval(k);
                                p()
                            }
                        };
                        b.pause && e.hover(function () {
                            clearInterval(k)
                        }, function () {
                            i()
                        });
                        b.pager && (l.bind("click", function (a) {
                            a.preventDefault();
                            b.pauseControls || i();
                            a = l.index(this);
                            if (!(m === a || d("." + j + ":animated").length)) {
                                n(a);
                                t(a)
                            }
                        }).eq(0).closest("li").addClass(s), b.pauseControls && l.hover(function () {
                            clearInterval(k)
                        }, function () {
                            i()
                        }));
                        if (b.nav) {
                            c = "<a href='javascript:' class='" + y + " prev'>" + b.prevText + "</a><a href='javascript:' class='" + y + " next'>" + b.nextText + "</a>";
                            h.controls ? d(b.controls).append(c) : e.after(c);
                            var c = d("." + g + "_nav"), B = d("." + g + "_nav.prev");
                            c.bind("click", function (a) {
                                a.preventDefault();
                                if (!d("." + j + ":animated").length) {
                                    var c = f.index(d("." + j)),
                                        a = c - 1, c = c + 1 < w ? m + 1 : 0;
                                    t(d(this)[0] === B[0] ? a : c);
                                    b.pager && n(d(this)[0] === B[0] ? a : c);
                                    b.pauseControls || i()
                                }
                            });
                            b.pauseControls && c.hover(function () {
                                clearInterval(k)
                            }, function () {
                                i()
                            })
                        }
                    }
                    if ("undefined" === typeof document.body.style.maxWidth && h.maxwidth) {
                        var C = function () {
                            e.css("width", "100%");
                            e.width() > r && e.css("width", r)
                        };
                        C();
                        d(D).bind("resize", function () {
                            C()
                        })
                    }
                })
            }
        })(jQuery, this, 0);
        $(function () {
            $(".f426x240").responsiveSlides({
                auto: true,
                pager: true,
                nav: true,
                speed: 500
            });
            $(".f160x160").responsiveSlides({
                auto: true,
                pager: true,
                speed: 500
            });
        });


        $(function () {

            $(".new_banner").hover(function () {

                $(".rslides_nav").show();
            }, function () {

                $(".rslides_nav").hide();
            })


        })
    </script>
    <script type="text/javascript" src="{{path('js/scrolld.min.js')}}"></script>
    <script type="text/javascript">$("[id*='Btn']").stop(true).on('click', function (e) {
            e.preventDefault();
            $(this).scrolld();
        })</script>
@endsection

