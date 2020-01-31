@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/goods_detail.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/new_file.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.jqzoom.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/goods_detail.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.mousewheel.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.jscrollpane.min.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jump.js')}}"></script>
    <style>
        .tanchuc {
            position: fixed;
            top: 50%;
            left: 50%;
            margin: -75px 0 0 -210px;
            background: url("{{get_img_path('images/tip_kuang.png')}}") no-repeat;
            width: 400px;
            height: 120px;
            z-index: 9999;
            padding: 10px;
        }

        .error_img {
            width: 58px;
            height: 58px;
            background: url("{{get_img_path('images/tipsBg_03.png')}}") 0 -64px no-repeat;
            float: left;
            margin: 12px 15px 0 12px;
        }

        .success_img {
            width: 58px;
            height: 58px;
            background: url("{{get_img_path('images/tipsBg_03.png')}}") 0 0 no-repeat;
            float: left;
            margin: 12px 15px 0 12px;
        }

        .renqidp {
            width: 982px;
            height: 260px;
            border: 1px solid #eaeaea;
            border-top: 2px solid #969696;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .renqidp h2 {
            height: 28px;
            line-height: 28px;
            background-color: #f7f7f7;
            text-indent: 25px;
            font-size: 14px;
            color: #6c6b6b;
            border-bottom: 1px solid #eaeaea;
        }

        .renqidp .renqidp-list {
            width: 1000px;
        }

        .renqidp ul li {
            width: 196px;
            height: 260px;
            float: left;
            text-align: center;
        }

        .renqidp ul li .img-p {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            margin-top: 20px;
        }

        .renqidp ul li .img-p img {
            width: 150px;
            height: 150px;
        }

        .renqidp ul li .name {
            line-height: 24px;
            width: 150px;
            margin: 0 auto;
            text-align: center;
        }

        .renqidp ul li .name a {
            color: #545352;
        }

        .renqidp ul li .price span {
            color: #f20000;
            font-weight: bold;
        }

        .scroll-pane {
            height: 660px;
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear" style="margin-bottom: 5px;">
        <div class="top">@include('layout.ur_here')</div>
        <div class="content">
            <form action="javascript:addToCart({{$goods->goods_id}})" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY">
                <!-- 大图begin -->
                <div class="left">
                    <div id="preview" class="spec-preview">
                        <span class="jqzoom"><img jqimg="{{$goods->goods_img}}" src="{{$goods->goods_img}}"/></span>
                    </div>
                    <!-- 大图end -->
                    <!-- 缩略图begin -->
                    <div class="spec-scroll fn_clear"><a class="prev2"></a> <a class="next2"></a>
                        <div class="items">
                            <ul>
                                @foreach($img as $v)
                                    <li><img bimg="{{get_img_path($v->img_url)}}" src="{{get_img_path($v->thumb_url)}}"
                                             onmousemove="preview(this);"></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- 缩略图end -->
                    <div class="share">

                        <div class="bdsharebuttonbox">
                            <a href="#" class="bds_more" data-cmd="more">分享到：</a>
                            <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                            <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                            <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                            <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">
                            </a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                        </div>

                        <div class="right_box">
                            <span class="ico"></span><a
                                    @if($goods->is_can_see==1) href="javascript:collect({{$goods->goods_id}})"
                                    @else href="javascript:addToCart2({{$goods->goods_id}})" @endif>收藏商品</a>
                        </div>
                    </div>

                </div>

                <div class="mid">
                    <div class="mid_top">
                        <h3>&nbsp;{{$goods->goods_name}}</h3>
                        @if(($goods->is_zx==1)&&!empty($goods->cxxx))

                            @if($goods->cxxx)
                                <p>{{$goods->cxxx}}</p>
                            @endif

                        @endif
                        @if(!empty($goods->bzxx))
                            <p>{{$goods->bzxx or ''}}</p>
                        @endif
                        @if(!empty($goods->bzxx2))
                            <p>{{$goods->bzxx2 or ''}}</p>
                        @endif
                        @if(time()<strtotime(20171102)&&in_array($goods->goods_id,[15999,3509]))
                            <p>此商品正在参加预售，<a target="_blank" style="font-size: 14px;color: #e70000"
                                            href="/119ys/">请点击查看</a></p>
                        @endif
                        @if(time()<strtotime(20171103)&&time()>=strtotime(20171102)&&in_array($goods->goods_id,[3045,684]))
                            <p>此商品正在参加预售，<a target="_blank" style="font-size: 14px;color: #e70000"
                                            href="/119ys/">请点击查看</a></p>
                        @endif
                        @if(time()<strtotime(20171104)&&time()>=strtotime(20171103)&&in_array($goods->goods_id,[17937,5041]))
                            <p>此商品正在参加预售，<a target="_blank" style="font-size: 14px;color: #e70000"
                                            href="/119ys/">请点击查看</a></p>
                        @endif
                        @if(time()<strtotime(20171105)&&time()>=strtotime(20171104)&&in_array($goods->goods_id,[3230,16525]))
                            <p>此商品正在参加预售，<a target="_blank" style="font-size: 14px;color: #e70000"
                                            href="/119ys/">请点击查看</a></p>
                        @endif
                        @if(time()<strtotime(20171106)&&time()>=strtotime(20171105)&&in_array($goods->goods_id,[714,3620]))
                            <p>此商品正在参加预售，<a target="_blank" style="font-size: 14px;color: #e70000"
                                            href="/119ys/">请点击查看</a></p>
                        @endif
                    </div>

                    <table>
                        <tr>
                            @if($goods->is_can_see==1)
                                @if($goods->is_cx==1)
                                    <td class="td1">促 销 价：</td>
                                @else
                                    <td class="td1">会 员 价：</td>
                                @endif
                                <td class="td2 price"><span class="prices">{{$goods->real_price_format}}</span></td>
                            @else
                                @if($goods->is_cx==1)
                                    <td class="td1">促 销 价：</td>
                                @else
                                    <td class="td1">会 员 价：</td>
                                @endif
                                <td class="td2 price"><span class="prices">{{$goods->real_price_format}}</span></td>
                            @endif
                            <td class="td1">建议零售价：</td>
                            <td class="td2 price">{{formated_price($goods->market_price)}}</td>
                        </tr>


                        <tr>
                            <td class="td1">生产厂家：</td>
                            <td class="td2">{{$goods->sccj}} </td>
                            @if($goods->ls_gg!=0)
                                <td class="td1">最低购买量：</td>
                                <td class="td2">{{$goods->ls_gg}}</td>
                            @else
                                <td class="td1"></td>
                                <td class="td2"></td>
                            @endif
                        </tr>

                        <tr>
                            <td class="td1">包装单位：</td>
                            <td class="td2">{{$goods->dw}} </td>
                            @if($goods->ls_ggg!=0&&$goods->is_cx==1)
                                <td class="td1">最高购买量：</td>
                                <td class="td2">{{$goods->ls_ggg}}</td>
                            @else
                                <td class="td1"></td>
                                <td class="td2"></td>
                            @endif
                        </tr>

                        <tr>
                            <td class="td1">药品规格：</td>
                            <td class="td2">{{$goods->spgg}} </td>
                            @if($goods->xq)
                                <td class="td1">效期：</td>
                                <td class="td2"
                                    @if($goods->is_xq_red==1) style="color: #e70000" @endif>{{$goods->xq}}</td>
                            @else
                                <td class="td1"></td>
                                <td class="td2"></td>
                            @endif
                        </tr>

                        <tr>
                            <td class="td1">批准文号：</td>
                            <td class="td2">{{$goods->gyzz}} </td>
                            <td class="td1"></td>
                            <td class="td2"></td>
                        </tr>

                        <tr>
                            <td class="td1">@if($goods->is_zyyp)产　　地@else件 装 量@endif：</td>
                            <td class="td2">{{$goods->jzl}} </td>
                            @if(!empty($goods->zbz))
                                <td class="td1">中 包 装：</td>
                                <td class="td2">{{$goods->zbz}}<input type="hidden" value="{{$goods->zbz}}" id="zbz"
                                                                      name="zbz"/></td>
                            @else
                                <td class="td1"></td>
                                <td class="td2"></td>
                            @endif
                        </tr>


                    </table>

                    <div class="num">
                        <span class="title">数　　　量：</span>
                        <a href="javascript:void(0)" class="reduce jianOne"
                           onclick="reduce_num({{$goods->goods_id}})">-</a>
                        <input type="text" name="number" onblur="changePrice({{$goods->goods_id}})"
                               value="@if($goods->ls_gg>0){{$goods->ls_gg}}@else{{$goods->zbz or 1}}@endif"
                               id="J_dgoods_num_{{$goods->goods_id}}" class="num_txt"
                               style="border:1px solid #a7a6ac; width:60px; height:32px; border-right:0; border-left:0; text-align:center; float:left;"
                               data-zbz="{{$goods->zbz or 1}}" data-lsgg="{{$goods->ls_gg}}"
                               data-lsggg="{{$goods->ls_ggg}}" data-xgtype="{{$goods->xg_type}}"
                               data-gn="{{$goods->goods_number}}" data-xgtypeflag="{{$goods->isXg}}">
                        <a href="javascript:void(0)" class="add addOne" onclick="add_num({{$goods->goods_id}})">+</a>
                        <span class="tip">
                        @if($goods->goods_number>800)库存充裕@elseif($goods->goods_number==0)暂时缺货@else库存
                            &nbsp;{{$goods->goods_number}}&nbsp;{{$goods->dw}}@endif
				        </span>
                        <input type="hidden" value="{{$goods->goods_id}}" id="goods_{{$goods->goods_id}}"/>
                        <input type="hidden" value="{{$goods->ls_gg}}" id="lsgg_{{$goods->goods_id}}"/>
                        <input type="hidden" value="{{$goods->is_xg}}" id="yl_{{$goods->goods_id}}"/>
                        <input type="hidden" value="{{$goods->xg_num}}" id="isYl_{{$goods->goods_id}}"/>
                        <input type="hidden" value="{{$goods->goods_number}}" id="gn_{{$goods->goods_id}}"/>
                        <input type="hidden" value="{{$goods->zbz or 1}}" id="zbz_{{$goods->goods_id}}"/>
                        <input type="hidden" value="{{$goods->jzl or 0}}" id="jzl_{{$goods->goods_id}}"/>
                    </div>
                    <div class="add_cart @if($goods->is_can_see==0) no_shopping @endif">
                        <img style="display: none;" class="fly_img{{$goods->goods_id}}"
                             src="{{empty($goods->goods_thumb)? 'no_picture.gif':$goods->goods_thumb}}" alt=""/>
                        @if($goods->xzgm==1&&$goods->is_can_buy==0)
                            <div class="add_btn"
                                 style='width: 280px;height: 110px;font-size: 18px;float: left;text-align: center;line-height: 110px;color: red;'>
                                控销商品，如需购买请联系客服！
                            </div>
                        @else
                            <a href="@if($goods->is_can_see==0) javascript:addToCart2() @else javascript:addToCart({{$goods->goods_id}}) @endif"
                               class="add_btn fly_to_cart{{$goods->goods_id}}">
                                <span class="ico"></span> 加入购物车</a>
                        @endif
                        <div class="add_weixin">
                            <img src="./images/detail_09.png" alt=""/>
                            <p class="saosao">扫一扫</p>
                            <p>进入官方微信</p>
                        </div>
                    </div>
                    <div class="payment">
                        <p>
                            <span class="way">支付方式</span>
                            <span class="box"><span class="ico ico1"></span><a
                                        href="{{route('articleInfo',['id'=>91])}}">在线支付</a></span>
                            <span class="box"><span class="ico ico2"></span><a
                                        href="{{route('articleInfo',['id'=>49])}}">银行汇款</a></span>
                            <a href="{{route('article.index',['id'=>5])}}" class="txt">如何购买？ </a>
                        </p>
                    </div>

                </div>
                <div class="right">
                    <img style="width: 269px;height: 278px;" src="{{get_img_path('images/detail66.png')}}" alt=""/>
                </div>
            </form>
        </div>
        <div class="bottom">
            <div class="left_list">
                <div class="list_top">
                    <h3>推荐厂家</h3>
                    <ul>
                        @foreach(ads(34) as $k=>$v)

                            <li>
                                <a href="{{$v->ad_link}}" target="_blank">
                                    <img src="{{$v->ad_code}}" alt=""/>
                                </a>
                            </li>

                        @endforeach
                    </ul>

                </div>
                <div class="list_next">
                    <h3>一周销量排行榜</h3>
                    <ul>
                        @foreach($weekSales as $k=>$v)
                            <li @if($k==0)class="first"@endif>
                                <a href="{{$v->goods_url}}" class="list">
                                    <span class="com_num red">{{$k+1}}</span>
                                    <span class="name" alt="{{$v->goods_name}}"
                                          title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>

                                    <span class="norms" alt="" title="{{$v->spgg}}">{{str_limit($v->spgg,6)}}</span>

                                </a>
                                <span class="span_hide">
						<span class="com_num red">{{$k+1}}</span>
						<a href="{{$v->goods_url}}"><img src="{{$v->goods_thumb}}" alt="{{$v->goods_name}}"
                                                         title="{{$v->goods_name}}"/></a>
						<span class="title" alt="{{$v->goods_name}}"
                              title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>

						<span class="norms" alt="{{$v->spgg}}" title="{{$v->spgg}}">{{str_limit($v->spgg,6)}}</span>

					</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>
            <div class="right_list" style="border: none">
                @if(count($goods_related)>=4)
                    <div class="renqidp">
                        <h2>猜你喜欢</h2>
                        <ul class="renqidp-list">
                            @foreach($goods_related as $v)
                                <li>
                                    <p class="img-p"><a href="{{$v->goods_url}}"><img src="{{$v->goods_thumb}}" alt=""/></a>
                                    </p>
                                    <p class="name"><a href="{{$v->goods_url}}">{{str_limit($v->goods_name,13)}}</a></p>
                                    <p class="price"><span>
                                        {{$v->real_price_format}}
                                        </span></p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div style="border: 1px solid #ddd;">
                    <div class="title_list">
                        <ul>
                            <li class="li_1 on">商品详情</li>
                            <li class="li_2">药品说明书</li>
                            <li class="li_3">售后保障</li>
                        </ul>
                        <div class="f_right">
                            <!--<span class="text">下载客户端，特价随时抢 </span>
                            <img src="./images/detail_64.png" alt=""/>
                            <span class="ico"></span>-->
                        </div>


                    </div>
                    <ul class="ul_list ul_1" style="display: block;">
                        {{--<li>产品参数：</li>--}}
                        {{--<li>品牌名称：{{$goods->brand->brand_name or ''}}</li>--}}


                        <li>生产厂家：{{$goods->sccj}}</li>
                        <li>包装单位：{{$goods->dw}}</li>
                        <li>药品规格：{{$goods->spgg}}</li>
                        <li>批准文号：{{$goods->gyzz}}</li>
                        <li>@if($goods->is_zyyp)产　　地@else件 装 量@endif：{{$goods->jzl}}</li>

                        <li>{!! $goods->goods_desc !!}</li>
                    </ul>
                    <ul class="ul_list ul_2">
                        <li>{!! $goods->goods_sms !!}</li>
                    </ul>
                    <ul class="content_7">
                        <div class="scroll-pane">
                            <img src="{{get_img_path('images/shouhou-1.jpg')}}"/>
                            <img src="{{get_img_path('images/shouhou-2.jpg')}}"/>
                            <img src="{{get_img_path('images/shouhou-3.jpg')}}"/>
                        </div>
                    </ul>
                </div>
            </div>

        </div>
    </div>
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
    @include('common.footer')
    <script type="text/javascript">
        $(function () {

            var bars = '.jspHorizontalBar, .jspVerticalBar';

            $('.scroll-pane').bind('jsp-initialised', function (event, isScrollable) {

                //hide the scroll bar on first load
                $(this).find(bars).hide();

            }).jScrollPane().hover(
                //hide show scrollbar
                function () {
                    $(this).find(bars).stop().fadeTo('fast', 0.9);
                },
                function () {
                    $(this).find(bars).stop().fadeTo('fast', 0);
                }
            );
            $('.li_3').click(function () {
                $('.ul_list').hide();
            })
        });
        function add_num(id) {
            var gn = parseInt($('#gn_' + id).val());
            var yl = parseInt($('#yl_' + id).val());
            var isYl = parseInt($('#isYl_' + id).val());
            var lsgg = parseInt($('#lsgg_' + id).val());
            var zbz = parseInt($('#zbz_' + id).val());
            var jzl = parseInt($('#jzl_' + id).val());
            var num = parseInt($('#J_dgoods_num_' + id).val());
            //console.log(gn,yl,isYl,lsgg,zbz,jzl,num);
            num = num + zbz;
            if (jzl) {//件装量存在
                if ((num % jzl) / jzl >= 0.8) {//购买数量达到件装量80%
                    alert('温馨提示：你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。')
                    num = Math.ceil(num / jzl) * jzl;
                }
            }

            if (num % zbz != 0) {//不为中包装整数倍
                num = num - num % zbz + zbz;
            }

            if (isYl > 0 && num > isYl && yl > 0) {//商品限购
                var tcc_str =
                    '<div class="tanchuc" id="shopping_box">' +
                    '<div class="content_buy"><a href="javascript:;" class="error_img"></a>' +
                    '<h4 class="tip_text">最大限购数量：' + isYl + '</h4>' +
                    '<p class="tip_txt" alt="" title=""></p>' +
                    '<p class="login_p tab_p4">' +
                    '<a href="javascript:;" onclick="hide_tcc()" class="login_a confirm again">确认</a>' +
                    '</p>' +
                    '<span class="close2" onclick="hide_tcc()"></span>' +
                    '</div>' +
                    '</div>';
                add_tanchuc(tcc_str);
                num = isYl;
            }

            if (num > gn) {
                var tcc_str =
                    '<div class="tanchuc" id="shopping_box">' +
                    '<div class="content_buy"><a href="javascript:;" class="error_img"></a>' +
                    '<h4 class="tip_text">库存不足</h4>' +
                    '<p class="tip_txt" alt="" title=""></p>' +
                    '<p class="login_p tab_p4">' +
                    '<a href="javascript:;" onclick="hide_tcc()" class="login_a confirm again">确认</a>' +
                    '</p>' +
                    '<span class="close2" onclick="hide_tcc()"></span>' +
                    '</div>' +
                    '</div>';
                add_tanchuc(tcc_str);
                return false;
            }
            $('#J_dgoods_num_' + id).val(num);
        }

        function reduce_num(id) {
            var gn = parseInt($('#gn_' + id).val());
            var yl = parseInt($('#yl_' + id).val());
            var isYl = parseInt($('#isYl_' + id).val());
            var lsgg = parseInt($('#lsgg_' + id).val());
            var zbz = parseInt($('#zbz_' + id).val());
            var jzl = parseInt($('#jzl_' + id).val());
            var num = parseInt($('#J_dgoods_num_' + id).val());
            num = num - zbz;
            if (jzl) {//件装量存在
                if ((num % jzl) / jzl >= 0.8 && (num % jzl) / jzl <= 1) {//购买数量达到件装量80%
                    num = num - num % jzl + parseInt(jzl * 0.8);
                }
            }

            if (num % zbz != 0) {//不为中包装整数倍
                num = num - num % zbz;
            }

            if (isYl > 0 && num > isYl && yl > 0) {//商品限购
                var tcc_str =
                    '<div class="tanchuc" id="shopping_box">' +
                    '<div class="content_buy"><a href="javascript:;" class="error_img"></a>' +
                    '<h4 class="tip_text">最大限购数量：' + isYl + '</h4>' +
                    '<p class="tip_txt" alt="" title=""></p>' +
                    '<p class="login_p tab_p4">' +
                    '<a href="javascript:;" onclick="hide_tcc()" class="login_a confirm again">确认</a>' +
                    '</p>' +
                    '<span class="close2" onclick="hide_tcc()"></span>' +
                    '</div>' +
                    '</div>';
                add_tanchuc(tcc_str);
                num = isYl;
            }

            if (num < 1) {
                num = zbz;
            }
            $('#J_dgoods_num_' + id).val(num);
        }

        function changePrice(id) {
            var gn = parseInt($('#gn_' + id).val());
            var yl = parseInt($('#yl_' + id).val());
            var isYl = parseInt($('#isYl_' + id).val());
            var lsgg = parseInt($('#lsgg_' + id).val());
            var zbz = parseInt($('#zbz_' + id).val());
            var jzl = parseInt($('#jzl_' + id).val());
            var num = parseInt($('#J_dgoods_num_' + id).val());
            if (num < 0) {
                alert('请输入正确的数量');
                $('#J_dgoods_num_' + id).val(0 - zbz);
                return false;
            }
            var old = num;

            if (num % zbz != 0) {//不为中包装整数倍
                num = num - num % zbz + zbz;
            }

            if (jzl) {//件装量存在
                if ((num % jzl) / jzl >= 0.8 && (num % jzl) / jzl <= 1) {//购买数量达到件装量80%
                    alert('温馨提示：你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。')
                    num = Math.ceil(num / jzl) * jzl;
//                if(num>gn){
//                    alert('库存不足');
//                    num = old - old%jzl + parseInt(jzl*0.8) - zbz;
//                }
                }
            }

            if (isYl > 0 && num > isYl && yl > 0) {//商品限购
                var tcc_str =
                    '<div class="tanchuc" id="shopping_box">' +
                    '<div class="content_buy"><a href="javascript:;" class="error_img"></a>' +
                    '<h4 class="tip_text">最大限购数量：' + isYl + '</h4>' +
                    '<p class="tip_txt" alt="" title=""></p>' +
                    '<p class="login_p tab_p4">' +
                    '<a href="javascript:;" onclick="hide_tcc()" class="login_a confirm again">确认</a>' +
                    '</p>' +
                    '<span class="close2" onclick="hide_tcc()"></span>' +
                    '</div>' +
                    '</div>';
                add_tanchuc(tcc_str);
                num = isYl;
            }

            if (num > gn) {
                var tcc_str =
                    '<div class="tanchuc" id="shopping_box">' +
                    '<div class="content_buy"><a href="javascript:;" class="error_img"></a>' +
                    '<h4 class="tip_text">库存不足</h4>' +
                    '<p class="tip_txt" alt="" title=""></p>' +
                    '<p class="login_p tab_p4">' +
                    '<a href="javascript:;" onclick="hide_tcc()" class="login_a confirm again">确认</a>' +
                    '</p>' +
                    '<span class="close2" onclick="hide_tcc()"></span>' +
                    '</div>' +
                    '</div>';
                add_tanchuc(tcc_str);
                $('#J_dgoods_num_' + id).val(zbz);
                return false;
            }
            $('#J_dgoods_num_' + id).val(num);
        }
        function hide_tcc() {
            $('#tanchuc').remove();
        }
    </script>
@endsection

