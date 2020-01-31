<!DOCTYPE html>
<html lang="zh">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>购物车-添加收货地址</title>
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/common_gwc.css" />
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/new_common.css" />
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/base.css" />
    <link rel="stylesheet" type="text/css" href="/new_gwc/gwc-css/cart.css" />
    <link rel="stylesheet" type="text/css" href="/new_gwc/flow-consignee.css"/>

    <script type="text/javascript" src="{{path('/js/transport_jquery.js')}}"></script>

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('/js/region.js')}}"></script>
</head>

<body>
<div class="big-container">
    <!--头部-->
    @include('layouts.header')
    <!--/头部-->
    <div class="top-box">
        <div class="box-container">
            <a href="/"><div class="left" style="width: 466px;"><img src="/new_gwc/img/购物车_03.jpg" /></div></a>
        </div>
    </div>

    <!--主体内容-->
    <div class="content">
        <form action="{{route('user.addressUpdate')}}" method="post" name="theForm">
            {!! csrf_field() !!}
            <input name="zipcode" type="hidden" value="" />
            <input name="email" type="hidden" value="" />
            <input name="address" type="hidden" value="" />
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td class="title">收货人姓名：</td>
                    <td><input name="consignee" type="text" class="com names" id="consignee_{{count($addressList)}}" value="" /> 必填</td>
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
                        </span>
                    </td>

                </tr>
                <tr>
                    <td class="title">手机：</td>
                    <td><input name="tel" type="text" class="com phone"  id="tel_{{count($addressList)}}" value="" /> 必填</td>
                    <td class="title">电话：</td>
                    <td><input name="mobile" type="text" class="com"  id="mobile_{{count($addressList)}}" value="" /></td>
                </tr>
                {{--<tr>--}}
                {{--<td class="title">标志建筑：</td>--}}
                {{--<td><input name="sign_building" type="text" class="com"  id="sign_building_{{count($addressList)}}" value="" /></td>--}}
                {{--<td class="title">最佳送货时间：</td>--}}
                {{--<td><input name="best_time" type="text"  class="com" id="best_time_{{count($addressList)}}" value="" /></td>--}}
                {{--</tr>--}}
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
    <!--/主体内容-->

    <!--footer-->
   @include('layouts.new_footer')
    <!--/footer-->
</div>
</body>
</html>