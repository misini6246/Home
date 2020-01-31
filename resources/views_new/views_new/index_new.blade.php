@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('new/js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/lunbo.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery-color.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')

    <!-- 顶部广告结束 -->

    <!-- 头部开始 -->
    @include('common.header')
    <!-- 头部结束 -->

    <!-- 导航条开始 -->
    @include('common.nav')
    <!------------------------------------------轮播以及产品分类------------------------------------------>
    <!--产品分类开始-->
    <div id="banner">

        <!--背景图-->
        <div id="bgcolor">

        </div>

        <!--背景图-->

        <div class="banner-box">
            <div style="width: 990px;float: left;">
                <div style="display: inline-block;">
                    <div class="lunbo">
                        <div id="ban1">
                            <div class="banner">
                                <ul class="img">
                                    @if($ad121)
                                        @foreach($ad121 as $ad)
                                            <li wenzi="{{str_replace('2017','',$ad->ad_name)}}" yanse="{{$ad->ad_bgc}}">
                                                <a href="{{$ad->ad_link}}" target="_blank"><img
                                                            src="{{get_img_path('data/afficheimg/'.$ad->ad_code)}}"></a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <ul class="num">
                                </ul>
                                <div class="btn btn_l">
                                    <img src="{{path('new/images/left.jpg')}}" alt="">
                                </div>
                                <div class="btn btn_r">
                                    <img src="{{path('new/images/right.jpg')}}" alt="">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="banner-right">
            <ul>
                @if($ad122)
                    @foreach($ad122 as $k=>$v)
                        @if($k<1)
                            <li>
                                <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                               style="width: 200px;height: 130px;"/></a>
                            </li>
                        @endif
                    @endforeach
                @endif
                @if($ad123)
                    @foreach($ad123 as $k=>$v)
                        @if($k<1)
                            <li>
                                <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"
                                                                               style="width: 200px;height: 130px;"/></a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
            <div style="position: relative;">
                <div class="dongtai1" style="cursor:pointer;">动态</div>
                <div class="cuxiao1" style="cursor:pointer;margin-left:20px;">促销</div>
                <hr style="position: absolute;top: 35px;left: 17px;border: 1px solid #3cbb2c;width: 23px;"
                    class="banner-right-hr"/>
                <hr style="position: absolute;top: 35px;left: 70px;border: 1px solid #3cbb2c;width: 23px;display: none;"
                    class="banner-right-hr1"/>
            </div>
            <div class="news">
                <div class="news1" style="margin-left: 10px;">
                    <ul>
                        @foreach($art1->article as $k=>$v)
                            <a href="{{route('articleInfo',['id'=>$v->article_id])}}" target="_blank">
                                <li @if($k==0) style="color: red;" @endif>{{str_limit($v->title,28)}}</li>
                            </a>
                        @endforeach
                    </ul>
                </div>
                <div class="news2" style="margin-left: 10px;">
                    <ul>
                        @foreach($art2->article as $k=>$v)
                            <a href="{{route('articleInfo',['id'=>$v->article_id])}}" target="_blank">
                                <li @if($k==0) style="color: red;" @endif>{{str_limit($v->title,28)}}</li>
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="newmore">
                <a href="">更多&gt;&gt;</a>
            </div>
        </div>
    </div>
    <!--产品分类结束-->
    <!------------------------------------------轮播以及产品分类结束------------------------------------------>


    <!------------------------------------------每日精选开始------------------------------------------>
    <div class="meiri" id="demo1">
        <div class="meiri-box">
            <div class="timeout">
                <div id="remainTime"></div>
            </div>
            <div class="meiri-shangpin">
                @if($ad124)
                    @foreach($ad124 as $k=>$v)
                        @if($k<2)
                            @if($k==0)
                                <a target="_blank" href="{{$v->ad_link}}"
                                   style="float:left;margin-left: 5px;margin-top: 10px;overflow: hidden;height: 450px;">
                                    <img src="{{$v->ad_code}}"
                                         style="transition: all .5s linear;width: 295px;height: 450px;"/>
                                </a>
                            @else
                                <a target="_blank" href="{{$v->ad_link}}"
                                   style="float:right;margin-right: 5px;margin-top: 10px;overflow: hidden;height: 450px;">
                                    <img src="{{$v->ad_code}}"
                                         style="transition: all .5s linear;width: 295px;height: 450px;"/>
                                </a>
                            @endif
                        @endif
                    @endforeach
                @endif
                <ul>
                    @if($ad125)
                        @foreach($ad125 as $k=>$v)
                            @if($k<4)
                                <li class="topimg">
                                    <a href="{{$v->ad_link}}" target="_blank">
                                        <img src="{{$v->ad_code}}" style="width: 280px;height: 220px;"/>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>

            </div>
        </div>
    </div>

    <!------------------------------------------每日精选结束------------------------------------------>
    <div class="tuijian" id="demo2">
        <div class="tuijian-box">
            <div>
                <img src="{{path('new/images/tuijian.png')}}"/>
                <div class="picScroll-left">
                    <div class="hd">
                        <a class="prev" href="javascript:void(0)"><img src="{{path('new/images/button-left_12.png')}}"/></a>
                        <a class="next" href="javascript:void(0)"><img
                                    src="{{path('new/images/button-right_12.png')}}"/></a>
                    </div>
                    <div class="bd" style="margin-top: -20px;">
                        <ul class="picList">
                            @if($wntj)
                                @foreach($wntj as $k=>$v)
                                    <li>
                                        <div class="pic1">
                                            <a href="{{route('goods.index',['id'=>$v->goods_id])}}" target="_blank">
                                                <img src="{{$v->goods_thumb}}"/>
                                            </a>
                                        </div>
                                        <div class="title">
                                            <p class="title-first-one">{{$v->goods_name}}</p>
                                            <p class="title-first-two">{{$v->spgg}}</p>
                                            <p class="title-first-second">{{$v->sccj}}</p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--以下是新品上市，产品推荐，用无序列表-->
    <div id="container">
        <div class="container-box">
            <!--新品-->
            <div class="xinpin" id="demo3">

                <img src="{{path('new/images/xinpin.png')}}" style="margin-top: 50px;"/>


                <div class="wrapper1">
                    <div id="focus">
                        <ul>
                            @if($ad126)
                                @foreach($ad126 as $k=>$v)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                </div>

                <ul>
                    @if($ad127)
                        @foreach($ad127 as $k=>$v)
                            @if($k<6)
                                <li>
                                    <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
            @if($ad128)
                @foreach($ad128 as $k=>$v)
                    @if($k<3)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                        </a>
                    @endif
                @endforeach
            @endif
        <!--新品-->

            <!--产品推荐-->
            <div class="chanpintuijian" id="demo4" style="height:610px;">
                <img src="{{path('new/images/chanpintuijian.png')}}" style="margin-top: 20px;"/>
                <div class="wrapper2">
                    <div id="focus1">
                        <ul style="height: 400px;">
                            @if($ad129)
                                @foreach($ad129 as $k=>$v)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>

                <ul>
                    @if($ad130)
                        @foreach($ad130 as $k=>$v)
                            @if($k<6)
                                <li>
                                    <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>

            </div>
            @if($ad131)
                @foreach($ad131 as $k=>$v)
                    @if($k<3)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                        </a>
                    @endif
                @endforeach
            @endif
        <!--产品推荐-->
            <!--当前热销-->
            <div class="chanpintuijian" id="demo5" style="height:610px;">
                <img src="{{path('new/images/dangqianrexiao_03.png')}}" style="margin-top: 20px;"/>
                <div class="wrapper3">
                    <div id="focus2">
                        <ul style="height: 400px;">
                            @if($ad132)
                                @foreach($ad132 as $k=>$v)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>

                <ul>
                    @if($ad134)
                        @foreach($ad134 as $k=>$v)
                            @if($k<6)
                                <li>
                                    <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>

            </div>
            <!--当前热销-->
            @if($ad135)
                @foreach($ad135 as $k=>$v)
                    @if($k<3)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                        </a>
                    @endif
                @endforeach
            @endif

        <!--家用保健-->
            <div class="jiayongbaojian" id="demo6" style="height: 610px;">
                <img src="{{path('new/images/family.png')}}" style="margin-top: 20px;"/>
                <div class="wrapper4">
                    <div id="focus3">
                        <ul style="height: 400px;">
                            @if($ad137)
                                @foreach($ad137 as $k=>$v)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                    <div class="fenleiid">
                        <li>
                            <a href="#" class="fenleili1">
                                分类类目一
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili2">
                                分类类目二
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili1">
                                分类类目三
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili2">
                                分类类目四
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili1">
                                分类类目五
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili2">
                                分类类目六
                            </a>
                        </li>
                    </div>
                </div>

                <ul>
                    @if($ad138)
                        @foreach($ad138 as $k=>$v)
                            @if($k<6)
                                <li>
                                    <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>

            </div>
            @if($ad136)
                @foreach($ad136 as $k=>$v)
                    @if($k<3)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                        </a>
                    @endif
                @endforeach
            @endif
        <!--家用保健-->

            <!--中药饮片-->
            <div class="chanpintuijian" id="demo7" style="height:610px;">
                <img src="{{path('new/images/zhongyao.png')}}" style="margin-top: 20px;"/>
                <div class="wrapper5">
                    <div id="focus4">
                        <ul style="height: 400px;">
                            @if($ad140)
                                @foreach($ad140 as $k=>$v)
                                    <li>
                                        <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                    </li>
                                @endforeach
                            @endif

                        </ul>
                    </div>
                    <div class="fenleiid">
                        <li>
                            <a href="#" class="fenleili1">
                                分类类目一
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili2">
                                分类类目二
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili1">
                                分类类目三
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili2">
                                分类类目四
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili1">
                                分类类目五
                            </a>
                        </li>
                        <li>
                            <a href="#" class="fenleili2">
                                分类类目六
                            </a>
                        </li>
                    </div>
                </div>

                <ul>
                    @if($ad139)
                        @foreach($ad139 as $k=>$v)
                            @if($k<6)
                                <li>
                                    <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>

            </div>
            @if($ad141)
                @foreach($ad141 as $k=>$v)
                    @if($k<3)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}" style="margin-top: 20px;"/>
                        </a>
                @endif
            @endforeach
        @endif
        <!--中药饮片-->

            <!--推荐商家-->
            <div class="changjia" id="demo8">
                <img src="{{path('new/images/changjia.png')}}" style="margin-top: 20px;"/>
                <div class="changjiaxinxi" style="width: 1200px;height:631px;margin-top:10px;background: white;">
                    <div class="main-page">
                        <div class="left">
                            <div class="nav-back"></div>
                            <div class="nav">
                                @if($ad142)
                                    @foreach($ad142 as $k=>$v)
                                        <div @if($k==0)class="on"@endif>
                                            <a href="{{$v->ad_link}}" target="_blank"><img src="{{$v->ad_code}}"/></a>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="right">
                            <div class="content">
                                @if($ad142)
                                    @foreach($ad142 as $key=>$cj)
                                        <div>
                                            <ul class="changjia-img">
                                                @if($cj->goods_list)
                                                    @foreach($cj->goods_list as $k=>$v)
                                                        <li>
                                                            <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}"><img style="width: 200px;height: 200px;"
                                                                 src="{{$v->goods_thumb}}"/></a>
                                                            <div class="changjia-wenzi">
                                                                <p>
                                                                    <span style="color: red;">【{{str_replace('2017','',$cj->ad_name)}}】</span>{{$v->goods_name}}
                                                                </p>
                                                                <p>{{$v->spgg}}</p>
                                                                <p>{{$v->sccj}}</p>
                                                            </div>

                                                        </li>
                                                    @endforeach
                                                @endif
                                            </ul>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>


                </div>

            </div>
            <!--推荐商家-->


            <!--以下是新品上市，产品推荐，用无序列表结束-->
            <!--<hr style="width:99.9%;position: absolute;top: 5805px;border: 1px solid #e5e5e5;"/>-->
            <!--右侧边栏开始-->

            <!--右侧边栏结束-->
            <!-- 浮动导航 -->

            <!--楼层提示-->

            <div id="fixedNavBar">
                <ul>
                    <li>
                        <a href="#demo1">
                            <img src="{{path('new/images/fixnav01_03.png')}}"/>
                        </a>
                        <p style="width: 30px;height: 40px;line-height:20px;margin:4px auto;text-align: center;color: white;">
                            每周精选</p>
                    </li>
                    <li>
                        <a href="#demo2">
                            <img src="{{path('new/images/fixnav07_03.png')}}"/>
                        </a>
                        <p style="width: 30px;height: 40px;line-height:20px;margin:4px auto;text-align: center;color: white;">
                            为您推荐</p>
                    </li>
                    <li>
                        <a href="#demo3">
                            <img src="{{path('new/images/fixnav02_03.png')}}"/>
                        </a>
                        <p style="width: 30px;height: 40px;line-height:20px;margin:4px auto;text-align: center;color: white;">
                            新品上架</p>
                    </li>
                    <li>
                        <a href="#demo4">
                            <img src="{{path('new/images/fixnav03_03.png')}}"/>
                        </a>
                        <p style="width: 30px;height: 40px;line-height:20px;margin:4px auto;text-align: center;color: white;">
                            产品推荐</p>
                    </li>
                    <li>
                        <a href="#demo5">
                            <img src="{{path('new/images/fixnav04_03.png')}}"/>
                        </a>
                        <p style="width: 30px;height: 40px;line-height:20px;margin:4px auto;text-align: center;color: white;">
                            当季热销</p>
                    </li>
                    <li>
                        <a href="#demo6">
                            <img src="{{path('new/images/fixnav05_03.png')}}"/>
                        </a>
                        <p style="width: 30px;height: 40px;line-height:20px;margin:4px auto;text-align: center;color: white;">
                            家用保健</p>
                    </li>
                    <li>
                        <a href="#demo7">
                            <img src="{{path('new/images/fixnav06_03.png')}}"/>
                        </a>
                        <p style="width: 30px;height: 40px;line-height:20px;margin:4px auto;text-align: center;color: white;">
                            中药饮片</p>
                    </li>
                    <li>
                        <a href="#demo8">
                            <img src="{{path('new/images/fixnav08_03.png')}}"/>
                        </a>
                        <p style="width: 30px;height: 40px;line-height:20px;margin:4px auto;text-align: center;color: white;">
                            厂家推荐</p>
                    </li>

                </ul>
            </div>

        </div>
    </div>

    {{--@if(($ad27))--}}
    {{--<!-- 弹出层开始 -->--}}
    {{--<div class="zzsc" style="display: block;z-index: 9999">--}}
    {{--<div class="content_tj"><a href="{{$ad27->ad_link}}" target="_blank"><img--}}
    {{--src="{{get_img_path('data/afficheimg/'.$ad27->ad_code)}}" class="ad"></a>--}}
    {{--<span class="close"><img src="{{path('/images/close.png')}}" alt=""></span>--}}
    {{--</div>--}}
    {{--</div>--}}

    {{--<div class="content_mark" style="display: block;z-index: 9998"></div>--}}
    {{--@endif--}}
    {{--<!-- app扫描开始 -->--}}
    {{--@if(time()<strtotime('20170316')&&time()>=strtotime('20170314'))--}}
    {{--<div class="saoma" style="left: 10px;bottom: 50px">--}}
    {{--<div class="saoma-box">--}}
    {{--<span class="saoma-close" style="top: 0;right: 0;"></span>--}}
    {{--<a target="_blank"--}}
    {{--href="@if(time()>strtotime('20170315')) {{route('category.index',['step'=>'gzbl_promotion'])}} @else {{route('category.index',['step'=>'gzbl_nextpro'])}} @endif">--}}
    {{--<img src="{{get_img_path('images/gzbl.jpg')}}" alt=""></a>--}}
    {{--</div>--}}

    {{--</div>--}}
    {{--@else--}}
    {{--<div class="saoma">--}}
    {{--<div class="saoma-box">--}}
    {{--<span class="saoma-close"></span>--}}
    {{--<a target="_blank" href="javascript:;"> <img src="{{get_img_path('images/app01.png')}}" alt=""></a>--}}
    {{--</div>--}}

    {{--</div>--}}
    {{--@endif--}}


    <!-- app扫描结束 -->
    <!-- 弹出层结束 -->
    @include('common.footer')
    <!--[if lte IE 8]>
    <script src="{{path('new/js/ieBetter.js')}}"></script>
    <![endif]-->
    <script type="text/javascript">
        $(function () {
            var _left = ($(window).width() - 1200) / 2 -75;
            $('#fixedNavBar').css('left', _left);
            $(window).scroll(function () {
                var cy = 40;
                var top1 = $('#demo1').offset().top - cy*5;
                var top2 = $('#demo2').offset().top - cy*2;
                var top3 = $('#demo3').offset().top - cy*3;
                var top4 = $('#demo4').offset().top - cy*4;
                var top5 = $('#demo5').offset().top - cy*5;
                var top6 = $('#demo6').offset().top - cy*6;
                var top7 = $('#demo7').offset().top - cy*7;
                var top8 = $('#demo8').offset().top - cy*8;
                var top9 = parseFloat(top8) + parseFloat($('#demo8').css('height'));
                // 获得窗口滚动上去的距离
                var ling = $('#fixedNavBar').offset().top;
                // 在标题栏显示滚动的距离
                //document.title = ling;
                // 如果滚动距离大于1534的时候让滚动框出来
                console.log(top9,ling)
                if (ling >= top1 && ling < top9) {
                    if (_left < 20) {
                        _left = 20
                    }
                    var hehe = $('#fixedNavBar ul li ');
                    var fixtupian = $('#fixedNavBar ul li a img');
                    $('#fixedNavBar ul').show();
                    if (ling >= top1 && ling < top2) {
                        hehe[0].style.background = '#3dbb2b';
                        fixtupian[0].style.display = 'none';

                    } else {
                        hehe[0].style.background = 'white';
                        fixtupian[0].style.display = 'block';
                    }
                    if (ling >= top2 && ling < top3) {
                        hehe[1].style.background = '#3dbb2b';
                        fixtupian[1].style.display = 'none';
                    } else {
                        hehe[1].style.background = 'white'
                        fixtupian[1].style.display = 'block';
                    }
                    if (ling >= top3 && ling < top4) {
                        hehe[2].style.background = '#3dbb2b';
                        fixtupian[2].style.display = 'none';
                    } else {
                        hehe[2].style.background = 'white'
                        fixtupian[2].style.display = 'block';
                    }
                    if (ling >= top4 && ling < top5) {
                        hehe[3].style.background = '#3dbb2b';
                        fixtupian[3].style.display = 'none';
                    } else {
                        hehe[3].style.background = 'white';
                        fixtupian[3].style.display = 'block';
                    }
                    if (ling >= top5 && ling < top6) {
                        hehe[4].style.background = '#3dbb2b';
                        fixtupian[4].style.display = 'none';
                    } else {
                        hehe[4].style.background = 'white';
                        fixtupian[4].style.display = 'block';
                    }
                    if (ling >= top6 && ling < top7) {
                        hehe[5].style.background = '#3dbb2b';
                        fixtupian[5].style.display = 'none';
                    } else {
                        hehe[5].style.background = 'white';
                        fixtupian[5].style.display = 'block';
                    }
                    if (ling >= top7 && ling < top8) {
                        hehe[6].style.background = '#3dbb2b';
                        fixtupian[6].style.display = 'none';
                    } else {
                        hehe[6].style.background = 'white';
                        fixtupian[6].style.display = 'block';
                    }

                    if (ling >= top8 && ling < top9) {
                        hehe[7].style.background = '#3dbb2b';
                        fixtupian[7].style.display = 'none';
                    } else {
                        hehe[7].style.background = 'white';
                        fixtupian[7].style.display = 'block';
                    }
                }else{
                    $('#fixedNavBar ul').hide();
                }

            })

            $('.dongtai1').click(function () {
                $('.news1 ul').css('display', 'block');
                $('.news2 ul').css('display', 'none');
                $('.banner-right-hr').css('display', 'block');
                $('.banner-right-hr1').css('display', 'none');
                $('.dongtai1').css('color', '#333333');
                $('.cuxiao1').css('color', '#777777');
            });
            $('.cuxiao1').click(function () {
                $('.news2 ul').css('display', 'block');
                $('.news1 ul').css('display', 'none');
                $('.banner-right-hr').css('display', 'none');
                $('.banner-right-hr1').css('display', 'block');
                $('.cuxiao1').css('color', '#333333');
                $('.dongtai1').css('color', '#777777');
            });

            $(".main-page .nav div").mouseenter(function () {
                var $this = $(this);
                var index = $this.index();
            }).mouseleave(function () {
                var $this = $(this);
                var index = $this.index();
            }).hover(function () {
                var $this = $(this);
                var index = $this.index();
                var l = -(index * 930);
                $(".main-page .nav div").removeClass("on");
                $(".main-page .nav div").eq(index).addClass("on");
                $(".main-page .content div:eq(0)").stop().animate({"margin-top": l}, 500);
            });
            jQuery(".picScroll-left").slide({
                titCell: ".hd ul",
                mainCell: ".bd ul",
                autoPage: true,
                effect: "left",
                autoPlay: true,
                vis: 5,
                trigger: "click"
            });

        })
    </script>
    <script type="text/javascript">
