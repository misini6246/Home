<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css"/>
    <link rel="stylesheet" type="text/css" href="/layer/mobile/need/layer.css"/>
    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="/xiangqing/AAS.js" type="text/javascript" charset="utf-8"></script>
    <script src="/js/new/change_num.js" type="text/javascript" charset="utf-8"></script>
    <title>端午节活动</title>
</head>
<style>
    body{
        background: #40c8ce;
    }
    header img,footer img{
        width: 100%;
    }
    footer{
      position: relative;
      z-index: -1;
    }
    footer img{
      position: absolute;
      bottom: -200px;
    }
    .youhui{

    }
    .youhui .header,.youhui .content,.list .header{
        text-align: center;
    }
    .youhui .content img{
      max-width: 100%;
    }
    .list {
      width: 100%;
      margin: 0 auto;
      padding: 0 0 100px 0;
      background-size: 100%;
    }

    .list ul {
      width: 1200px;
      margin: 0 auto;
      margin-top: 86px;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .list ul li {
      width: 585px;
      height: 380px;
      margin-top: 10px;
      background-color: #e5fad9;
      border: solid 3px #718a75;
      display: flex;
    }

    .list ul li .left {
      width: 290px;
      display: flex;
      align-items: center;
      background: #fff;
    }
    .list ul li .left img{
      width: 100%;
    }
    .list ul li .right {
      margin-left: 20px;
      margin-top: 20px;
      font-family: PingFang-SC-Regular;
      font-size: 14px;
      color: #35701a;
    }

    .list ul li .right > p {
      margin-top: 14px;
    }

    .list ul li .right .name {
      font-size: 28px;
      font-weight: bold;
    }

    .list ul li .right .sccj {
      margin-top: 30px;
    }

    .list ul li .right .jg .hdj {
      font-size: 20px;
      color: #ff0000;
      font-weight: bold;
    }

    .list ul li .right .jg .hdj > span {
      width: 32px;
      height: 20px;
      border: solid 1px #ff0000;
      padding: 1px;
    }

    .list ul li .right .jg .yj {
      margin-left: 8px;
      font-size: 12px;
      color: #333333;
    }

    .list ul li .right .btn-box {
      display: flex;
      margin-top: 24px;
    }

    .list ul li .right .btn-box .jiajian {
      display: flex;
    }

    .list ul li .right .btn-box .jiajian input {
      width: 45px;
      height: 31px;
      font-size: 14px;
      text-align: center;
      color: #000;
    }

    .list ul li .right .btn-box .jiajian .jiajian_btn {
      margin-left: 5px;
    }

    .list ul li .right .btn-box .jiajian .jia,
    .list ul li .right .btn-box .jiajian .jian {
      cursor: pointer;
    }

    .list ul li .right .btn-box .add-cart {
      width: 105px;
      height: 31px;
      margin-left: 12px;
      background-color: #ffffff;
      border: solid 1px #88b799;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #ff0000;
    }

    .list ul li .right .btn-box .add-cart img {
      width: 22px;
    }

    .list .tip {
      width: 100%;
      margin-top: 10px;
      font-family: MicrosoftYaHei;
      font-size: 12px;
      text-align: right;
      color: #b3c8af;
    }
    @media screen and (max-width: 800px){
      .youhui .header img,.list .header img{
        max-width: 100%;
      }
      ul{
        width: 100% !important;
        display: block !important;
      }
      ul li{
        max-width: 100%;
        height: auto !important;
        margin: 0 auto;
      }
    }
</style>
<body>
{{-- 顶部 --}}
    <header>
        <img src="/huodong/201906/img/top.jpg" alt="">
    </header>
    {{-- 优惠券 --}}
    <div class="youhui">
        <div class="header">
            <img src="/huodong/201906/img/header1.png" alt="">
        </div>
        <div class="content">
            <a href="http://www.jyeyw.com/yhq" target="_blank"><img src="/huodong/201906/img/youhui.jpg" alt=""></a>
        </div>
    </div>
    <div class="list">
        <div class="header">
            <img src="/huodong/201906/img/header2.png" alt="">
        </div>
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
                    {{-- 限购 --}}
                    <p class="xg">
                      @if ($v->xg_type==1)
                        单张订单限购数量：{{$v->ls_ggg}}                        
                      @elseif($v->xg_type==2)
                        {{date("Y-m-d",$v->xg_start_date)}}至{{date("Y-m-d",$v->xg_end_date)}}限购数量：{{$v->ls_ggg}}
                      @elseif($v->xg_type==3)
                        每天限购数量：{{$v->ls_ggg}}
                      @elseif($v->xg_type==4)
                        每周限购数量：{{$v->ls_ggg}}
                      @endif
                    </p>
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
    <footer>
        <img src="/huodong/201906/img/bottom.jpg" alt="">
    </footer>
</body>

</html>
<script>
  var _hmt = _hmt || [];
  (function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?03e7fad6559fdc4b1fb26c880c76f802";
    var s = document.getElementsByTagName("script")[0]; 
    s.parentNode.insertBefore(hm, s);
  })();
  </script>
  