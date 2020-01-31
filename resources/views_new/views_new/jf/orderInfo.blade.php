@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_order.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_page_common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/dialog.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_page.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_order.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_homepage.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/dialog.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/wait_alert.js')}}"></script>

@endsection
@section('content')
@include('layout.jf_header')
<div class="content_main">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">我的账户</span></p>
    <div class="content_main_all clear_float">
        <p><span class="vip_center">会员中心</span><span class="address_manage">交易中心</span><span class="reset_btn add_address">我的订单</span></p>
        @include('layout.jfMenu')
        <div class="manage_all_address">
            <div class="maa_o">
                <div class="order_status">
                    <p class="os_head">订单状态</p>
                    <table>
                        <tbody>
                        <tr>
                            <td class="order_status_tip">订单号：</td>
                            <td class="order_status_c">{{$order->order_sn}}</td>
                        </tr>
                        <tr>
                            <td class="order_status_tip">订单状态：</td>
                            <td class="order_status_c os_status"><span>{{$orderState[$order->order_state]}}</span>
                                @if($order->order_state==1)
                                <button class="reset_btn" id="J_pay" data-id="{{$order->id}}" data-step="pay"><img src="{{path('jfen/images/sheep.gif')}}" alt=""/>立即兑换</button>
                                @endif
                                @if($order->order_state==3)
                                <button class="reset_btn" id="J_confir_order" data-id="{{$order->id}}" data-step="confir"><img src="{{path('jfen/images/sheep.gif')}}" alt=""/>确认收货</button>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="order_status_tip">兑换总积分</td>
                            <td class="order_status_c">{{$order->order_amount}}</td>
                        </tr>
                        <tr>
                            <td class="order_status_tip">物流：</td>
                            <td class="order_status_c">@if($order->order_state==3){{$order->shipping}}，（物流单号：{{$order->shipping_code}}）@endif</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <script type="text/javascript">
                    (function($) {
                        $(function() {
                            $('#J_confir_order').click(function() {
                                var $this = $(this) ;

                                var id = $this.attr('data-id') ;
                                var step = $this.attr('data-step') ;
                                if(id == ''){
                                    alert('系统参数错误') ;
                                    return ;
                                }

                                showDialog('是否确定收货？',false, function() {

                                }) ;
                            }) ;

                            $('#J_pay').click(function() {
                                var $this = $(this) ;

                                var id = $this.attr('data-id') ;
                                var step = $this.attr('data-step') ;
                                if(id == ''){
                                    alert('系统参数错误') ;
                                    return ;
                                }

                                showDialog('是否确认兑换？',false, function() {
                                    location.href='{{route('jf.sure',['id'=>$order->id])}}'
                                })
                                /*if(!confirm('是否确定收货？')){
                                 return ;
                                 }*/
                            }) ;
                            /*$('#J_pay').click(function() {
                             var id = $(this).attr('data-id') ;
                             location.href = "index.php?m=pay&a=index&ois=os_"+id ;
                             }) ;*/
                        }) ;
                    })(jQuery) ;
                </script>
                <div class="goods_list order_status">
                    <p class="os_head">商品列表</p>
                    <table>
                        <thead>
                        <tr>
                            <td>商品名称</td>
                            <td>商品数量</td>
                            <td>兑换积分</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->goods as $v)
                        <tr>
                            <td>{{$v->goods_name}}</td>
                            <td>{{$v->goods_num}}</td>
                            <td>{{$v->jf}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>

            <div class="fill_msg">
                <div class="get_address_title">收货地址</div>
                <label class="clear_float name"><span class="ca_tip" style="width:500px;text-align:left;">{{$order->address->name}}，{{$order->address->mob_phone}}，{{$order->address->address}},{{$order->address->zip_code}}</span><!--<input type="text" class="people"/><span class="alert">*</span>--></label>
                <!--
                <div class="choose_address clear_float">
                    <span class="ca_tip">所在地区：</span>
                    <div class="select choose_select">
                        <div class="select_choose"><span value="0">省</span><i></i></div>
                        <ul class="select_options">
                            <li value="1" style="border: 0">四川</li>
                            <li value="2">北京</li>
                        </ul>
                    </div>
                    <div class="select choose_select">
                        <div class="select_choose"><span value="0">市</span><i></i></div>
                        <ul class="select_options">
                            <li value="1" style="border: 0">成都</li>
                            <li value="2">乐山</li>
                        </ul>
                    </div>
                    <div class="select choose_select">
                        <div class="select_choose"><span value="0">区</span><i></i></div>
                        <ul class="select_options">
                            <li value="1" style="border: 0">郫县</li>
                            <li value="2">金牛区</li>
                        </ul>
                    </div>
                    <span class="alert">*</span>
                </div>
               <label class="clear_float"><span class="ca_tip">街道地址：</span><input type="text" class="detail_address"/><span class="alert">*</span></label>
               <label class="clear_float"><span class="ca_tip">邮政编码：</span><input type="text" class="postcode"/><span class="alert">*</span></label>
               <label class="clear_float cellphone"><span class="ca_tip">手机号码：</span><input type="text" class="cellphone_num"/><span class="alert">*</span></label>
               <label class="clear_float"><span class="ca_tip">设为默认：</span><input type="checkbox" class="to_default"/></label>
                <div class="submit">
                    <button class="reset_btn save">保存</button><button class="reset_btn reset">取消</button>
                </div>
                -->
            </div>
            @include('layout.tj8')
        </div>
    </div>
</div>
</div>
@include('layout.jf_footer')
@endsection
