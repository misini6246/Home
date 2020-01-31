@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/change_bigImg.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/pagination.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/integral_buy.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/dialog_addCart.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/pagination.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/change_bigImg.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/integral_buy.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/dialog_addCart.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/wait.js')}}"></script>
    <!--[if lte IE 6]>
    <script type="text/javascript" src="{{path('jfen/js/EvPng.js')}}"></script>
    <script type="text/javascript">
        EvPNG.fix(".hot_top_num");
    </script>
    <![endif]-->
@endsection
@section('content')
@include('layout.jf_header')
<div class="exchange">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">{{$goods->name}}</span></p>
    <div class="exchange_main clear_float">
        <div class="exchange_things">
            <div class="proviewbox">
                <div class="probigshow">
                    <a ref="@if(isset($goods->goodsImg[0])){{path('jfen')}} @endif" id="daimg" href="javascript:;" class="a_probigshow">
                        <img width="435" height="435" id="daimgok" class="js_goods_image_url" alt="" src="@if(isset($goods->goodsImg[0])){{get_img_path('jf/'.substr($goods->goodsImg[0]->img,1))}} @endif" original="@if(isset($goods->goodsImg[0])){{get_img_path('jf/'.substr($goods->goodsImg[0]->img,1))}} @endif"> </a>
                    <div class="zoomplepopup"></div>
                    <div id="probig_preview"><img width="800" height="800" src="@if(isset($goods->goodsImg[0])){{get_img_path('jf/'.substr($goods->goodsImg[0]->img,1))}} @endif"></div></div>
            </div>
            <div class="div_prothumb">
                <div class="thumbporbox">
                    <ul class="ul_prothumb">
                        @foreach($goods->goodsImg as $k=>$v)
                        @if($k==0)<li class="now">@else<li>@endif<a target="_blank" href="{{get_img_path('jf/'.substr($v->img,1))}}">
                                <img width="60" height="60" alt="" src="{{get_img_path('jf/'.substr($v->small_img,1))}}" longdesc="{{get_img_path('jf/'.substr($v->small_img,1))}}"
                                     original="{{get_img_path('jf/'.substr($v->small_img,1))}}">
                            </a></li>
                        @endforeach
                    </ul>
                </div>
                <span class="span_prev span_prevb"></span><span class="span_next span_nextb"></span></div>
        </div>
        <div class=" exchange_things_info">
            <p class="eti_name goods_name">{{$goods->name}}</p>
            <ul>
                <li class="eti_price"><span class="align">市场</span>价：<span class="goods_price">{{formated_price($goods->market_price)}}</span></li>
                <li class="eti_integral"><span class="align">所需积</span>分：<span class="need_record">{{$goods->jf}}</span></li>
                <li class="eti_num"><span class="align">库</span>存：{{$goods->goods_stock}}<span class="has_num"></span></li>
                <!--<li class="eti_area"><span class="align">配送范</span>围：<span class="send_area">全国(港澳台地区除外)</span></li>-->
                <li class="exchange_num">
                    <span class="align">兑换数</span>量：
                    <!--10-9-->
                    <button class="del1"></button><!--
                            --><input type="text" value="1"/><!--
                            --><button class="add1"></button>
                    <!--end-->
                </li>
            </ul>
            <div class="eti_choose">
                <button class="reset_button add_to_cart" data-id="{{$goods->id}}">加入礼品车</button><!--
                        --><!--<button class="reset_button direct_pay" data-id="{$goodsdetail.id}">收藏</button>-->
            </div>
        </div>
    </div>
    <div class="exchange_btm clear_float">
        <div class="exchange_hotList">
            <div class="exchange_hotList_title"><img src="{{path('jfen/images/hot_exchange.png')}}" alt=""/></div>
            @foreach($Top5 as $k=>$v)
                <div class="exchange_hotList_list clear_float">
                    <div><img src="{{path('jfen/images/hot_top'.$k.'.png')}}" alt="" class="hot_top_num"/></div>
                    <div class="hot_things">
                        <a href="{{route('jf.goods',['id'=>$v->id])}}" class="ehl_img" target="_blank" title="{{$v->name}}"><img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}" alt="" width="60" height="60"/></a>
                        <div class="hot_things_msg">
                            <a href="{{route('jf.goods',['id'=>$v->id])}}" target="_blank" title="{{$v->name}}">{{$v->name}}</a>
                            <p><span>{{$v->jf}}积分</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="exchange_goods_detail">
            <div class="egd_nav">
                <div class="nav_strip"></div>
                <div class="nav_white_strip"></div>
                <ul class="clear_float" id="egd_nav_ul">
                    <li class="bg_c"><p>商品详情</p></li>
                    <!--<li><p>顾客评价（<span class="evaluation_num">0</span>）</p></li>-->
                    <!--<li><p style="border-right: 0;width: 121px">兑换记录（<span class="record_num">0</span>）</p></li>-->
                </ul>
                <div class="egd_msg_diff">
                    <div class="egd_msg_detail">
                        <div class="egd_msg">
                            <p>商品名称：<span>{{$goods->name}}</span></p>
                            <p>上架时间：<span>{{date('Y-m-d H:i:s',$goods->add_time)}}</span></p>
                        </div>
                        <div class="egd_img">
                            <div class="egd_img_center">
                                {!! stripslashes($goods->introduction) !!}
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="egd_msg_comment clear_float">
                        <div class="egd_msg_comment_user">
                            <img src="" alt="" width="50" height="50"/>
                            <p>12345</p>
                        </div>
                        <div class="egd_msg_cmt_detail">
                            <p class="egd_msg_grade">
                                <span class="bold_black">评分：</span><i></i><i></i><i></i><span class="egd_msg_time">2014-03-24 09:55:12</span>
                            </p>
                            <p class="egd_msg_evaluate"><span class="bold_black">评价：</span><span>12313</span></p>
                        </div>
                    </div>
                    -->
                    <div class="exchange_record">
                        <table class="exchange_record_table">
                            <!--
                                <thead>
                                <tr>
                                    <th>用户</th>
                                    <th>积分</th>
                                    <th>数量</th>
                                    <th>兑换时间</th>
                                    <th>状态</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr>
                                    <td>li***l</td>
                                    <td>19000</td>
                                    <td>1</td>
                                    <td>2014-03-24 09:55:34</td>
                                    <td>成交</td>
                                </tr>
                                <tr>
                                    <td>li***l</td>
                                    <td>19000</td>
                                    <td>1</td>
                                    <td>2014-03-24 09:55:34</td>
                                    <td>成交</td>
                                </tr>
                                <tr>
                                    <td>li***l</td>
                                    <td>19000</td>
                                    <td>1</td>
                                    <td>2014-03-24 09:55:34</td>
                                    <td>成交</td>
                                </tr>-->
                            </tbody>
                        </table>
                        <!--分页-->
                        <!--
                        <div class="exchange_record_pagination">
                            <div class="pagination" data-page="10">
                                <ul>
                                    <li class="pagination_toLeft"><button class="reset_btn"></button></li>
                                    <li class="clicked page_num "><a href="javascript:;">1</a></li>
                                    <li class="page_num"><a href="javascript:;">2</a></li>
                                    <li class="page_num"><a href="javascript:;">3</a></li>
                                    <li class="page_num"><a href="javascript:;">4</a></li>
                                    <li class="page_num"><a href="javascript:;">5</a></li>
                                    <li class="pagination_toRight"><button class="reset_btn"></button></li>
                                </ul>
                            </div>
                        </div>-->
                        <!--end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('layout.jf_footer')
@endsection