//        window.onscroll = function () { //绑定scroll事件
//            var t = document.documentElement.scrollTop || document.body.scrollTop;//获取滚动距离
//            //查询并定义div元素
//            if (400 <= t && t <= 5268) { //判断
//                $('#fixedNavBar').css('display', 'block');
//
//            }
//            else {
//                $('#fixedNavBar').css('display', 'none');
//            }
//
//
//            var hehe = $('#fixedNavBar ul li ');
//            var fixtupian = $('#fixedNavBar ul li a img');
//            if (t >= 400 && t < 1000) {
//                hehe[0].style.background = '#3dbb2b';
//                fixtupian[0].style.display = 'none';
//
//            } else {
//                hehe[0].style.background = 'white';
//                fixtupian[0].style.display = 'block';
//            }
//            if (t >= 1000 && t < 1500) {
//                hehe[1].style.background = '#3dbb2b';
//                fixtupian[1].style.display = 'none';
//            } else {
//                hehe[1].style.background = 'white'
//                fixtupian[1].style.display = 'block';
//            }
//            if (t >= 1500 && t < 2150) {
//                hehe[2].style.background = '#3dbb2b';
//                fixtupian[2].style.display = 'none';
//            } else {
//                hehe[2].style.background = 'white'
//                fixtupian[2].style.display = 'block';
//            }
//            if (t >= 2150 && t < 2800) {
//                hehe[3].style.background = '#3dbb2b';
//                fixtupian[3].style.display = 'none';
//            } else {
//                hehe[3].style.background = 'white';
//                fixtupian[3].style.display = 'block';
//            }
//            if (t >= 2800 && t < 3300) {
//                hehe[4].style.background = '#3dbb2b';
//                fixtupian[4].style.display = 'none';
//            } else {
//                hehe[4].style.background = 'white';
//                fixtupian[4].style.display = 'block';
//            }
//            if (t >= 3300 && t < 3800) {
//                hehe[5].style.background = '#3dbb2b';
//                fixtupian[5].style.display = 'none';
//            } else {
//                hehe[5].style.background = 'white';
//                fixtupian[5].style.display = 'block';
//            }
//            if (t >= 3800 && t < 4553) {
//                hehe[6].style.background = '#3dbb2b';
//                fixtupian[6].style.display = 'none';
//            } else {
//                hehe[6].style.background = 'white';
//                fixtupian[6].style.display = 'block';
//            }
//
//            if (t >= 4553 && t < 5268) {
//                hehe[7].style.background = '#3dbb2b';
//                fixtupian[7].style.display = 'none';
//            } else {
//                hehe[7].style.background = 'white';
//                fixtupian[7].style.display = 'block';
//            }
//
//
//        }
        

    </script>
@endsection

