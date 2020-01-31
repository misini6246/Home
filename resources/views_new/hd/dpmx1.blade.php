@extends('common.vue_index')
@section('links')
    <script src="https://cdn.jsdelivr.net/npm/tween.js@16.3.4"></script>
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

        .bang {
            position: absolute;
            width: 16%;
            top: 64.2%;
        }

        .bang-left {
            left: 9.5%
        }

        .bang-right {
            right: 13.5%;
        }

        .time {
            position: absolute;
            top: 68.9%;
            width: 50%;
            left: 16%;
        }

        .money {
            position: absolute;
            top: 84.4%;
            width: 55%;
            left: 13.5%;
        }

        .jindu {
            position: absolute;
            top: 100%;
            width: 75%;
            left: 12%;
        }

        .hour {
            position: absolute;
            left: 63%;
            text-align: center;
            color: #ffffff;
            font-weight: bold;
        }

        .minute {
            position: absolute;
            left: 75.5%;
            text-align: center;
            color: #ffffff;
            font-weight: bold;
        }

        .second {
            position: absolute;
            left: 87.5%;
            text-align: center;
            color: #ffffff;
            font-weight: bold;
        }

        .shuzi {
            position: absolute;
            color: #313135;
            width: 7%;
        }

        .title {
            position: absolute;
            text-align: center;
            color: #ffffff;
            width: 100%;
            height: 7%;
        }

        .lists {
            top: 9.8%;
            height: 42%;
            position: absolute;
            left: 5%;
            list-style: none;
            color: #fff;
            display: inline-block;
            width: 100%;
            overflow: hidden;
        }

        .jp1 {
            height: 48% !important;
        }

        .jp2 {
            height: 36%;
            top: 57.8% !important;
        }

        .lists li {
            height: 10%;
            font-size: 14px;
            line-height: 30px;
            top: 0;
        }

        .lists li .first {
            display: inline-block;;
            width: 60%;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: middle;
        }

        .log {
            color: #f9e794;
            vertical-align: middle;
        }

        .tiao {
            position: absolute;
            top: 108.9%;
            /*width: 71.9%;*/
            width: 0;
            left: 13.7%;
            overflow: hidden;
        }
    </style>
