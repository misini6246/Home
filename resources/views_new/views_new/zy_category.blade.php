@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/common2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/goods_list.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/zhongyyp.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/zhongyyp-list.css')}}" rel="stylesheet" type="text/css" />    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/wntj-zy.js')}}"></script>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="site-content-box ">
        <div class="zhongyyp-box fn_clear">
            @include('layout.zy_zs')


            <div class="zhongyyp-list-right ">
                <div class="shuaixuan-box">
                    <div class="r_top">
                        <img src="./images/zyyp/zhyp054.jpg" alt=""/>
                    </div>
                    @if($select_arr)
                    <div class="g_csize fn_clear">
                        <div class="g_hdiv">所选分类 :</div>
                        <div class="g_listdiv g_fsdiv">
                            @foreach($select_arr as $v)
                            <a class="g_select_cate" href="{{$v['url']}}"><h5>{{$v['tip']}}:</h5>&nbsp;{{$v['text']}}<span class="g_close_icon"></span></a>
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
                                @if($k<7)<li @if($phaid==$v->cat_id)class="on_click"@endif ><a href="{{build_url('category.zyyp',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a></li>@endif
                                @endforeach
                            </ul>
                            <span class="open_zy">更多<em class="up_ico"></em></span>
                        </div>
                        <div class="ul_list1 ul_list2 fn_clear" style="display: none;">
                            <span class="title_name">中药饮片分类： </span>
                            <ul class="fn_clear">
                                @foreach(cate_tree(445) as $k=>$v)
                                <li @if($phaid==$v->cat_id)class="on_click"@endif ><a href="{{build_url('category.zyyp',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a></li>
                                @endforeach
                            </ul>
                            <span class="close_zy">收起 <em class="up_ico"></em></span>
                        </div>

                        <div class="ul_list1" style="display: block;">
                            <span class="title_name">中药功能分类：</span>
                            <ul>
                                @foreach(cate_tree(446) as $k=>$v)
                                    @if($k<10)<li @if($phaid==$v->cat_id)class="on_click"@endif ><a href="{{build_url('category.zyyp',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a></li>@endif
                                @endforeach

                            </ul>
                            <span class="open_zy">更多<em class="up_ico"></em></span>
                        </div>
                        <div class="ul_list1 ul_list2 fn_clear" style="display: none;">
                            <span class="title_name">中药功能分类： </span>
                            <ul class="fn_clear">
                                @foreach(cate_tree(446) as $k=>$v)
                                    <li @if($phaid==$v->cat_id)class="on_click"@endif ><a href="{{build_url('category.zyyp',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a></li>
                                @endforeach

                            </ul>
                            <span class="close_zy">收起 <em class="up_ico"></em></span>
                        </div>

                        <div class="ul_list1" style="display: block;">
                            <span class="title_name">中药来源属性： </span>
                            <ul>
                                @foreach(cate_tree(447) as $k=>$v)
                                    @if($k<13)<li @if($phaid==$v->cat_id)class="on_click"@endif ><a href="{{build_url('category.zyyp',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a></li>@endif
                                @endforeach

                            </ul>
                            <span class="open_zy">更多<em class="up_ico"></em></span>
                        </div>
                        <div class="ul_list1 ul_list2 fn_clear" style="display: none;">
                            <span class="title_name">中药来源属性：  </span>
                            <ul class="fn_clear">
                                @foreach(cate_tree(447) as $k=>$v)
                                    <li @if($phaid==$v->cat_id)class="on_click"@endif ><a href="{{build_url('category.zyyp',['pid'=>$v->cat_id,'product_name'=>$product_name_here,'zm'=>$zmhere])}}">{{$v->cat_name}}</a></li>
                                @endforeach

                            </ul>
                            <span class="close_zy">收起 <em class="up_ico"></em></span>
                        </div>

                        <div class="ul_list1" style="display: block;">
                            <span class="title_name">生产厂家： </span>
                            <ul>
                                @foreach($sccj as $k=>$v)
                                    @if($k<4)<li @if($product_name_here==$v)class="on_click"@endif ><a href="{{build_url('category.zyyp',['pid'=>$phaid,'product_name'=>$v,'zm'=>$zmhere])}}">{{$v}}</a></li>@endif
                                @endforeach


                            </ul>
                            <span class="open_zy">更多<em class="up_ico"></em></span>
                        </div>
                        <div class="ul_list1 ul_list2 fn_clear" style="display: none;">
                            <span class="title_name">生产厂家： </span>
                            <ul class="fn_clear">
                                @foreach($sccj as $k=>$v)
                                    <li @if($product_name_here==$v)class="on_click"@endif ><a href="{{build_url('category.zyyp',['pid'=>$phaid,'product_name'=>$v,'zm'=>$zmhere])}}">{{$v}}</a></li>
                                @endforeach
                            </ul>
                            <span class="close_zy">收起 <em class="up_ico"></em></span>
                        </div>

                        <div class="initial-a">
                            <span class="title_name">首字母： </span>
                            @foreach($zm as $v)
                            <a @if($zmhere==$v)class="checked_a"@endif href="{{build_url('category.zyyp',['pid'=>$phaid,'product_name'=>$product_name_here,'zm'=>$v])}}">{{$v}}</a>
                            @endforeach
                        </div>

                    </div>

                </div>
                @if(count($pages)>0)
                <div class="zhongyyp-goods-list">
                    <ul class="fn_clear">
                        @foreach($pages as $v)
                        <li >
                            <div class="shoucang">
                                <a href="javascript:collect({{$v->goods_id}})"><img src="./images/zyyp/zhyp063.png" alt=""/></a>
                            </div>
                            @if($v->is_hot==1)
                            <div class="hot">
                                <img src="./images/zyyp/zhyp062.png" alt=""/>
                            </div>
                            @endif
                            <a href="{{$v->goods_url}}">
                                <img src="{{$v->goods_thumb}}" alt=""/>
                            </a>
                            <div class="title">{{str_limit($v->goods_name,13)}}</div>
                            <p>{{str_limit($v->sccj,25)}}</p>
                            <p>规格：{{$v->spgg}}</p>
                            <p><span class="chandi">产地：{{$v->jzl}}&nbsp;&nbsp;</span></p>
                            <p>库存：@if($v->goods_number>800)充裕@elseif($v->goods_number==0)缺货@else{{$v->goods_number}}@endif&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </p>
                            <p>包装规格：{{$v->zf}} </p>
                            <p>价格： <em>{{$v->real_price_format}}</em>  </p>
                            <div class="btn">
                                <input id="J_dgoods_num_{{$v->goods_id}}" class="num ls_num" name="number" type="text" value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif" defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"
                                       onblur="changePrice({{$v->goods_id}})" data-gn="{{$v->goods_number}}" data-zbz="{{$v->zbz or 1}}" data-lsgg="{{$v->ls_gg}}" data-lsggg="{{$v->ls_ggg}}" data-xgtype="{{$v->xg_type}}" data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>
                                <p>
                                    <span class="add" onclick="add_num({{$v->goods_id}})"></span>
                                    <span class="reduce" onclick="reduce_num({{$v->goods_id}})"></span>
                                </p>
                                <input type="hidden" value="{{$v->goods_id}}" id="goods_{{$v->goods_id}}" />
                                <input type="hidden" value="{{$v->ls_gg}}" id="lsgg_{{$v->goods_id}}" />
                                <input type="hidden" value="{{$v->yl['yl']}}" id="yl_{{$v->goods_id}}" />
                                <input type="hidden" value="{{$v->yl['isYl']}}" id="isYl_{{$v->goods_id}}" />
                                <input type="hidden" value="{{$v->goods_number}}" id="gn_{{$v->goods_id}}" />
                                <input type="hidden" value="{{$v->zbz or 1}}" id="zbz_{{$v->goods_id}}" />
                                <input type="hidden" value="{{$v->jzl or 0}}" id="jzl_{{$v->goods_id}}" />
                                <a @if($v->is_can_see==1)href="javascript:tocart({{$v->goods_id}})"@else href="javascript:addToCart2({{$v->goods_id}})" @endif id="dsssss_{{$v->goods_id}}"><em></em>加入购物车</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>



                </div>
                <!--分页显示开始-->

                    <!--分页显示开始-->
                    @if($pages->lastPage()>0)
                        {!! pagesView($pages->currentPage(),$pages->lastPage(),3,3,[
                        'url'=>'category.zyyp',
                        'pid'=>$phaid,
                        'keywords'=>$keywords,
                        'zm'=>$zmhere,
                        'product_name'=>$product_name_here,
                        'order'=>$order,
                        'step'=>$step,
                        ]) !!}
                        @endif
                <!--分页显示结束-->
            </div>
            @else
            <div class="g_right_bottom">
                <p>抱歉, 没有找到相关的药品,</p>
                <p><a href="requirement.php" target="_blank">点击这里提交求购意向，合纵医药网会尽快补货！</a></p>
            </div>
            <div class="g_right_bottom_bottom">
                <p>没有找到你想要的药品？ <a href="requirement.php" target="_blank">点击这里提交求购意向，合纵医药网会尽快补货！</a></p>
            </div>
            @endif
        </div>

    </div>
    @include('layout.page_footer')
    <script type="text/javascript">
        $(function () {
            $(".open_zy").click(function () {

                $(this).parents(".ul_list1").hide();

                $(this).parents(".ul_list1").next(".ul_list2").show();

                $(this).parents(".ul_list1").next(".ul_list2").find(".up_ico").css("background-position","-75px -31px")



            });

            $(".close_zy").click(function () {

                $(this).parents(".ul_list2").hide();

                $(this).parents(".ul_list2").prev(".ul_list1").show();

                $(this).parents(".ul_list2").prev(".ul_list1").find(".up_ico").css("background-position","-50px 0")

            })

            $(".zhongyyp-goods-list ul li").hover(function () {
                $(this).addClass("zhongyy-list-hover");
            }, function () {
                $(this).removeClass("zhongyy-list-hover");
            })


        })





    </script>
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

            if(isYl>0&&num>isYl&&yl==1){//商品限购
                num = isYl;
            }

            if(num>gn){
                alert('库存不足');
                return false;
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

            if(isYl>0&&num>isYl&&yl==1){//商品限购
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

            if(isYl>0&&num>isYl&&yl==1){//商品限购
                num = isYl;
            }

            if(num>gn){
                alert('库存不足');
                $('#J_dgoods_num_'+id).val(zbz);
                return false;
            }
            $('#J_dgoods_num_'+id).val(num);
        }

        function tocart(id){
            var num = $('#J_dgoods_num_'+id).val();
            addToCart1(id,num);
        }
    </script>
@endsection

