@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/search_result.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/dialog_addCart.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/search_result.js')}}"></script>
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
        <p class="search_title">积分在“<span class="search_area">{{jfContent($s)}}</span>”的搜索结果：<!--（<span class="result_num">7</span>）--></p>
        <!--
        <div class="search_nav">
            <p class="also_can">你还可以查找：</p>
            <ul class="clear_float">
                <li><a href="javascript:;">5000积分以下</a></li>
                <li><a href="javascript:;">5000-15000</a></li>
                <li><a href="javascript:;">15000-30000</a></li>
                <li><a href="javascript:;">30000积分以上</a></li>
            </ul>
        </div>
        -->
        <div class="search_result">
            <ul class="etc_class_list clear_float">
                @foreach($search as $v)
                <li>
                    <div class="etc_class_list_img">
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
        <div class="goods_prompt">
            <div class="get_address_title">礼品推荐</div>
            <div class="prompt">
                <button class="prompt_left reset_btn"></button>
                <ul class="clear_float">
                    @foreach(getTj8() as $v)
                    <li><a href="{{route('jf.goods',['id'=>$v->id])}}" target="_blank"><img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}" width="134" height="134" alt=""/></a><p>{{$v->name}}</p></li>
                    @endforeach
                </ul>
                <button class="prompt_right reset_btn"></button>
            </div>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(function(){
        $(".page_nav").hover(function(){
            $(".page_nav_detail").fadeIn(300) ;
        },function(){
            $(".page_nav_detail").fadeOut(300) ;
        }) ;
        $(".etc_class_list_img a img").hover(function(){
            $(this).animate({marginTop: "-5px"},100) ;
        },function(){
            $(this).animate({marginTop: "0"},100) ;
        });
    });
</script>
@include('layout.jf_footer')
@endsection
