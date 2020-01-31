@extends('layout.body')
@section('links')
    <link href="{{path('/css/base.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('/css/address2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/index2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{path('css/new-common.css')}}" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/user_address.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/region.js')}}"></script>
@endsection
@section('content')
    @include('layout.page_header')
    @include('layout.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a href="{{route('user.addressList')}}" class="end">>　<span>收货地址</span></a> </div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>收货地址</h3>
                <span class="ico"></span>
            </div>
            <div  class="content_box" >
                <h4>收货地址</h4>
                <div class="content">
                    @foreach($addressList as $k=>$v)
                        <form action="{{route('user.addressUpdate')}}" method="post" name="theForm">
                            {!! csrf_field() !!}
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="title">收货人姓名：</td>
                                    <td><input name="consignee" type="text" class="com names" id="consignee_{{$k}}" value="{{$v->consignee or ''}}" /> <span class="xinghao">*</span></td>
                                    {{--<td class="title">电子邮件地址：</td>--}}
                                    {{--<td><input name="email" type="text" class="com email"  id="email_{{$k}}" value="{{$v->email or ''}}" /> <span class="xinghao">*</span></td>--}}
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
                            <input name="address" type="text" class="com address"  id="address_{{$k}}" value="{{$v->address or ''}}" /> <span style="left: 550px;" class="xinghao">*</span>
                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="title">手机：</td>
                                    <td><input name="tel" type="text" class="com phone"  id="tel_{{$k}}" value="{{$v->tel or ''}}" /> <span class="xinghao">*</span></td>
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
                                        <input type="hidden" name="addressId" value="{{$v->address_id}}"/>
                                        <input name="submit" class="revise_1" value="确认修改" type="submit">
                                        <input name="button" class="revise_del" onclick="if (confirm('你确认要删除该收货地址吗？'))location.href='{{route('user.addressDelete',['id'=>$v->address_id])}}'" value="删除" type="button">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    @endforeach
                        @if(count($addressList)<5)
                        <form action="{{route('user.addressUpdate')}}" method="post" name="theForm">
                            {!! csrf_field() !!}
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="title">收货人姓名：</td>
                                    <td><input name="consignee" type="text" class="com names" id="consignee_{{count($addressList)}}" value="" /> <span class="xinghao">*</span></td>
                                    {{--<td class="title">电子邮件地址：</td>--}}
                                    {{--<td><input name="email" type="text" class="com email"  id="email_{{count($addressList)}}" value="" /> <span class="xinghao">*</span></td>--}}
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
		                    <select name="district" class="seachdistrict selects4" id="selDistricts_{{count($addressList)}}" >
                                <option value="0">请选择县</option>
                            </select>
                            <input name="address" type="text" class="com address"  id="address_{{count($addressList)}}" value="" /> <span style="left: 550px;" class="xinghao">*</span>
                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="title">手机：</td>
                                    <td><input name="tel" type="text" class="com phone"  id="tel_{{count($addressList)}}" value="" /> <span class="xinghao">*</span></td>
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
                                        <input type="hidden" name="addressId" value="0"/>
                                        <input name="submit" class="revise_1" value="新增收货地址" type="submit">
                                    </td>
                                </tr>
                            </table>
                        </form>
                        @endif
                </div>
            </div>




        </div>
    </div>
    @include('layout.page_footer')
@endsection
