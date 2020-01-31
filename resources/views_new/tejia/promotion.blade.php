@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/goods_list.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jump.js')}}"></script>
    <style>
        .cart_tab ul li.child .collect {
            top: 210px !important;
        }

        .child_a img {
            width: 100% !important;
            height: 100% !important;
        }

        .cart_tab ul {
            margin-top: 0 !important;
        }

        .cart_tab .box_goods .price {
            font-size: 18px;
            color: #ef2c2f;
            font-weight: bold;
        }

        .cart_tab ul .child {
            height: 400px !important;
            width: 260px !important;
            background: #fff;
            margin: 15px 0 0 28.5px !important;
            border: none !important;
        }

        .child_a {
            width: 260px !important;
            height: 260px !important;
            line-height: 260px;
            text-align: center;
        }

        .cart_tab ul li.child ul {
            padding: 5px 10px !important;
            width: 220px !important;
            height: auto !important;
        }

        .cart_tab ul li.child ul li {
            height: 20px;
            line-height: 20px;
            color: #333;
            margin-top: 1px;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: middle;
        }

        .cart_tab ul li.child ul li a {
            font-size: 14px;
            color: #111;
            font-weight: bold;
        }

        .btn {
            overflow: hidden;
            /*border: 1px solid red;*/
            margin-left: 10px;
        }

        ul li.child .btn .num {
            width: 54px;
            height: 26px;
            line-height: 26px;
            float: left;
            margin: 0;
            border-left: none;
            border-right: none;
        }

        ul li.child .btn .add {
            width: 26px;
            height: 26px;
            float: left;
            border: 1px solid #dbdbdb;
        }

        ul li.child .btn .reduces {
            width: 26px;
            height: 26px;
            float: left;
            border: 1px solid #dbdbdb;
        }

        ul li.child .btn p {
            width: auto !important;
        }

        .cart_tab .box_goods {
            background: #fff2b3;
        }

        .box_goods {
            height: 140px !important;
            *height: 188px !important;
        }

        .box_goods .mg {
            margin-right: 10px;
        }

        .jiage {
            margin-top: 3px !important;
        }

        .name {
            margin-top: 5px !important;
        }

        .ll {
            margin-left: 18px !important;
        }

        .llr {
            color: #ef2c2f !important;
        }

        .ll_1 {
            width: 100px !important;
            display: inline-block !important;
        }

        .ll_2 {
            margin-left: 27px !important;
        }

        ul li.child .btn a {
            display: block;
            float: left;
            width: 110px;
            height: 28px;
            border: none;
            margin-left: 20px;
            line-height: 26px;
            text-indent: 0 !important;
            background-color: #fff;
            color: #e70000;
            position: relative;
        }

        ul li.child .btn a img {
            width: 110px !important;
            height: 28px !important;
        }

        .tejia-box {
            background: #fedc37;
            width: 1200px;
            margin: 0 auto;
            border-radius: 20px;
            box-shadow: 0 0 21px rgba(225, 135, 19, 0.75);
            -webkit-box-shadow: 0 0 21px rgba(225, 135, 19, 0.75);
        }

        .pingpaizq {
            width: 100%;
            height: 467px;
            min-width: 1200px;
            background: url('{{get_img_path('images/hd/1109/tejia_bg.jpg')}}') no-repeat scroll top center;
        }

        .ul_box {
            width: 1185px !important;
            border-radius: 20px;
            margin: 8px auto !important;
            overflow: hidden;
            /*border: 1px solid red;*/
            background: #fbf9ec;
        }

        .main {
            /*margin-top:-60px!important;*/
            width: 100%;
            min-width: 1200px;
            background: #ff972b url('{{get_img_path('images/hd/1109/bg_content.jpg')}}') no-repeat scroll top center;
            margin: auto !important;
            padding-bottom: 40px;
        }

        /*分页*/
        .listPageDiv {
            width: 900px !important;
            float: left !important;
            margin: 15px 0 15px 330px !important;
            text-align: left !important;
            height: auto !important;
            line-height: initial !important;
        }

        .p1 {
            border: 1px solid #efefef !important;
            width: 36px;
            height: 36px;
            text-align: center;
            line-height: 36px;
            background: #fefefe !important;
            padding: 0 !important;
            display: inline-block;
            margin: 0 !important;
            font-size: 16px;
            color: #333;
        }

        .p1 a img {
            width: 6px !important;
            height: 9px !important;
        }

        .listPageDiv a {
            font-size: 16px;
            color: #333;
        }

        .next {
            border-bottom-right-radius: 30px;
            border-top-right-radius: 30px;
        }

        .prev {
            border-bottom-left-radius: 30px;
            border-top-left-radius: 30px;
        }

        .shenglue {
            width: 22px;
            height: 38px;
            line-height: 38px;
            text-align: center;
            display: inline-block;
        }

        .p_ok {
            background: #e84e3e !important;
            color: white !important;
        }

        .dyy, .syy, .xyy, .zmy {
            width: 50px !important;
        }

        .p1 {
            margin: 0 2px !important;
        }

        .p1 a {
            font-size: 14px !important;
        }

        .pageList {
            width: auto !important;
        }

        .listPageDiv .submit_input {
            /*width: 160px!important;*/
            float: left !important;
            padding: 0 !important;
            color: #777;
            margin-left: 10px;
        }

        .listPageDiv .page_inout {
            width: 24px !important;
            height: 38px !important;
            line-height: 38px !important;
            border: 1px solid #efefef !important;
            color: #777;
        }

        .listPageDiv .submit {
            width: 46px !important;
            height: 36px !important;
            line-height: 36px !important;
            *line-height: 32px !important;
            border: 1px solid #efefef !important;
            background: #fdfdfd !important;
            color: #777;
            box-sizing: initial !important;
        }

        #znq-daohang {
            right: 45px !important;
            bottom: 20px !important;
        }

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

        .pingpaizq .center {
            width: 1200px;
            margin: 0 auto;
        }

        .pingpaizq .cc, .pingpaizq .time {
            width: 290px;
            height: 209px;
            position: relative;
        }

        .pingpaizq .cc {
            background: url('{{get_img_path('images/hd/next_1.png')}}') no-repeat scroll top center;
            float: left;
            margin-left: 77px;
        }

        .pingpaizq .cc p.txt {
            width: 100%;
            text-align: center;
            position: absolute;
            top: 105px;
            font-size: 36px;
            font-weight: bold;
            color: #fff228;
        }

        .pingpaizq .time {
            background: url('{{get_img_path('images/hd/next_2.png')}}') no-repeat scroll top center;
            float: right;
            margin-right: 77px;
            height: 198px;
        }

        .pingpaizq .time .remaintime {
            position: absolute;
            width: 100%;
            height: 50px;
            left: 0;
            top: 108px;
        }

        .pingpaizq .time .remaintime p {
            float: left;
            width: 48px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            color: #fbee3f;
            font-size: 24px;
        }

        .pingpaizq .time .remaintime p.minute {
            margin-left: 65px;
        }

        .pingpaizq .time .remaintime p.second {
            margin-left: 38px;
        }

        .pingpaizq .cc a, .pingpaizq .time a {
            display: inline-block;
            width: 135px;
            height: 33px;
            position: absolute;
            bottom: 0;
            left: 77px;
        }

        /*新增筛选*/
        .shaixuan {
            width: 1128px;
            margin: 10px auto;
            border: 1px solid #cebc45;
            box-sizing: border-box;
            background: #fff;
            position: relative;
            z-index: 2;
        }

        .shaixuan .choose {
            width: 1100px;
            height: 39px;
            line-height: 39px;
            border-bottom: 1px dashed #cebc45;
            margin: 0 auto;
        }

        .shaixuan .title {
            float: left;
            padding-right: 10px;
            font-family: "宋体";
            color: #000;
        }

        .shaixuan .choose .result {
            float: left;
            font-family: "宋体";
            color: #ff3737;
            border: 1px dashed #ff3737;
            height: 24px;
            line-height: 24px;
            margin-top: 7px;
            padding: 0 7px;
            cursor: pointer;
        }

        .shaixuan .choose .result img {
            margin-left: 5px;
        }

        .shaixuan .zimu {
            width: 1100px;
            margin: 0 auto;
            height: 32px;
            line-height: 32px;
        }

        .shaixuan .zimu ul li {
            float: left;
            width: 26px;
            text-align: center;
            color: #333;
            cursor: pointer;
            margin-left: 7px;
            position: relative;
            z-index: 3;
            background: white;
            box-sizing: border-box;
        }

        .shaixuan .zimu ul li.none {
            color: #999;
        }

        .shaixuan .zimu ul li.active {
            border: 1px solid #ff3737;
            border-bottom: none;

        }

        .changjia {
            width: 1126px;
            /*	height: 50px;*/
            border: 1px solid #ff3737;
            position: absolute;
            left: -1px;
            background: #fff;
            z-index: 2;
            *width: 1128px;
            padding: 10px 0;
            display: none;
        }

        .changjia p {
            float: left;
            margin-left: 10px;
            padding: 5px 20px 5px 0;
            cursor: pointer;
        }

        .changjia p.active {
            color: #ff3636;
        }

        .changjia p span {
            vertical-align: middle;
        }

        .changjia p img {
            vertical-align: middle;
            margin-left: 5px;
        }

        .sale {
            position: absolute;
            top: 0;
            left: 0;
            width: 97px !important;
            height: 79px !important;
        }

    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="pingpaizq">
        {{--<div class="center">--}}
        {{--<div class="cc">--}}
        {{--<a href="#"></a>--}}
        {{--<p class="txt">9点场</p>--}}
        {{--</div>--}}
        {{--<div class="time">--}}
        {{--<a href="#"></a>--}}
        {{--<div class="remaintime">--}}
        {{--<p class="minute"></p>--}}
        {{--<p class="second"></p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
    </div>
    <div class="main fn_clear" style="width: 100%;
    {{--background-color: #{{$bg_color or 'ec1556'}};--}}
            margin: auto;">

        <div class="tejia-box">
            <div class="right_list" style="float: none;width: 1200px;">
                @if(count($result)>0)

                    <div class="cart_tab" style="width: 1200px;">
                        <ul class="ul_box">
                            <div class="shaixuan">
                                @if(!empty($keywords))
                                    <div class="choose">
                                        <p class="title">当前选中：</p>
                                        <div class="result">
                                            <span>{{$keywords}}</span><a href="{{route('tejia',['step'=>$step])}}"><img
                                                        src="{{get_img_path('images/x.png')}}"/></a>
                                        </div>
                                    </div>
                                @endif
                                @if(count($sccj)>0)
                                    <div class="zimu">
                                        <p class="title">厂家首字母：</p>
                                        <ul>
                                            @foreach($sccj as $k=>$v)
                                                <li @if(count($v)==0) class="none" disabled @endif>{{$k}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @foreach($sccj as $v)
                                        <div class="changjia">
                                            @foreach($v as $val)
                                                <p>
                                                    <a href="{{route('tejia',['step'=>$step,'keywords'=>$val])}}">{{$val}}</a>
                                                </p>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @foreach($result as $k=>$v)
                                <li class="child">
                                    @if($v->getAttribute('119zk')>0)
                                        <img src="{{get_img_path('images/hd/1109/sale_'.$v->getAttribute('119zk').'.png')}}"
                                             class="sale"/>
                                    @endif
                                    @if($v->is_cx!=0)
                                        <span class="tetj"><img src="{{get_img_path('images/tejia.png')}}"
                                                                alt=""/></span>
                                    @elseif($v->zyzk>0)
                                        <span class="tetj"><img src="{{get_img_path('images/hui.png')}}"
                                                                alt=""/></span>
                                    @endif
                                    <a href="{{$v->goods_url}}" target="_blank" class="child_a">
                                        <img class="fly_img{{$v->goods_id}}"
                                             src="{{empty($v->goods_thumb)? 'no_picture.gif':$v->goods_thumb}}"
                                             alt=""/>
                                        <a @if($v->is_can_see==1) href="javascript:collect({{$v->goods_id}})"
                                           @else href="javascript:addToCart2({{$v->goods_id}})"
                                           @endif class="collect"><span
                                                    class="collect_ico"></span> 收藏</a>
                                        <div class="tip">
                                            @if($v->is_zx==1)
                                                <span class="tip_txt">买赠</span>
                                            @endif
                                            @if($v->is_hg==1) <!-- 2015-7-9 -->
                                            <span class="tip_txt te">换购</span>
                                            @endif
                                        </div>
                                    </a>
                                    <div class="box_goods">
                                        <ul>
                                            <li><span style="width: 130px;display: inline-block" class="price">
                                   @if($v->is_can_see==0) {{$v->getAttribute('119bz')}} @else
                                                        @if(auth()->check()&&(auth()->user()->user_rank==2||auth()->user()->user_rank==5))
                                                            {{formated_price($v->promote_price)}}
                                                            @if($step=='nextpro')
                                                                <strike style="font-size: 12px;color: #666;font-weight: normal;">{{formated_price($v->real_price)}}</strike>
                                                            @else
                                                                <strike style="font-size: 12px;color: #666;font-weight: normal;">{{formated_price($v->shop_price)}}</strike>
                                                            @endif
                                                        @else
                                                            {{formated_price($v->real_price)}}
                                                        @endif
                                                    @endif
                                </span>@if($step=='nextpro')
                                                    @if(($v->xg_type>0&&$v->xg_end_date>$v->promote_start_date&&$v->xg_start_date<=$v->promote_start_date)||$v->xg_type==1)
                                                        <span class="title">活动限量：{{$v->ls_ggg}}</span>@endif
                                                @else
                                                    @if(($v->xg_type>0&&$v->xg_end_date>time()&&$v->xg_start_date<time())||$v->xg_type==1)
                                                        <span class="title mg">限&nbsp;&nbsp;&nbsp;量：{{$v->ls_ggg}}</span>@endif
                                                @endif
                                            </li>

                                            <li class="name"><a href="{{$v->goods_url}}" target="_blank"
                                                                alt="{{$v->goods_name}}"
                                                                title="{{$v->goods_name}}">{{str_limit($v->goods_name,26)}}</a>
                                            </li>
                                            <li>{{str_limit($v->sccj,36)}}</li>
                                            <li><span class="title mg">规格：</span>{{str_limit($v->spgg,12)}}</li>
                                            @if(!empty($v->xq))
                                                <li><span class="title mg">效期：</span>{{str_limit($v->xq,12)}}<span
                                                            class="ll">库存：<span class="llr">@if($v->goods_number>800)
                                                                充裕@elseif($v->goods_number==0)
                                                                缺货@else{{$v->goods_number}}@endif</span></span></li>
                                            @else
                                                <li><span class="title mg">库存：<span class="llr">@if($v->goods_number>800)
                                                                充裕@elseif($v->goods_number==0)
                                                                缺货@else{{$v->goods_number}}@endif</span></span></li>
                                            @endif
                                            <li>
                                                    <span class="title ll_1"><span
                                                                class="mg">件装量：</span>{{$v->jzl}}</span>
                                                @if($step=='nextpro')
                                                    <span class="title ll_2 llr">
                                                                活动时间：{{$ad160->ad_name or '07.26'}}
                                                        <input type="hidden" value="{{$v->zbz}}"
                                                               id="product_zbz_{{$k}}"/></span>
                                                @else
                                                    <span class="title ll_2">
                                                                中包装：{{$v->zbz}}
                                                        <input type="hidden" value="{{$v->zbz}}"
                                                               id="product_zbz_{{$k}}"/></span>
                                                @endif
                                            </li>
                                        </ul>
                                        {{--<div class="btn">--}}
                                        {{--<p>--}}
                                        {{--<img src="{{get_img_path('images/hd/1109/jian.jpg')}}" alt=""--}}
                                        {{--onclick="reduce_num({{$v->goods_id}})"--}}
                                        {{--class="reduces"/>--}}
                                        {{--<input class="num ls_num" id="J_dgoods_num_{{$v->goods_id}}"--}}
                                        {{--name="number" type="text"--}}
                                        {{--value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"--}}
                                        {{--defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"--}}
                                        {{--onblur="changePrice({{$v->goods_id}})"--}}
                                        {{--data-zbz="{{$v->zbz or 1}}" data-lsgg="{{$v->ls_gg}}"--}}
                                        {{--data-lsggg="{{$v->ls_ggg}}" data-xgtype="{{$v->xg_type}}"--}}
                                        {{--data-gn="{{$v->goods_number}}"--}}
                                        {{--data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>--}}
                                        {{--<img src="{{get_img_path('images/hd/1109/jia.jpg')}}" alt=""--}}
                                        {{--onclick="add_num({{$v->goods_id}})"--}}
                                        {{--class="add"/>--}}
                                        {{--</p>--}}
                                        {{--<input type="hidden" value="{{$v->goods_id}}"--}}
                                        {{--id="goods_{{$v->goods_id}}"/>--}}
                                        {{--<input type="hidden" value="{{$v->ls_gg}}"--}}
                                        {{--id="lsgg_{{$v->goods_id}}"/>--}}
                                        {{--<input type="hidden" value="{{$v->yl['yl']}}"--}}
                                        {{--id="yl_{{$v->goods_id}}"/>--}}
                                        {{--<input type="hidden" value="{{$v->yl['isYl']}}"--}}
                                        {{--id="isYl_{{$v->goods_id}}"/>--}}
                                        {{--<input type="hidden" value="{{$v->goods_number}}"--}}
                                        {{--id="gn_{{$v->goods_id}}"/>--}}
                                        {{--<input type="hidden" value="{{$v->zbz or 1}}"--}}
                                        {{--id="zbz_{{$v->goods_id}}"/>--}}
                                        {{--<input type="hidden" value="{{$v->jzl or 0}}"--}}
                                        {{--id="jzl_{{$v->goods_id}}"/>--}}
                                        {{--<a class="fly_to_cart{{$v->goods_id}}"--}}
                                        {{--@if($v->is_can_see==1)href="javascript:tocart({{$v->goods_id}})"--}}
                                        {{--@else href="javascript:addToCart2({{$v->goods_id}})"--}}
                                        {{--@endif id="dsssss_{{$v->goods_id}}"><img--}}
                                        {{--src="{{get_img_path('images/hd/1109/jrgwc.jpg')}}"/></a>--}}
                                        {{--</div>--}}
                                    </div>
                                </li>
                            @endforeach
                        <!--分页显示开始-->
                            <!--[if IE]>
                            <style type="text/css">
                                .listPageDiv .page_inout, .listPageDiv .submit {
                                    position: relative;
                                    top: -3px;
                                }
                            </style>
                            <![endif]-->
                            @if($result->lastPage()>1)
                                {!! pagesView($result->currentPage(),$result->lastPage(),3,3,[
                                'url'=>'tejia',
                                'keywords'=>$keywords,
                                'step'=>$step,
                                ]) !!}
                            @else
                                <div class="listPageDiv"></div>
                        @endif
                        <!--分页显示结束-->
                        </ul>

                    </div>


                @else
                    <div class="g_right_bottom">
                        <p>抱歉, 没有找到
                            @if(!empty($goods_name_here))
                                与“ <span>{{$goods_name_here}}</span> ”
                            @elseif(!empty($product_name_here))
                                与“ <span>{{$product_name_here}}</span> ”
                            @elseif(!empty($keywords))
                                与“ <span>{{$keywords}}</span> ”
                            @endif相关的药品,</p>
                        <p><a href="{{url('requirement')}}" target="_blank">点击这里提交求购意向，合纵医药网会尽快补货！</a></p>
                    </div>
                    <div class="g_right_bottom_bottom">
                        <p>没有找到你想要的药品？ <a href="{{url('requirement')}}" target="_blank">点击这里提交求购意向，合纵医药网会尽快补货！</a></p>
                    </div>
                @endif

            </div>
        </div>
    </div>
    @if(!auth()->check())
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
    @if(isset($daohang)&&$daohang==1)
        @include('miaosha.daohang')
    @endif

    @include('common.footer')
    <script type="text/javascript">
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

            if (num > gn && gn > 0) {
//            alert('库存不足');
//            return false;
                num = gn;
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

            if (num > gn && gn > 0) {
//            alert('库存不足');
//            $('#J_dgoods_num_'+id).val(zbz);
//            return false;
                num = gn;
            }
            $('#J_dgoods_num_' + id).val(num);
        }

        function tocart(id) {
            var num = $('#J_dgoods_num_' + id).val();
            addToCart1(id, num);
        }
    </script>
    <script>
        $(function () {
            var time1 = parseInt('{{strtotime('2017-11-09 02:00:00')}}');
            var time2 = parseInt('{{strtotime('2017-11-09 07:00:00')}}');
            var time3 = parseInt('{{strtotime('2017-11-09 09:00:00')}}');
            var time4 = parseInt('{{strtotime('2017-11-09 11:00:00')}}');
            var time5 = parseInt('{{strtotime('2017-11-09 14:00:00')}}');
            var time6 = parseInt('{{strtotime('2017-11-09 17:00:00')}}');
            var time7 = parseInt('{{strtotime('2017-11-09 19:00:00')}}');
            var time8 = parseInt('{{strtotime('2017-11-09 21:00:00')}}');
            var time_arr = [time1, time2, time3, time4, time5, time6, time7, time8];
            var time0 = parseInt('{{time()}}');
            var start = parseInt('{{strtotime(20171109)}}');
            var djs = 0;
            for (var i = 0; i < time_arr.length; i++) {
                if (time0 < time_arr[i]) {
                    djs = time_arr[i] - time0;
                }
            }
            $(document).ready(function () {
                time();
                setInterval(time, 1000)
            })
            function time() {
                var cc = [0, 2, 7, 9, 11, 14, 17, 19];
                var now_cc = 0;
                if (time0 >= start) {
                    $('.center').show();
                }
                if (djs == 0) {
                    for (var i = 0; i < time_arr.length; i++) {
                        if (time0 < time_arr[i]) {
                            djs = time_arr[i] - time0;
                            now_cc = cc[i];
                        }
                    }
                }
                djs--;
                time0++;
                var second = Math.floor(djs % 60); // 计算秒
                var minite = Math.floor(djs / 60); //计算分
                $('.remaintime .minute').html(minite);
                $('.remaintime .second').html(second);
                $('.cc .txt').html(now_cc + '点场');
            }

            $(".table2 tr td  .t-tip").hover(function () {


                $(this).find(".tip_span").show();


            }, function () {

                $(this).find(".tip_span").hide();

            })
            $(window).scroll(function () {
                var start = $('.tejia-box').offset().top;
            });

        })

        $(function () {
            $('.zimu ul li').click(function () {
                if (!$(this).hasClass('none')) {
                    var tar = $(this).index();
                    $(this).addClass('active').siblings('li').removeClass('active');
                    $('.changjia').hide();
                    $('.changjia').eq(tar).show()
                }
            })
//            $('.changjia p').click(function(){
//                $('.changjia p img').remove()
//                $(this).addClass('active').siblings('p').removeClass('active');
//                $(this).append("<img src='img/gou.png'/>");
//                $('.result span').text($(this).text());
//                $('.result').show();
//                $('.result img').click(function(){
//                    $('.result').hide();
//                })
//            })
        })
    </script>
@endsection
