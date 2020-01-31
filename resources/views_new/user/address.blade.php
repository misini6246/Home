@extends('layout.body')
@section('links')
    <link href="{{path('new/css/base.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/huiyuancommon.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/user/shouhuodizhi.css')}}" rel="stylesheet" type="text/css"/>
    <script src="{{path('js/common.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{path('new/js/jquery.SuperSlide.js')}}" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript" src="{{path('js/user/huiyuancommon.js')}}"></script>
@endsection
@section('content')
    @include('common.header')
    @include('common.nav')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="{{get_img_path('images/user/weizhi.png')}}"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="{{get_img_path('images/user/right_1_03.png')}}"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的太星医药网</a><img
                        src="{{get_img_path('images/user/right_1_03.png')}}" class="right_icon"/><span>收货地址</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="{{get_img_path('images/user/dian_03.png')}}"/>
                    <span>收货地址</span>
                </div>
                @if($info)
                    <div class="address">
                        <ul>
                            <li>
                                <p class="mz">
                                    <span class="add_left">收货人姓名：</span>
                                    <span class="add_right">{{$info->consignee}}</span>
                                </p>
                                <p class="dz">
                                    <span class="add_left">收货地址：</span>
                                    <span class="add_right">{{$info->region_name}}  {{$info->address}}</span>
                                </p>
                                <p class="sj">
                                    <span class="add_left">手机：</span>
                                    <span class="add_right">{{$info->tel}}</span>
                                    <span class="add_left add_left_1">座机：</span>
                                    <span class="add_right">{{$info->mobile}}</span>
                                </p>
                                <p class="bm">
                                    <span class="add_left">邮政编码：</span>
                                    <span class="add_right">{{$info->zipcode}}</span>
                                </p>
                            </li>
                        </ul>
                        <div class="warning">
                            *注：按国家GSP规定，收货地址需和药品经营许可证上地址一致，填写后如需更改请联系客服人员！
                        </div>
                    </div>
                @else
                    <form action="{{route('member.address.store')}}" method="post" onsubmit="return check_sub()">
                        {!! csrf_field() !!}
                        <div class="add_address">
                            <div class="add_box">
                                <div class="add_xx">
								<span class="add_left">
									收货人姓名：
								</span>
                                    <input type="text" class="add_text" name="consignee" value="{{old('consignee')}}"/>
                                    <span style="color: red;vertical-align: middle">*</span>
                                </div>
                                <div class="add_xx">
								<span class="add_left add_left_span">
									收货地址：
								</span>
                                    <ul id="list1">
                                        <li id="summary-stock">
                                            <div class="dd">
                                                <div id="store-selector">
                                                    <div class="text">
                                                        <div></div>
                                                        <b></b></div>
                                                    <div onclick="$('#store-selector').removeClass('hover')"
                                                         class="close"></div>
                                                </div>
                                                <!--store-selector end-->
                                                <div id="store-prompt"><strong></strong></div>
                                                <!--store-prompt end--->
                                            </div>
                                        </li>
                                        <input type="hidden" name="province" value="0">
                                        <input type="hidden" name="city" value="0">
                                        <input type="hidden" name="district" value="0">
                                    </ul>
                                    <div style="display: inline-block;vertical-align: top;margin-top: -2px;margin-left: -15px;">
                                        <input type="text" class="add_text" name="address" value="{{old('address')}}"/>
                                        <span style="color: red;vertical-align: middle">*</span>
                                    </div>
                                </div>
                                <div class="add_xx">
								<span class="add_left">
									手机：
								</span>
                                    <input type="text" class="add_text" name="tel" value="{{old('tel')}}"/>
                                    <span style="color: red;vertical-align: middle">*</span>
                                    <span class="add_left">
									座机：
								</span>
                                    <input type="text" class="add_text" name="mobile" value="{{old('mobile')}}"/>
                                </div>
                                <div class="add_xx">
								<span class="add_left">
									邮政编码：
								</span>
                                    <input type="text" class="add_text" name="zipcode" value="{{old('zipcode')}}"/>
                                </div>
                            </div>
                            <p style="    width: 940px;
    margin: 0 auto;
    color: #f83148;
    height: 40px;
    line-height: 40px;">*注：按国家GSP规定，收货地址需和药品经营许可证上地址一致，填写后如需更改请联系客服人员！</p>
                            <div class="btn_box">
                                <input type="submit" value="添加收货地址"/>
                            </div>
                        </div>
                    </form>
                @endif

            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <script>
        function check_sub() {
            var consignee = $('input[name=consignee]').val();
            if (consignee == '') {
                layer.msg('收货人不能为空', {icon: 2});
                return false;
            }
            var province = $('input[name=province]').val();
            var city = $('input[name=city]').val();
            var district = $('input[name=district]').val();
            var address = $('input[name=address]').val();
            if (province == 0 || city == 0 || district == 0 || address == '') {
                layer.msg('请完善收货地址', {icon: 2});
                return false;
            }
            var tel = $('input[name=tel]').val();
            if (tel == '') {
                layer.msg('手机号不能为空', {icon: 2});
                return false;
            }
            var is_tel = /^[1][3,4,5,7,8][0-9]{9}$/;
            if (!is_tel.test(tel)) {
                layer.msg('请填写正确的手机号', {icon: 2});
                return false;
            }
            var mobile = $('input[name=mobile]').val();
            var is_mobile = /^([0-9]{3,4}-)?[0-9]{7,8}$/;
            if (mobile != '' && !is_mobile.test(mobile)) {
                layer.msg('请填写正确的座机号', {icon: 2});
                return false;
            }
            var zipcode = $('input[name=zipcode]').val();
            var is_zipcode = /^[1-9][0-9]{5}$/;
            if (zipcode != '' && !is_zipcode.test(zipcode)) {
                layer.msg('请填写正确的邮政编码', {icon: 2});
                return false;
            }
        }
        !function ($) {
            $.extend({
                _jsonp: {
                    scripts: {},
                    counter: 1,
                    charset: "gb2312",
                    head: document.getElementsByTagName("head")[0],
                    name: function (callback) {
                        var name = "_jsonp_" + (new Date).getTime() + "_" + this.counter;
                        this.counter++;
                        var cb = function (json) {
                            eval("delete " + name),
                                callback(json),
                                $._jsonp.head.removeChild($._jsonp.scripts[name]),
                                delete $._jsonp.scripts[name]
                        };
                        return eval(name + " = cb"),
                            name
                    },
                    load: function (a, b) {
                        var c = document.createElement("script");
                        c.type = "text/javascript",
                            c.charset = this.charset,
                            c.src = a,
                            this.head.appendChild(c),
                            this.scripts[b] = c
                    }
                },
                getJSONP: function (a, b) {
                    var c = $._jsonp.name(b),
                        a = a.replace(/{callback};/, c);
                    return $._jsonp.load(a, c),
                        this
                }
            })
        }
        (jQuery);

        var iplocation = {
                @foreach($province as $k=>$v)
                @if($k!='四川')
            ,
                @endif
            "{{$v->region_name}}"
        :
        {
            id: "{{$v->region_id}}"
        }
        @endforeach
        }
        ;
        var provinceCityJson = {
                @foreach($province as $k=>$v)
                @if($k>0)
            ,
                @endif
            "{{$v->region_id}}"
        :
        [
                @foreach($v->child as $child)
            {
                "id": '{{$child->region_id}}',
                "name": "{{$child->region_name}}"
            },
            @endforeach
        ]
        @endforeach
        }
        ;
        var cName = "ipLocation";
        var currentLocation = "四川";
        var currentProvinceId = 26;

        //根据省份ID获取名称
        function getNameById(provinceId) {
            for (var o in iplocation) {
                if (iplocation[o] && iplocation[o].id == provinceId) {
                    return o;
                }
            }
            return "四川";

        }

        var isUseServiceLoc = true; //是否默认使用服务端地址
        var provinceHtml = '<div class="content"><div data-widget="tabs" class="m JD-stock" id="JD-stock">' +
            '<div class="mt">' +
            '    <ul class="tab">' +
            '        <li data-index="0" data-widget="tab-item" class="curr"><a href="#none" class="hover"><em>请选择</em><i></i></a></li>' +
            '        <li data-index="1" data-widget="tab-item" style="display:none;"><a href="#none" class=""><em>请选择</em><i></i></a></li>' +
            '        <li data-index="2" data-widget="tab-item" style="display:none;"><a href="#none" class=""><em>请选择</em><i></i></a></li>' +
            '        <li data-index="3" data-widget="tab-item" style="display:none;"><a href="#none" class=""><em>请选择</em><i></i></a></li>' +
            '    </ul>' +
            '    <div class="stock-line"></div>' +
            '</div>' +
            '<div class="mc" data-area="0" data-widget="tab-content" id="stock_province_item">' +
            '    <ul class="area-list">' +
            '       @foreach($province as $v) <li><a href="#none" data-value="{{$v->region_id}}">{{$v->region_name}}</a></li> @endforeach' +
            '    </ul>' +
            '</div>' +
            '<div class="mc" data-area="1" data-widget="tab-content" id="stock_city_item"></div>' +
            '<div class="mc" data-area="2" data-widget="tab-content" id="stock_area_item"></div>' +
            '<div class="mc" data-area="3" data-widget="tab-content" id="stock_town_item"></div>' +
            '</div></div>';

        function getAreaList(result) {
            var html = ["<ul class='area-list'>"];
            var longhtml = [];
            var longerhtml = [];
            if (result && result.length > 0) {
                for (var i = 0, j = result.length; i < j; i++) {
                    result[i].name = result[i].name.replace(" ", "");
                    if (result[i].name.length > 12) {
                        longerhtml.push("<li class='longer-area'><a href='#none' data-value='" + result[i].id + "'>" + result[i].name + "</a></li>");
                    } else if (result[i].name.length > 5) {
                        longhtml.push("<li class='long-area'><a href='#none' data-value='" + result[i].id + "'>" + result[i].name + "</a></li>");
                    } else {
                        html.push("<li><a href='#none' data-value='" + result[i].id + "'>" + result[i].name + "</a></li>");
                    }
                }
            } else {
                html.push("<li><a href='#none' data-value='" + currentAreaInfo.currentFid + "'> </a></li>");
            }
            html.push(longhtml.join(""));
            html.push(longerhtml.join(""));
            html.push("</ul>");
            return html.join("");
        }

        function cleanKuohao(str) {
            if (str && str.indexOf("(") > 0) {
                str = str.substring(0, str.indexOf("("));
            }
            if (str && str.indexOf("（") > 0) {
                str = str.substring(0, str.indexOf("（"));
            }
            return str;
        }

        function getStockOpt(id, name) {
            if (currentAreaInfo.currentLevel == 3) {
                currentAreaInfo.currentAreaId = id;
                $('input[name=district]').val(id);
                currentAreaInfo.currentAreaName = name;
                if (!page_load) {
                    currentAreaInfo.currentTownId = 0;
                    currentAreaInfo.currentTownName = "";
                }
            } else if (currentAreaInfo.currentLevel == 4) {
                currentAreaInfo.currentTownId = id;
                currentAreaInfo.currentTownName = name;
            }
            //添加20140224
            $('#store-selector').removeClass('hover');
            //setCommonCookies(currentAreaInfo.currentProvinceId,currentLocation,currentAreaInfo.currentCityId,currentAreaInfo.currentAreaId,currentAreaInfo.currentTownId,!page_load);
            if (page_load) {
                page_load = false;
            }
            //替换gSC
            var address = currentAreaInfo.currentProvinceName + currentAreaInfo.currentCityName + currentAreaInfo.currentAreaName + currentAreaInfo.currentTownName;
            $("#store-selector .text div").html(currentAreaInfo.currentProvinceName + cleanKuohao(currentAreaInfo.currentCityName) + cleanKuohao(currentAreaInfo.currentAreaName) + cleanKuohao(currentAreaInfo.currentTownName)).attr("title", address);
        }

        function getAreaListcallback(r) {
            currentDom.html(getAreaList(r));
            if (currentAreaInfo.currentLevel >= 2) {
                currentDom.find("a").click(function () {
                    if (page_load) {
                        page_load = false;
                    }
                    if (currentDom.attr("id") == "stock_area_item") {
                        currentAreaInfo.currentLevel = 3;
                    } else if (currentDom.attr("id") == "stock_town_item") {
                        currentAreaInfo.currentLevel = 4;
                    }

                    getStockOpt($(this).attr("data-value"), $(this).html());

                });
                if (page_load) { //初始化加载
                    currentAreaInfo.currentLevel = currentAreaInfo.currentLevel == 2 ? 3 : 4;
                    if (currentAreaInfo.currentAreaId && new Number(currentAreaInfo.currentAreaId) > 0) {
                        getStockOpt(currentAreaInfo.currentAreaId, currentDom.find("a[data-value='" + currentAreaInfo.currentAreaId + "']").html());
                    } else {
                        getStockOpt(currentDom.find("a").eq(0).attr("data-value"), currentDom.find("a").eq(0).html());

                    }
                }
            }
        }

        function chooseProvince(provinceId) {
            provinceContainer.hide();
            currentAreaInfo.currentLevel = 1;
            currentAreaInfo.currentProvinceId = provinceId;
            $('input[name=province]').val(provinceId);
            currentAreaInfo.currentProvinceName = getNameById(provinceId);
            if (!page_load) {
                currentAreaInfo.currentCityId = 0;
                currentAreaInfo.currentCityName = "";
                currentAreaInfo.currentAreaId = 0;
                currentAreaInfo.currentAreaName = "";
                currentAreaInfo.currentTownId = 0;
                currentAreaInfo.currentTownName = "";
            }
            areaTabContainer.eq(0).removeClass("curr").find("em").html(currentAreaInfo.currentProvinceName);
            areaTabContainer.eq(1).addClass("curr").show().find("em").html("请选择");
            areaTabContainer.eq(2).hide();
            areaTabContainer.eq(3).hide();
            cityContainer.show();
            areaContainer.hide();
            townaContainer.hide();
            if (provinceCityJson["" + provinceId]) {
                cityContainer.html(getAreaList(provinceCityJson["" + provinceId]));
                cityContainer.find("a").click(function () {
                    if (page_load) {
                        page_load = false;
                    }
                    $("#store-selector").unbind("mouseout");
                    chooseCity($(this).attr("data-value"), $(this).html());

                });
                if (page_load) { //初始化加载
                    if (currentAreaInfo.currentCityId && new Number(currentAreaInfo.currentCityId) > 0) {
                        chooseCity(currentAreaInfo.currentCityId, cityContainer.find("a[data-value='" + currentAreaInfo.currentCityId + "']").html());
                    } else {
                        chooseCity(cityContainer.find("a").eq(0).attr("data-value"), cityContainer.find("a").eq(0).html());
                    }
                }
            }
        }

        function chooseCity(cityId, cityName) {
            provinceContainer.hide();
            cityContainer.hide();
            currentAreaInfo.currentLevel = 2;
            currentAreaInfo.currentCityId = cityId;
            $('input[name=city]').val(cityId);
            currentAreaInfo.currentCityName = cityName;
            if (!page_load) {
                currentAreaInfo.currentAreaId = 0;
                currentAreaInfo.currentAreaName = "";
                currentAreaInfo.currentTownId = 0;
                currentAreaInfo.currentTownName = "";
            }
            areaTabContainer.eq(1).removeClass("curr").find("em").html(cityName);
            areaTabContainer.eq(2).addClass("curr").show().find("em").html("请选择");
            areaTabContainer.eq(3).hide();
            areaContainer.show().html("<div class='iloading'>正在加载中，请稍候...</div>");
            townaContainer.hide();
            currentDom = areaContainer;
            $.ajax({
                url: '/member/get_region'
                , data: {id: cityId}
                , dataType: 'json'
                , success: function (data) {
                    getAreaListcallback(data);
                }
            })
        }

        function chooseArea(areaId, areaName) {
            provinceContainer.hide();
            cityContainer.hide();
            areaContainer.hide();
            currentAreaInfo.currentLevel = 3;
            currentAreaInfo.currentAreaId = areaId;
            currentAreaInfo.currentAreaName = areaName;
            if (!page_load) {
                currentAreaInfo.currentTownId = 0;
                currentAreaInfo.currentTownName = "";
            }
            areaTabContainer.eq(2).removeClass("curr").find("em").html(areaName);
            areaTabContainer.eq(3).addClass("curr").show().find("em").html("请选择");
            townaContainer.show().html("<div class='iloading'>正在加载中，请稍候...</div>");
            currentDom = townaContainer;
            $.getJSONP("http://d.jd.com/area/get?fid=" + areaId + "&callback=getAreaListcallback");
        }
        $("#store-selector .text").after(provinceHtml);
        var areaTabContainer = $("#JD-stock .tab li");
        var provinceContainer = $("#stock_province_item");
        var cityContainer = $("#stock_city_item");
        var areaContainer = $("#stock_area_item");
        var townaContainer = $("#stock_town_item");
        var currentDom = provinceContainer;
        //当前地域信息
        var currentAreaInfo;
        //初始化当前地域信息
        function CurrentAreaInfoInit() {
            currentAreaInfo = {
                "currentLevel": 1,
                "currentProvinceId": 1,
                "currentProvinceName": "四川",
                "currentCityId": 0,
                "currentCityName": "",
                "currentAreaId": 0,
                "currentAreaName": "",
                "currentTownId": 0,
                "currentTownName": ""
            };
            var ipLoc = getCookie("ipLoc-djd");
            ipLoc = ipLoc ? ipLoc.split("-") : [];
            if (ipLoc.length > 0 && ipLoc[0]) {
                currentAreaInfo.currentProvinceId = ipLoc[0];
                currentAreaInfo.currentProvinceName = getNameById(ipLoc[0]);
            }
            if (ipLoc.length > 1 && ipLoc[1]) {
                currentAreaInfo.currentCityId = ipLoc[1];
            }
            if (ipLoc.length > 2 && ipLoc[2]) {
                currentAreaInfo.currentAreaId = ipLoc[2];
            }
            if (ipLoc.length > 3 && ipLoc[3]) {
                currentAreaInfo.currentTownId = ipLoc[3];
            }
        }
        var page_load = true;
        (function () {
            $("#store-selector").unbind("mouseover").bind("mouseover", function () {
                $('#store-selector').addClass('hover');
                $("#store-selector .content,#JD-stock").show();
            }).find("dl").remove();
            CurrentAreaInfoInit();
            areaTabContainer.eq(0).find("a").click(function () {
                areaTabContainer.removeClass("curr");
                areaTabContainer.eq(0).addClass("curr").show();
                provinceContainer.show();
                cityContainer.hide();
                areaContainer.hide();
                townaContainer.hide();
                areaTabContainer.eq(1).hide();
                areaTabContainer.eq(2).hide();
                areaTabContainer.eq(3).hide();
            });
            areaTabContainer.eq(1).find("a").click(function () {
                areaTabContainer.removeClass("curr");
                areaTabContainer.eq(1).addClass("curr").show();
                provinceContainer.hide();
                cityContainer.show();
                areaContainer.hide();
                townaContainer.hide();
                areaTabContainer.eq(2).hide();
                areaTabContainer.eq(3).hide();
            });
            areaTabContainer.eq(2).find("a").click(function () {
                areaTabContainer.removeClass("curr");
                areaTabContainer.eq(2).addClass("curr").show();
                provinceContainer.hide();
                cityContainer.hide();
                areaContainer.show();
                townaContainer.hide();
                areaTabContainer.eq(3).hide();
            });
            provinceContainer.find("a").click(function () {
                if (page_load) {
                    page_load = false;
                }
                $("#store-selector").unbind("mouseout");
                chooseProvince($(this).attr("data-value"));
            }).end();
            //chooseProvince(currentAreaInfo.currentProvinceId);
        })();

        function getCookie(name) {
            var start = document.cookie.indexOf(name + "=");
            var len = start + name.length + 1;
            if ((!start) && (name != document.cookie.substring(0, name.length))) {
                return null;
            }
            if (start == -1) return null;
            var end = document.cookie.indexOf(';', len);
            if (end == -1) end = document.cookie.length;
            return unescape(document.cookie.substring(len, end));
        };
    </script>
    @include('common.footer')
@endsection
