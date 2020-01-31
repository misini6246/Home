@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/goods_list.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.lazyload.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jump.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/index.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/slides.jquery.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/jquery.cookie.js')}}"></script>
    <style type="text/css">
        .ms-left span,.time-item span{font-size: 40px;color: #fff;}
        .time-item strong{font-size: 40px;color: #bf9104;font-weight: normal;}
        .list-first {width: 1240px;}
        .list-first li{width: 228px;height: 384px;float: left;margin-right: 10px;margin-bottom: 10px;background-color: #e0f4fa;}
        .list-first li .li-box{width: 222px;height: 378px;border: 3px solid #bf9104;background-color: #e0f4fa;}
        .list-first li .li-box img{width: 222px;height: 186px;}
        .list-first li .li-box h4{height: 30px;line-height: 30px;font-weight: normal;font-size: 16px;color: #03b2d8;text-indent: 7px;}
        .list-first li .li-box p{line-height: 24px;color: #040404;text-indent: 7px;height: 24px;overflow: hidden}
        .list-first li .li-box .price span{color: #eb294e}
        .list-first li .li-box .price-txt{font-size: 20px;font-weight: bold;}
        .list-first li .li-box  .shopping-btn img{width: 206px;height: 27px;}
        .list-three li{width: 228px;height: 410px;float: left;border: 2px solid #b41310;margin-right: 10px;margin-bottom: 10px;}
        .list-three li .li-box{width: 222px;height: 404px;border: 3px solid #bf9104;background-color: #e0f4fa;}
        .list-three li .li-box input{width: 45px;height: 24px;border: 1px solid #dddddd;float: left;text-align: center;border-left: 0;border-right: 0;}
        .btn{height: 32px;margin-top: 5px;}
        .btn .num {width: 27px;height: 27px;text-align: center;line-height: 27px;border: 1px solid #dbdbdb;float: left;margin:0 3px 0 7px;}
        .btn p{width: 16px;height: 28px !important;float: left;}
        .btn span{display: block;width: 16px;height: 14px;float: left;background:url(./images/sprite.png) no-repeat;cursor:pointer;}  .btn span.add{background-position: -182px 0 }
        .btn span.reduce{background-position: -182px -14px }  .btn  a{display: block;float: left;width: 112px;height: 26px;border: 1px solid #dbdbdb;margin-left: 10px;line-height: 26px;text-indent: 38px;background-color: #fff;color: #e70000;position: relative;}  .btn  a em{width: 23px;height: 26px;float: left;background: url(./images/com_sprites.png) -71px -1px no-repeat;position: absolute;left: 10px;top:0;}
        body{
            padding: 0 !important;margin: 0;background-color: #ffc412 !important;
        }
    </style>
@endsection
@section('content')

    <div style='background: url("{{get_img_path('images/xkh_tj_xj.jpg')}}") no-repeat scroll center top;height: 460px;min-width: 1200px;overflow: hidden;width: 100%;'>
    </div>
    <div class="site-content-box" style="width: 1200px;margin: 0 auto;">

        <div class="site-first">

            <div class="good-list" style="margin-top: 20px;width: 1200px;overflow: hidden;">
                <div class="title" style="width:290px;height:94px;margin:0 auto 30px auto;"><img src="{{get_img_path('images/shang12010.jpg')}}" alt="" ></div>
                <ul class="list-first fn_clear" style="background-color:#efb505;padding:10px 10px 0 10px" >

                    @foreach($goods_list as $k=>$v)
                    <li>
                        <div class="li-box">
                            <a href="{{$v->goods_url}}" target="_blank"><img src="{{$v->goods_thumb}}" alt=""/></a>
                            <h4 >{{str_limit($v->goods_name,13)}}</h4>
                            <p>{{str_limit($v->sccj,13)}}</p>
                            <p>规格：{{$v->spgg}}</p>
                            <div class="fn_clear" style="height: 24px;line-height: 24px;">
                                <p style="width: 45%;float: left;">件装量：{{$v->jzl or ''}}</p>
                                <p style="width: 55%;float: left;@if($v->is_xq_red==1) color:#e70000; @endif">效期：{{$v->xq}}</p>
                            </div>

                            <div class="price">
                                <p>
                                    <span style="color:#040404">价格：</span>
                                    <span class="price-txt">{{$v->real_price_format}}</span>
                                </p>

                            </div>
                            <div class="fn_clear" style="height: 24px;line-height: 24px;">
                                <p style="width: 45%;float: left;">库存：@if($v->goods_number>800)充裕@elseif($v->goods_number==0)缺货@else{{$v->goods_number}}@endif </p>
                                <p style="width: 55%;float: left;"> 中包装：{{$v->zbz or 1}}</p>
                            </div>

                            <div class="btn">
                                <input class="num ls_num" id="J_dgoods_num_{{$v->goods_id}}" name="number" type="text" value="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif" defaultnumber="@if($v->ls_gg>0){{$v->ls_gg}}@else{{$v->zbz or 1}}@endif"  onblur="changePrice({{$v->goods_id}})" data-zbz="{{$v->zbz or 1}}" data-lsgg="{{$v->ls_gg}}" data-lsggg="{{$v->ls_ggg}}" data-xgtype="{{$v->xg_type}}" data-gn="{{$v->goods_number}}" data-xgtypeflag="{{$v->xg_type_flag}}" dd-id="{{$k}}"/>
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
                                <a @if($v->is_can_see==1)href="javascript:tocart({{$v->goods_id}})"@else href="javascript:addToCart2({{$v->goods_id}})"  @endif id="dsssss_{{$v->goods_id}}"><em></em>加入购物车</a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>


            </div>
        </div>

        <div class="bottom-box">
            <div class="l-box" style="width:582px;height:390px;float:left;margin-left:10px;"><a target="_blank" href="/jf"><img src="{{get_img_path('images/shang12011.jpg')}}" alt=""></a></div>
            <div class="r-box" style="width:582px;height:390px;float:left;margin-left:20px;"><img src="{{get_img_path('images/shang12012.jpg')}}" alt=""></div>


        </div>
    </div>
    <div style='background: url("{{get_img_path('images/shang12013.jpg')}}") no-repeat scroll center top;height: 158px;min-width: 1200px;overflow: hidden;width: 100%;'>
    </div>

    <div class="footer-box" style="width:100%;height:500px;background-color:#2897d0;">
        <div class="footer" style="width:1200px;margin:0 auto;">
            <ul style="width:870px;margin:0 auto" class="cc fn_clear">
                <li><a target="_blank" href="{{route('index')}}#demo1"><img src="{{get_img_path('images/shang12014.jpg')}}" alt=""></a></li>
                <li><a target="_blank" href="/mz"><img src="{{get_img_path('images/shang12015.jpg')}}" alt=""></a></li>
                <li><a target="_blank" href="{{$mydc or route('index')}}"><img src="{{get_img_path('images/shang12016.jpg')}}" alt=""></a></li>
            </ul>

            <ul style="width:760px;margin:0 auto" class="sm fn_clear">
                <li><img src="{{get_img_path('images/shang12017.jpg')}}" alt=""></li>
                <li><img src="{{get_img_path('images/shang12018.jpg')}}" alt=""></li>

            </ul>

        </div>


    </div>

    <style type="text/css">
        .footer-box ul.cc li{width: 200px;height: 80px;float: left;margin:75px 0 75px  75px;}
        .footer-box ul.sm li{width: 170px;height: 210px;float: left;margin:0 0 0px  150px;*margin-top: 75px;}

    </style>
    <!-- 加入购物车弹出层begin -->
    <div class="comfirm_buy" style="display:none;" id="shopping_box">
        <div class="content_buy" ><a href="#" class="success"></a>
            <h4>&nbsp;</h4>
            <p class="tip_txt" alt="" title="">&nbsp;</p>

            <p class="login_p tab_p1" style="display: none;">
                <a class="login_a again" >继续购物</a> <a href="{{route('cart.index')}}">去结算 ></a>
            </p>

            <p class="login_p tab_p2" style="display: none;">
                <a href="/auth/login" class="login_a" >登录</a> <a href="/auth/register">注册</a>
            </p>

            <p class="login_p tab_p3" style="display: none;">
                <a href="requirement.php" class="login_a" >去登记</a> <a class="login_a again">取消</a>
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
