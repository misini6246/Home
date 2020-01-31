<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css"/>
    <link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css"/>
    <link rel="stylesheet" type="text/css" href="/huodong/april/css/ccxsj.css"/>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
    <script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>
    <title>4月秒杀</title>
</head>

<body>
    <!-- 顶部 -->
    <header>
        <img src="/huodong/april/img/top.jpg" alt="">
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
                    <p class="sccj">{{$v->product_name}}</p>
                    <!-- 商品规格 -->
                    <p class="spgg">规格：{{$v->ypgg}}</p>
                    <!-- 件装量 -->
                    <p class="jzl">件装量：{{$v->jzl or ''}}</p>
                    <!-- 效期 -->
                    <p class="xq">效期：{{$v->xq}}</p>
                    <!-- 价格 -->
                    <p class="jg">
                        <!-- 活动价 -->
                        <span class="hdj"> <span>秒杀</span>￥{{$v->promote_price}}
                        </span>
                        <!-- 原价 -->
                        <span class="yj">原价:￥<span style="text-decoration:line-through">￥{{$v->shop_price}}
                        </span></span>
                    </p>
                    <!-- 库存 -->
                    <p class="kc">库存：
                        @if($v->goods_number>800)
                        充裕@elseif($v->goods_number==0)缺货@else{{$v->goods_number}}@endif
                    </p>
                    <!-- 中包装 -->
                    <p class="zbz">中包装：{{$v->zbz or 1}}</p>
                    <div class="btn-box">
                        <!-- 加减 -->
                        <div class="jiajian">

                            <input id="J_dgoods_num_{{$v->goods_id}}" type="text" value="1" class="input_val"
                                data-zbz="1" data-kc="350" data-jzl="100" data-xl="100" data-isxl="0" />
                            <div class="jiajian_btn">
                                <div class="jia">
                                    <img src="/huodong/april/img/up.png" alt="">
                                </div>
                                <div class="jian min">
                                    <img src="/huodong/april/img/down.png" alt="">
                                </div>
                            </div>
                        </div>
                        <!-- 加入购物车 -->
                        <div class="add-cart" data-img="{{$v->goods_thumb}}"
                            onclick="tocart('{{$v->goods_id}}')">
                            <img src="/huodong/april/img/cart.png" /> 加入购物车
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
        </ul>
    </div>
</body>

</html>