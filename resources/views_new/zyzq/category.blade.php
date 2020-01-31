@extends('layouts.app')

@section('title')
    <title>中药专区-分类</title>
    @endsection

@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />

    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/base.css" />
    <link rel="stylesheet" type="text/css" href="/index/css/index/index.css" />
    <link rel="stylesheet" type="text/css" href="/new_zyzq/zyzq.css" />
    <link rel="stylesheet" type="text/css" href="/new_zyzq/goods_list.css" />
    <link rel="stylesheet" type="text/css" href="/new_zyzq/zhongyyp.css" />
    <link rel="stylesheet" type="text/css" href="/new_zyzq/zhongyyp-list.css" />

    <script src="/new_gwc/gwc-js/transport_jquery.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/new_gwc/gwc-js/tanchuc.js" type="text/javascript" charset="utf-8"></script>
    <script src="/new_zyzq/goods_list.js" type="text/javascript" charset="utf-8"></script>

    <!--加减插件-->
    <script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
    <script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>


    <!--layer-->
    <link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css" />
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/lazyload.js" type="text/javascript" charset="utf-8"></script>
    <style type="text/css">
        .listPageDiv {
            height: 50px;
            line-height: 50px;
            text-align: right;
            margin-top: 10px;
            float: right;
            width: 82%;
            color: #333333;
            font-family: "Microsoft YaHei"
        }

        .pageList {
            width: 600px;
            float: left;
        }

        .listPageDiv .p1 {
            border: 1px #CCC solid;
            padding: 4px 9px;
            margin: 3px;
            background-color: #efefef;
        }

        .listPageDiv .p_ok {
            color: #39a817;
            border: 0;
            background-color: #fff;
        }

        .listPageDiv a {
            color: #666;
        }

        .listPageDiv a:hover {
            text-decoration: underline;
            color: #39a817;
        }

        .listPageDiv .no {
            background-color: #fff;
        }

        .listPageDiv .no a {
            color: #cccccc;
        }

        .listPageDiv .page_inout {
            width: 24px;
            height: 24px;
            border: 1px solid #ccc;
            margin: 0 5px;
            line-height: 24px;
            text-align: center;
        }

        .listPageDiv .submit {
            cursor: pointer;
            width: 45px;
            height: 24px;
            line-height: 20px;
            background-color: #efefef;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .listPageDiv .submit_input {
            padding-left: 10px;
            width: 180px;
            float: right;
            _margin-top: 10px;
        }

        .nav-item li a {
            font-size: 16px;
        }
    </style>
    @endsection
