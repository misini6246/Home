@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/dialog.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_gift_car.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_gift_car.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/dialog.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/wait_alert.js')}}"></script>

    <!--[if lte IE 6]>
    <script type="text/javascript" src="{{path('jfen/js/EvPng.js')}}"></script>
    <script type="text/javascript">
        EvPNG.fix(".hot_top_num");
    </script>
    <![endif]-->

@endsection
@section('content')
@include('layout.jf_header')
<div class="car_list">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">我的礼品车</span></p>
    <div class="look_step">
        <ul class="clear_float cross">
            <li style="color: #fff">1.查看礼品车</li>
            <li>2.确认订单信息</li>
            <li>3.确认兑换</li>
            <li>4.确认收货</li>
        </ul>
    </div>
    <div class="car_list_detail">
        <div class="cld_topNav clear_float" style="">
            <div class="pay">已选商品：<span class="choose_record">0</span>积分</div>
            <button class="reset_btn all_list">全部商品<!--(<span class="all_list_num">3</span>)--></button><!--<button
                    class="reset_btn lack">库存紧张(<span class="lack_num">0</span>)</button>-->
        </div>
        <div class="list_in_car">
            <table>
                <thead>
                <tr>
                    <td><label class="all_select"><input type="checkbox"/>全选</label></td>
                    <td>商品信息</td>
                    <td>库存</td>
                    <td class="num_head">数量</td>
                    <td>所需积分</td>
                    <td>操作</td>
                </tr>
                </thead>
                <tbody>
                @foreach($goods as $v)
                <tr class="del" data-jf="{{$v->jf}}" data-id="{{$v->goods_id}}" >
                    <td class="check_goods"><label><input type="checkbox" data-id="{{$v->goods_id}}" /><img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}" width="80" height="80" alt=""/></label></td>
                    <td class="goods_msg"><p>{{$v->goods_name}}</p></td>
                    <td class="remain"><p>{{$v->goods->goods_stock}}</p></td>
                    <td><p><button class="reset_btn del1">－</button><label class="choose_every_label"><input type="text" value="{{$v->goods_num}}" class="choose_every_num"/></label><button class="reset_btn add1">＋</button></p></td>
                    <td class="need_point"><p>{{$v->jf*$v->goods_num}}</p></td>
                    <td class="operate">
                        <div>
                            <!--<a class="reset_btn move_to" href="javascript:;">移入收藏夹</a>-->
                            <button class="reset_btn remove_goods" data-id="{{$v->id}}">删除</button>
                        </div>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="table_operate clear_float">
                <div class="all_goods_msg">
                    <p class="show_sth">请勾选你需要结算的商品！</p>
                    <p class="is_choose">已选商品<span class="choose_num">0</span>件</p>
                    <p>合计<span class="choose_record">0</span>分</p>
                    <button class="reset_btn pay_btn">结算</button>
                </div>
                <div class="t_op">
                    <label class="all_select"><input type="checkbox"/>全选</label>
                    <!--<button class="reset_btn delete_goods">删除</button>
                    <button class="reset_btn move_to_collect">移入收藏夹</button>-->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@include('layout.jf_footer')
@endsection
