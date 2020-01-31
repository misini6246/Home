@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/goods_list.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/zhongyyp.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/zhongyyp-detail.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/attach_left.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/new_file.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>

    <script type="text/javascript" src="{{path('/js/jquery.jqzoom.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/goods_detail.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.mousewheel.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.jscrollpane.min.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/wntj-zy.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <script type="text/javascript">
        $(function () {
            $('#container').highcharts({
                title: {
                    text: '此商品近期价格记录',
                    x: -20 //center
                },

                xAxis: {
                    categories: [{!! $goods_attribute->old_time or '' !!}]
                },
                yAxis: {
                    title: {
                        text: '商品价格'
                    },
                    plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                tooltip: {
                    valueSuffix: '元'
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
                },
                series: [{

                    name: '价格',
                    data: [{{$goods_attribute->old_price or ''}}]

                }]
            });
        });
    </script>
    <div class="site-content-box " style="margin-bottom: -1px;">
        <div class="zhongyyp-box fn_clear">
            <div class="mianbaoxue">
                <span class="dangqian">当前位置：</span>
                <a href="{{route('zy.index')}}">中药饮片专区</a> >
                <a href="#">{{$goods->goods_name}}</a>
            </div>
            <form action="javascript:addToCart({{$goods->goods_id}})" method="post" name="ECS_FORMBUY" id="ECS_FORMBUY">
                <div class="site-detail-box">

                    <div class="detail-left">

                        <div id="preview" class="spec-preview">
                            <span class="jqzoom"><img class="fly_img{{$goods->goods_id}}" jqimg="{{$goods->goods_img}}" src="{{$goods->goods_img}}"/></span>
                        </div>
                        <div class="spec-scroll fn_clear"><a class="prev2"></a> <a class="next2"></a>
                            <div class="items">
                                <ul>
                                    @foreach($img as $v)
                                        <li><img bimg="{{get_img_path($v->img_url)}}"
                                                 src="{{get_img_path($v->thumb_url)}}" onmousemove="preview(this);">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="share">
                            @if($goods->is_cx==1)
                                <div class="xianshith">
                                    <img src="./images/zyyp/zhyp066.png" alt=""/>
                                </div>
                                <div class="detail-bg"></div>
                            @endif

                            <div class="detail-txt">
                                <p>{{$goods->keywords}}</p>
                            </div>

                            <div class="chengluo">
                                {!! $goods_attribute->spms or '' !!}
                            </div>
                            <div class="bdsharebuttonbox">
                                <a href="#" class="bds_more" data-cmd="more">分享到：</a>
                                <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                                <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                                <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                                <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网">
                                </a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                            </div>
                            <div class="collect-shopping">
                                <span class="ico"></span><a href="javascript:collect({{$goods->goods_id}})">收藏商品</a>
                            </div>
                        </div>

                    </div>
                    <div class="detail-mid">
                        <div class="mid-txt">
                            <h3>{{$goods->goods_name}}</h3>
                            <p>
                                {{$goods->goods_brief}}
                            </p>
                            @if($goods_attribute&&$goods->is_zx==1)
                                <p style="color: #e70000">{{$goods_attribute->cxxx}}</p>
                            @endif
                            @if(($goods->is_zx==1)&&!empty($goods->cxxx))

                                @if($goods->cxxx)
                                    <p style="color: #e70000">{{$goods->cxxx}}</p>
                                @endif

                            @endif
                        </div>

                        <table class="goods-xinxi">
                            <tr>

                                <td class="xinxi-td1">药易购价格 ： <span class="price"
                                                                    style="color:#e70000;font-size:18px;">{{$goods->real_price_format}}</span>
                                </td>
                                <!--
                                <td class="xinxi-td2">市场价： <span class="price" style="color:#e70000;"> {$goods.market_price}</span></td>
                                -->
                                <td class="xinxi-td3">建议零售价： <span class="price"
                                                                   style="color:#e70000;"> {{formated_price($goods->market_price)}}</span>
                                </td>
                            </tr>
                            <tr>
                                <td class="xinxi-td1">品名：{{$goods->goods_name}}   </td>
                                @if($goods->zbz)
                                    <td colspan="2"> 中包装：{{$goods->zbz}}   </td>@endif
                            </tr>
                            <tr>
                                <td class="xinxi-td1">别名：{{$goods_attribute->bm or ''}} </td>
                                <td colspan="2"> 包装规格：{{$goods_attribute->zf or ''}}</td>
                            </tr>
                            <tr>
                                <td class="xinxi-td1">规格：{{$goods_attribute->ypgg or ''}}      </td>
                                <td colspan="2"> 生产标准： {{$goods_attribute->scbz or ''}} </td>
                            </tr>
                            <tr>
                                <td class="xinxi-td1">单位： {{$goods_attribute->bzdw or ''}}</td>
                                <td colspan="2"> 生产厂家： {{$goods_attribute->sccj or ''}}</td>
                            </tr>
                            <tr>
                                <td class="xinxi-td1">原产地： {{$goods_attribute->jzl or ''}}</td>
                                <td colspan="2">批号： {{$goods_attribute->pzwh or ''}}</td>
                            </tr>
                            <tr>
                                <td class="xinxi-td1">有效期至：{{$goods->xq}}</td>
                                <td colspan="2"> 销售限制：{{$goods_attribute->xsxz or ''}} </td>
                            </tr>
                            <tr>

                                <td colspan="3"> 商品属性：{{$goods_attribute->cat_ids or ''}}</td>
                            </tr>


                        </table>
                        <div class="num">
                            <div class="num-txt-box">
                                <span class="shuliang">数　　　量：</span>
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
        					@if($goods->goods_number>800)库存充裕@elseif($goods->goods_number==0)暂时缺货@else
                                        库存{{$goods->goods_number}}{{$goods_attribute->bzdw or ''}}
                                        ，{{$goods_attribute->zf or ''}}@endif
                            								</span>
                                <input type="hidden" value="{{$goods->goods_id}}" id="goods_{{$goods->goods_id}}"/>
                                <input type="hidden" value="{{$goods->ls_gg}}" id="lsgg_{{$goods->goods_id}}"/>
                                <input type="hidden" value="{{$goods->yl['yl']}}" id="yl_{{$goods->goods_id}}"/>
                                <input type="hidden" value="{{$goods->yl['isYl']}}" id="isYl_{{$goods->goods_id}}"/>
                                <input type="hidden" value="{{$goods->goods_number}}" id="gn_{{$goods->goods_id}}"/>
                                <input type="hidden" value="{{$goods->zbz or 1}}" id="zbz_{{$goods->goods_id}}"/>
                                <input type="hidden" value="{{$goods->jzl or 0}}" id="jzl_{{$goods->goods_id}}"/>
                            </div>


                            <a href="@if($goods->is_can_see==0) javascript:addToCart2() @else javascript:addToCart({{$goods->goods_id}}) @endif"
                               class="add_btn fly_to_cart{{$goods->goods_id}}"></a>

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
                        <ul class="wechat fn_clear" style="
    width: 640px;
    padding: 0;
    border-top: 1px solid #eee;
    padding-top: 40px;">
                            <li>
                                <a><img src="{{get_img_path('images/dingyuehao.jpg')}}" alt="二维码"></a>
                                <div class="wechat_box">
                                    <h4>药易购官方订阅号</h4>
                                    <p>全面为您提供最新资讯</p>
                                </div>
                            </li>
                            <li>
                                <a><img src="{{path('images/bottom2.png')}}" alt="二维码"></a>
                                <div class="wechat_box">
                                    <h4>药易购官方服务号</h4>
                                    <p>万千优惠资讯抢先收到</p>
                                </div>
                            </li>
                        </ul>

                    </div>
                    <div class="detail-right">
                        <img src="./images/zyyp/zhyp064.jpg" alt=""/>
                    </div>

                </div>
            </form>

            @include('layout.zy_zs')
            <div class="bottom-right-box">
                <div class="renqidp">
                    <h2>人气单品</h2>
                    <ul class="renqidp-list">
                        @foreach($rqdp as $v)
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

                <div class="bottom-right-tab">


                    <div class="title_list">
                        <ul>
                            <li class="li_1 on">商品详情</li>
                            <li class="li_2">药品说明书</li>
                            <li class="li_3 ">售后保障</li>
                        </ul>
                    </div>
                    <ul class="ul-list ul_1" style="display: block;">
                        <li>
                            @if($goods_attribute)
                                @if($goods_attribute->old_ten_price&&$goods->is_can_see)
                                    <div id="container" class="dongtaixx" style="width: 984px;height: 400px;"></div>
                                @endif
                            @endif
                            {!! $goods->goods_desc !!}
                        </li>
                    </ul>
                    <ul class="ul-list ul_2" style="display: none;">
                        <li>{!! $goods->goods_sms !!}</li>

                    </ul>

                    <ul class="content_7" style="width: 982px;">
                        <div class="scroll-pane" style="height: 2108px;">
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

            if (isYl > 0 && num > isYl && yl == 1) {//商品限购
                num = isYl;
            }

            if (num > gn) {
                alert('库存不足');
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

            if (isYl > 0 && num > isYl && yl == 1) {//商品限购
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

            if (isYl > 0 && num > isYl && yl == 1) {//商品限购
                num = isYl;
            }

            if (num > gn) {
                alert('库存不足');
                $('#J_dgoods_num_' + id).val(zbz);
                return false;
            }
            $('#J_dgoods_num_' + id).val(num);
        }
    </script>
    <script type="text/javascript" src="{{path('/js/highcharts.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/exporting.js')}}"></script>
@endsection

