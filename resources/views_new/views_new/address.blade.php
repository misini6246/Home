@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/cart.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/flow-consignee.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/flow.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/region.js')}}"></script>
    <style>
        .cj_type1{width: 1200px;margin: 0 auto;height: 178px;background: url("{{path('images/cj_03.jpg')}}") no-repeat;position:relative;}
        .cj_type2{width: 1200px;margin: 0 auto;height: 178px;background: url("{{path('images/zhongjiang_banner.jpg')}}") no-repeat;position:relative;}
        .cj_type3{width: 1200px;margin: 0 auto;height: 178px;background: url("{{path('images/zhongjiang_banner2.jpg')}}") no-repeat;position:relative;}
        .cj_bm{color: #ff5100;position: absolute;
            top: 75px;
            right: 340px;
            height: 40px;
            width: 200px;
            text-align: left;
            font-size: 24px;}
    </style>
@endsection
@section('content')
    @include('layout.page_header_cart')
    <div class="content">
        @foreach($addressList as $k=>$v)
            <form action="{{route('user.addressUpdate')}}" method="post" name="theForm">
                {!! csrf_field() !!}
                <table cellpadding="0" cellspacing="0">
                    <tr>
                        <th colspan="4">收货人信息</th>
                    </tr>
                    <tr>
                        <td class="title">收货人姓名：</td>
                        <td><input name="consignee" type="text" class="com names" id="consignee_{{$k}}" value="{{$v->consignee or ''}}" /> 必填</td>
                        {{--<td class="title">电子邮件地址：</td>--}}
                        {{--<td><input name="email" type="text" class="com email"  id="email_{{$k}}" value="{{$v->email or ''}}" /> 必填</td>--}}
                    </tr>
                    <tr>
                        <td class="title">收货地址：</td>
                        <td colspan="3">
                            <select name="country" class="seachprov selects1" id="selCountries_{{$k}}" onchange="region.changed(this, 1, 'selProvinces_{{$k}}')">
                                <option value="0">请选择国家</option>
                                <option value="1" selected>中国</option>
                            </select>
                            <select name="province" class="seachcity selects2" id="selProvinces_{{$k}}" class="seachprov" onchange="region.changed(this, 2, 'selCities_{{$k}}')">
                                <option value="0">请选择省</option>
                                @foreach($province as $val)
                                    <option value="{{$val->region_id}}" @if(isset($v->province)&&$v->province==$val->region_id) selected @endif>{{$val->region_name}}</option>
                                @endforeach
                            </select>
                            <select name="city" id="selCities_{{$k}}" class="seachcity selects3" onchange="region.changed(this, 3, 'selDistricts_{{$k}}')">
                                <option value="0">请选择市</option>
                                @foreach($v->cityList as $val)
                                    <option value="{{$val->region_id}}" @if(isset($v->city)&&$v->city==$val->region_id) selected @endif>{{$val->region_name}}</option>
                                @endforeach
                            </select>
			            <span id="seachdistrict_div" class="seachdistrict_div">
		                    <select name="district" class="seachdistrict selects4" id="selDistricts_{{$k}}">
                                <option value="0">请选择县</option>
                                @foreach($v->districtList as $val)
                                    <option value="{{$val->region_id}}" @if(isset($v->district)&&$v->district==$val->region_id) selected @endif>{{$val->region_name}}</option>
                                @endforeach
                            </select>
                            <input name="address" type="text" class="com address"  id="address_{{$k}}" value="{{$v->address or ''}}" /> 必填
                        </span>
                        </td>

                    </tr>
                    <tr>
                        <td class="title">手机：</td>
                        <td><input name="tel" type="text" class="com phone"  id="tel_{{$k}}" value="{{$v->tel or ''}}" /> 必填</td>
                        <td class="title">电话：</td>
                        <td><input name="mobile" type="text" class="com"  id="mobile_{{$k}}" value="{{$v->mobile or ''}}" /></td>
                    </tr>
                    <tr>
                        <td class="title">标志建筑：</td>
                        <td><input name="sign_building" type="text" class="com"  id="sign_building_{{$k}}" value="{{$v->sign_building or ''}}" /></td>
                        <td class="title">最佳送货时间：</td>
                        <td><input name="best_time" type="text"  class="com" id="best_time_{{$k}}" value="{{$v->best_time or ''}}" /></td>
                    </tr>
                    <tr>
                        <td class="title">邮政编码：</td>
                        <td colspan="3"><input name="zipcode" type="text" class="com"  id="zipcode_{{$k}}" value="{{$v->zipcode or ''}}" /></td>
                    </tr>
                    <tr class="end">
                        <td colspan="4" class="btn1">
                            <input name="submit" class="revise submit" value="配送至这个地址" type="submit">

                            <input name="button" onclick="if (confirm('你确认要删除该收货地址吗？'))location.href='{{route('user.addressDelete',['id'=>$v->address_id,'act'=>'jiesuan'])}}'" class="del_ads" value="删除" type="button">
                            <input name="step" value="consignee" type="hidden">
                            <input name="act" value="jiesuan" type="hidden">
                            <input name="update_act" value="update" type="hidden">
                            <input name="addressId" value="{{$v->address_id}}" type="hidden">
                        </td>
                    </tr>
                </table>
            </form>
        @endforeach
        <form action="{{route('user.addressUpdate')}}" method="post" name="theForm">
            {!! csrf_field() !!}
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="title">收货人姓名：</td>
                    <td><input name="consignee" type="text" class="com names" id="consignee_{{count($addressList)}}" value="" /> 必填</td>
                    <td class="title">电子邮件地址：</td>
                    <td><input name="email" type="text" class="com email"  id="email_{{count($addressList)}}" value="" /> 必填</td>
                </tr>
                <tr>
                    <td class="title">收货地址：</td>
                    <td colspan="3">
                        <select name="country" class="seachprov selects1" id="selCountries_{{count($addressList)}}" onchange="region.changed(this, 1, 'selProvinces_{{count($addressList)}}')">
                            <option value="0">请选择国家</option>
                            <option value="1" selected>中国</option>
                        </select>
                        <select name="province" class="seachcity selects2" id="selProvinces_{{count($addressList)}}" class="seachprov" onchange="region.changed(this, 2, 'selCities_{{count($addressList)}}')">
                            <option value="0">请选择省</option>
                            @foreach($province as $v)
                                <option value="{{$v->region_id}}">{{$v->region_name}}</option>
                            @endforeach
                        </select>
                        <select name="city" id="selCities_{{count($addressList)}}" class="seachcity selects3" onchange="region.changed(this, 3, 'selDistricts_{{count($addressList)}}')">
                            <option value="0">请选择市</option>

                        </select>
			            <span id="seachdistrict_div" class="seachdistrict_div">
		                    <select name="district" class="seachdistrict selects4" id="selDistricts_{{count($addressList)}}" style="display:none">
                                <option value="0">请选择县</option>
                            </select>
                            <input name="address" type="text" class="com address"  id="address_{{count($addressList)}}" value="" /> 必填
                        </span>
                    </td>

                </tr>
                <tr>
                    <td class="title">手机：</td>
                    <td><input name="tel" type="text" class="com phone"  id="tel_{{count($addressList)}}" value="" /> 必填</td>
                    <td class="title">电话：</td>
                    <td><input name="mobile" type="text" class="com"  id="mobile_{{count($addressList)}}" value="" /></td>
                </tr>
                <tr>
                    <td class="title">标志建筑：</td>
                    <td><input name="sign_building" type="text" class="com"  id="sign_building_{{count($addressList)}}" value="" /></td>
                    <td class="title">最佳送货时间：</td>
                    <td><input name="best_time" type="text"  class="com" id="best_time_{{count($addressList)}}" value="" /></td>
                </tr>
                <tr>
                    <td class="title">邮政编码：</td>
                    <td colspan="3"><input name="zipcode" type="text" class="com"  id="zipcode_{{count($addressList)}}" value="" /></td>
                </tr>
                <tr class="end">
                    <td colspan="4" class="btn1">
                        <input name="submit" class="revise submit" value="配送至这个地址" type="submit">
                        <input name="step" value="consignee" type="hidden">
                        <input name="act" value="jiesuan" type="hidden">
                        <input name="orderstr" value="203528_203529_" type="hidden">
                        <input name="update_act" value="update" type="hidden">
                        <input name="address_id" value="0" type="hidden">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    @include('layout.page_footer')
@endsection
