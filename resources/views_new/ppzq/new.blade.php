@extends('layout.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/ppzq.css')}}4"/>
    <!--IE兼容-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 7]>
    <script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div class="fixed_nav">
        <div class="box">
            <div class="menu">
                <ul>
                    <a class="cur" href="#header_box" class="smooth">
                        <li>品牌 一区</li>
                    </a>
                    <a href="#header_box" class="smooth">
                        <li>品牌 二区</li>
                    </a>
                    <a href="#header_box" class="smooth">
                        <li>品牌 三区</li>
                    </a>
                    <a href="#body" class="smooth">
                        <li></li>
                    </a>
                </ul>
            </div>
        </div>
    </div>
    <div class="ppzq_container" style="background: #f5f5f5;">
        <!--banner开始-->
        <div id="banner_tabs" class="flexslider">
            <ul class="slides">
                @foreach($ad119 as $v)
                    <li>
                        <a target="_blank" href="{{$v->ad_link}}">
                            <img width="1920" height="480" alt=""
                                 style="background: url('{{$v->ad_code}}') no-repeat center;">
                        </a>
                    </li>
                @endforeach
            </ul>
            {{--<ul class="flex-direction-nav">--}}
            {{--<li><a class="flex-prev" href="javascript:;">Previous</a></li>--}}
            {{--<li><a class="flex-next" href="javascript:;">Next</a></li>--}}
            {{--</ul>--}}
            <ol id="bannerCtrl" class="flex-control-nav flex-control-paging">
                @foreach($ad119 as $k=>$v)
                    <li @if($k==0) class="active" @endif><a>{{$k+1}}</a></li>
                @endforeach
            </ol>
        </div>
        <!--banner结束-->
        <!--标题开始-->
        <div id="header_box" class="header_box">
            <img src="{{get_img_path('adimages1/201807/erji/ppzq_title.png')}}"/>
        </div>
        <!--标题结束-->
        <div class="classify">
            <div class="title">全部品牌：</div>
            <ul class="goods">
                @foreach($ppzq as $k=>$v)
                    <li>
                        <a href="#{{$v->rec_id}}" data-id="{{$k}}" class="smooth" id="link{{$v->rec_id}}"
                           onclick="change_page('{{intval($k/14)}}')">{{$v->ppzq_name}}</a>
                    </li>
                @endforeach
            </ul>
            <div class="more">
                <img width="52" height="24" src="{{get_img_path('adimages1/201807/erji/ppzq1.jpg')}}"/>
            </div>
        </div>
        <!--列表开始-->
        <div class="list">
            @foreach($ppzq as $k=>$v)
                <div class="item page{{intval($k/14)}}" id="{{$v->rec_id}}">
                    <a target="_blank"
                       href="@if(!empty($v->url)) {{$v->url}} @else {{route('category.index',['step'=>$v->rec_id,'style'=>'g'])}} @endif"
                       class="logo">
                        <img src="{{$v->img}}"/>
                    </a>
                    <div class="name">{{$v->ppzq_name}}</div>
                    <div class="number">共有<span>{{count($v->goods)}}</span>个品种</div>
                    <div class="activity">{!! $v->description !!}</div>
                    <a target="_blank"
                       href="@if(!empty($v->url)) {{$v->url}} @else {{route('category.index',['step'=>$v->rec_id,'style'=>'g'])}} @endif">
                        <div class="btn"></div>
                    </a>
                    <div class="product">
                        @foreach($v->child as $k=>$child)
                            @if($k<3)
                                <a target="_blank" href="{{$child->goods_url}}">
                                    <div @if($k==0) style="margin-left: 20px;" @endif>
                                        <img width="180" height="180" src="{{$child->goods_thumb}}"/>
                                        <span>{{str_limit($child->goods_name,28)}}
                                            <span style="color: #ef2c2f;">{{$child->real_price_format}}</span>
                                        </span>
                                    </div>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <div id="clear" style="clear: both"></div>
        <div class="bottom-page">
            <a href="#header_box" class="smooth cur">第一页</a>
            <a href="#header_box" class="smooth">第二页</a>
            <a href="#header_box" class="smooth">第三页</a>
        </div>
    </div>
    @include('layouts.old_footer')
    <script src="{{path('js/new/ppzq.js')}}" type="text/javascript" charset="utf-8"></script>
    <script>
        $(function () {
            var hash = location.hash;
            if (hash != '') {
                console.log(hash);
                $('#link' + hash.replace('#', '')).click();
                var wz = $(hash).offset().top;
                $("html,body").animate({scrollTop: wz}, 500);
            }
            $(window).scroll(function (event) {
                var h1 = $('.fixed_nav').offset().top;
                var h2 = $('.header_box').offset().top;
                var h3 = $('#clear').offset().top;
                if (h1 < h2) {
                    $('.menu').fadeOut();
                } else if (h1 + 200 > h3) {
                    $('.menu').fadeOut();
                } else {
                    $('.menu').fadeIn();
                }
            });
            var off = false;
            //设置基数索引列表盒子间距
            if (IEVersion() == 7 || IEVersion() == 8) {
                $('.list .item:odd').css({
                    'margin-left': '20px',
                    'margin-bottom': '20px'
                })
            }
            $('.bottom-page a').click(function () {
                $(this).addClass('cur').siblings().removeClass('cur');
                change_page($(this).index());
            });

            $('.fixed_nav .box .menu ul a').click(function () {
                if ($(this).index() != $('.fixed_nav .box .menu ul a').length - 1) {
                    $(this).addClass('cur').siblings().removeClass('cur');
                    change_page($(this).index());
                }
            });

            //导航
            $('.classify .goods li').each(function () {
                if (($(this).offset().left - 40) == $('.classify .goods li').eq(0).offset().left) {
                    $(this).css('margin-left', '0px')
                }
            });

            $('.classify .more').click(function () {
                if (!off) {
                    $(this).find('img').attr('src', "{{get_img_path('adimages1/201807/erji/ppzq2.jpg')}}")
                    $('.classify').css('height', '100%')
                    off = true;
                } else {
                    $(this).find('img').attr('src', "{{get_img_path('adimages1/201807/erji/ppzq1.jpg')}}")
                    $('.classify').css('height', '60px')
                    off = false;
                }
            })
            $(".smooth").click(function () {
                var href = $(this).attr("href");
                var pos = $(href).offset().top;
                $("html,body").animate({scrollTop: pos}, 500);
                return false;
            });
        });

        function change_page(id) {
            $('.item').hide();
            $('.page' + id).show();
            $('.fixed_nav .box .menu ul a').eq(id).addClass('cur').siblings().removeClass('cur');
            $('.bottom-page a').eq(id).addClass('cur').siblings().removeClass('cur');
        }
    </script>
@endsection
