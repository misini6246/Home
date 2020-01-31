@extends('layout.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link href="{{path('css/cart/gwc_1.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('js/index/lb.js')}}"></script>
    <script type="text/javascript" src="{{path('js/cart/gwc_1.js')}}"></script>
@endsection
@section('content')
    @include('cart.header')
    <div id="gwc_1" class="container">
        <div class="container_box">
            <div class="gwc_title">
                我的购物车
            </div>
            @if(count($goods_list)>0)
                <div class="gwc_content">
                    <div class="title_list">
                        <ul>
                            <li class="active">
                                <a href="javascript:;">全部商品<span class="n">{{count($goods_list)}}</span></a>
                            </li>
                            {{--<li>--}}
                            {{--<a href="#">促销商品<span class="n">1</span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<a href="#">精品专区<span class="n">1</span></a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<a href="#">秒杀商品</a>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                            {{--<a href="#">库存紧张<span class="n">1</span></a>--}}
                            {{--</li>--}}
                        </ul>
                        <div class="fr">
                            已选商品（不含运费）<span class="heji">{{formated_price($total['shopping_money'])}}</span>
                            <a href="#" class="jiesuan">结算</a>
                        </div>
                    </div>
                    <div class="content">
                        <ul class="table_title">
                            <li class="input"><input type="checkbox" name="qx_1" id="Checkbox1" class="allselect"/></li>
                            <li class="img_box"><label for="qx_1">全选</label></li>
                            <li class="spxx">商品信息</li>
                            <li class="dj">单价</li>
                            <li class="kc">库存</li>
                            <li class="sl">数量</li>
                            <li class="xj">小计</li>
                            <li class="cz">操作</li>
                        </ul>
                        <ul class="content_list gwc_tb2">
                            @foreach($goods_list as $v)
                                <li id="li_{{$v->rec_id}}" data-id="{{$v->rec_id}}" data-jp="{{$v->goods->is_jp}}"
                                    class="xuanzhongzt">
                                    <div class="input"><input name="newslist" type="checkbox"/></div>
                                    <div class="img_box">
                                        <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                    src="{{$v->goods->goods_thumb}}"/></a>
                                        @if($v->goods_number==0)
                                            <div class="zt">缺货</div>
                                        @endif
                                    </div>
                                    <div class="spxx">
                                        <div class="name">
                                            <p>
                                                <a href="{{$v->goods->goods_url}}">{{$v->goods->goods_name}}</a>
                                            </p>
                                            @if($v->goods->is_cx)
                                                <span class="bs xq">特价</span>
                                            @endif
                                            @if($v->goods->zyzk>0)
                                                <span class="bs yh">优惠</span>
                                            @endif
                                            @if($v->goods->is_jp)
                                                <span class="bs xq">精品</span>
                                            @endif
                                            @if($v->goods->tsbz=='预')
                                                <span class="bs xq">预售</span>
                                            @endif
                                            @if($v->goods->tsbz=='秒')
                                                <span class="bs xq">秒杀</span>
                                            @endif
                                        </div>
                                        <div class="gg">
                                            <p>规格：{{$v->goods->spgg}}</p>
                                            <p>中包装：{{$v->goods->zbz}}</p>
                                            <p>{{$v->goods->sccj}}</p>
                                        </div>
                                        <div class="xq">
                                            <p class="daoqi">效期：{{$v->goods->xq}}</p>
                                            <p>件装量：{{$v->goods->jzl}}</p>
                                        </div>
                                    </div>
                                    <div class="dj">
                                        ￥<span>{{$v->goods_price}}</span>
                                    </div>
                                    <div class="kc">
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
                                    </div>
                                    <div class="sl">
                                    <span @if($v->is_can_change==1)onclick="reduce_num({{$v->rec_id}})"
                                          @endif class="jian min">-</span><input id="goods_num_show_{{$v->rec_id}}"
                                                                                 type="text"
                                                                                 value="{{$v->goods_number}}"
                                                                                 class="input_val"
                                                                                 data-zbz="{{$v->zbz}}"
                                                                                 data-kc="{{$v->goods->goods_number}}"
                                                                                 data-jzl="{{$v->jzl}}"
                                                                                 data-xl="{{$v->goods->xg_num}}"
                                                                                 data-isxl="{{$v->goods->is_xg}}"
                                                                                 data-goods_id="{{$v->goods_id}}"
                                                                                 @if($v->is_can_change==1)onblur="changePrice_ls({{$v->rec_id}})"
                                                                                 @else disabled @endif/><span
                                                @if($v->is_can_change==1)onclick="add_num({{$v->rec_id}})" @endif
                                        class="jia">+</span>
                                    </div>
                                    <div class="xj">
                                        <span id="subtotal_{{$v->rec_id}}">{{formated_price($v->goods_number*$v->goods->real_price)}}</span>
                                    </div>
                                    <div class="cz">
                                        <p class="sc" onclick="del_to_collection('{{$v->rec_id}}')">移到收藏夹</p>
                                        <p class="del" onclick="del('{{$v->rec_id}}')">删除</p>
                                    </div>
                                    @include('cart.zp_goods')
                                    @if((($v->goods->is_zx==1)&&!empty($v->goods->cxxx))||!empty($v->goods->bzxx)||!empty($v->goods->bzxx2)||$v->goods->tsbz=='预')
                                        <p class="tishi">
                                            注：<span>单次购买本品满20瓶+0.2元可换购本品1瓶（仅限终端客户可享受此换购）</span>
                                        </p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <ul class="warning">
                            <li>温馨提示：请仔细核对商品的名称、数量、规格以及商品有效期，药品为特殊商品非质量问题概不退换！</li>
                            @if(count($tip_info)>0)
                                <li>下列商品由于限购，已从您的购物车删除，如有疑问，请联系客服。</li>
                                @foreach($tip_info as $k=>$v)
                                    <li class="ts_sp_list ts_sp_list_first">
                                        <p class="number">{{$k+1}})，</p>
                                        <p class="name">{{$v->goods->goods_name}}</p>
                                        <p class="company">{{$v->goods->sccj}}</p>
                                        <p class="gg">规格：{{$v->goods->spgg}}</p>
                                        <p class="why">原因：{{$v->message}}</p>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                        <div class="jiesuan_box">
                            <div class="jiesuan_box_left fl">
                                <div class="input fl">
                                    <input type="checkbox" name="qx_2" id="Checkbox2" class="allselect"/>
                                </div>
                                <label for="qx_2" class="fl">全选</label>
                                <div class="js_del" id="del_checked">
                                    <img src="{{get_img_path('images/cart/delete.png')}}"/>
                                    <p>删除选中商品</p>
                                </div>
                                <a href="{{route('cart.del_no_num')}}" class="js_del" id="delete_all">
                                    <img src="{{get_img_path('images/cart/delete-all.png')}}"/>
                                    <p>删除无库存和下架商品</p>
                                </a>
                            </div>
                            <div class="jiesuan_box_right fr">
                                <div class="piece fl">
                                    已选商品<span id="shuliang">{{count($goods_list)}}</span>件
                                </div>
                                <div class="total fl">
                                    精品专区合计：<span class="jp_heji">{{formated_price($total['jp_total_amount'])}}</span>
                                </div>
                                <div class="total fl">
                                    总计(不含运费)：<span class="heji">{{formated_price($total['shopping_money'])}}</span>
                                </div>
                                @if($total['shopping_money'] > 0)
                                <a href="/cart/jiesuan" class="jiesuan" style="color: #00a0e9">结算</a>
                                    @else
                                    <a href="/cart/jiesuan" class="jiesuan">结算</a>
                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="gwc_content">
                    <div class="gwc_none">
                        <img src="{{get_img_path('images/cart/gwc_none.png')}}" alt="">
                        <p>购物车空空的哦~，去看看心仪的商品吧~</p>
                        <p><a href="/">去购物</a></p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @include('layouts.old_footer',['hide_yc'=>1])
@endsection
