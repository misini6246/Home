@extends('jifen.layouts.body')
@section('links')
    <link href="{{path('jfen/css/css_reset.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('jfen/css/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('jfen/css/sure_order.css')}}" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="{{path('jfen/js/my_homepage.js')}}"></script>
@endsection
@section('content')
    <div class="sure_order_real" style="padding: 0;border: 0;">
        <div class="fill_msg" style="display: block;">
            <form action="{{route('jifen.address.store')}}" method="post" id="form">
                {!! csrf_field() !!}
                <label class="clear_float fill_name"><span class="ca_tip">收货人姓名：</span>
                    <input class="people" type="text" name="consignee"/>
                    <span class="alert">*</span>
                </label>
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
                <label class="clear_float">
                    <span class="ca_tip">街道地址：</span>
                    <textarea class="detail_address" cols="80" rows="10" name="address"></textarea>
                    <span class="alert">*</span>
                </label>
                <label class="clear_float">
                    <span class="ca_tip">邮政编码：</span>
                    <input class="postcode" type="text" name="zipcode"/>
                    <span class="alert">*</span>
                </label>
                <label class="clear_float cellphone">
                    <span class="ca_tip">电话：</span>
                    <input class="cellphone_num" type="text" name="tel"/>
                    <span class="alert">*</span>
                </label>
                <div class="submit">
                    <input type="hidden" name="province" id="province" value=""/>
                    <input type="hidden" name="city" id="city" value=""/>
                    <input type="hidden" name="district" id="district" value=""/>
                    <button class="reset_btn save" data-url="flow.php?step=make">确认提交</button>
                    <button class="reset_btn reset">取消重置</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        var success = '{{$success or 0}}';
        var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
        if (success == 1) {
            parent.layer.close(index);
            parent.layer.msg('添加成功', {icon: 1});
            parent.$('#address_list').html('{!! $content or '' !!}');
            parent.$('#default_address').html('{!! $default_address or '' !!}');
        }
        $(".select_choose").click(function (e) {
            stopPropagation(e);//阻止冒泡但是允许默认事件的发生
            if ($(this).next().find("li").length > 0) {
                $(this).next(".select_options").slideDown(100);
            }
            if ($(this).next().height() < 300) {
                $(this).next().css({"overflow": "hidden"});
            } else {
                $(this).next().css({"overflow": "scroll"});
            }
        });
        $(".select_options li").live({
            "mouseover": function () {
                $(this).css({backgroundColor: "#ddd"});
            }, "mouseout": function () {
                $(this).css({background: "none"});
            }
        });
        $(".select_options li").live("click", function () {
            var span = $(this).parent().prev().find("span");
            span.text($(this).text());
            span.attr("data-id", $(this).attr("data-id"));
            var next = $(this).parent().parent().nextAll(".choose_select");
            $(this).parent().slideUp(100);

            next.find(".select_choose span").attr("data-id", 0);
            next.find(".select_choose span").html("请选择...");
            next.find("ul").html("");

            return false;
        });
        $(":not(.select_choose)").click(function () {
            $(".select .select_options").slideUp(100);
        });
        function stopPropagation(e) {
            e = e || window.event;
            if (e.stopPropagation) { //W3C阻止冒泡方法
                e.stopPropagation();
            } else {
                e.cancelBubble = true; //IE阻止冒泡方法
            }
        }
    </script>
@endsection
