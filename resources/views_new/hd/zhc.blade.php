@extends('common.index',['page_title'=>'1109主会场'])
@section('links')
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
        }

        img {
            display: block;
            border: none;
            width: 100%;
        }

        area {
            outline: none
        }

        .btn {
            cursor: pointer;
            position: absolute;
            left: 43%;
            top: 80%;
        }

        .hide {
            display: none;
        }

        .jf_money {
            position: absolute;
            left: 45%;
            top: 38%;
            text-align: center;
            width: 12%;
            color: #f63c3c;
            font-size: 38px;
        }

        #alert_box_jf {
            width: 38%;
            position: fixed;
            top: 20%;
            left: 30.8%;
        }

        #alert_box_yhq {
            width: 33%;
            position: fixed;
            top: 20%;
            left: 33.5%;
        }

        #shijian span.word {
            *top: 84% !important;
        }
    </style>
@endsection
@section('content')
    <img id="img1" src="{{get_img_path('images/hd/index_top.jpg')}}" usemap="#map1"
         hidefocus="true">
    <div style="position: relative;" id="shijian">
        <img id="djstp" src="{{get_img_path('images/hd/zhc/remaintime_start.jpg')}}"
             data-end="{{get_img_path('images/hd/zhc/remaintime_end.jpg')}}">
        <span class="hourse word" data-sx1="16" data-sx2="21" data-sx3="256.266"
              style="position: absolute;left: 45.1%;top:82.9%;text-align: center;width: 2%;color: #fbee3f;">0</span>
        <span class="minute word" data-sx1="16" data-sx2="21" data-sx3="256.266"
              style="position: absolute;left: 48.5%;top:82.9%;text-align: center;width: 2.1%;color: #fbee3f;">0</span>
        <span class="second word" data-sx1="16" data-sx2="21" data-sx3="256.266"
              style="position: absolute;left: 51.8%;top:82.9%;text-align: center;width: 2.1%;color: #fbee3f;">0</span>
    </div>
    <img id="img9" src="{{get_img_path('images/hd/zhc/miaosha1.jpg')}}" usemap="#map9"
         hidefocus="true">
    <img id="img10" src="{{get_img_path('images/hd/zhc/tejia.jpg')}}" usemap="#map10"
         hidefocus="true">
    <div style="background: #ff7e32;padding: 1% 0">
        <a target="_blank" href="http://www.hezongyy.com/category?keywords=%E8%92%99%E7%89%9B&showi=0"><img
                    style="width: 60%;margin: 0 auto;" src="{{get_img_path('images/miaosha/mengniu.jpg')}}"></a>
    </div>
    <img id="img11" src="{{get_img_path('images/hd/zhc/zhekou.jpg')}}" usemap="#map11"
         hidefocus="true">
    <img id="img12" src="{{get_img_path('images/hd/zhc/zhongyao.jpg')}}" usemap="#map12"
         hidefocus="true">
    <img id="img7" src="{{get_img_path('images/hd/zhc/huangou.jpg')}}" usemap="#map7"
         hidefocus="true">
    <map id="map9" name="map9">
        <area target="_blank" href="/119ms/" shape="rect" coords=''
              data-coords='{"x1":"270","y1":"80","x2":"1080","y2":"375","w":"1349","h":"413"}'>
    </map>
    <map id="map10" name="map10">
        <area target="_blank" href="/tejia?step=nextpro&type=all" shape="rect" coords=''
              data-coords='{"x1":"270","y1":"80","x2":"1080","y2":"375","w":"1349","h":"395"}'>
    </map>
    <map id="map11" name="map11">
        <area target="_blank" href="/tejia?step=nextpro&type=zk" shape="rect" coords=''
              data-coords='{"x1":"270","y1":"80","x2":"1080","y2":"375","w":"1349","h":"395"}'>
    </map>
    <map id="map12" name="map12">
        <area target="_blank" href="/119ms/indexzy.html" shape="rect" coords=''
              data-coords='{"x1":"270","y1":"80","x2":"1080","y2":"375","w":"1349","h":"394"}'>
    </map>
    <map id="map7" name="map7">
        <area target="_blank" href="/cxhd/hdhg" shape="rect" coords=''
              data-coords='{"x1":"270","y1":"80","x2":"1080","y2":"375","w":"1349","h":"395"}'>
    </map>

    <div style="position: relative;">
        <img id="img8" src="{{get_img_path('images/hd/zhc/youhuijuan.jpg')}}" usemap="#map8"
             hidefocus="true">

        <img style="width: 12%;height:8%;position: absolute;left: 44%;top:80%;cursor: pointer"
             src="http://images.hezongyy.com/images/yhq/btn.png"
             id="lingqu" onclick="lq_yhq()">
        <img style="width: 12%;height:8%;position: absolute;left: 44%;top:80%;cursor: pointer" class="hide"
             src="{{get_img_path('new_yhq')}}" id="yilingqu">

    </div>
    <img id="img3" src="{{get_img_path('images/hd/zhc/jifen.jpg')}}" usemap="#map3"
         hidefocus="true">
    <img src="{{get_img_path('images/hd/zhc/choujiang.jpg')}}"/>
    <img id="img5" src="{{get_img_path('images/hd/zhc/footer.jpg')}}" usemap="#map5"
         hidefocus="true">
    <div style="width: 10.5%;position: fixed;top: 20%;right: 9%;">
        <img id="img6" src="{{get_img_path('images/hd/zhc/fix_nav1.png')}}" usemap="#map6"
             hidefocus="true">
    </div>
    <div style="position: fixed;top: 30%;left: 2%;">
        <a target="_blank"
           href="http://www.hezongyy.com/category?keywords=%E5%B9%BF%E5%B7%9E%E8%AF%BA%E9%87%91%E5%88%B6%E8%8D%AF%E6%9C%89%E9%99%90%E5%85%AC%E5%8F%B8&showi=0"><img
                    src="{{get_img_path('images/hd/zhc/nj119.jpg')}}" style="width: 190px;height: 340px;"></a>
    </div>
    <div id="alert_box_yhq" class="hide">
        <img id="img2" src="{{get_img_path('images/yhq/tcc.png')}}" usemap="#map2"
             hidefocus="true">
    </div>
    <div id="alert_box_jf" class="hide">
        <img id="img4" src="{{get_img_path('images/yhq/jifentcc.png')}}" usemap="#map4"
             hidefocus="true">
        <span class="jf_money">10</span>
    </div>
    <map id="map1" name="map1">
        <area href="javascript: void(to_bottom());" shape="rect" coords=''
              data-coords='{"x1":"1000","y1":"10","x2":"1085","y2":"60","w":"1349","h":"70"}'>
    </map>
    <map id="map8" name="map8">
        <area target="_blank" href="/119yh/" shape="rect" coords=''
              data-coords='{"x1":"250","y1":"100","x2":"1100","y2":"380","w":"1349","h":"651"}'>
    </map>
    <map id="map2" name="map2">
        <area href="javascript:;" shape="rect" coords='' onclick="$('#alert_box_yhq').hide();"
              data-coords='{"x1":"75","y1":"225","x2":"210","y2":"270","w":"445","h":"291"}'>
        <area target="_blank" href="/user/youhuiq" shape="rect" coords=''
              data-coords='{"x1":"232","y1":"225","x2":"370","y2":"270","w":"445","h":"291"}'>
    </map>
    <map id="map3" name="map3">
        <area target="_blank" href="/jf_money" shape="rect" coords=''
              data-coords='{"x1":"598","y1":"300","x2":"750","y2":"350","w":"1349","h":"704"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="lq_yhq_jf(10,10)"
              data-coords='{"x1":"277","y1":"560","x2":"420","y2":"610","w":"1349","h":"704"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="lq_yhq_jf(150,150)"
              data-coords='{"x1":"440","y1":"560","x2":"580","y2":"610","w":"1349","h":"704"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="lq_yhq_jf(700,700)"
              data-coords='{"x1":"603","y1":"560","x2":"742","y2":"610","w":"1349","h":"704"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="lq_yhq_jf(1900,1900)"
              data-coords='{"x1":"603","y1":"560","x2":"742","y2":"610","w":"1349","h":"704"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="lq_yhq_jf(1900,1900)"
              data-coords='{"x1":"765","y1":"560","x2":"905","y2":"610","w":"1349","h":"704"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="lq_yhq_jf(4000,4000)"
              data-coords='{"x1":"927","y1":"560","x2":"1067","y2":"610","w":"1349","h":"704"}'>
    </map>
    <map id="map4" name="map4">
        <area href="javascript:;" shape="rect" coords='' onclick="$('#alert_box_jf').hide();"
              data-coords='{"x1":"118","y1":"314","x2":"250","y2":"350","w":"513","h":"497"}'>
        <area target="_blank" href="/jf_money/log" shape="rect" coords=''
              data-coords='{"x1":"270","y1":"314","x2":"410","y2":"350","w":"513","h":"497"}'>
    </map>
    <map id="map5" name="map5">
        <area target="_blank" href="/119yh/" shape="rect" coords=''
              data-coords='{"x1":"333","y1":"180","x2":"670","y2":"345","w":"1349","h":"623"}'>
        <area target="_blank" href="/jf_money" shape="rect" coords=''
              data-coords='{"x1":"671","y1":"180","x2":"1010","y2":"345","w":"1349","h":"623"}'>
        <area href="javascript:;" shape="rect" coords=''
              data-coords='{"x1":"333","y1":"346","x2":"670","y2":"520","w":"1349","h":"623"}'>
        <area href="javascript:;" shape="rect" coords=''
              data-coords='{"x1":"671","y1":"346","x2":"1010","y2":"520","w":"1349","h":"623"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="to_top();"
              data-coords='{"x1":"600","y1":"550","x2":"750","y2":"590","w":"1349","h":"623"}'>
    </map>
    <map id="map6" name="map6">
        <area target="_blank" href="/119ms/" shape="rect" coords=''
              data-coords='{"x1":"25","y1":"80","x2":"135","y2":"115","w":"142","h":"423"}'>
        <area target="_blank" href="/tejia?step=nextpro&type=all" shape="rect" coords=''
              data-coords='{"x1":"25","y1":"115","x2":"135","y2":"150","w":"142","h":"423"}'>
        <area target="_blank" href="/tejia?step=nextpro&type=zk" shape="rect" coords=''
              data-coords='{"x1":"25","y1":"150","x2":"135","y2":"180","w":"142","h":"423"}'>
        <area target="_blank" href="/119ms/indexzy.html" shape="rect" coords=''
              data-coords='{"x1":"25","y1":"180","x2":"135","y2":"210","w":"142","h":"423"}'>
        <area target="_blank" href="/cxhd/hdhg" shape="rect" coords=''
              data-coords='{"x1":"25","y1":"210","x2":"135","y2":"240","w":"142","h":"423"}'>
        <area target="_blank" href="/119yh/" shape="rect" coords=''
              data-coords='{"x1":"25","y1":"240","x2":"135","y2":"270","w":"142","h":"423"}'>
        <area target="_blank" href="/jf_money" shape="rect" coords=''
              data-coords='{"x1":"25","y1":"270","x2":"135","y2":"300","w":"142","h":"423"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="to_bottom()"
              data-coords='{"x1":"25","y1":"300","x2":"135","y2":"350","w":"142","h":"423"}'>
        <area href="javascript:;" shape="rect" coords='' onclick="to_top()"
              data-coords='{"x1":"25","y1":"350","x2":"135","y2":"380","w":"142","h":"423"}'>
        <area target="_blank" href="http://www.hezongyy.com" shape="rect" coords=''
              data-coords='{"x1":"25","y1":"380","x2":"135","y2":"440","w":"142","h":"423"}'>
    </map>
    <input type="hidden" id="start" value="{{strtotime('2017-11-09 00:00:00')}}">
    <input type="hidden" id="end" value="{{strtotime('2017-11-10 00:00:00')}}">
    <input type="hidden" id="type" value="0">
    <input type="hidden" id="type_jf" value="0">
    <script src="{{path('js/map.js')}}"></script>
    <script>
        $(function () {
            var now;
            var start = $('#start').val();
            var end = $('#end').val();
            var time;
            var djs;
            $.ajax({
                url: '/check_has_yhq',
                type: 'get',
                data: {id: 1},
                dataType: 'json',
                success: function (data) {
                    now = data.now;
                    if (now < start) {
                        time = start - now;
                    }
                    else if (now >= start && now < end) {
                        time = end - now;
                        $('#img1').attr('src', $('#img1').data('end'));
                    }
                    remaintime();
                    djs = window.setInterval(remaintime, 1000);
                    if (data.has == 1) {
                        $('#yilingqu').show();
                        $('#lingqu').hide();
                    }
                }
            });
            function remaintime() {
                time--;
                now++;
                if (time <= -1) {
                    time = 0;
                    if (now >= start && now < end) {
                        time = end - now;
                        $('#img1').attr('src', $('#img1').data('end'));
                    } else if (now >= end) {
                        clearInterval(djs);
                    }
                }
                var second = Math.floor(time % 60); // 计算秒
                var minute = Math.floor((time / 60) % 60); //计算分
                var hourse = Math.floor(time / 3600); //计算小时
                $('.hourse').html(hourse);
                $('.minute').html(minute);
                $('.second').html(second);
            }
        });
        function to_top() {
            $("html,body").animate({
                scrollTop: 0
            });
        }
        function to_bottom() {
            $("html,body").animate({
                scrollTop: $(document).height()
            });
        }
        function closebox() {
            $('#alert_box').hide();
        }
        function rt() {
            var d = document,
                dd = document.documentElement,
                db = document.body,
                top = dd.scrollTop || db.scrollTop,
                step = Math.floor(top / 20);
            (function () {
                top -= step;
                if (top > -step) {
                    dd.scrollTop == 0 ? db.scrollTop = top : dd.scrollTop = top;
                    setTimeout(arguments.callee, 20);
                }
            })();
        }
        function lq_yhq() {
            var type = $('#type').val();
            if (type == 0) {
                $.ajax({
                    url: '/yhq',
                    data: {id: 1},
                    dataType: 'json',
                    success: function (data) {
                        if (data.error == 2) {
                            layer.confirm(data.msg, {
                                btn: ['注册', '登录'], //按钮
                                icon: 2
                            }, function () {
                                location.href = '/auth/register';
                            }, function () {
                                location.href = '/auth/login';
                                return false;
                            });
                        } else {
                            if (data.error == 0 || data.error == 3) {
                                $('#lingqu').hide();
                                $('#yilingqu').show();
                                if (data.error == 3) {
                                    data.error = 1;
                                    layer.msg(data.msg, {icon: data.error + 1});
                                } else {
                                    $('#alert_box_yhq').show();
                                    adjust();
                                }
                                $('#type').val(1)
                            } else {
                                layer.msg(data.msg, {icon: data.error + 1});
                            }
                        }
                    }
                })
            } else {
                layer.msg('您已领取过该优惠券', {icon: 2});
            }
        }
        function lq_yhq_jf(id, je) {
            var type = $('#type_jf').val();
            layer.confirm('确定兑换' + je + '积分金币？', function (e) {
                layer.closeAll();
                if (type == 0) {
                    $('#type_jf').val(1);
                    $.ajax({
                        url: '/jf_money',
                        data: {id: id},
                        async: false,
                        dataType: 'json',
                        success: function (data) {
                            $('#type_jf').val(0);
                            if (data.error == 2) {
                                layer.confirm(data.msg, {
                                    btn: ['注册', '登录'], //按钮
                                    icon: 2
                                }, function () {
                                    location.href = '/auth/register';
                                }, function () {
                                    location.href = '/auth/login';
                                    return false;
                                });
                            } else if (data.error == 0 || data.error == 3) {
                                $('.jf_money').text(je);
                                $('#alert_box_jf').show();
                                adjust();
                                if (data.error == 3) {
                                    data.error = 1;
                                }
                            } else {
                                layer.msg(data.msg, {icon: data.error + 1})
                            }
                        }
                    })
                }
            });
        }
    </script>
@endsection
