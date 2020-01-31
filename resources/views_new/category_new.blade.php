@extends('common.index')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/goods_list.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jump.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/new/change_num.js')}}"></script>
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
    @if($step=='nextpro'||$step=='promotion')
        {{--@include('layout.aoyuntj')--}}
    @endif
    <div class="main fn_clear">



        <div class="left_list">
            <div class="list_top">
                <h3>推荐厂家</h3>
                <ul>
                    @if($ad34)
                        @foreach($ad34 as $v)
                            <li>
                                <a href="{{$v->ad_link}}" target="_blank">
                                    <img src="{{$v->ad_code}}" alt=""/>
                                </a>
                            </li>
                        @endforeach
                    @endif
                </ul>

            </div>
            <div class="list_next">
                <h3>一周销量排行榜</h3>
                <ul>
                    @foreach($weekSales as $k=>$v)
                        <li @if($k==0)class="first"@endif>
                            <a href="{{$v->goods_url}}" class="list">
                                <span class="com_num red">{{$k+1}}</span>
                                <span class="name" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>

                                <span class="norms" alt="" title="{{$v->spgg or ''}}" >{{str_limit($v->spgg,12)}}</span>

                            </a>
                            <span class="span_hide">
						<span class="com_num red">{{$k+1}}</span>
						<a href="{{$v->goods_url}}"><img src="{{empty($v->goods_thumb)? 'no_picture.gif':$v->goods_thumb}}" alt="{{$v->goods_name}}" title="{{$v->goods_name}}"/></a>
						<span class="title" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>

						<span class="norms" alt="{{$v->spgg}}" title="{{$v->spgg}}" >{{str_limit($v->spgg,12)}}</span>

					</span>
                        </li>
                    @endforeach
                </ul>
            </div>


        </div>

        <div class="right_list">
            @if($step!='nextpro'&&$step!='promotion'&&$step!='gzbl_promotion'&&$step!='gzbl_nextpro')
                <div class="r_top">
                    <span class="filter_ico"></span>药品筛选
                </div>

                @if(!empty($select_arr))
                    <div class="g_csize fn_clear">
                        <div class="g_hdiv">所选分类 :</div>
                        <div class="g_listdiv g_fsdiv">
                            @foreach($select_arr as $v)
                                <a class="g_select_cate" href="{{$v['url']}}"><h5>{{$v['name']}}:</h5>&nbsp;{{$v['text']}}<span class="g_close_icon"></span></a>
                            @endforeach
                        </div>
                        <div class="clear"></div>
                    </div>
                @endif

                <div class="list_title fn_clear">
                    <div class="ul_list1" style="display: block;">
                        <span class="title_name">剂型： </span>
                        <ul>
                            @foreach($jx as $k=>$v)
                                @if($k<11)
                                    <li @if($jxhere==$v->jx) class="on_click" @endif ><a href="{{$url}}&jx={{$v->jx}}&zm={{$zmhere}}&sort={{$sorthere}}&order={{$order}}">{{$v->jx}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                        <span class="open">展开 <em class="up_ico"></em></span>

                    </div>
                    <div class="ul_list1 ul_list2 fn_clear" style="display: none;">
                        <span class="title_name">剂型： </span>

                        <ul class="fn_clear">
                            @foreach($jx as $k=>$v)
                                <li @if($jxhere==$v->jx) class="on_click" @endif ><a href="{{$url}}&jx={{$v->jx}}&zm={{$zmhere}}&sort={{$sorthere}}&order={{$order}}">{{$v->jx}}</a></li>
                            @endforeach
                        </ul>
                        <span class="close">收起 <em class="up_ico"></em></span>
                    </div>

                    <div class="initial">
                        <span class="title_name">首字母： </span>
                        @foreach($zm as $k=>$v)
                            <a @if($zmhere==$v) class="checked_a" @endif href="{{$url}}&jx={{$jxhere}}&zm={{$v}}&sort={{$sorthere}}&order={{$order}}">{{$v}}</a>
                        @endforeach
                    </div>

                    <div class="search">
                        <form action="{{url('/category')}}" method="get">
                            <p> <span class="title">药品名称：</span> <input type="text" name="goods_name" value="{{$goods_name_here}}" class="text" /></p>
                            <p> <span class="title">生产厂家：</span> <input type="text" name="product_name" value="{{$product_name_here}}" class="text" /></p>
                            <input type="submit" class="submit" value="查询" />
                            <input type="hidden" name="jx" value="{{$jxhere}}" />
                            <input type="hidden" name="dis" value="{{$dis}}" />
                            <input type="hidden" name="showi" value="{{$showi}}" />
                        </form>

                    </div>



                    <table class="table1" >
                        <tr class="first">
                            <td class="td com @if($sorthere=='goods_id') sort @endif"><a href="{{$url}}&jx={{$jxhere}}&zm={{$zmhere}}&goods_name={{$goods_name_here}}&product_name={{$product_name_here}}&sort=goods_id&order={{$goods_id['next_order'] or 'asc'}}&showi={{$showi}}">综合 <span class="{{$goods_id['order_class'] or 'arrow'}}"></span></a></td>
                            <td class="td com @if($sorthere=='click_count') sort @endif"><a href="{{$url}}&jx={{$jxhere}}&zm={{$zmhere}}&goods_name={{$goods_name_here}}&product_name={{$product_name_here}}&sort=click_count&order={{$click_count['next_order'] or 'asc'}}&showi={{$showi}}">人气 <span class="{{$click_count['order_class'] or 'arrow'}}"></span></a></td>

                            <td class="td com @if($sorthere=='sales_volume') sort @endif"><a href="{{$url}}&jx={{$jxhere}}&zm={{$zmhere}}&goods_name={{$goods_name_here}}&product_name={{$product_name_here}}&sort=sales_volume&order={{$sales_volume['next_order'] or 'asc'}}&showi={{$showi}}">销量 <span class="{{$sales_volume['order_class'] or 'arrow'}}"></span></a></td>

                            <td class="td com @if($sorthere=='shop_price') sort @endif"><a href="{{$url}}&jx={{$jxhere}}&zm={{$zmhere}}&goods_name={{$goods_name_here}}&product_name={{$product_name_here}}&sort=shop_price&order={{$shop_price['next_order'] or 'asc'}}&showi={{$showi}}">价格 <span class="{{$shop_price['order_class'] or 'arrow'}}"></span></a></td>
                            <td class="td com @if($sorthere=='goods_name') sort @endif"><a href="{{$url}}&jx={{$jxhere}}&zm={{$zmhere}}&goods_name={{$goods_name_here}}&product_name={{$product_name_here}}&sort=goods_name&order={{$goods_name['next_order'] or 'asc'}}&showi={{$showi}}">品名 <span class="{{$goods_name['order_class'] or 'arrow'}}"></span></a></td>
                            <td class="td com @if($sorthere=='product_name') sort @endif"><a href="{{$url}}&jx={{$jxhere}}&zm={{$zmhere}}&goods_name={{$goods_name_here}}&product_name={{$product_name_here}}&sort=product_name&order={{$product_name['next_order'] or 'asc'}}&showi={{$showi}}">厂家 <span class="{{$product_name['order_class'] or 'arrow'}}"></span></a></td>
                            <td class="td com @if($step=='zyzk') sort @endif"><a href="{{route('category.index',['step'=>'zyzk'])}}">促销产品</a></td>
                            <td class="td7">
                                @if($dis!=7)
                                    <a href="{{$url}}&page={{$pages->currentPage()}}&jx={{$jxhere}}&zm={{$zmhere}}&goods_name={{$goods_name_here}}&product_name={{$product_name_here}}&sort={{$sorthere}}&order={{$order}}&step={{$step}}&showi=0" class="big_pic @if($showi!=0) checked @endif"></a>
                                    <a href="{{$url}}&page={{$pages->currentPage()}}&jx={{$jxhere}}&zm={{$zmhere}}&goods_name={{$goods_name_here}}&product_name={{$product_name_here}}&sort={{$sorthere}}&order={{$order}}&step={{$step}}&showi=1" class="list @if($showi==1) checked @endif"></a>
                                @endif
                            </td>

                        </tr>
                    </table>
                </div>
            @endif
            @if(count($pages)>0)
                @if($showi)
                    <div class="cart_list">
                        <table class="table2" >
                            <tr>
                                <th>促销标识</th>
                                <th>产品名称 </th>
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
                                                <span class="tip_span" style="width:144px;height:46px;position:absolute;left:0px;top:21px;display:none;z-index:999;"><img src="{{get_img_path('images/tj_tip.png')}}" alt="" /></span>

                                            </div>

                                        @endif
                                        {{--@if($v->is_hg==1)<a href="javascript:;" style="color:#690;">换购</a>@endif<!-- 2015-7-9 -->--}}

                                    </td>
                                    <!-- 2015-8-5 -->
                                    <td class="table2_td2">
                        <span class="img_a">
                            <a href="{{$v->goods_url}}" title="{{$v->goods_name}}" target="_blank">{{str_limit($v->goods_name,22)}}</a>
                            <a href="{{$v->goods_url}}" class="a_img">
                                <img src="{{empty($v->goods_thumb)? 'no_picture.gif':$v->goods_thumb}}" alt="{{$v->name}}"/>
                                @if(!empty($v->xq))<span class="info_txt" @if($v->is_xq_red==1) style="color: #e70000" @endif>效期：{{$v->xq}}</span>@endif
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
                                    <td class="table2_td7" >{{str_limit($v->jzl,6)}}</td>
                                    <td class="table2_td8">{{$v->zbz}}<input type="hidden" value="{{$v->zbz}}" id="product_zbz_{{$k}}" /></td>
                                    <td class="table2_td9">
                                        <span class="left_ico" onclick="reduce_num({{$v->goods_id}})">-</span>
                                        <input id="J_dgoods_num_{{$v->goods_id}}" class="ls_num" name="number" type="text" value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif" defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                               onblur="changePrice({{$v->goods_id}})" data-gn="{{$v->goods_number}}" data-zbz="{{$v->zbz or 1}}" data-lsgg="{{$v->ls_gg}}" data-lsggg="{{$v->ls_ggg}}" data-xgtype="{{$v->xg_type}}" data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>
                                        <span class="right_ico" onclick="add_num({{$v->goods_id}})">+</span>
                                        <input type="hidden" value="{{$v->goods_id}}" id="goods_{{$v->goods_id}}" />
                                        <input type="hidden" value="{{$v->ls_gg}}" id="lsgg_{{$v->goods_id}}" />
                                        <input type="hidden" value="{{$v->yl['yl']}}" id="yl_{{$v->goods_id}}" />
                                        <input type="hidden" value="{{$v->yl['isYl']}}" id="isYl_{{$v->goods_id}}" />
                                        <input type="hidden" value="{{$v->goods_number}}" id="gn_{{$v->goods_id}}" />
                                        <input type="hidden" value="{{$v->zbz or 1}}" id="zbz_{{$v->goods_id}}" />
                                        <input type="hidden" value="{{$v->jzl or 0}}" id="jzl_{{$v->goods_id}}" />
                                    </td>
                                    <td class="table2_td10">@if($v->goods_number>800)充裕@elseif($v->goods_number==0)缺货@else{{$v->goods_number}}@endif</td>
                                    <td class="table2_td11"><a @if($v->is_can_see==1)href="javascript:tocart({{$v->goods_id}})"@else href="javascript:tocart1()" @endif  id="sssss_{{$v->goods_id}}" class="add_cart">加入购物车</a> <a href="javascript:collect({{$v->goods_id}})" class="col">收藏</a> </td>

                                </tr>
                            @endforeach
                        </table>

                    </div>
                @else
                    <div class="cart_tab">
                        <ul>
                            @foreach($pages as $k=>$v)
                                <li class="child">
                                    <!-- 2015-7-9 -->
                                    @if($v->is_cx!=0)
                                        <span class="tetj"><img src="{{get_img_path('images/tejia.png')}}" alt=""/></span>
                                    @elseif($v->zyzk>0)
                                        <span class="tetj"><img src="{{get_img_path('images/hui.png')}}" alt=""/></span>
                                    @endif
                                    <a href="{{$v->goods_url}}" target="_blank" class="child_a">
                                        <img src="{{empty($v->goods_thumb)? 'no_picture.gif':$v->goods_thumb}}" alt=""/>
                                        <a href="javascript:collect({{$v->goods_id}})" class="collect"><span class="collect_ico"></span> 收藏</a>
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
                                            <li><a href="{{$v->goods_url}}" target="_blank" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,26)}}</a></li>

                                            <li>{{str_limit($v->sccj,26)}}</li>
                                            <li> <span class="title">规格：</span>{{str_limit($v->spgg,12)}}</li>
                                            <li> <span class="title">@if(strpos($v->show_area,'4')!==false&&intval($v->jzl)==0)产地@else件装量@endif：</span>{{str_limit($v->jzl,6)}} @if(!empty($v->xq))<span @if($dis==7)style='font-size:13px;color:red;' @elseif($v->is_xq_red==1) style="color: #e70000" @endif>效期：{{$v->xq}}</span>@endif</li><!-- 2015-8-5 -->
                                            @if($step=='nextpro'||$step=='gzbl_nextpro')
                                                <li> <span class="title" style="color: red;">@if(!auth()->check()) 活动价 @elseif($v->is_can_see==0) 会员价 @else活动价@endif：</span><span class="price" style="color:red;font-size:16px;font-weight:bold;">
                                   @if($v->is_can_see==0) 会员可见 @else
                                                            @if(auth()->check()&&(auth()->user()->user_rank==2||auth()->user()->user_rank==5))
                                                                {{formated_price($v->promote_price)}}
                                                            @else
                                                                {{formated_price($v->real_price)}}
                                                            @endif
                                                        @endif
                                </span></li>
                                                <li> <span class="title" style="color: red">活动时间：03.29</span></li>
                                            @else
                                                <li> <span class="title">价格：</span><span class="price">
                                   @if($v->is_can_see==0) 会员可见 @else
                                                            {{formated_price($v->real_price)}}
                                                        @endif
                                </span></li>
                                                <li> <span class="title">库存：@if($v->goods_number>800)充裕@elseif($v->goods_number==0)缺货@else{{$v->goods_number}}@endif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;@if($v->zbz) 中包装：{{$v->zbz}}<input type="hidden" value="{{$v->zbz}}" id="product_zbz_{{$k}}" />@endif</span></li>
                                            @endif
                                        </ul>
                                        @if($v->xzgm==1&&$v->is_can_buy==0)
                                            <div class="btn">
                                                <p class='num' style='width:184px;color:red;border:none'>控销品种，如需购买请联系客服！</p>
                                            </div>
                                        @else
                                            <div class="btn">
                                                <input class="num ls_num" id="J_dgoods_num_{{$v->goods_id}}" name="number" type="text" value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif" defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"  onblur="changePrice({{$v->goods_id}})" data-zbz="{{$v->zbz or 1}}" data-lsgg="{{$v->ls_gg}}" data-lsggg="{{$v->ls_ggg}}" data-xgtype="{{$v->xg_type}}" data-gn="{{$v->goods_number}}" data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>
                                                <p>
                                                    <span class="add" onclick="add_num({{$v->goods_id}})"></span>
                                                    <span class="reduce" onclick="reduce_num({{$v->goods_id}})"></span>
                                                </p>
                                                <input type="hidden" value="{{$v->goods_id}}" id="goods_{{$v->goods_id}}" />
                                                <input type="hidden" value="{{$v->ls_gg}}" id="lsgg_{{$v->goods_id}}" />
                                                <input type="hidden" value="{{$v->is_xg}}" id="yl_{{$v->goods_id}}" />
                                                <input type="hidden" value="{{$v->xg_num}}" id="isYl_{{$v->goods_id}}" />
                                                <input type="hidden" value="{{$v->goods_number}}" id="gn_{{$v->goods_id}}" />
                                                <input type="hidden" value="{{$v->zbz or 1}}" id="zbz_{{$v->goods_id}}" />
                                                <input type="hidden" value="{{$v->jzl or 0}}" id="jzl_{{$v->goods_id}}" />
                                                <a @if($v->is_can_see==1)href="javascript:tocart({{$v->goods_id}})"@else href="javascript:tocart1()"  @endif id="dsssss_{{$v->goods_id}}"><em></em>加入购物车</a>
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
                    <p><a href="{{url('requirement')}}" target="_blank">点击这里提交求购意向，合纵医药网会尽快补货！</a></p>
                </div>
                <div class="g_right_bottom_bottom">
                    <p>没有找到你想要的药品？ <a href="{{url('requirement')}}" target="_blank">点击这里提交求购意向，合纵医药网会尽快补货！</a></p>
                </div>
            @endif

        </div>
    </div>
    @if(isset($daohang)&&$daohang==1)
        @include('20170412.daohang')
    @endif
    @include('common.footer')
    <script type="text/javascript">
        function add_num(id){
            var gn = parseInt($('#gn_'+id).val());
            var yl = parseInt($('#yl_'+id).val());
            var isYl = parseInt($('#isYl_'+id).val());
            var lsgg = parseInt($('#lsgg_'+id).val());
            var zbz = parseInt($('#zbz_'+id).val());
            var jzl = parseInt($('#jzl_'+id).val());
            var num = parseInt($('#J_dgoods_num_'+id).val());
            //console.log(gn,yl,isYl,lsgg,zbz,jzl,num);
            num = num + zbz;
            if(jzl){//件装量存在
                if((num%jzl)/jzl>=0.8){//购买数量达到件装量80%
                    alert('温馨提示：你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。')
                    num = Math.ceil(num/jzl)*jzl;
                }
            }

            if(num%zbz!=0){//不为中包装整数倍
                num = num - num%zbz + zbz;
            }

            if(isYl>0&&num>isYl&&yl>0){//商品限购
                num = isYl;
            }

            if(num>gn&&gn>0){
//            alert('库存不足');
//            return false;
                num = gn;
            }
            $('#J_dgoods_num_'+id).val(num);
        }

        function reduce_num(id){
            var gn = parseInt($('#gn_'+id).val());
            var yl = parseInt($('#yl_'+id).val());
            var isYl = parseInt($('#isYl_'+id).val());
            var lsgg = parseInt($('#lsgg_'+id).val());
            var zbz = parseInt($('#zbz_'+id).val());
            var jzl = parseInt($('#jzl_'+id).val());
            var num = parseInt($('#J_dgoods_num_'+id).val());
            num = num - zbz;
            if(jzl){//件装量存在
                if((num%jzl)/jzl>=0.8&&(num%jzl)/jzl<=1){//购买数量达到件装量80%
                    num = num - num%jzl + parseInt(jzl*0.8);
                }
            }

            if(num%zbz!=0){//不为中包装整数倍
                num = num - num%zbz;
            }

            if(isYl>0&&num>isYl&&yl>0){//商品限购
                num = isYl;
            }

            if(num<1){
                num = zbz;
            }
            $('#J_dgoods_num_'+id).val(num);
        }

        function changePrice(id){
            var gn = parseInt($('#gn_'+id).val());
            var yl = parseInt($('#yl_'+id).val());
            var isYl = parseInt($('#isYl_'+id).val());
            var lsgg = parseInt($('#lsgg_'+id).val());
            var zbz = parseInt($('#zbz_'+id).val());
            var jzl = parseInt($('#jzl_'+id).val());
            var num = parseInt($('#J_dgoods_num_'+id).val());
            if(num<0){
                alert('请输入正确的数量');
                $('#J_dgoods_num_'+id).val(0-zbz);
                return false;
            }
            var old = num;

            if(num%zbz!=0){//不为中包装整数倍
                num = num - num%zbz + zbz;
            }

            if(jzl){//件装量存在
                if((num%jzl)/jzl>=0.8&&(num%jzl)/jzl<=1){//购买数量达到件装量80%
                    alert('温馨提示：你所选择的数量已接近件装量，为避免拆零引起的运输破损，系统自动调为整件。')
                    num = Math.ceil(num/jzl)*jzl;
//                if(num>gn){
//                    alert('库存不足');
//                    num = old - old%jzl + parseInt(jzl*0.8) - zbz;
//                }
                }
            }

            if(isYl>0&&num>isYl&&yl>0){//商品限购
                num = isYl;
            }

            if(num>gn&&gn>0){
//            alert('库存不足');
//            $('#J_dgoods_num_'+id).val(zbz);
//            return false;
                num = gn;
            }
            $('#J_dgoods_num_'+id).val(num);
        }
    </script>
    <script>
        $(function(){

            $(".table2 tr td  .t-tip").hover(function(){



                $(this).find(".tip_span").show();


            },function(){

                $(this).find(".tip_span").hide();

            })
            $('.fenlei').hover(function () {
                $('.category-menu').show()
            }, function () {
                $('.category-menu').hide()
            });
            $('.category-menu').hover(function () {
                $('.category-menu').show()
            }, function () {
                $('.category-menu').hide()
            });

        })
        $('#fixedNavBar,.qudingbu,#lvjing').singlePageNav({
            offset: 0
        });
    </script>
@endsection
