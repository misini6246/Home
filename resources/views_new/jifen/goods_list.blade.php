@extends('jifen.layouts.body')
@section('links')
    <link href="{{path('css/jifen/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jifen/lipinliebiao.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/jifen/add_to_cart.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('jifen.layouts.header')
    @include('jifen.layouts.nav')
    <div class="container content">
        <div class="content_box">
            <div class="sx_box">
                <div class="sx_box_top">
                    <div class="sx_box_title">类&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;别：</div>
                    <ul>
                        @foreach($cate as $k=>$v)
                            <li @if($k==$cate_id)class="active"@endif>
                                <a href="{{route('jifen.goods.index',['cate_id'=>$k,'range_id'=>$range_id])}}">{{$v}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="sx_box_top sx_bottom">
                    <div class="sx_box_title">积分范围：</div>
                    <ul>
                        @foreach($jifen_range as $k=>$v)
                            <li @if($k==$range_id)class="active"@endif>
                                <a href="{{route('jifen.goods.index',['cate_id'=>$cate_id,'range_id'=>$k])}}">{{$v['text']}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <ul class="product_list">
                @foreach($result as $v)
                    <li>
                        <div class="img_box">
                            <a target="_blank" href="{{route('jifen.goods.show',['id'=>$v->id])}}"><img
                                        src="{{get_img_path('jf/'.substr($v->goods_image,1))}}"/></a>
                        </div>
                        <p class="name">{{$v->name}}</p>
                        <p class="ck">参考价：<span>{{formated_price($v->market_price)}}</span></p>
                        <p class="jf">
                            <img src="{{get_img_path('images/jf/jrgwc_03.png')}}" class="fr"
                                 onclick="add_to_cart('{{$v->id}}',1)"/>
                            {{$v->jf}}积分
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    @include('jifen.layouts.footer')
@endsection