@section('content')

    <div class="big-container">
        <!--头部-->
        @include('layouts.header')
        <!--/头部-->

        <!--搜索导航-->
        @include('layouts.search')
        <!--/搜索导航-->

        <!--导航-->
       @include('layouts.nav')
        <!--/导航-->

        @include('layouts.youce')

        <div class="site-content-box ">
            <div class="zhongyyp-box fn_clear">
                @include('zyzq.layouts.zy_zs')


                <div class="zhongyyp-list-right ">
                    <div class="shuaixuan-box">
                        <div class="r_top">
                            <img src="{{path('images/zyyp/zhyp054.jpg')}}" alt=""/>
                        </div>
                        @if($select_arr)
                            <div class="g_csize fn_clear">
                                <div class="g_hdiv">所选分类 :</div>
                                <div class="g_listdiv g_fsdiv">
                                    @foreach($select_arr as $v)
                                        <a class="g_select_cate" href="{{$v['url']}}"><h5>{{$v['tip']}}
                                                :</h5>&nbsp;{{$v['text']}}<span class="g_close_icon"></span></a>
                                    @endforeach
                                </div>
                                <div class="clear"></div>
                            </div>
                        @endif

                        <div class="dosage-selection fn_clear">
                            <div class="ul_list1" style="display: block;">
                                <span class="title_name">中药饮片分类：</span>
                                <ul>
                                    @foreach(cate_tree(445) as $k=>$v)
                                        @if($k<4)
                                            <li @if($phaid==$v->cat_id)class="on_click"@endif ><a
                                                        href="{{build_url('zyzq.category',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a>
                                            </li>@endif
                                    @endforeach
                                </ul>
                                <span class="open_zy">更多<em class="up_ico"></em></span>
                            </div>
                            <div class="ul_list1 ul_list2 fn_clear" style="display: none;">
                                <span class="title_name">中药饮片分类： </span>
                                <ul class="fn_clear">
                                    @foreach(cate_tree(445) as $k=>$v)
                                        <li @if($phaid==$v->cat_id)class="on_click"@endif ><a
                                                    href="{{build_url('zyzq.category',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <span class="close_zy">收起 <em class="up_ico"></em></span>
                            </div>

                            <div class="ul_list1" style="display: block;">
                                <span class="title_name">中药功能分类：</span>
                                <ul>
                                    @foreach(cate_tree(446) as $k=>$v)
                                        @if($k<10)
                                            <li @if($phaid==$v->cat_id)class="on_click"@endif ><a
                                                        href="{{build_url('zyzq.category',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a>
                                            </li>@endif
                                    @endforeach

                                </ul>
                                <span class="open_zy">更多<em class="up_ico"></em></span>
                            </div>
                            {{--<div class="ul_list1 ul_list2 fn_clear" style="display: none;">--}}
                                {{--<span class="title_name">中药功能分类： </span>--}}
                                {{--<ul class="fn_clear">--}}
                                    {{--@foreach(cate_tree(446) as $k=>$v)--}}
                                        {{--<li @if($phaid==$v->cat_id)class="on_click"@endif ><a--}}
                                                    {{--href="{{build_url('zyzq.category',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}

                                {{--</ul>--}}
                                {{--<span class="close_zy">收起 <em class="up_ico"></em></span>--}}
                            {{--</div>--}}

                            {{--<div class="ul_list1" style="display: block;">--}}
                                {{--<span class="title_name">中药来源属性： </span>--}}
                                {{--<ul>--}}
                                    {{--@foreach(cate_tree(447) as $k=>$v)--}}
                                        {{--@if($k<13)--}}
                                            {{--<li @if($phaid==$v->cat_id)class="on_click"@endif ><a--}}
                                                        {{--href="{{build_url('zyzq.category',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a>--}}
                                            {{--</li>@endif--}}
                                    {{--@endforeach--}}

                                {{--</ul>--}}
                                {{--<span class="open_zy">更多<em class="up_ico"></em></span>--}}
                            {{--</div>--}}
                            {{--<div class="ul_list1 ul_list2 fn_clear" style="display: none;">--}}
                                {{--<span class="title_name">中药来源属性：  </span>--}}
                                {{--<ul class="fn_clear">--}}
                                    {{--@foreach(cate_tree(447) as $k=>$v)--}}
                                        {{--<li @if($phaid==$v->cat_id)class="on_click"@endif ><a--}}
                                                    {{--href="{{build_url('zyzq.category',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}

                                {{--</ul>--}}
                                {{--<span class="close_zy">收起 <em class="up_ico"></em></span>--}}
                            {{--</div>--}}

                            {{--<div class="ul_list1" style="display: block;">--}}
                                {{--<span class="title_name">生产厂家： </span>--}}
                                {{--<ul>--}}
                                    {{--@foreach($sccj as $k=>$v)--}}
                                        {{--@if($k<4)--}}
                                            {{--<li @if($product_name_here==$v)class="on_click"@endif ><a--}}
                                                        {{--href="{{build_url('zyzq.category',['pid'=>$phaid,'product_name'=>$v,'zm'=>$zmhere])}}">{{$v}}</a>--}}
                                            {{--</li>@endif--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                                {{--<span class="open_zy">更多<em class="up_ico"></em></span>--}}
                            {{--</div>--}}
                            {{--<div class="ul_list1 ul_list2 fn_clear" style="display: none;">--}}
                                {{--<span class="title_name">生产厂家： </span>--}}
                                {{--<ul class="fn_clear">--}}
                                    {{--@foreach($sccj as $k=>$v)--}}
                                        {{--<li @if($product_name_here==$v)class="on_click"@endif ><a--}}
                                                    {{--href="{{build_url('zyzq.category',['pid'=>$phaid,'product_name'=>$v,'zm'=>$zmhere])}}">{{$v}}</a>--}}
                                        {{--</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                                {{--<span class="close_zy">收起 <em class="up_ico"></em></span>--}}
                            {{--</div>--}}

                            <div class="initial-a">
                                <span class="title_name">首字母： </span>
                                @foreach($zm as $v)
                                    <a @if($zmhere==$v)class="checked_a"
                                       @endif href="{{build_url('zyzq.category',['pid'=>$phaid,'product_name'=>$product_name_here,'zm'=>$v])}}">{{$v}}</a>
                                @endforeach
                            </div>

                        </div>

                    </div>
                    @if(count($result)>0)
                        <div class="zhongyyp-goods-list">
                            <ul class="fn_clear">
                                @foreach($result as $v)
                                    <li>
                                        <div class="shoucang">
                                            <a href="javascript:collect({{$v->goods_id}})"><img
                                                        src="{{path('images/zyyp/zhyp063.png')}}" alt=""/></a>
                                        </div>
                                        @if($v->is_hot==1)
                                            <div class="hot">
                                                <img src="{{path('images/zyyp/zhyp062.png')}}" alt=""/>
                                            </div>
                                        @endif
                                        <a href="{{$v->goods_url}}">
                                            <img class="fly_img{{$v->goods_id}}" src="{{$v->goods_thumb}}" alt=""/>
                                        </a>
                                        <div class="title">{{str_limit($v->goods_name,13)}}</div>
                                        <p>{{str_limit($v->sccj,25)}}</p>
                                        <p>规格：{{$v->spgg}}</p>
                                        <p><span class="chandi">产地：{{$v->jzl}}&nbsp;&nbsp;</span></p>
                                        <p>库存：@if($v->goods_number>800)充裕@elseif($v->goods_number==0)
                                                缺货@else{{$v->goods_number}}@endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </p>
                                        <p>包装规格：{{$v->zf}} </p>
                                        <p>价格： <em>{{$v->real_price_format}}</em></p>
                                        <div class="btn">
                                            <input id="J_dgoods_num_{{$v->goods_id}}" class="num ls_num" name="number"
                                                   type="text"
                                                   value="@if($v->ls_gg>0){{$v->ls_gg}}@elseif($v->zbz ==0) 1 @else{{$v->zbz}}@endif"
                                                   defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                   onblur="changePrice({{$v->goods_id}})" data-gn="{{$v->goods_number}}"
                                                   data-zbz="@if($v->zbz == 0 ) 1 @else{{$v->zbz}} @endif" data-lsgg="{{$v->ls_gg}}"
                                                   data-lsggg="{{$v->ls_ggg}}" data-xgtype="{{$v->xg_type}}"
                                                   data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>
                                            <p>
                                                <span class="add" onclick="add_num({{$v->goods_id}})"></span>
                                                <span class="reduce" onclick="reduce_num({{$v->goods_id}})"></span>
                                            </p>
                                            <input type="hidden" value="{{$v->goods_id}}" id="goods_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->ls_gg}}" id="lsgg_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->yl['yl']}}" id="yl_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->yl['isYl']}}" id="isYl_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->goods_number}}" id="gn_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->zbz or 1}}" id="zbz_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->jzl or 0}}" id="jzl_{{$v->goods_id}}"/>
                                            <a @if($v->is_can_see==1)onclick="tocart('{{$v->goods_id}}','{{$v->product_id}}')"
                                               @else onclick="tocart('{{$v->goods_id}}','{{$v->product_id}}')"
                                               @endif id="dsssss_{{$v->goods_id}}"
                                               class="fly_to_cart{{$v->goods_id}}"><em></em>加入购物车</a>
                                        </div>
                                    </li>
                                @endforeach
                                @if(in_array($keywords,['燕窝','石斛','冬虫夏草','鹿鞭','鹿茸']))
                                    <li>
                                        @if($keywords=='燕窝')
                                            <a href="javascript:;">
                                                <img src="/new_zyzq/img/yanwo.jpg" alt=""/>
                                            </a>
                                        @elseif($keywords=='石斛')
                                            <a href="javascript:;">
                                                <img src="/new_zyzq/img/shixie.jpg" alt=""/>
                                            </a>
                                        @elseif($keywords=='冬虫夏草')
                                            <a href="javascript:;">
                                                <img src="/new_zyzq/img/dongcxc.jpg"
                                                     alt=""/>
                                            </a>
                                        @elseif($keywords=='鹿鞭')
                                            <a href="javascript:;">
                                                <img src="/new_zyzq/img/lubian.jpg"
                                                     alt=""/>
                                            </a>
                                        @elseif($keywords=='鹿茸')
                                            <a href="javascript:;">
                                                <img src="/new_zyzq/img/lurong.jpg"
                                                     alt=""/>
                                            </a>
                                        @endif
                                        <div class="title">{{$keywords}}</div>
                                        <p></p>
                                        <p>更多规格</p>
                                        <p></p>
                                        <p>联系：81151421</p>
                                        <p></p>
                                        <p>QQ：2131868497</p>
                                    </li>
                                @endif
                            </ul>


                        </div>
                        @if($result->lastPage()>0)
                            {!! pagesView($result->currentPage(),$result->lastPage(),3,3,[
                            'url'=>'zyzq.category',
                            'pid'=>$phaid,
                            'keywords'=>$keywords,
                            'zm'=>$zmhere,
                            'product_name'=>$product_name_here,
                            'order'=>$order,
                            'step'=>$step,
                            ]) !!}
                        @endif
                </div>
                @elseif(in_array($keywords,['燕窝','石斛','冬虫夏草','鹿鞭','鹿茸']))
                    <div class="zhongyyp-goods-list">
                        <ul class="fn_clear">
                            @if(in_array($keywords,['燕窝','石斛','冬虫夏草','鹿鞭','鹿茸']))
                                <li>
                                    @if($keywords=='燕窝')
                                        <a href="javascript:;">
                                            <img src="/new_zyzq/img/yanwo.jpg" alt=""/>
                                        </a>
                                    @elseif($keywords=='石斛')
                                        <a href="javascript:;">
                                            <img src="/new_zyzq/img/shixie.jpg" alt=""/>
                                        </a>
                                    @elseif($keywords=='冬虫夏草')
                                        <a href="javascript:;">
                                            <img src="/new_zyzq/img/dongcxc.jpg"
                                                 alt=""/>
                                        </a>
                                    @elseif($keywords=='鹿鞭')
                                        <a href="javascript:;">
                                            <img src="/new_zyzq/img/lubian.jpg"
                                                 alt=""/>
                                        </a>
                                    @elseif($keywords=='鹿茸')
                                        <a href="javascript:;">
                                            <img src="/new_zyzq/img/lurong.jpg"
                                                 alt=""/>
                                        </a>
                                    @endif
                                    <div class="title">{{$keywords}}</div>
                                    <p></p>
                                    <p>更多规格</p>
                                    <p></p>
                                    <p>联系：81151421</p>
                                    <p></p>
                                    <p>QQ：2131868497</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                @else
                    <div class="g_right_bottom" style="text-align: center">
                        <div class="img_box">
                            <img src="/index/img/search_none.jpg"/>
                        </div>
                        <p>抱歉, 没有找到相关的药品,</p>
                        <p><a href="/requirement" target="_blank">点击这里提交求购意向，{{config('services.web.name')}}网会尽快补货！</a></p>
                    </div>
                    <div class="g_right_bottom_bottom">
                        <p>没有找到你想要的药品？ <a href="/requirement" target="_blank">点击这里提交求购意向，{{config('services.web.name')}}
                                网会尽快补货！</a></p>
                    </div>
                @endif
            </div>

        </div>
    @if(!auth()->check())
        <!-- 加入购物车弹出层begin -->
            <div class="comfirm_buy" style="display:none;" id="shopping_box">
                <div class="content_buy"><a href="#" class="success"></a>
                    <h4>&nbsp;</h4>
                    <p class="tip_txt" alt="" title="">&nbsp;</p>

                    <p class="login_p tab_p1" style="display: none;">
                        <a class="login_a again">继续购物</a> <a href="/cart">去结算 ></a>
                    </p>

                    <p class="login_p tab_p2" style="display: none;">
                        <a href="/auth/login" class="login_a">登录</a> <a href="/auth/register">注册</a>
                    </p>

                    <p class="login_p tab_p3" style="display: none;">
                        <a href="requirement.php" class="login_a">去登记</a> <a class="login_a again">取消</a>
                    </p>

                    <p class="login_p tab_p4" style="display: none;">
                        <a class="login_a confirm again">确认</a>
                    </p>

                    <p class="login_p tab_p5" style="display: none;">
                        <a href="#" class="login_a confirm">确认</a>
                    </p>

                    <span class="close2"></span>
                </div>
            </div>
            <!-- 加入购物车弹出层end -->
    @else
        <!-- 收藏弹出层部分begin -->
            <div class="comfirm_buy" style="display:none;" id="collect_box">
                <div class="content_buy"><a href="#" class="success"></a>
                    <h4>&nbsp;</h4>
                    <p class="collect_p">
                        <span class="collect_text"> 共收藏 <span class="num">0</span>  件商品</span>
                        <a href="{{route('user.collectList')}}" class="click_me">查看我的收藏 &gt;</a>
                    </p>

                    <p class="login_p login_p2" style="display:none;">
                        <a href="/auth/login" class="login_a">登录</a> <a href="/auth/register">注册</a>
                    </p>
                    <span class="close2"></span>
                </div>
            </div>
            <!-- 弹出层部分end -->
    @endif
        <!--footer-->
        @include('layouts.new_footer')
        <!--/footer-->
    </div>

    <script type="text/javascript">
        $('.menu_list li').hover(function() {
            index = $(this).index();
            $(this).addClass('active');
            $(this).prev().find('.text').css('border-bottom', 'none')
        }, function() {
            $(this).removeClass('active');
            $(this).prev().find('.text').css('border-bottom', '1px dashed #b2d1c1')
        })

        $(".open_zy").click(function() {

            $(this).parents(".ul_list1").hide();

            $(this).parents(".ul_list1").next(".ul_list2").show();

            $(this).parents(".ul_list1").next(".ul_list2").find(".up_ico").css("background-position", "-75px -31px")

        });

        $(".close_zy").click(function() {

            $(this).parents(".ul_list2").hide();

            $(this).parents(".ul_list2").prev(".ul_list1").show();

            $(this).parents(".ul_list2").prev(".ul_list1").find(".up_ico").css("background-position", "-50px 0")

        })

        $(".zhongyyp-goods-list ul li").hover(function() {
            $(this).addClass("zhongyy-list-hover");
        }, function() {
            $(this).removeClass("zhongyy-list-hover");
        })

        $('.animate').hover(function() {
            $(this).find('.animate-box').css('right', '100px').show().animate({
                right: "33px"
            })
        }, function() {
            $(this).find('.animate-box').css('right', '100px').hide()
        });
        var _obj;

        function show_yc(view, _object) {
            var _this = $('.youce-box');
            var right = $('#fixed-right').css('margin-right');
            if(right == '270px' && _obj == view) {
                hide_yc(_object);
            } else {
                $.ajax({
                    url: '/' + $('#web-prefix').val() + '/sync',
                    type: 'get',
                    dataType: 'json',
                    data: {
                        views: [view]
                    },
                    statusCode: {
                        401: function() {
                            location.href = '/auth/login';
                        }
                    },
                    success: function(data) {
                        for(var i in data) {
                            _this.html(data[i])
                        }
                        $('#fixed-right').animate({
                            marginRight: "270px"
                        });
                        _obj = view;
                        _object.addClass('active').siblings().removeClass('active');
                    }
                })
            }
        }

        function hide_yc(_object) {
            $('#fixed-right').animate({
                marginRight: "0px"
            })
            _object.removeClass('active');
        }

        function to_top() {
            $('body,html').animate({
                'scrollTop': 0
            })
        }

        function tocart_nofly(goods_id, product_id, num) {
            var count = parseInt($('#youce-cart-count').text());
            $.ajax({
                url: '/' + $('#web-prefix').val() + '/cart',
                data: {
                    goods_id: goods_id,
                    product_id: product_id,
                    num: num
                },
                dataType: 'json',
                statusCode: {
                    200: function(data) {
                        layer.msg(data.message, {
                            icon: 0
                        })
                    },
                    201: function(result) {
                        count++;
                        $('.cart_number').text(count);
                        layer.confirm(result.message, {
                            btn: ['继续购物', '去结算'], //按钮
                            icon: 1
                        }, function(index) {
                            layer.close(index);
                        }, function() {
                            location.href = '/' + $('#web-prefix').val() + '/cart';
                            return false;
                        });
                    }
                }
            })
        }


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

        function get_other() {
            $.ajax({
                url: '/zdtjp',
                type: 'get',
                dataType: 'json',
                success: function(msg) {
                    if(msg) {
                        var html = "";
                        for(var i = 0; i < msg.length; i++) {
                            html += "<li>";
                            html += "<div style='text-align:center'>";
                            html += "<a href='" + msg[i]['goods_url'] + "'><img src='" + msg[i]['goods_thumb'] + "' alt=''/></a>";
                            html += "<p>  <a href='" + msg[i]['goods_url'] + "'>" + msg[i]['goods_name'] + "</a></p>";
                            html += "<p><a>" + msg[i]['spgg'] + "</a></p>";
                            html += "<p class='price'><span class='linshoujia'>" + msg[i]['real_price_format'] + "</span></p>";
                            html += "</div>";
                            html += "</li>";
                        }
                        $(".zhongdiantj-list").html(html);
                    }
                }
            })
        }
    </script>
    @endsection

