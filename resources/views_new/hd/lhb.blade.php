@extends('common.vue_index')
@section('links')
    <script src="https://cdn.jsdelivr.net/npm/tween.js@16.3.4"></script>
    <style type="text/css">
        * {
            padding: 0;
            margin: 0;
            font-family: "Microsoft YaHei";
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
            width: 20%;
            top: 82%;
        }

        .bang-left {
            left: 13%
        }

        .bang-middle {
            left: 40%
        }

        .bang-right {
            right: 13%;
        }

        .title {
            position: absolute;
            text-align: center;
            color: #ffffff;
            width: 100%;
            height: 11%;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: middle;
        }

        .lists {
            top: 11%;
            height: 82.5%;
            position: absolute;
            left: 17%;
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
            width: 50%;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            vertical-align: middle;
        }

        .left li .first {
            width: 60% !important;
        }

        .log {
            color: #f9e794;
            vertical-align: middle;
        }
    </style>
@endsection
@section('content')
    <div id="data">
        <div style="position: relative;" id="img1">
            <img src="{{get_img_path('images/hd/1109/lhbg_pc.jpg')}}">
        </div>
        <div class="bang bang-left word" data-sx3="540.516">
            <img src="{{get_img_path('images/hd/1109/lhbang.png')}}">
            <div class="title word" style="font-size: 20px;line-height: 40px;top: 0;"
                 data-sx1="20" data-sx2="40" data-sx3="0">单品最佳人气排行榜
            </div>
            <ul class="lists left">

            </ul>
            <div class="title word" style="font-size: 12px;line-height: 24px;bottom: 0;height: 7%"
                 data-sx1="12" data-sx2="24" title="单品最具人气奖冠军奖励5万元现金+价值8000元推广礼包">单品最具人气奖冠军奖励5万元现金
            </div>
        </div>
        <div class="bang bang-middle word" data-sx3="540.516">
            <img src="{{get_img_path('images/hd/1109/lhbang.png')}}">
            <div class="title word" style="font-size: 20px;line-height: 40px;top: 0;"
                 data-sx1="20" data-sx2="40" data-sx3="0">单品销量排行榜
            </div>
            <ul class="lists middle">

            </ul>
            <div class="title word" style="font-size: 12px;line-height: 24px;bottom: 0;height: 7%"
                 data-sx1="12" data-sx2="24" title="单品销量冠军奖励10万元现金+价值16000元推广礼包">单品销量冠军奖励10万元现金
            </div>
        </div>
        <div class="bang bang-right word" data-sx3="540.516">
            <img src="{{get_img_path('images/hd/1109/lhbang.png')}}">
            <div class="title word" style="font-size: 20px;line-height: 40px;top: 0;"
                 data-sx1="20" data-sx2="40" data-sx3="0">供应商销量排行榜
            </div>
            <ul class="lists right">

            </ul>
            <div class="title word" style="font-size: 12px;line-height: 24px;bottom: 0;height: 7%"
                 data-sx1="12" data-sx2="24" title="供货商销量冠军奖励15万元现金+价值40000元推广礼包">供货商销量冠军奖励15万元现金
            </div>
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
            lists_left: [],
            lists_middle: [],
            lists_right: []
        };
        get_data(1);
        window.setInterval(get_data, 10000);
        function get_data(type) {
            $.ajax({
                url: '{{route('lhb')}}'
                , type: 'get'
                , data: {jindu: 1}
                , dataType: 'json'
                , success: function (response) {
                    var left = response.xl1;
                    data.lists_left = check_lists(data.lists_left, left, '.left');
                    var middle = response.xl2;
                    data.lists_middle = check_lists(data.lists_middle, middle, '.middle');
                    var right = response.xl3;
                    data.lists_right = check_lists(data.lists_right, right, '.right');
                    adjust();
                }
            });
        }
        function check_lists(oldValue, newValue, _obj) {
            if (newValue.length > 10 && oldValue.length > 10) {
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
            } else if (newValue.length <= 10 || oldValue.length <= 10) {
                oldValue = newValue;
                bang(_obj, oldValue);
            }
//            if (oldValue.length > 10) {
//                setTimeout('lunbo()', 2000);
//            }
            return oldValue;
        }
        function lunbo() {
            var m = $('.lists li:eq(0)').css('height');
            $('.lists li:eq(0)').animate({marginTop: "-" + m}, 1000, function () {
                $(this).css('margin-top', '0');
                $('.lists').append($(this));
            })
        }
        function bang(_obj, lists) {
            var html = '';
            for (var i in lists) {
                html += '<li class="word" data-sx1="14" data-sx2="30" data-sx3="0" data-sx4="33">' +
                    '<span class="first" title="' + lists[i].name + '">' + lists[i].name + '</span><span class="log">' + lists[i].total + '</span> </li>';
            }
            $(_obj).html(html);
        }
        function add_bang(_obj, val) {
            var one = '<li class="word" data-sx1="14" data-sx2="30" data-sx3="0" data-sx4="33">' +
                '<span class="first" title="' + val.name + '">' + val.name + '</span><span class="log">' + val.total + '</span> </li>';
            $(_obj).append(one);
        }
    </script>
@endsection
