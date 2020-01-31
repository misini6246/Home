@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/dialog.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/sure_order.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/sure_order.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/dialog.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/wait_alert.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_homepage.js')}}"></script>

@endsection
@section('content')
@include('layout.jf_header')
<div class="sure_order">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">我的礼品车</span></p>
    <div class="look_step">
        <ul class="clear_float cross">
            <li>1.查看礼品车</li>
            <li style="color: #fff">2.确认订单信息</li>
            <li>3.确认兑换</li>
            <li>4.确认收货</li>
        </ul>
    </div>
    <div class="sure_order_real">
        <p class="sor_title clear_float"><button class="reset_btn manage_address">管理收货地址</button><span>确认收货地址</span></p>
        <ul class="sure_order_real_d">
            <li>
                <div class="send_to clear_float">
                    <div class="send_bg"></div>
                    <div class="send_detail">
                        <!--<div class="change_this_address"><a href="javascript:;">修改本地址</a><a href="javascript:;">设为默认地址</a></div>-->
                        <div class="to_where" data-id="{{$address->address_id}}">
                            <img class="address_icon" src="{{path('jfen/images/address_icon.png')}}" alt=""/>
                            <span class="send_to_tips">寄送至 </span>
                            <label><input type="radio" name="send" checked class="send_to_radio"/></label>
                            <span class="address">{{$address->full_address}} {{$address->address}}</span>
                            （<span class="user_name">{{$address->consignee}}</span> 收）
                            <span class="phone_num">{{$address->tel}}</span>
                        </div>
                    </div>
                </div>
            </li>
            @foreach($addressAll as $v)
            <li>
                <div class="to_where" data-id="{{$v->address_id or ''}}">
                    <label><input type="radio" name="send" class="send_to_radio"/></label>
                    <span class="address">{{$v->full_address}} {{$v->address}}</span>
                    （<span class="user_name">{{$v->consignee}}</span> 收）
                    <span class="phone_num">{{$v->tel}}</span>
                </div>
            </li>
            @endforeach
        </ul>
        <button class="use_new_address reset_btn"></button>

        <div class="fill_msg">
            <form action="{{route('jf.newAddress')}}" method="post" id="form">
                {!! csrf_field() !!}
                <label class="clear_float fill_name"><span class="ca_tip">收货人姓名：</span><input class="people" type="text" name="consignee"/><span class="alert">*</span></label>
                <div class="choose_address clear_float">
                    <span class="ca_tip">所在地区：</span>
                    <div class="select choose_select province">
                        <div class="select_choose"><span data-id="0">请选择...</span><i></i></div>
                        <ul class="select_options">
                            <li data-id="0" style="border: 0">请选择...</li>
                            @foreach($province as $v)
                            <li data-id="{{$v->region_id}}">{{$v->region_name}}</li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="select choose_select city">
                        <div class="select_choose"><span data-id="0">请选择...</span><i></i></div>
                        <ul class="select_options"></ul>
                    </div>
                    <div class="select choose_select district">
                        <div class="select_choose"><span data-id="0">请选择...</span><i></i></div>
                        <ul class="select_options"></ul>
                    </div>
                    <span class="alert">*</span>
                </div>
                <label class="clear_float"><span class="ca_tip">街道地址：</span><textarea class="detail_address" cols="100" rows="10" name="address"></textarea><span class="alert">*</span></label>
                <label class="clear_float"><span class="ca_tip">邮政编码：</span><input class="postcode" type="text" name="zipcode"/><span class="alert">*</span></label>
                <label class="clear_float cellphone"><span class="ca_tip">电话：</span><input class="cellphone_num" type="text" name="tel"/><span class="alert">*</span></label>
                <div class="submit">
                    <input type="hidden" name="province" id="province" value=""/>
                    <input type="hidden" name="city" id="city" value=""/>
                    <input type="hidden" name="district" id="district" value=""/>
                    <button class="reset_btn save" data-url="flow.php?step=make">确认提交</button><button class="reset_btn reset">取消重置</button>
                </div>
            </form>
        </div>
        <div class="sure_order_msg">
            <p class="som_title">确认订单信息</p>
            <div class="list_in_car">
                <table>
                    <thead>
                    <tr>
                        <td>商品信息</td>
                        <td>单价（元）</td>
                        <td class="num_head">数量</td>
                        <td>兑换积分</td>
                        <!--<td>运送方式</td>-->
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($goods as $v)
                    <tr>
                        <td class="sure_goods_msg"><img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}" alt="" width="80" height="80"/><p>{{$v->name}}</p></td>
                        <td class="only_price"><p>{{formated_price($v->market_price)}}</p></td>
                        <td class="number"><p>{{$v->num}}</p></td>
                        <td class="need_point"><p>{{$v->num*$v->jf}}</p></td>
                        <!--<td class="send_method">
                            <div class="select choose_select">
                                <div class="select_choose"><span value="3">德邦物流</span><i></i></div>
                                <ul class="select_options">
                                    <li value="1" style="border: 0">郫县</li>
                                    <li value="2">金牛区</li>
                                </ul>
                            </div>
                        </td>-->
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="table_operate clear_float">
                    <div class="to_right">
                        <!--<p>货品总积分：<span class="all_record">0</span>分</p>
                        <p class="is_choose">运费总计：<span class="send_money">0</span>元</p>
                        <p class="is_choose">应付兑换分（不含运费）：<span class="pay_record">0</span>分</p>-->
                    </div>
                    <label class="give_us_msg">给我们留言：<input type="text"/><span>可以给我们你的特殊要求</span></label>
                </div>
            </div>
        </div>
    </div>
    <div class="send_msg">
        <form action="{{route('jf.done')}}" method="post" id="orderForm">
            {!! csrf_field() !!}
        <button class="reset_btn sub_order" type="button">提交订单</button>
            <input type="hidden" name="addressId" id="addressId"/>
            <input type="hidden" name="message" id="message"/>
        </form>
        <div class="send_msg_to">
            <img src="{{path('jfen/images/address_icon1.png')}}" alt=""/><span class="send_to_tips">寄送至：</span><span class="address">{{$address->full_address}} {{$address->address}}</span>（<span class="user_name">{{$address->consignee}}</span> 收）<span class="phone_num">{{$address->tel}}</span>
            <span class="the_last_record">实兑换积分：<span>{{$totalJf}}</span>分</span>
        </div>
    </div>
</div>
</div>
@include('layout.jf_footer')
@endsection
