@extends('layout.jf_body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/change_bigImg.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_homepage.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/my_page_common.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('jfen/css/dialog.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('jfen/js/jquery-1.7.2.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/dialog.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_page.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/wait_alert.js')}}"></script>
    <script type="text/javascript" src="{{path('jfen/js/my_homepage.js')}}"></script>

@endsection
@section('content')
@include('layout.jf_header')
<div class="content_main">
    <p class="road_nav">您当前的位置： <span>首页</span> >> <span class="goods_name">我的账户</span></p>
    <div class="content_main_all clear_float">
        <p><span class="vip_center">会员中心</span><span class="address_manage">地址管理</span><span class="add_address">添加地址</span></p>
        @include('layout.jfMenu')
        <div class="manage_all_address">
            <div class="all_address">
                <table>
                    <thead>
                    <tr>
                        <td>收货人</td>
                        <td>所在地区</td>
                        <td>街道地址</td>
                        <td>电话</td>
                        <td>邮编</td>
                        <td>操作</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($addressList)>0)
                    @foreach($addressList as $v)
                    <tr data-id="{{$v->address_id}}">
                        <td>{{$v->consignee}}</td>
                        <td>{{$v->full_address}}</td>
                        <td>{{$v->address}}</td>
                        <td>{{$v->tel}}</td>
                        <td>{{$v->zipcode}}</td>
                        <td class="operate"><a href="{{route('jf.address',['id'=>$v->address_id])}}" class="change">修改</a>|<a href="javascript:;" class="del">删除</a><!--|<a href="javascript:;" class="cancel" style="border: 0">取消默认</a>--></td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan='6' class='color_f9'>没有地址！</td></tr>
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="fill_msg">
                <div class="get_address_title">收货地址</div>
                @if($edit!=0)
                <form action="{{route('jf.newAddress')}}" method="post" id="form">
                    {!! csrf_field() !!}
                    <label class="clear_float name"><span class="ca_tip">收货人姓名：</span><input  type="text" class="people" value="{{$address->consignee}}"/><span class="alert">*</span></label>
                    <div class="choose_address clear_float">
                        <span class="ca_tip">所在地区：</span>
                        <div class="select choose_select province">
                            <div class="select_choose"><span data-id="{{$address->province}}">{{$address->regionProvince->region_name}}</span><i></i></div>
                            <ul class="select_options">
                                <li data-id="0" style="border: 0">请选择...</li>
                                @foreach($province as $v)
                                    <li data-id="{{$v->region_id}}">{{$v->region_name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="select choose_select city">
                            <div class="select_choose"><span data-id="{{$address->city}}">{{$address->regionCity->region_name}}</span><i></i></div>
                            <ul class="select_options">
                                <li data-id="0" style="border: 0">请选择...</li>
                                @foreach($address->cityList as $v)
                                    <li data-id="{{$v->region_id}}">{{$v->region_name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="select choose_select district">
                            <div class="select_choose"><span data-id="{{$address->district}}">{{$address->regionDistrict->region_name}}</span><i></i></div>
                            <ul class="select_options">
                                <li data-id="0" style="border: 0">请选择...</li>
                                @foreach($address->districtList as $v)
                                    <li data-id="{{$v->region_id}}">{{$v->region_name}}</li>
                                @endforeach
                            </ul>
                        </div>
                        <span class="alert">*</span>
                    </div>
                    <label class="clear_float"><span class="ca_tip">街道地址：</span><input type="text" class="detail_address" value="{{$address->address}}" name="address"/><span class="alert">*</span></label>

                    <label class="clear_float"><span class="ca_tip">邮政编码：</span><input type="text" class="postcode" value="{{$address->zipcode}}" name="zipcode"/><span class="alert">*</span></label>
                    <label class="clear_float cellphone"><span class="ca_tip">电话：</span><input type="text" class="cellphone_num" value="{{$address->tel}}" name="tel"/><span class="alert">*</span></label>
                    <!--<label class="clear_float"><span class="ca_tip">设为默认：</span><input type="checkbox" class="to_default"/></label>-->
                    <div class="submit">
                        <input type="hidden" name="province" id="province" value=""/>
                        <input type="hidden" name="city" id="city" value=""/>
                        <input type="hidden" name="district" id="district" value=""/>
                        <input type="hidden" name="addressId"  value="{{$address->address_id}}"/>
                        <button class="reset_btn save" data-url="member.php?act=mem_addr" data-edit="{{$edit}}" data-aid="{{$address->address_id}}">保存</button><button class="reset_btn reset">取消</button>
                    </div>
                </form>
                @else
                <form action="{{route('jf.newAddress')}}" method="post" id="form">
                    {!! csrf_field() !!}
                    <label class="clear_float name"><span class="ca_tip">收货人姓名：</span><input type="text" class="people" name="consignee"/><span class="alert">*</span></label>
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
                    <label class="clear_float"><span class="ca_tip">街道地址：</span><input type="text" class="detail_address" name="address"/><span class="alert">*</span></label>

                    <label class="clear_float"><span class="ca_tip">邮政编码：</span><input type="text" class="postcode" name="zipcode"/><span class="alert">*</span></label>
                    <label class="clear_float cellphone"><span class="ca_tip">电话：</span><input type="text" class="cellphone_num" name="tel"/><span class="alert">*</span></label>
                    <!--<label class="clear_float"><span class="ca_tip">设为默认：</span><input type="checkbox" class="to_default"/></label>-->
                    <div class="submit">
                        <input type="hidden" name="province" id="province" value=""/>
                        <input type="hidden" name="city" id="city" value=""/>
                        <input type="hidden" name="district" id="district" value=""/>
                        <button class="reset_btn save" data-url="member.php?act=mem_addr" data-edit="{{$edit}}" data-aid="0">保存</button><button class="reset_btn reset">取消</button>
                    </div>
                </form>
                @endif
            </div>
            @include('layout.tj8')
        </div>
    </div>

</div>
</div>
@include('layout.jf_footer')
@endsection