@endsection
@section('content')
    <div id="data">
        <div style="position: relative;" id="img1">
            <img src="{{get_img_path('images/hd/1109/6000bg.jpg')}}">
        </div>
        <div class="bang bang-right word" data-sx3="590">
            <img src="{{get_img_path('images/hd/1109/bang.png')}}">
            <div class="title word" style="font-size: 14px;line-height: 20px;top: 0;"
                 data-sx1="14" data-sx2="20" data-sx3="0">119中奖名单
            </div>
            <ul class="lists jp1">

            </ul>
            <ul class="lists jp2">

            </ul>
        </div>
        <div class="time word" data-sx3="615">
            <img src="{{get_img_path('images/hd/1109/time_bg.png')}}">
            <span class="hour word"
                  data-sx1="28" data-sx2="36" data-sx3="15"
                  style="  font-size: 28px;line-height: 36px;top: 15px;">00</span>
            <span class="minute word"
                  data-sx1="28" data-sx2="36" data-sx3="15"
                  style="  font-size: 28px;line-height: 36px;top: 15px;">00</span>
            <span class="second word"
                  data-sx1="28" data-sx2="36" data-sx3="15"
                  style="  font-size: 28px;line-height: 36px;top: 15px;">00</span>
        </div>
        <div class="money word" data-sx3="720">
            <img src="{{get_img_path('images/hd/1109/money.png')}}">
            <span class="shuzi word" style="left: 30.4%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
            <span class="shuzi word" style="left: 37.5%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
            <span class="shuzi word" style="left: 44.2%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
            <span class="shuzi word" style="left: 54.3%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
            <span class="shuzi word" style="left: 61.3%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
            <span class="shuzi word" style="left: 68.0%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
            <span class="shuzi word" style="left: 77.7%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
            <span class="shuzi word" style="left: 84.6%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
            <span class="shuzi word" style="left: 91.5%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3">0</span>
        </div>
        <div class="tiao word" data-sx3="867">
            <img class="word" data-sx4="31" data-sx5="963" style="width: 963px;height: 31px;"
                 src="{{get_img_path('images/hd/1109/tiao.png')}}">
        </div>


        <map id="map1" name="map1">
            <area href="javascript:;" shape="rect" coords=''
                  data-coords='{"x1":"0","y1":"0","x2":"0","y2":"0","w":"1349","h":"1012"}'>
        </map>
        <input type="hidden" id="start" value="{{strtotime('2017-11-09 00:00:00')}}">
        <input type="hidden" id="end" value="{{strtotime('2017-11-10 00:00:00')}}">
    </div>
    <script src="{{path('js/map.js')}}"></script>
    <script>
        var data = {
            items: [0, 0, 0, 0, 0, 0, 0, 0, 0],
            lists_left: [
                {
                    log_id: 1,
                    msn: '',
                    log: ''
                },
                {
                    log_id: 2,
                    msn: '',
                    log: ''
                },
                {
                    log_id: 3,
                    msn: '',
                    log: ''
                },
                {
                    log_id: 4,
                    msn: '',
                    log: ''
                }
            ],
            lists_right: [
                {
                    log_id: 1,
                    msn: '',
                    log: ''
                },
                {
                    log_id: 2,
                    msn: '',
                    log: ''
                },
                {
                    log_id: 3,
                    msn: '',
                    log: ''
                }
            ],
            old_money: 0,
            jindu: 0,
            money: 0,
            animatedNumber: 0,
            animatedNumber1: 0,
            djs: {
                hour: '00',
                minute: '00',
                second: '00',
                time: 0
            }
        };
        var daojishi;
        get_data(1);
        window.setInterval(get_data, 5000);
        function get_data(type) {
            $.ajax({
                url: '{{route('dpm')}}'
                , type: 'get'
                , data: {jindu: 0}
                , dataType: 'json'
                , success: function (response) {
                    if (type == 1) {
                        data.djs.time = response.time;
                        if (data.djs.time > 0) {
                            daojishi = window.setInterval(djs, 1000);
                        }
                    }
                    if (data.money < response.money) {
                        money(data.money, response.money);
                        data.old_money = data.money;
                        data.money = response.money;
                    }
                    var jp1 = response.jp1;
                    data.lists_left = check_lists(data.lists_left, jp1, '.jp1', 4);
                    var jp2 = response.jp2;
                    data.lists_right = check_lists(data.lists_right, jp2, '.jp2', 3);
                    jindu(data.jindu, response.jindu);
                    data.jindu = response.jindu;
                    adjust();
                }
            });
        }
        function check_lists(oldValue, newValue, _obj, num) {
            if (newValue.length > num && oldValue.length > num) {
                for (var i in newValue) {
                    var has = 0;
                    for (var j in oldValue) {
                        if (newValue[i].log_id == oldValue[j].log_id) {
                            has = 1;
                        }
                    }
                    if (has == 0) {
                        oldValue.push(newValue[i]);
                        add_bang(_obj, newValue[i]);
                    }
                }
            } else if (newValue.length <= num || oldValue.length <= num) {
                oldValue = newValue;
                bang(_obj, oldValue);
            }
            if (oldValue.length > num) {
                setTimeout('lunbo(\''+_obj+'\')', 2000);
            }
            return oldValue;
        }
        function djs() {
            data.djs.hour = lws(Math.floor(data.djs.time / 3600));
            data.djs.minute = lws(Math.floor((data.djs.time % 3600) / 60));
            data.djs.second = lws(data.djs.time % 60);
            data.djs.time--;
            $('.hour').text(data.djs.hour);
            $('.minute').text(data.djs.minute);
            $('.second').text(data.djs.second);
            if (data.djs.time < 0) {
                clearInterval(daojishi);
            }
        }
        function lws(val) {

            if (val < 10) {
                val = '0' + val;
            }
            return val;
        }
        function to_array(val) {
            var str = val.toString();
            var len = str.length;
            for (var i = 0; i < (data.items.length - len); i++) {
                str = '0' + str;
            }
            data.items = str.split("");
            for (var i in data.items) {
                $('.shuzi').eq(i).text(data.items[i]);
            }
        }
        function retuen10(num) {
            for (var i = 0; i < num; i++) {
                for (var j = 0; j < 10; j++) {
                    $('.shuzi').eq(i).text(j);
                }
            }
        }
        function lunbo(_obj) {
            var m = $(_obj + ' li:eq(0)').css('height');
            $(_obj + ' li:eq(0)').animate({marginTop: "-" + m}, 1000, function () {
                $(this).css('margin-top', '0');
                $(_obj).append($(this));
            })
        }
        function bang(_obj, lists) {
            var html = '';
            for (var i in lists) {
                html += '<li class="word" data-sx1="14" data-sx2="30" data-sx3="0" data-sx4="30">' +
                    '<span class="first">' + lists[i].msn + '</span><span class="log">' + lists[i].log + '</span> </li>';
            }
            $(_obj).html(html);
        }
        function add_bang(_obj, val) {
            var one = '<li class="word" data-sx1="14" data-sx2="30" data-sx3="0" data-sx4="30">' +
                '<span class="first">' + val.msn + '</span><span class="log">' + val.log + '</span> </li>';
            $(_obj).append(one);
        }
        function jindu(oldValue, newValue) {
            $('.tiao').animate({width: newValue + '%'}, 1000)
        }
        function money(oldValue, newValue) {
            to_array(newValue);
//            function animate() {
//                if (TWEEN.update()) {
//                    requestAnimationFrame(animate)
//                }
//            }
//
//            new TWEEN.Tween({tweeningNumber: oldValue})
//                .easing(TWEEN.Easing.Quadratic.Out)
//                .to({tweeningNumber: newValue}, 2000)
//                .onUpdate(function () {
//                    data.animatedNumber = this.tweeningNumber.toFixed(0);
//                    to_array(data.animatedNumber);
//                })
//                .start();
//            animate()
        }
    </script>
@endsection
