@extends('layout.body')

@section('links')
    <!-- <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css"/> -->

    <link rel="stylesheet" href="{{path('/demo2/css/com-css.css')}}">
    <!-- <link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css"/> -->
    <link rel="stylesheet" href="{{path('/demo2/layer/mobile/need/layer.css')}}">
    <link rel="stylesheet" href="{{path('/demo2/css/ccxsj.css')}}">

    <!-- <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script> -->
    <script src="{{path('/demo2/js/jQuery-1.8.3.min.js')}}"></script>
    <!-- <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script> -->
    <script src="{{path('/demo2/layer/layer.js')}}"></script>
    <!-- <script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script> -->
    <script src="{{path('/demo2/js/AAS.js')}}"></script>
    <!-- <script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script> -->
    <script src="{{path('/demo2/js/change_num.js')}}"></script>
@endsection
@section('content')
    <!-- 顶部 -->
    <header>
        <img src="{{path('/demo2/img/top.jpg')}}" alt="">
    </header>
    <div class="list">
        <ul>
        @foreach($goods as $k=>$v)
                <li>
                        <div class="left">
                            <a href="http://www.jyeyw.com/goods?id={{$v->goods_id}}" target="_blank"><img src="http://112.74.176.233/{{$v->goods_thumb}}" alt=""></a>
                        </div>
                        <div class="right">
                            <!-- 商品名 -->
                            <p class="name">{{$v->goods_name}}</p>
                            <!-- 生产厂家 -->
                            <p class="sccj">{{$v->produc_name}}</p>
                            <!-- 商品规格 -->
                            <p class="spgg">规格：{{$v->ypgg}}</p>
                            <!-- 件装量 -->

                            <p class="jzl">件装量：    @foreach($v->attr as $val){{$val->attr_value}} @endforeach</p>

                            <!-- 效期 -->
                            <p class="xq">效期：{{$v->xq}}</p>
                            <!-- 价格 -->
                            <p class="jg">
                                <!-- 活动价 -->
                                <span class="hdj"> <span>特价</span> ￥{{$v->promote_price}}</span>
                                <!-- 原价 -->
                                @if($v->shop_price)
                                <span class="yj">原价:￥<span style="text-decoration:line-through">{{$v->shop_price}}</span></span>
                                 @endif
                            </p>
                            <!-- 库存 -->
                            <p class="kc">库存：{{$v->goods_number}}</p>
                            <!-- 中包装 -->
                            <p class="zbz">中包装：{{$v->ls_gg}}</p>
                            <div class="btn-box">
                                <!-- 加减 -->
                                <div class="jiajian">

                                    <input id="J_dgoods_num_{{$v->goods_id}}" type="text" value="1" class="input_val"
                                           data-zbz="1" data-kc="350" data-jzl="100" data-xl="100" data-isxl="0" />
                                    <div class="jiajian_btn">
                                        <div class="jia">
                                            <img src="demo2/img/up.png" alt="">
                                        </div>
                                        <div class="jian min">
                                            <img src="/demo2/img/down.png" alt="">
                                        </div>
                                    </div>
                                </div>
                                <!-- 加入购物车 -->
                                <div class="add-cart" data-img="{{$v->goods_thumb}}"
                                     onclick="tocart('{{$v->goods_id}}','{{$v->product_id}}')">
                                    <img src="demo2/img/cart.png" /> 加入购物车
                                </div>
                            </div>
                        </div>
                    </li>
    @endforeach
        </ul>
    </div>
    <footer>
        <img src="demo2/img/bottom.jpg" alt="">
    </footer>
@endsection