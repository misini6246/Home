@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/goods_list.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jump.js')}}"></script>
    <style>
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
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    @include('common.lunbo')
    <div class="main fn_clear" style="width: 100%;
            background-color: #{{$bg_color or 'ec1556'}};
            margin: auto;">

        <div class="tejia-box" style="width:992px;margin:0 auto;background-color:#fff;padding-left:8px;">
            <div class="right_list" style="float: none;">
                @if(count($pages)>0)
                    @if($showi)
                        <div class="cart_list">
                            <table class="table2">
                                <tr>
                                    <th>促销标识</th>
                                    <th>产品名称</th>
                                    <th>规格</th>
                                    <th>单位</th>
                                    <th>生产厂家</th>
                                    <th>会员价</th>
                                    <th>@if($dis==4)产地@else件装量@endif</th>
                                    <th>中包装</th>
                                    <th>数量</th>
                                    <th> 库存</th>
                                    <th> 操作</th>
                                </tr>
                                @foreach($pages as $k=>$v)
                                    <tr>
                                        <td class="table2_td1" style="z-index:99">
                                            @if($v->is_zx==1)
                                                <a href="#" style="color:#f00;">买赠</a>
                                            @endif
                                            @if($v->is_cx==1)
                                                <a href="#" style="color:#66f;">特</a>
                                            @elseif($v->zyzk>0)
                                                <div style="position:relative;" class="t-tip">
                                                    <a href="#" style="color:#66f;position:relative;z-index:10;">惠</a>
                                                    <span class="tip_span"
                                                          style="width:144px;height:46px;position:absolute;left:0px;top:21px;display:none;z-index:999;"><img
                                                                src="{{get_img_path('images/tj_tip.png')}}"
                                                                alt=""/></span>

                                                </div>

                                            @endif
                                            {{--@if($v->is_hg==1)<a href="javascript:;" style="color:#690;">换购</a>@endif<!-- 2015-7-9 -->--}}

                                        </td>
                                        <!-- 2015-8-5 -->
                                        <td class="table2_td2">
                        <span class="img_a">
                            <a href="{{$v->goods_url}}" title="{{$v->goods_name}}"
                               target="_blank">{{str_limit($v->goods_name,22)}}</a>
                            <a href="{{$v->goods_url}}" class="a_img">
                                <img src="{{empty($v->goods_thumb)? 'no_picture.gif':$v->goods_thumb}}"
                                     alt="{{$v->name}}"/>
                                @if(!empty($v->xq))<span class="info_txt"
                                                         @if($v->is_xq_red==1) style="color: #e70000" @endif>效期：{{$v->xq}}</span>@endif
                                <span class="info_txt">总销量: <span class="num">{{$v->sales_volume or 0}}</span></span>
                            </a>
                        </span>
                                        </td>
                                        <td class="table2_td3">{{str_limit($v->spgg,12)}}</td>
                                        <td class="table2_td4">{{$v->dw}}</td>
                                        <td class="table2_td5">{{str_limit($v->sccj,22)}}</td>
                                        <td class="table2_td6">
                                            @if($v->is_can_see==0) 会员可见 @else
                                                {{formated_price($v->real_price)}}
                                            @endif
                                        </td>
                                        <td class="table2_td7">{{str_limit($v->jzl,6)}}</td>
                                        <td class="table2_td8">{{$v->zbz}}<input type="hidden" value="{{$v->zbz}}"
                                                                                 id="product_zbz_{{$k}}"/></td>
                                        <td class="table2_td9">
                                            <span class="left_ico" onclick="reduce_num({{$v->goods_id}})">-</span>
                                            <input id="J_dgoods_num_{{$v->goods_id}}" class="ls_num" name="number"
                                                   type="text"
                                                   value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                   defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                   onblur="changePrice({{$v->goods_id}})" data-gn="{{$v->goods_number}}"
                                                   data-zbz="{{$v->zbz or 1}}" data-lsgg="{{$v->ls_gg}}"
                                                   data-lsggg="{{$v->ls_ggg}}" data-xgtype="{{$v->xg_type}}"
                                                   data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>
                                            <span class="right_ico" onclick="add_num({{$v->goods_id}})">+</span>
                                            <input type="hidden" value="{{$v->goods_id}}" id="goods_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->ls_gg}}" id="lsgg_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->yl['yl']}}" id="yl_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->yl['isYl']}}" id="isYl_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->goods_number}}" id="gn_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->zbz or 1}}" id="zbz_{{$v->goods_id}}"/>
                                            <input type="hidden" value="{{$v->jzl or 0}}" id="jzl_{{$v->goods_id}}"/>
                                        </td>
                                        <td class="table2_td10">@if($v->goods_number>800)充裕@elseif($v->goods_number==0)
                                                缺货@else{{$v->goods_number}}@endif</td>
                                        <td class="table2_td11"><a
                                                    @if($v->is_can_see==1)href="javascript:tocart({{$v->goods_id}})"
                                                    @else href="javascript:addToCart2({{$v->goods_id}})"
                                                    @endif  id="sssss_{{$v->goods_id}}" class="add_cart">加入购物车</a> <a
                                                    href="javascript:collect({{$v->goods_id}})" class="col">收藏</a></td>

                                    </tr>
                                @endforeach
                            </table>

                        </div>
                    @else
                        <div class="cart_tab">
                            <ul>
                                @foreach($pages as $k=>$v)
                                    <li class="child" style="height: 391px;">
                                        <!-- 2015-7-9 -->
                                        @if($v->is_cx!=0)
                                            <span class="tetj"><img src="{{get_img_path('images/tejia.png')}}" alt=""/></span>
                                        @elseif($v->zyzk>0)
                                            <span class="tetj"><img src="{{get_img_path('images/hui.png')}}"
                                                                    alt=""/></span>
                                        @endif
                                        <a href="{{$v->goods_url}}" target="_blank" class="child_a">
                                            <img src="{{empty($v->goods_thumb)? 'no_picture.gif':$v->goods_thumb}}"
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
                                        <div class="box_goods" style="height: 166px;">
                                            <ul style="height: 122px;">
                                                <li><a href="{{$v->goods_url}}" target="_blank" alt="{{$v->goods_name}}"
                                                       title="{{$v->goods_name}}">{{str_limit($v->goods_name,26)}}</a>
                                                </li>

                                                <li>{{str_limit($v->sccj,26)}}</li>
                                                <li><span class="title">规格：</span>{{str_limit($v->spgg,12)}}</li>
                                                <li><span class="title">@if(strpos($v->show_area,'4')!==false&&intval($v->jzl)==0)
                                                            产地@else件装量@endif
                                                        ：</span>{{str_limit($v->jzl,6)}} @if(!empty($v->xq))<span
                                                            @if($dis==7)style='font-size:13px;color:red;'
                                                            @elseif($v->is_xq_red==1) style="color: #e70000" @endif>效期：{{$v->xq}}</span>@endif
                                                </li><!-- 2015-8-5 -->
                                                {{--<li> <span class="title">原价：</span>@if($v->is_can_see==0) 会员可见 @else {{formated_price($v->shop_price)}} @endif</li>--}}
                                                @if($step=='nextpro')
                                                    <li><span class="title" style="color: red;">@if(!auth()->check())
                                                                活动价 @elseif($v->is_can_see==0) 会员价 @else活动价@endif
                                                            ：</span><span class="price"
                                                                          style="color:red;font-size:16px;font-weight:bold;">
                                   @if($v->is_can_see==0) 会员可见 @else
                                                                @if(auth()->check()&&(auth()->user()->user_rank==2||auth()->user()->user_rank==5))
                                                                    {{formated_price($v->promote_price)}}
                                                                @else
                                                                    {{formated_price($v->real_price)}}
                                                                @endif
                                                            @endif
                                </span></li>
                                                    <li><span class="title" style="color: red">活动时间：06.21</span>@if(($v->xg_type>0&&$v->xg_end_date>$v->promote_start_date&&$v->xg_start_date<=$v->promote_start_date)||$v->xg_type==1)<span style="margin-left: 10px;" class="title">活动限量：{{$v->ls_ggg}}</span>@endif</li>
                                                @else
                                                    <li><span class="title">价格：</span><span style="width: 69px;display: inline-block" class="price">
                                   @if($v->is_can_see==0) 会员可见 @else
                                                                {{formated_price($v->real_price)}}
                                                            @endif
                                </span>@if(($v->xg_type>0&&$v->xg_end_date>time()&&$v->xg_start_date<time())||$v->xg_type==1)<span class="title">限&nbsp;&nbsp;&nbsp;量：{{$v->ls_ggg}}</span>@endif</li>
                                                    <li><span style="width: 100px;display: inline-block" class="title">库存：@if($v->goods_number>800)
                                                                充裕@elseif($v->goods_number==0)
                                                                缺货@else{{$v->goods_number}}@endif</span><span class="title">@if($v->zbz)
                                                                中包装：{{$v->zbz}}<input type="hidden" value="{{$v->zbz}}"
                                                                                      id="product_zbz_{{$k}}"/>@endif</span>
                                                    </li>
                                                @endif
                                            </ul>
                                            @if($v->xzgm==1&&$v->is_can_buy==0)
                                                <div class="btn">
                                                    <p class='num' style='width:184px;color:red;border:none'>
                                                        控销品种，如需购买请联系客服！</p>
                                                </div>
                                            @else
                                                <div class="btn">
                                                    <input class="num ls_num" id="J_dgoods_num_{{$v->goods_id}}"
                                                           name="number" type="text"
                                                           value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                           defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                                           onblur="changePrice({{$v->goods_id}})"
                                                           data-zbz="{{$v->zbz or 1}}" data-lsgg="{{$v->ls_gg}}"
                                                           data-lsggg="{{$v->ls_ggg}}" data-xgtype="{{$v->xg_type}}"
                                                           data-gn="{{$v->goods_number}}"
                                                           data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>
                                                    <p>
                                                        <span class="add" onclick="add_num({{$v->goods_id}})"></span>
                                                        <span class="reduce"
                                                              onclick="reduce_num({{$v->goods_id}})"></span>
                                                    </p>
                                                    <input type="hidden" value="{{$v->goods_id}}"
                                                           id="goods_{{$v->goods_id}}"/>
                                                    <input type="hidden" value="{{$v->ls_gg}}"
                                                           id="lsgg_{{$v->goods_id}}"/>
                                                    <input type="hidden" value="{{$v->yl['yl']}}"
                                                           id="yl_{{$v->goods_id}}"/>
                                                    <input type="hidden" value="{{$v->yl['isYl']}}"
                                                           id="isYl_{{$v->goods_id}}"/>
                                                    <input type="hidden" value="{{$v->goods_number}}"
                                                           id="gn_{{$v->goods_id}}"/>
                                                    <input type="hidden" value="{{$v->zbz or 1}}"
                                                           id="zbz_{{$v->goods_id}}"/>
                                                    <input type="hidden" value="{{$v->jzl or 0}}"
                                                           id="jzl_{{$v->goods_id}}"/>
                                                    <a @if($v->is_can_see==1)href="javascript:tocart({{$v->goods_id}})"
                                                       @else href="javascript:addToCart2({{$v->goods_id}})"
                                                       @endif id="dsssss_{{$v->goods_id}}"><em></em>加入购物车</a>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    @endif

                <!--分页显示开始-->
                    @if($pages->lastPage()>0)
                        {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,[
                        'url'=>'category.index',
                        'dis'=>$dis,
                        'phaid'=>$phaid,
                        'py'=>$py,
                        'keywords'=>$keywords,
                        'jx'=>$jxhere,
                        'zm'=>$zmhere,
                        'goods_name'=>$goods_name_here,
                        'product_name'=>$product_name_here,
                        'sort'=>$sorthere,
                        'order'=>$order,
                        'showi'=>$showi,
                        'step'=>$step,
                        ]) !!}
                    @endif
                <!--分页显示结束-->

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
                        <p><a href="{{url('requirement')}}" target="_blank">点击这里提交求购意向，{{config('services.web.name')}}网会尽快补货！</a></p>
                    </div>
                    <div class="g_right_bottom_bottom">
                        <p>没有找到你想要的药品？ <a href="{{url('requirement')}}" target="_blank">点击这里提交求购意向，{{config('services.web.name')}}网会尽快补货！</a></p>
                    </div>
                @endif

            </div>
        </div>
    </div>
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

            $(".table2 tr td  .t-tip").hover(function () {


                $(this).find(".tip_span").show();


            }, function () {

                $(this).find(".tip_span").hide();

            })
            $(window).scroll(function () {
                var start = $('.tejia-box').offset().top;
            });

        })

    </script>
@endsection
