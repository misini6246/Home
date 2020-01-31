@extends('layouts.app')
@section('title')
    <title>【重庆今瑜e药网】是重庆今瑜医药股份有限公司旗下国家药监局批准的正规药品采购、批发、销售网上药品交易电子商务平台（今瑜e药网），主要经营普药、OTC高毛利、医疗器械、中药饮片；300人的团队为您的采购和销售，保驾护航，为您提供最有价值的医药服务；平台保证您的货款安全和药品质量，服务热线：400-993-7199</title>
    @endsection
@section('content')
    {{-- 11.1头顶banner --}}
    <style>
        .top-img{
            width:100%;
        }
        .top-img:hover{
            transform: none !important;
            transition: none !important;
        }
    </style>
    <a href="/zhuchang"  target="_blank"><img class="top-img" src="/111/index_top.jpg" /></a>
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <script>
        $('.all').removeClass('all-hover');
    </script>
    {{--轮播图--}}
    <div class="banner-box" style="background-color: #{{$ad121[0]->ad_bgc}};">
        <div class="box-container">
            <!--轮播-->
            <div id="carousel" class="carousel">
                <ul class="carousel-list">
                    @foreach($ad121 as $k=>$ad)
                        <li data-bg="#{{$ad->ad_bgc}}" @if($k==0) class="cur" @endif >
                            <a href="{{$ad->ad_link}}" target="_blank">
                                <img class="img-not-hover" src="{{'http://112.74.176.233/'.$ad->ad_code}}"/></a>
                        </li>
                    @endforeach
                </ul>
                <ul class="carousel-nav">
                    @foreach($ad121 as $k=>$ad)
                        <li  @if($k==0) class="cur" @endif></li>
                    @endforeach
                </ul>
                <ul class="carousel-page">
                    <li class="prev">
                        <div class="content">
                            <div class="bg"></div>
                            <i class="com-icon carousel-prev"></i>
                        </div>
                    </li>
                    <li class="next">
                        <div class="content">
                            <div class="bg"></div>
                            <i class="com-icon carousel-next"></i>
                        </div>
                    </li>
                </ul>
            </div>
            <!--/轮播-->

            <!--广告-->
            <div class="yg-box">

                    @foreach($ad123 as $k=>$ad)
                    <div class="img-box">
                            <a href="{{$ad->ad_link}}" target="_blank">
                                <img src="{{$ad->ad_code}}"/></a>
                    </div>
                    @endforeach


                <!--资讯-->
                <div class="message-box">
                    <ul class="title">
                        <li class="cur">公司动态</li>
                        <li>行业资讯</li>
                    </ul>
                    <ul class="list">

                        <li style="display: list-item">
                            @if(isset($art1->article))
                                @foreach($art1->article as $k=>$v)
                                    <a target="_blank"
                                       href="{{route('articleInfo',['id'=>$v->article_id])}}">{{str_limit($v->title,28)}}</a>
                                @endforeach
                            @endif
                        </li>
                        <li style="display: none">
                            @if(isset($art2->article))
                                @foreach($art2->article as $k=>$v)
                                    <a target="_blank"
                                       href="{{route('articleInfo',['id'=>$v->article_id])}}">{{str_limit($v->title,28)}}</a>
                                @endforeach
                            @endif
                        </li>
                    </ul>
                </div>
                <!--/资讯-->
            </div>
            <!--/广告-->
        </div>
    </div>
    {{--每周精选--}}
    <div class="mzjx-box">
        <div class="box-container">
            <div class="more" style="margin-bottom:10px;text-align:right;font-size:18px;font-weight:bold;color:#d43030;">
                <a href="/cxzq#mzjx" target="_blank">查看更多>></a>
            </div>
            <div class="djs-box" data-end_time="{{$ad124->first()->end_time-time()}}">
                <div class="sfm"><span class="d">--</span><span class="h">--</span><span class="m">--</span><span class="s">--</span></div>
            </div>
            <ul class="item-box">
                @foreach($ad124 as $k=>$ad)
                    @if($k<5)
                        <li>
                            <a target="_blank" href="{{$ad->ad_link}}">
                                    <img src="{{get_img_path($ad->ad_code)}}"/>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    {{--每周精选end--}}
    {{--新品上架--}}
    <div class="xpsj-box">
        <div class="box-container">
            <div class="xpsj_content xpsj_left">
                <div class="title">
                    <span>新品上架</span>
                    <span class="en">New shelves</span>
                </div>
                <div class="goods">
                    <!--轮播-->
                    <div id="carousel-1" class="carousel">
                        <ul class="carousel-list">
                            @foreach($ad126 as $k=>$v)
                                <li>
                                    <a href="{{$v->ad_link}}" target="_blank">
                                <img src="{{$v->ad_code}}" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="carousel-nav">
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <!--/轮播-->
                    <div class="goods_item">
                        @foreach($cx_goods[7] as $k=>$v)
                            @if($k<3)
                                <div class="item">
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                    <img class="lazy" src="{{$v->goods_thumb}}"/>
                                    <p class="name" style=" overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$v->goods_name}}</p>
                                    <p class="money login">
                                        @if($v->zyzk>0&&$v->preferential_end_date>time()&&$v->preferential_start_date<time())
                                        <div class="triangle triangle-index">
                                            <a target="_blank" href="{{$v->goods_url}}">
                                                <img class="label" src="/new_cxzq/label.png" alt="">
                                                <span class="text">折扣</span>
                                            </a>
                                        </div>
                                        <span style="font-size: 12px; padding: 0 4px; width: 40px;line-height: 20px;height: 20px;background: #ff5d60;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                            优惠
                                        </span>
                                        @elseif($v->is_promote==1&&$v->promote_end_date>time()&&$v->promote_start_date<time())
                                        <span style="font-size: 12px;  padding: 0 4px;width: 40px;line-height: 20px;height: 20px;background: #418ed2;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                            特价
                                        </span>
                                        @endif
                                        {{$v->format_price}}
                                    </p>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="xpsj_content xpsj_right">
                <div class="title">
                    <span>热门推荐</span>
                    <span class="en">Popular recommendation</span>
                </div>
                <div class="goods">
                    <!--轮播-->
                    <div id="carousel-2" class="carousel">
                        <ul class="carousel-list">
                            @foreach($ad129 as $k=>$v)
                                <li>
                                    <a href="{{$v->ad_link}}" target="_blank">
                                        <img src="{{$v->ad_code}}" />
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="carousel-nav">
                            <li></li>
                            <li></li>
                            <li></li>
                        </ul>
                    </div>
                    <!--/轮播-->
                    <div class="goods_item">
                        @foreach($cx_goods[9] as $k=>$v)
                            @if($k<3)
                                <div class="item">
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                        <img class="lazy" src="{{$v->goods_thumb}}"/>
                                        <p class="name" style=" overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$v->goods_name}}</p>
                                        <p class="money login">
                                            @if($v->zyzk>0&&$v->preferential_end_date>time()&&$v->preferential_start_date<time())
                                            <span style="font-size: 12px; padding: 0 4px; width: 40px;line-height: 20px;height: 20px;background: #ff5d60;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                优惠
                                            </span>
                                            @elseif($v->is_promote==1&&$v->promote_end_date>time()&&$v->promote_start_date<time())
                                            <span style="font-size: 12px;  padding: 0 4px;width: 40px;line-height: 20px;height: 20px;background: #418ed2;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                特价
                                            </span>
                                            @endif
                                            {{$v->format_price}}
                                        </p>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--新品上架end--}}
    {{--中西成药--}}
    <div class="content-box zxcy-box">
        <div class="box-container">
            <div class="content_title" style="border-bottom-color: #1b6fd5;">
                <img class="title-img" src="/index/img/首页-03.png"/>
            </div>
            <div class="content_item">
                <div class="item_img">
                    @foreach($ad208 as $k=>$v)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}">
                        </a>
                    @endforeach
                </div>
                <div class="item_box">
                    @if(isset($cx_goods[18]))
                        @foreach($cx_goods[18] as $k=>$v)
                            @if($k<6)
                                <div class="box" style="border-left: none;">
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                        <img src="{{$v->goods_thumb}}">
                                        <p class="name" style=" overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$v->goods_name}}{{$v->ypgg}}</p>
                                        <p class="price">
                                            @if($v->zyzk>0&&$v->preferential_end_date>time()&&$v->preferential_start_date<time())
                                            <span style="font-size: 12px; padding: 0 4px; width: 40px;line-height: 20px;height: 20px;background: #ff5d60;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                优惠
                                            </span>
                                            @elseif($v->is_promote==1&&$v->promote_end_date>time()&&$v->promote_start_date<time())
                                            <span style="font-size: 12px;  padding: 0 4px;width: 40px;line-height: 20px;height: 20px;background: #418ed2;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                特价
                                            </span>
                                            @endif
                                            {{$v->format_price}}
                                        </p>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{--中西成药end--}}
    {{--广告位--}}
    {{--@foreach($ad207 as $k=>$ad)--}}
        {{--{{dd($ad207)}}--}}

            <img class="gg_x" src="{{$ad207[0]->ad_code}}" style="display: block;margin: 10px auto"/>

    {{--@endforeach--}}
    {{--当季热销--}}
    <div class="content-box djrx-box">
        <div class="box-container">
            <div class="content_title" style="border-bottom-color: #FF2A3E;">
                <img class="title-img" src="/index/img/首页-04.png"/>
            </div>
            <div class="content_item">
                <div class="item_img">
                    @foreach($ad133 as $k=>$v)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}">
                        </a>
                    @endforeach
                </div>
                <div class="item_box">

                    @if(isset($cx_goods[11]))
                        @foreach($cx_goods[11] as $k=>$v)
                            @if($k<6)
                                <div class="box" style="border-left: none;">
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                    <img src="{{$v->goods_thumb}}">
                                    <p class="name" style=" overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$v->goods_name}}{{$v->ypgg}}</p>
                                    <p class="price">
                                            @if($v->zyzk>0&&$v->preferential_end_date>time()&&$v->preferential_start_date<time())
                                            <span style="font-size: 12px; padding: 0 4px; width: 40px;line-height: 20px;height: 20px;background: #ff5d60;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                优惠
                                            </span>
                                            @elseif($v->is_promote==1&&$v->promote_end_date>time()&&$v->promote_start_date<time())
                                            <span style="font-size: 12px;  padding: 0 4px;width: 40px;line-height: 20px;height: 20px;background: #418ed2;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                特价
                                            </span>
                                            @endif
                                        {{$v->format_price}}
                                    </p>
                                    </a>
                                </div>
                                @endif
                        @endforeach
                        @endif
                </div>
            </div>
        </div>
    </div>
    {{--当季热销end--}}
    {{--广告位二--}}
    @if(isset($ad207[1]))

            <img class="gg_x" src="{{$ad207[1]->ad_code}}" style="display: block;margin: 10px auto"/>

    @else

            <img class="gg_x" src="{{$ad207[0]->ad_code}}" style="display: block;margin: 10px auto"/>

    @endif
    {{--中药饮品--}}
    <div class="content-box zyyp-box">
        <div class="box-container">
            <div class="content_title" style="border-bottom-color: #e5a04c;">
                <img class="title-img" src="/index/img/首页-05.png"/>
            </div>
            <div class="content_item">
                <div class="item_img">
                    @foreach($ad140 as $k=>$v)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}">
                        </a>
                    @endforeach
                </div>
                <div class="item_box">
                    @if(isset($cx_goods[13]))
                        @foreach($cx_goods[13] as $v)
                            @if($k<6)
                                <div class="box" style="border-left: none;">
                                    <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                        <img src="{{$v->goods_thumb}}">
                                        <p class="name" style=" overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$v->goods_name}}{{$v->ypgg}}</p>
                                        <p class="price">
                                                @if($v->zyzk>0&&$v->preferential_end_date>time()&&$v->preferential_start_date<time())
                                                <span style="font-size: 12px; padding: 0 4px; width: 40px;line-height: 20px;height: 20px;background: #ff5d60;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                    优惠
                                                </span>
                                                @elseif($v->is_promote==1&&$v->promote_end_date>time()&&$v->promote_start_date<time())
                                                <span style="font-size: 12px;  padding: 0 4px;width: 40px;line-height: 20px;height: 20px;background: #418ed2;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                    特价
                                                </span>
                                                @endif
                                            {{$v->format_price}}
                                        </p>
                                    </a>
                                </div>
                                @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{--中药饮品end--}}
    {{--广告位三--}}
    @if(isset($ad207[2]))
        <img class="gg_x" src="{{$ad207[2]->ad_code}}" style="display: block;margin: 10px auto"/>
        @else
            <img class="gg_x" src="{{$ad207[0]->ad_code}}" style="display: block;margin: 10px auto"/>
    @endif
    {{--家庭保健--}}
    <div class="content-box jtbj-box">
        <div class="box-container">
            <div class="content_title" style="border-bottom-color: #11c3d1;">
                <img class="title-img" src="/index/img/首页-06.png"/>
            </div>
            <div class="content_item">
                <div class="item_img">
                    @foreach($ad137 as $k=>$v)
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}">
                        </a>
                    @endforeach
                </div>
                <div class="item_box">
                    @if(isset($cx_goods[12]))
                        @foreach($cx_goods[12] as $k=>$v)
                            @if($k<6)
                                <div class="box" style="border-left: none;">
                                <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                                    <img src="{{$v->goods_thumb}}">
                                    <p class="name" style=" overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">{{$v->goods_name}}{{$v->ypgg}}</p>
                                    <p class="price">
                                            @if($v->zyzk>0&&$v->preferential_end_date>time()&&$v->preferential_start_date<time())
                                            <span style="font-size: 12px; padding: 0 4px; width: 40px;line-height: 20px;height: 20px;background: #ff5d60;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                优惠
                                            </span>
                                            @elseif($v->is_promote==1&&$v->promote_end_date>time()&&$v->promote_start_date<time())
                                            <span style="font-size: 12px;  padding: 0 4px;width: 40px;line-height: 20px;height: 20px;background: #418ed2;text-align: center;color: #fff;border-radius: 5px;margin-right: 5px;">
                                                特价
                                            </span>
                                            @endif
                                        {{$v->format_price}}
                                    </p>
                                </a>
                                </div>
                                @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('layouts.new_footer')
    {{--电梯导航--}}
    <div class="lift" data-start="0">
        <div class="lift-item cur" data-area=".mzjx-box">每 周 精 选</div>
        <div class="lift-item" data-area=".xpsj-box">新 品 上 架</div>
        <div class="lift-item" data-area=".zxcy-box">中 西 成 药</div>
        <div class="lift-item" data-area=".djrx-box">当 季 热 销</div>
        <div class="lift-item" data-area=".zyyp-box">中 药 饮 片</div>
        <div class="lift-item" data-area=".jtbj-box">家 庭 保 健</div>
        <div class="lift-item btn-top"><img src="/index/img/首页-13.jpg"/></div>
    </div>
    {{--侧边栏--}}
    @include('layouts.youce')
    {{-- @include('hd.111.nav111') --}}
    {{-- 
        刘磊修改于2019年4月24日 15:42 
        修改内容：删除签到的弹窗
    --}}
    {{-- 签到左下角悬浮 --}}
    <div style="display: block;position: fixed;left: 0;bottom: 90px;z-index: 1000;left: 10px;">
        <a target="_blank" href="/jifen/qiandao">
            <img src="/index/img/qiandao_btn.gif" style="width:140px;transform:none">
        </a>
    </div>
    {{-- 提示领券弹出层 --}}
    <style>
            .layui-layer{
                background: none;
                box-shadow: none;
            }
            #yhq-pop img:hover{
                transform: none;
                transition: none;
                cursor: pointer;
            }
        </style>
    <div id="yhq-pop" style="display:none">
        <a href="/yhq" target="_blank">
            <img src="http://www.jyeyw.com/index/img/yhq/yhq.png" alt="">
        </a>
    </div>
    <script type="text/javascript">
        var num_cur_time = get_cur_time();
        var num_end_time = $('.djs-box').attr('data-end_time');
        var bl_fixed_right = false;
        var obj_fixed_click;
        // 优惠券弹窗
        @if($is_show_yhq)
        layer.open({
            type:1,
            title:false,
            area:"660px",
            content:$('#yhq-pop')
        })
        @endif
        //返回顶部
        $('.btn-top').click(function(){
            $('html,body').animate({
                'scrollTop':0
            })
        });

        //电梯导航
        $('.lift').css({
            top:'25%',
            left:$('.nav-box .box-container').offset().left - 40 + 'px'
        });
        $(window).resize(function(){
            $('.lift').css({
                top:'25%',
                left:$('.nav-box .box-container').offset().left - 40 + 'px'
            });
        })
        $(window).scroll(function(){
            var scroll = $('html,body').scrollTop();
            var idx = -1;
            if(scroll>290 && scroll<$('body').height()-800) {
                $('.lift').fadeIn(500);
            }else {
                $('.lift').fadeOut(500);
            }

            if(scroll >= $(".mzjx-box").offset().top-120 && scroll < $(".xpsj-box").offset().top) {
                idx = 0;
            }
            if(scroll >= $(".xpsj-box").offset().top-120&& scroll < $(".zxcy-box").offset().top) {
                idx = 1;
            }
            if(scroll >= $(".zxcy-box").offset().top-120&& scroll < $(".djrx-box").offset().top) {
                idx = 2;
            }
            if(scroll >= $(".djrx-box").offset().top-120&& scroll < $(".zyyp-box").offset().top) {
                idx = 3;
            }
            if(scroll >= $(".zyyp-box").offset().top-120&& scroll < $(".jtbj-box").offset().top) {
                idx = 4;
            }
            if(scroll >= $(".jtbj-box").offset().top-120) {
                idx = 5;
            }
            $('.lift .lift-item').eq(idx < 0 ? 0 : idx).addClass('cur').siblings().removeClass('cur')
        });

       
        /**
         * searchEvent 初始化搜索功能
         * 参数1 获取数据方法
         * 参数2 回调方法
         * 参数3 按钮元素(执行搜索)(可选)
         * 参数4 搜索结果列表显示或隐藏的回调  返回true/false(可选)
         */
        $('.search').searchEvent(
            function(_target, _val) { //获取数据方法 val:搜索框内输入的值
                $.get('/ajax/cart/searchKey',{keyword:_val},function(data){
                    _target.searchDataShow(data, 'value')
                },'json');
                /**
                 * searchDataShow 将数据渲染至页面
                 * 参数1:数据数组
                 * 参数2:数据数组内下标名
                 */
            },
            function(val) { //回调方法 val:返回选中的值
//                alert('搜索关键词"' + val + '"...');
                window.location.href = "http://www.jyeyw.com/category?keywords="+val+"&showi=0";
            },
            $('.search-btn')
        );

        //	轮播
        $('#carousel').carouselEvent({
            auto: true,
            time: 4000
        },function(_idx){
            var bg = $('#carousel .carousel-list li').eq(_idx).attr('data-bg');
			console.log(bg)
			$('.banner-box').css('background-color',bg);
        });
        $('#carousel-1').carouselEvent({
            auto: true,
            time: 4000
        });
        $('#carousel-2').carouselEvent({
            auto: true,
            time: 4000
        });

        //	资讯
        $('.message-box .list li').eq($('.message-box .title li.cur').index()).show();
        $('.message-box .title li').hover(function() {
            $(this).addClass('cur').siblings().removeClass('cur');
            $('.message-box .list li').eq($(this).index()).show().siblings().hide();
        })

        //倒计时
        if((num_end_time - num_cur_time) > 0) start_djs(num_end_time - num_cur_time, $('.djs-box .sfm'), function() {
            $('.djs-box .sfm span').html('--');
        });

        //获取当前时间
        function get_cur_time() {
            var t;
            var myDate = new Date();
            var timestamp = myDate.getTime();
            //		t = timestamp/1000;
            t = 0;
            return Math.floor(t);
        }

        //开始倒计时
        function start_djs(_time, _e, _fun) {
            var t = $.leftTime(_time, function(d) {
                if(d.status) {
                    var $dateShow = _e;
                    $dateShow.find(".d").html(d.d);
                    $dateShow.find(".h").html(d.h);
                    $dateShow.find(".m").html(d.m);
                    $dateShow.find(".s").html(d.s);
                } else { //倒计时结束
                    if(typeof _fun == 'function') _fun();
                }
            }, false);
            return t;
        }
    </script>
@endsection

