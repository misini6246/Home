@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/member2.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('/css/address2.css')}}" rel="stylesheet" type="text/css"/>

    <script type="text/javascript" src="{{path('/js/common.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/member.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/user_address.js')}}"></script>
    <script type="text/javascript" src="{{path('/js/region.js')}}"></script>
    <style type="text/css">
        .sh_box {
            width: 878px;
            height: 148px;
            border: 1px solid #e5e5e5;
            margin: 25px auto;
            padding: 10px 30px 20px 30px;
        }

        .sh_box .fir, .sh_box .fir_1 {
            font-size: 14px;
            color: #666;
            width: 84px;
            display: inline-block;
            text-align: right;
        }

        .sh_box .fir_1 {
            width: auto;
        }

        .sh_box .sec {
            font-size: 14px;
            color: #333;
            font-weight: bold;
            margin-left: 10px;
            display: inline-block;
            min-width: 240px;
        }

        .sh_box div {
            margin-top: 10px;
        }

        .warning {
            width: 920px;
            margin: 0 auto;
            color: #f83148;
            font-family: "宋体";
        }
    </style>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')
    <div class="main fn_clear">
        <div class="top"><span class="title">我的太星医药网</span> <a>>　<span>我的账户</span> </a> <a
                    href="{{route('user.addressList')}}" class="end">>　<span>收货地址</span></a></div>
        @include('layout.user_menu')
        <div class="main_right1">
            <div class="top_title">
                <h3>收货地址</h3>
                <span class="ico"></span>
            </div>
            @if(!$info)
                <div class="content_box">
                    <h4>收货地址</h4>
                    <div class="content">

                        <form action="{{route('user.addressUpdate')}}" method="post" name="theForm">
                            {!! csrf_field() !!}
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="title">收货人姓名：</td>
                                    <td><input name="consignee" type="text" class="com names"
                                               id="consignee_0" value=""/> <span
                                                class="xinghao">*</span></td>
                                    {{--<td class="title">电子邮件地址：</td>--}}
                                    {{--<td><input name="email" type="text" class="com email"  id="email_0" value="" /> <span class="xinghao">*</span></td>--}}
                                </tr>
                                <tr>
                                    <td class="title">收货地址：</td>
                                    <td colspan="3">
                                        <select name="country" class="seachprov"
                                                id="selCountries_0"
                                                onchange="region.changed(this, 1, 'selProvinces_0')">
                                            <option value="1" selected>中国</option>
                                        </select>
                                        <select name="province" class="seachcity selects1"
                                                id="selProvinces_0" class="seachprov"
                                                onchange="region.changed(this, 2, 'selCities_0')">
                                            <option value="">请选择省</option>
                                            @foreach($province as $v)
                                                <option value="{{$v->region_id}}">{{$v->region_name}}</option>
                                            @endforeach
                                        </select>
                                        <select name="city" id="selCities_0"
                                                class="seachcity selects2"
                                                onchange="region.changed(this, 3, 'selDistricts_0')">
                                            <option value="">请选择市</option>

                                        </select>
                                        <span id="seachdistrict_div" class="seachdistrict_div">
		                    <select name="district" class="seachdistrict selects3"
                                    id="selDistricts_0">
                                <option value="0">请选择县</option>
                            </select>
                            <input name="address" type="text" class="com address" id="address_0"
                                   value=""/> <span style="left: 550px;" class="xinghao">*</span>
                        </span>
                                    </td>

                                </tr>
                                <tr>
                                    <td class="title">手机：</td>
                                    <td><input name="tel" type="text" class="com phone" id="tel_0"
                                               value=""/><span class="xinghao">*</span></td>
                                    <td class="title">电话：</td>
                                    <td><input name="mobile" type="text" class="com" id="mobile_0"
                                               value=""/></td>
                                </tr>
                                {{--<tr>--}}
                                    {{--<td class="title">标志建筑：</td>--}}
                                    {{--<td><input name="sign_building" type="text" class="com"--}}
                                               {{--id="sign_building_0" value=""/></td>--}}
                                    {{--<td class="title">最佳送货时间：</td>--}}
                                    {{--<td><input name="best_time" type="text" class="com"--}}
                                               {{--id="best_time_0" value=""/></td>--}}
                                {{--</tr>--}}
                                <tr>
                                    <td class="title">邮政编码：</td>
                                    <td colspan="3"><input name="zipcode" type="text" class="com"
                                                           id="zipcode_0" value=""/></td>
                                </tr>
                                <tr class="end">
                                    <td colspan="4" class="btn1">
                                        <input type="hidden" name="addressId" value="0"/>
                                        <input name="submit" class="revise_1" value="填写收货地址" type="submit">
                                    </td>
                                </tr>
                            </table>
                            <div class="warning" style="margin-left: 170px;margin-top: -40px;margin-bottom: 20px;">
                                *注：按国家GSP规定，收货地址需和药品经营许可证上地址一致，填写后如需更改请联系客服人员！
                            </div>
                        </form>

                    </div>
                </div>
            @else
                <div class="sh_box">
                    <div class="name">
						<span class="fir">
							收货人姓名：
						</span>
                        <span class="sec">
							{{$info->consignee}}
						</span>
                    </div>
                    <div class="address">
						<span class="fir">
							收货地址：
						</span>
                        <span class="sec">
							{{$info->region_name}}&nbsp;{{$info->address}}
						</span>
                    </div>
                    <div class="phone">
						<span class="fir">
							手机：
						</span>
                        <span class="sec">
							{{$info->tel}}
						</span>
                        <span class="fir_1">
							座机：
						</span>
                        <span class="sec">
							{{$info->mobile}}
						</span>
                    </div>
                    {{--<div class="build">--}}
						{{--<span class="fir">--}}
							{{--标志建筑：--}}
						{{--</span>--}}
                        {{--<span class="sec">--}}
                            {{--{{$info->sign_building}}--}}
						{{--</span>--}}
                        {{--<span class="fir_1">--}}
							{{--最佳送货时间：--}}
						{{--</span>--}}
                        {{--<span class="sec">--}}
                            {{--{{$info->best_time}}--}}
						{{--</span>--}}
                    {{--</div>--}}
                    <div class="code">
						<span class="fir">
							邮政编码：
						</span>
                        <span class="sec">
                            {{$info->zipcode}}
						</span>
                    </div>
                </div>
                <div class="warning">
                    *注：按国家GSP规定，收货地址需和药品经营许可证上地址一致，填写后如需更改请联系客服人员！
                </div>
            @endif


        </div>
    </div>
    @include('common.footer')
@endsection
