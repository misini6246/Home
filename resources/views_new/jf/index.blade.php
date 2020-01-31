@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/integral.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/dialog_addCart.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/slide.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/integral.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/dialog_addCart.js')}}"></script>
    <!--[if lte IE 6]>
    <script type="text/javascript" src="{{path('jfen/js/EvPng.js')}}"></script>
    <script type="text/javascript">
        EvPNG.fix(".hot_top_num");
    </script>
    <![endif]-->
@endsection
@section('content')
@include('layout.jf_header')

<!--幻灯片-->
<div class="slide">
    <div class="left50">
        <div class="slide_detail">
            @foreach($focusList as $v)
            <a href="{{$v->url}}" target='_blank'><img src="{{get_img_path('jf/'.substr($v->img,1))}}" width="1800" height="412"/></a>
            @endforeach
        </div>
        <div class="slide_bottom"><img src="{{path('jfen/images/slide_bottom.jpg')}}" alt=""/></div>
        <ul class="slide_num" id="slide_num">
            @foreach($focusList as $k=>$v)
            @if($k==0)<li data-value="{{$k+1}}" class="on">@else<li data-value="{{$k+1}}">@endif <div class="touming">{{$k+1}}</div><div class="bgw"></div></li>
            @endforeach
        </ul>
    </div>
</div>
<!--end-->
<div class="exchange clear_float">
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
        <img src="{{path('jfen/images/scan.jpg')}}" alt="" class="erweima"/>
    </div>
    <div class="exchange_things">
        <div class="exchange_things_class">
            <div class="etc_title1"><img src="{{path('jfen/images/exchange1.png')}}" alt=""/></div>
            <ul class="etc_class_list clear_float">
                @foreach(catGoods(1) as $k=>$v)
                    @if($k==0)<li style="margin-left: 1px">@else<li>@endif<div class="etc_class_list_img">
                            <a href="{{route('jf.goods',['id'=>$v->id])}}" target="_blank"><img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}" alt="" width="143" height="143"/></a>
                            <div class="etc_class_list_info">
                                <p class="things_name">{{$v->name}}</p>
                                <p class="things_price">参考价：<span>{{formated_price($v->market_price)}}</span></p>
                            </div>
                        </div>
                        <div class="etc_class_list_msg">
                            <a href="javascript:;" data-id="{{$v->id}}"><img src="{{path('jfen/images/gwc_red.png')}}" alt=""/>加入礼品车</a>
                            <p class="etc_realPrice">兑换积分：{{$v->jf}}分</p>
                        </div>
                    </li>
                    @endforeach
            </ul>
        </div>
        <div class="exchange_things_class">
            <div class="etc_title1"><img src="{{path('jfen/images/exchange2.png')}}" alt=""/></div>
            <ul class="etc_class_list clear_float">
                @foreach(catGoods(2) as $k=>$v)
                @if($k==0)<li style="margin-left: 1px">@else<li>@endif<div class="etc_class_list_img">
                        <a href="{{route('jf.goods',['id'=>$v->id])}}" target="_blank"><img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}" alt="" width="143" height="143"/></a>
                        <div class="etc_class_list_info">
                            <p class="things_name">{{$v->name}}</p>
                            <p class="things_price">参考价：<span>{{formated_price($v->market_price)}}</span></p>
                        </div>
                    </div>
                    <div class="etc_class_list_msg">
                        <a href="javascript:;" data-id="{{$v->id}}"><img src="{{path('jfen/images/gwc_red.png')}}" alt=""/>加入礼品车</a>
                        <p class="etc_realPrice">兑换积分：{{$v->jf}}分</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="exchange_things_class">
            <div class="etc_title1"><img src="{{path('jfen/images/exchange3.png')}}" alt=""/></div>
            <ul class="etc_class_list clear_float">
                @foreach(catGoods(3) as $k=>$v)
                    @if($k==0)<li style="margin-left: 1px">@else<li>@endif<div class="etc_class_list_img">
                            <a href="{{route('jf.goods',['id'=>$v->id])}}" target="_blank"><img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}" alt="" width="143" height="143"/></a>
                            <div class="etc_class_list_info">
                                <p class="things_name">{{$v->name}}</p>
                                <p class="things_price">参考价：<span>{{formated_price($v->market_price)}}</span></p>
                            </div>
                        </div>
                        <div class="etc_class_list_msg">
                            <a href="javascript:;" data-id="{{$v->id}}"><img src="{{path('jfen/images/gwc_red.png')}}" alt=""/>加入礼品车</a>
                            <p class="etc_realPrice">兑换积分：{{$v->jf}}分</p>
                        </div>
                    </li>
                    @endforeach
            </ul>
        </div>
        <div class="exchange_things_class">
            <div class="etc_title1"><img src="{{path('jfen/images/exchange4.png')}}" alt=""/></div>
            <ul class="etc_class_list clear_float">
                @foreach(catGoods(4) as $k=>$v)
                    @if($k==0)<li style="margin-left: 1px">@else<li>@endif<div class="etc_class_list_img">
                            <a href="{{route('jf.goods',['id'=>$v->id])}}" target="_blank"><img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}" alt="" width="143" height="143"/></a>
                            <div class="etc_class_list_info">
                                <p class="things_name">{{$v->name}}</p>
                                <p class="things_price">参考价：<span>{{formated_price($v->market_price)}}</span></p>
                            </div>
                        </div>
                        <div class="etc_class_list_msg">
                            <a href="javascript:;" data-id="{{$v->id}}"><img src="{{path('jfen/images/gwc_red.png')}}" alt=""/>加入礼品车</a>
                            <p class="etc_realPrice">兑换积分：{{$v->jf}}分</p>
                        </div>
                    </li>
                    @endforeach
            </ul>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function(){
        slide($(".slide"),5000);//幻灯片
        $(".page_nav").hover(function(){
            $(".page_nav_detail").fadeIn(300);
        }, function(){
            $(".page_nav_detail").fadeOut(300);
        }) ;
        $(".etc_class_list_img a img").hover(function(){
            $(this).animate({marginTop: "-5px"},100);
        },function(){
            $(this).animate({marginTop: "0"},100);
        });
    });
</script>
@include('layout.jf_footer')
@endsection
