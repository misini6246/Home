@extends('common.vue_index')
@section('links')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{path('js/vue.js')}}" type="text/javascript" charset="utf-8"></script>
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
            height: 84%;
            position: absolute;
            left: 5%;
            list-style: none;
            color: #fff;
            display: inline-block;
            width: 100%;
            overflow: hidden;
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
            top: 107.3%;
            width: 71.9%;
            left: 13.7%;
            overflow: hidden;
        }

        [v-cloak] {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div id="data">
        <div style="position: relative;" id="img1">
            <img src="{{get_img_path('images/hd/1109/6000bg.jpg')}}">
        </div>
        {{--<div class="bang bang-left word" data-sx3="355">--}}
        {{--<img src="{{get_img_path('images/hd/1109/bang.png')}}">--}}
        {{--<div class="title word" style="font-size: 14px;line-height: 20px;top: 0;"--}}
        {{--data-sx1="14" data-sx2="20" data-sx3="0">供应商销售排行榜--}}
        {{--</div>--}}
        {{--<ul class="lists">--}}
        {{--<li class="word" data-sx1="12" data-sx2="39" data-sx3="0" data-sx4="28.3" v-for="item in lists_left">--}}
        {{--<span :title="item.suppliers_name"--}}
        {{--class="first">@{{ item.name }}</span><span>@{{ item.total }}</span>--}}
        {{--</li>--}}
        {{--</ul>--}}
        {{--</div>--}}
        <div class="bang bang-right word" data-sx3="415">
            <img src="{{get_img_path('images/hd/1109/bang.png')}}">
            <div class="title word" style="font-size: 14px;line-height: 20px;top: 0;"
                 data-sx1="14" data-sx2="20" data-sx3="0">119中奖名单
            </div>
            <ul class="lists" v-cloak>
                <li class="word" data-sx1="14" data-sx2="30" data-sx3="0" data-sx4="30" v-for="item in lists_right">
                        <span :title="item.goods_name"
                              class="first">@{{ item.msn }}</span><span class="log">@{{ item.log }}</span>
                </li>
            </ul>
        </div>
        <div class="time word" data-sx3="445">
            <img src="{{get_img_path('images/hd/1109/time_bg.png')}}">
            <span class="hour word" v-cloak=""
                  data-sx1="28" data-sx2="36" data-sx3="15"
                  style="  font-size: 28px;line-height: 36px;top: 15px;">@{{ djs.hour }}</span>
            <span class="minute word" v-cloak=""
                  data-sx1="28" data-sx2="36" data-sx3="15"
                  style="  font-size: 28px;line-height: 36px;top: 15px;">@{{ djs.minute }}</span>
            <span class="second word" v-cloak=""
                  data-sx1="28" data-sx2="36" data-sx3="15"
                  style="  font-size: 28px;line-height: 36px;top: 15px;">@{{ djs.second }}</span>
        </div>
        <div class="money word" data-sx3="545">
            <img src="{{get_img_path('images/hd/1109/money.png')}}">
            <span class="shuzi word" style="left: 30.4%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[0] }}</span>
            <span class="shuzi word" style="left: 37.5%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[1] }}</span>
            <span class="shuzi word" style="left: 44.2%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[2] }}</span>
            <span class="shuzi word" style="left: 54.3%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[3] }}</span>
            <span class="shuzi word" style="left: 61.3%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[4] }}</span>
            <span class="shuzi word" style="left: 68.0%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[5] }}</span>
            <span class="shuzi word" style="left: 77.7%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[6] }}</span>
            <span class="shuzi word" style="left: 84.6%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[7] }}</span>
            <span class="shuzi word" style="left: 91.5%;font-size: 60px;line-height: 70px;top: 3%;"
                  data-sx1="60" data-sx2="70" data-sx3="3"
                  v-cloak>@{{ items[8] }}</span>
        </div>
        <div class="tiao word" data-sx3="693" :style="{ width: animatedNumber1 + '%' }">
            <img class="word" data-sx4="31" data-sx5="963" style="width: 963px;height: 31px;"
                 src="{{get_img_path('images/hd/1109/tiao.png')}}">
        </div>


        <map id="map1" name="map1">
            <area href="javascript:;" shape="rect" coords=''
                  data-coords='{"x1":"0","y1":"0","x2":"0","y2":"0","w":"1349","h":"843"}'>
        </map>
        <input type="hidden" id="start" value="{{strtotime('2017-11-09 00:00:00')}}">
        <input type="hidden" id="end" value="{{strtotime('2017-11-10 00:00:00')}}">
    </div>
    <script src="{{path('js/map.js')}}"></script>
    <script>
        let data = {
            items: [0, 0, 0, 0, 0, 0, 0, 0, 0],
            lists_right: [
                {
                    log_id: 1,
                    msn: '',
                    log: '',
                },
                {
                    log_id: 2,
                    msn: '',
                    log: '',
                },
                {
                    log_id: 3,
                    msn: '',
                    log: '',
                },
                {
                    log_id: 4,
                    msn: '',
                    log: '',
                },
                {
                    log_id: 5,
                    msn: '',
                    log: '',
                },
                {
                    log_id: 6,
                    msn: '',
                    log: '',
                },
                {
                    log_id: 7,
                    msn: '',
                    log: '',
                },
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
        let vm = new Vue({
            el: '#data',
            data: data,
            watch: {
                money: function (newValue, oldValue) {
                    function animate() {
                        if (TWEEN.update()) {
                            requestAnimationFrame(animate)
                        }
                    }

                    new TWEEN.Tween({tweeningNumber: oldValue})
                        .easing(TWEEN.Easing.Quadratic.Out)
                        .to({tweeningNumber: newValue}, 2000)
                        .onUpdate(function () {
                            vm.animatedNumber = this.tweeningNumber.toFixed(0)
                            to_array(vm.animatedNumber);
                        })
                        .start();
                    animate()
                },
                jindu: function (newValue, oldValue) {
                    function animate() {
                        if (TWEEN.update()) {
                            requestAnimationFrame(animate)
                        }
                    }

                    new TWEEN.Tween({tweeningNumber: oldValue})
                        .easing(TWEEN.Easing.Quadratic.Out)
                        .to({tweeningNumber: newValue}, 2000)
                        .onUpdate(function () {
                            vm.animatedNumber1 = this.tweeningNumber.toFixed(2);
                        })
                        .start();
                    animate()
                },
            }
        });
        let daojishi;
        get_data(1);
        window.setInterval(get_data, 5000);
        function get_data(type) {
            axios.get('{{route('dpm')}}', {
                params: {
                    jindu: 0
                }
            })
                .then(function (response) {
                    adjust();
                    if (type == 1) {
                        data.djs.time = response.data.time;
                        if (data.djs.time > 0) {
                            daojishi = window.setInterval(djs, 1000);
                        }
                    }
                    if (data.money < response.data.money) {
                        data.old_money = data.money;
                        data.money = response.data.money;
                    }
                    let jp = response.data.jp;
                    if (jp.length > 7 && data.lists_right.length > 7) {
                        for (let i in jp) {
                            let has = 0;
                            for (let j in data.lists_right) {
                                if (jp[i].log_id == data.lists_right[j].log_id) {
                                    has = 1;
                                }
                            }
                            if (has == 0) {
                                data.lists_right.push(jp[i]);
                            }
                        }
                    } else if (jp.length <= 7 || data.lists_right.length <= 7) {
                        data.lists_right = response.data.jp;
                    }
                    if (data.lists_right.length > 7) {
                        setTimeout('lunbo()', 2000);
                    }
                    data.jindu = response.data.jindu;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
        function djs() {
            data.djs.hour = lws(Math.floor(data.djs.time / 3600));
            data.djs.minute = lws(Math.floor((data.djs.time % 3600) / 60));
            data.djs.second = lws(data.djs.time % 60);
            data.djs.time--;
            if (data.djs.time <= 0) {
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
            let str = val.toString();
            let len = str.length;
            for (let i = 0; i < (data.items.length - len); i++) {
                str = '0' + str;
            }
            data.items = str.split("");
        }
        function lunbo() {
            let m = $('.lists li:eq(0)').css('height');
            $('.lists li:eq(0)').animate({marginTop: "-" + m}, 1000, function () {
                $(this).css('margin-top', '0');
                $('.lists').append($(this));
            })
        }
    </script>
@endsection
