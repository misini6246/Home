@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('new/css/index.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/cart.css')}}" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/flow_cart.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/slides.jquery.js')}}"></script>
    <style>
        a {
            color: #666666;
        }

        .min, .add {
            width: 20px;
            height: 20px;
            text-align: center;
            border: 1px solid #ccc;
            background-color: #fff;
            cursor: pointer;
            display: block;
            float: left;
        }

        .min {
            border-right: 0;
            margin-left: 28px;
            _margin-left: 14px;
        }

        .add {
            border-left: 0;
        }

        .com_text {
            width: 40px;
            text-align: center;
            border: 1px solid #ccc;
            height: 18px;
            float: left;
            padding-top: 2px;
        }

        .gwc_tb2 .info-box td {
        }

        .gwc_tb2 tr.td-tip td {
            height: 26px;
            line-height: 26px;
            padding: 0;
            border: 0;
        }

        .tb1_td1 {
            width: 20px;
            padding-left: 5px;
        }

        .tb1_td2 {
            width: 35px;
        }

        .tb1_td3 {
            width: 35px;
        }

        .tb1_td4 {
            width: 240px;
            text-indent: 60px;
        }

        .tb1_td5 {
            width: 160px;
            text-indent: 60px;
        }

        .tb1_td6 {
            width: 120px;
            text-indent: 30px;
        }

        .tb1_td7 {
            width: 80px;
            text-indent: 12px;
        }

        .tb1_td8 {
            width: 80px;
            text-indent: 18px;
        }

        .tb1_td9 {
            width: 80px;
            text-indent: 15px;
        }

        .tb1_td10 {
            width: 80px;
            text-indent: 20px;
        }

        .tb1_td11 {
            width: 100px;
            text-indent: 40px;
        }

        .tb1_td12 {
            width: 90px;
            text-indent: 30px;
        }

        .tb1_td13 {
            text-indent: 20px;
        }

        .gwc_tb2 {
            width: 100%;
            border: 1px solid #e5e5e5;
            color: #666666;
            margin-bottom: 20px;
        }

        .gwc_tb2 tr td {
            border-top: 1px solid #e5e5e5;
            position: relative;
            padding: 10px 0;
        }

        .tb2_td1 {
            width: 40px;
        }

        .tb2_td1 input {
            margin-left: 10px;
        }

        .tb2_td2 {
            width: 60px;
            text-align: center;
        }

        .tb2_td3 {
            width: 240px;
            overflow: hidden;
            padding-left: 10px;
        }

        .tb2_td3 a {
            position: relative;
            display: block;
            float: left;
            width: 50px;
            height: 50px;
        }

        .tb2_td3 span {
            display: block;
            float: left;
            width: 160px;
            overflow: hidden;
            margin-top: 15px;
            text-indent: 5px;
        }

        .tb2_td3 img {
            width: 50px;
            height: 50px;
        }

        .tb2_td3 .mz {
            width: 190px;
            float: left;
            overflow: hidden;
            margin-top: 30px;
            color: #fe7200;
        }

        .tb2_td4 {
            width: 150px;
            overflow: hidden;
            padding-left: 0px;
        }

        .tb2_td4 p {
            line-height: 22px;
        }

        .tb2_td4 p.important {
            color: #f20000;
        }

        .tb2_td5 {
            width: 120px;
            text-align: center;
        }

        .tb2_td6 {
            width: 70px;
            text-align: center;
        }

        .tb2_td7 {
            width: 80px;
            text-align: center;
        }

        .tb2_td8 {
            width: 80px;
            text-align: center;
        }

        .tb2_td9 {
            width: 80px;
            text-align: center;
        }

        .tb2_td10 {
            width: 112px;
            text-align: center;
        }

        .tb2_td11 {
            width: 90px;
            text-align: center;
        }

        .tb2_td12 {
            text-align: center;
        }

        .tb2_td12 a:hover {
            color: #f60
        }

        .gwc_tb3 {
            width: 100%;
            border: 1px solid #e7e7e7;
            background: #f5f5f5;
            height: 86px;
            margin: 20px 0 20px 0;
            color: #666666;
        }

        .gwc_tb3 tr td {
            border-right: 1px solid #f5f5f5;
        }

        .zengpin {
            /*border: 1px solid red;*/
            height: 29px;
            line-height: 29px;
            overflow: hidden;
        }

        .zengpin span {
            /*display: inline-block;*/
            /*border: 1px solid red;*/
            text-align: center;
            float: left;
            border-top: 1px solid transparent;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: middle;
            color: #666;
        }

        .zengpin .biaoshi {
            width: 29px;
            margin-left: 10px;
            height: 14px;
            line-height: 14px;
            text-align: center;
            border: 1px solid #fb9c31;
            background: #ffebd4;
            color: #fb9c31;
            border-radius: 3px;
            margin: 8px 5px 0 112px;
        }

        .zengpin .name {
            width: 184px;
            text-align: left;
            padding-left: 9px;
        }

        .zengpin .changjia {
            width: 150px;
            text-align: left;
            *text-align: center;
        }

        .zengpin .guige {
            width: 120px;
            *width: 140px;
        }

        .zengpin .jianzhuang {
            width: 70px;
        }

        .zengpin .xiaoqi,
        .zengpin .kucun,
        .zengpin .danjia {
            width: 80px;
        }

        .zengpin .shuliang {
            width: 100px;
            margin-left: 18px;
        }

        .zengpin .xiaoji {
            width: 80px;
        }

        .zengpin .caozuo {
            width: 79px;
            *width: 59px;
            text-indent: 5px;
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    @include('layout.page_header_cart')
    <div class="content">
        <div class="content_top">
            <div class="left"><span class="title">我的购物车</span>@if(!Auth::check())现在<a href="/auth/login">登录</a>
                ，您购物车内的商品将被永久保存 @endif
            </div>
            {{--<span style="color: red;float: right;">提示：3.8日当天累计采购金额每满1000送券1张，活动结束后统一返到账户。</span>--}}
            {{--<div class="right"> 全川满 <span class="text">800</span> 元即可免运费</div>--}}
        </div>

        @if(count($goods_list)>0)
            <div class="gwc">
                <table cellpadding="0" cellspacing="0" class="gwc_tb1">
                    <tr>
                        <td class="tb1_td1"><input id="Checkbox1" type="checkbox" class="allselect"/></td>
                        <td class="tb1_td2">全选</td>
                        <td class="tb1_td3">标识</td>
                        <td class="tb1_td4">商品名称</td>
                        <td class="tb1_td5">生产厂家</td>
                        <td class="tb1_td6">药品规格</td>
                        <td class="tb1_td7">件装量</td>
                        <td class="tb1_td8">效期</td>
                        <td class="tb1_td9">库存</td>
                        <td class="tb1_td10">单价</td>
                        <td class="tb1_td11">数量</td>
                        <td class="tb1_td12">小计</td>
                        <td class="tb1_td13">操作</td>
                    </tr>
                </table>
                <table cellpadding="0" cellspacing="0" class="gwc_tb2">
                    @foreach($goods_list as $v)
                        <tr data-id="{{$v->rec_id}}" class="info-box xuanzhongzt tr{{$v->rec_id}}"
                            data-goods_price="{{$v->goods_price}}" data-jp="{{$v->goods->is_jp}}"
                            data-goods_number="{{$v->goods_number}}">
                            <td class="tb2_td1"><input type="checkbox" value="1" name="newslist" id="newslist-0"
                                                       @if($v->is_checked==1)checked="checked" @else disabled="disabled"
                                                       @endif is_checked="{{$v->is_checked}}"></td>
                            <td class="tb2_td2" style="color: rgb(243, 16, 16);">
                                @if($v->goods->is_cx)
                                    特
                                @endif
                                @if($v->goods->zyzk>0)
                                    惠
                                @endif
                                @if($v->goods->is_jp)
                                    精
                                @endif
                                @if($v->goods->tsbz=='预')
                                    预
                                @endif
                                @if($v->goods->tsbz=='秒')
                                    秒
                                @endif
                            </td>
                            <td class="tb2_td3">
                                <a href="{{$v->goods->goods_url}}" target="_blank"><img src="{{$v->goods->goods_thumb}}"
                                                                                        title="{{$v->goods->goods_name}}"></a>
                                <span>{{$v->goods->goods_name}}</span>
                            </td>
                            <td class="tb2_td4">
                                {{$v->goods->sccj}}
                            </td>
                            <td class="tb2_td5">{{str_limit($v->goods->spgg,16)}}</td>
                            <td class="tb2_td6">{{str_limit($v->goods->jzl,5)}}</td>
                            <td class="tb2_td7"
                                @if($v->goods->is_xq_red==1) style="color:#e70000;" @endif>{{$v->goods->xq}}</td>
                            @if($v->goods->zbz)

                                <input type="hidden" value="{$goods_sx.value}" id="goods_num_show1_{{$v->rec_id}}"/>
                            @endif
                            <td class="tb2_td8">
                                @if($v->is_can_change==0&&$v->is_checked==1)
                                    库存充裕
                                @elseif($v->goods->goods_number>=800)
                                    库存充裕
                                @elseif($v->goods->goods_number==0)
                                    <span style="color: red;">暂时缺货</span>
                                @else
                                    库存{{$v->goods->goods_number}}
                                    {{$v->goods->dw or ''}}
                                @endif
                            </td>
                            <td class="tb2_td9">{{formated_price($v->goods->real_price)}}</td>
                            <td class="tb2_td10">
                                <a class="min"
                                   @if($v->is_can_change==1)onclick="reduce_num({{$v->rec_id}})"@endif >-</a>
                                <input class="com_text" type="text" value="{{$v->goods_number}}"
                                       data-value="{{$v->goods_number}}" data-lsgg="{{$v->goods->ls_gg}}"
                                       data-g="{{$v->goods_id}}"
                                       @if($v->is_can_change==1)onblur="changePrice_ls({{$v->rec_id}})" @else disabled
                                       @endif id="goods_num_show_{{$v->rec_id}}">
                                <a class="add" @if($v->is_can_change==1)onclick="add_num({{$v->rec_id}})"@endif>+</a>
                            </td>
                            <td class="tb2_td11"
                                id="subtotal_{{$v->rec_id}}">{{formated_price($v->goods_number*$v->goods->real_price)}}</td>
                            <td class="tb2_td12">
                                <p><a class="del">删除</a></p>
                                @if(Auth::check())
                                    <p><a class="collect">移到收藏</a></p>
                                @endif

                            </td>
                        </tr>
                        @include('layout.zp_goods')
                    @endforeach
                </table>

                <!--提示信息   2015-8-26  start     -->
                <div class="tip_box">
                    <div class="title"><img src="{{get_img_path('images/cart009.jpg')}}" alt=""/></div>
                    @if(count($tip_info)>0)
                        <div class="table_box">

                            <div style="border-radius: 5px !important; width: 1150px;margin: 0px auto 5px auto;border: 1px solid #e2e2e2;color: #666666;">
                                <table>
                                    @foreach($tip_info as $k=>$v)
                                        <tr>
                                            <td class="tip_box_td1" alt="{{$v->goods->goods_name}}"
                                                title="{{$v->goods->goods_name}}">{{$k+1}}
                                                )、{{str_limit($v->goods->goods_name,20)}}</td>
                                            <td class="tip_box_td2" alt="" title="">
                                                生产厂家：{{str_limit($v->goods->sccj,12)}}</td>
                                            <td class="tip_box_td3">药品规格：{{str_limit($v->goods->spgg,16)}}</td>
                                            <td class="tip_box_td4">
                                                <div class="td_img"><img src="{{get_img_path('images/cart0010.jpg')}}"
                                                                         alt=""/>{{$v->message}}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>

                        </div>
                    @endif
                </div>
                <!--提示信息    end    -->

                <table cellpadding="0" cellspacing="0" class="gwc_tb3">
                    <tr>
                        <td class="tb3_td1" style="width:160px;">
                            <p><span class="select"><input id="Checkbox2" type="checkbox" class="allselect"
                                                           checked="checked">全选</span></p>
                            <p style="margin-top:5px;*margin-top:15px;"><a href="javascript:void(0);"
                                                                           id="del_checked"><span
                                            class="ico del_all"></span>删除选中商品</a></p>
                            <p style="margin-top:5px;*margin-top:15px;"><a href="{{route('cart.del_no_num')}}"
                                                                           onclick="return confirm('确定删除无库存商品吗')"><span
                                            class="ico del_all"></span>删除无库存和下架商品</a></p>

                            <!--<a href="javascript:void(0);" id="clear_all"><span class="ico clear_all" ></span>清空购物车</a>-->
                        </td>
                        <td></td>
                        <td class="tb3_td2">已选商品 <label id="shuliang">{{count($goods_list)}}</label> 件</td>
                        <td class="tb3_td3">精品专区合计:<span style=" color:#f31010;"></span><span
                                    style=" color:#f31010;"><label id="zong2"
                                                                   style="color:#f31010;font-size:22px;">{{formated_price($total['jp_total_amount'])}}</label></span>
                        </td>
                        <td class="tb3_td4">合计(不含运费):<span style=" color:#f31010;"></span><span style=" color:#f31010;"><label
                                        id="zong1"
                                        style="color:#f31010;font-size:22px;">{{formated_price($total['shopping_money'])}}</label></span>
                        </td>
                        <td class="tb3_td5" id="jiesuan">
                            @if(count($goods_list)==0)
                                <span>结算</span>
                            @else
                                <a href="{{route('cart.jiesuan')}}" class="jz2" id="jz2">结算</a>
                            @endif
                        </td>
                        <td style="color:#EF0000;display: none;line-height:82px;" class="submit_txt">正在转向订单信息填写页面，请稍候！
                        </td>
                    </tr>
                </table>
            </div>
        @else
        <!--提示信息   2015-8-26  start     -->
            @if(count($tip_info)>0)
                <div class="tip_box">
                    <div class="title"><img src="{{get_img_path('images/cart009.jpg')}}" alt=""/></div>

                    <div class="table_box">

                        <div style="border-radius: 5px !important; width: 1150px;margin: 0px auto 5px auto;border: 1px solid #e2e2e2;color: #666666;">
                            <table>
                                @foreach($tip_info as $k=>$v)
                                    <tr>
                                        <td class="tip_box_td1" alt="{{$v->goods->goods_name}}"
                                            title="{{$v->goods->goods_name}}">{{$k+1}}
                                            )、{{str_limit($v->goods->goods_name,20)}}</td>
                                        <td class="tip_box_td2" alt="" title="">
                                            生产厂家：{{str_limit($v->goods->sccj,12)}}</td>
                                        <td class="tip_box_td3">药品规格：{{str_limit($v->goods->spgg,16)}}</td>
                                        <td class="tip_box_td4">
                                            <div class="td_img"><img src="{{get_img_path('images/cart0010.jpg')}}"
                                                                     alt=""/>{{$v->message}}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                    </div>

                </div>
                <!--提示信息    end    -->
            @else
                <div class="no_shopping">
                    <div class="no_box">
                        <span class="no_ico"><img src="./images/no-login-icon.png" alt=""/></span>
                        <p>购物车空空的哦~，去看看心仪的商品吧~</p>
                        <p><a href="/">去购物></a></p>
                    </div>
                </div>
            @endif
        @endif


        <div class="shopping_list">
            <!--<h3>购买了同样商品的顾客还购买了</h3>-->
            <h3>为您推荐</h3>
            <div id="slides" class="visual slides">
                <ul class="slides_container">
                    @foreach($wntj as $k=>$v)
                        @if($k==4)
                            <li class="common">
                                <div>
                                    @foreach($wntj as $key=>$val)
                                        @if($key<5)
                                            <div class="base">
                                                <a href="{{route('goods.index',['id'=>$val->goods_id])}}"> <img
                                                            src="{{$val->goods_thumb}}"/></a>
                                                <div>
                                                    <p alt="{{$val->goods_name}}"
                                                       title="{{$val->goods_name}}">{{str_limit($val->goods_name,8)}}</p>
                                                    <p alt="{{$val->real_price}}"
                                                       title="{{$val->real_price}}">{{formated_price($val->real_price)}}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </li>
                        @elseif($k==5)
                            <li class="common">
                                <div>
                                    @foreach($wntj as $key=>$val)
                                        @if($key>=5)
                                            <div class="base">
                                                <a href="{{route('goods.index',['id'=>$val->goods_id])}}"> <img
                                                            src="{{$val->goods_thumb}}"/></a>
                                                <div>
                                                    <p alt="{{$val->goods_name}}"
                                                       title="{{$val->goods_name}}">{{str_limit($val->goods_name,8)}}</p>
                                                    <p alt="{{$val->real_price}}"
                                                       title="{{$val->real_price}}">{{formated_price($val->real_price)}}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <div class="slideControl slideContro_tab">
                    <p class="slide_lBt"><a href="#" class="prev"></a></p>
                    <p class="slide_rBt"><a href="#" class="next"></a></p>
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


    <!-- 购物删除弹出层begin -->
    <div class="comfirm_buy" id="shopping_box4">
        <div class="content_buy"><a href="#" class="question"></a>

            <h3>删除商品？</h3>
            <p class="txt_tip">您可以选择移到收藏，或删除商品。</p>


            <p class="del_p">
                <a href="" class="del2">删 除</a>
                <a href="" class="remove_col">移到我的收藏</a>
            </p>

            <span class="close2"></span>
        </div>
    </div>
    <!-- 购物删除弹出层end -->

    <!-- 购物移到收藏弹出层begin -->
    <div class="comfirm_buy" id="shopping_box5">
        <div class="content_buy"><a href="#" class="question"></a>
            <h3>移到收藏？</h3>
            <p class="txt_tip">移动后该商品将不在购物车中显示。</p>
            <p class="del_p">
                <a href="" class="confirm_cc">确定</a>
                <a href="javascript:void(0); " class="cancel">取消</a>
            </p>
            <span class="close2"></span>
        </div>
    </div>
    <!-- 购物移到收藏弹出层end -->
    @include('common.footer',['hide_yc'=>1])
@endsection
