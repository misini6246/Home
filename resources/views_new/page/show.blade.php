@extends('layout.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/mh/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/goods/hdzt.css')}}"/>
    <script type="text/javascript" src="{{path('js/zs/lazyload.js')}}"></script>
    <script type="text/javascript" src="{{path('js/goods/AAS.js')}}"></script>
    <script type="text/javascript" src="{{path('js/goods/change_num.js')}}"></script>
    <script type="text/javascript" src="{{path('js/goods/hdzt.js')}}"></script>
    <script type="text/javascript" src="{{path('js/jquery.singlePageNav.min.js')}}"></script>
    <script type="text/javascript" src="{{path('js/goods/navigation.js')}}"></script>
    @if(!empty($info->bg_color))
        <style>
            body {
                background-color: {{$info->bg_color}};
            }
        </style>
    @endif
@endsection
@section('content')
    @include('layoutss.header')
    @include('layoutss.search')
    @include('layoutss.nav_goods')
    <div id="hdzt" class="container">
        @if(!empty($info->top_img))
            <div id="hdzt_banner">
                <img src="{{get_img_upload($info->top_img)}}"/>
            </div>
        @endif
        <div class="container_box">
            @foreach($lanmu as $v)
                @if($v->goods&&count($v->goods)>0)
                    <div id="lanmu_{{$v->lanmu_id}}" class="lanmu">
                        <div class="hdzt_title">
                            <img src="{{get_img_upload($v->bg_img)}}"/>
                        </div>
                        <ul class="datu">
                            @foreach($v->goods as $goods)
                                <li>
                                    <div class="datu-chanpin-img">
                                        <a target="_blank" href="{{$goods->goods_url}}"><img
                                                    src="{{$goods->goods_thumb}}"/></a>
                                    </div>
                                    <div class="datu-jiage">
                                        {{$goods->real_price_format}}
                                    </div>
                                    <div class="datu-mingzi">
                                        {{$goods->goods_name}}
                                    </div>
                                    <div class="datu-compamy">
                                        {{$goods->sccj}}
                                    </div>
                                    <div class="datu-guige">
                                        规格：<span>{{$goods->spgg}}</span>
                                    </div>
                                    <div class="datu-xiaoqi">
                                        效期：<span class="daoqi">{{$goods->xq}}</span> 件装量：
                                        <span class="jianzhuang">{{$goods->jzl}}</span>
                                    </div>
                                    <div class="datu-jianzhuang">
                                        库存：<span>@if($goods->goods_number>=800)充裕@elseif($goods->goods_number==0)
                                                缺货@else{{$goods->goods_number}}@endif</span> 中包装：
                                        <span>{{$goods->zbz}}</span>
                                    </div>
                                    <div class="btn_box">
                                        <div class="datu-jrgwc" onclick="tocart('{{$goods->goods_id}}')">
                                            <img src="{{get_img_path('images/goods/datu_jrgwc.png')}}"/> 加入购物车
                                        </div>
                                        <div class="jiajian">
                                            <div class="jian min">
                                                -
                                            </div>
                                            <input type="text" value="{{$goods->zbz}}" class="input_val"
                                                   data-zbz="{{$goods->zbz}}" data-kc="{{$goods->goods_number}}"
                                                   data-jzl="{{$goods->jzl}}"
                                                   data-xl="{{$goods->xg_num}}" data-isxl="{{$goods->is_xg}}"/>
                                            <div class="jia">
                                                +
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endforeach
            <div class="to_top_box">
                <div class="to_top">
                    <img src="{{get_img_upload($info->totop_img)}}"/>
                </div>
            </div>
        </div>
    </div>
    @include('layoutss.footer')
    @include('layoutss.right')
    @if($info->is_show_nav==1)
        <div id="fixedNavBar">
            <ul>
                @foreach($lanmu as $v)
                    <li>
                        <a href="#lanmu_{{$v->lanmu_id}}">{{$v->name}}</a>
                    </li>
                @endforeach
                <li class="to_top">
                    <img src="{{get_img_upload($info->totop_img1)}}"/>
                </li>
            </ul>
        </div>
    @endif
    <script>
        var show_top = $('#hdzt_banner').offset().top + parseInt($('#hdzt_banner').height() / 2);
        var show_bottom = $('#footer').offset().top - 50;
        $("#fixedNavBar ul").navigation({
            parent: "#fixedNavBar",
            target: [
                @foreach($lanmu as $v)
                    "#lanmu_{{$v->lanmu_id}}",
                @endforeach
            ],
            current: "active",
            top_show: show_top,
            bottom_show: show_bottom
        })
    </script>
@endsection
