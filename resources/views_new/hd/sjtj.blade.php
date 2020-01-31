<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('services.web.title')}}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('css/sjtj.css')}}"/>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/echarts.min.js')}}"></script>
    <style>
        .right {
            float: right;
        }

        .left {
            float: left;
        }

        .bg_title {
            background-image: url('{{asset('images/sjtj/title.jpg')}}1');
            background-repeat: no-repeat;
        }

        .bg_html {
            background-image: url('{{asset('images/sjtj/big_data_bg.jpg')}}');
            background-repeat: no-repeat;
        }

        .title span {
            float: left;
        }

        .title span:first-child {
            color: #FFFFFF;
            font-size: 25px;
            font-family: "微软雅黑";
            margin-top: 30px;
            margin-left: 43px;
        }

        .title span:first-child + span {
            color: #FFFFFF;
            font-size: 35px;
            margin-left: 520px;
            margin-top: 19px;
        }

        .reg_user_y {
            position: absolute;
            top: 535px;
            left: 44px;
            height: 50px;
            line-height: 50px;
            width: 319px;
        }

        .reg_user_y span {
            font-family: "微软雅黑";
            font-size: 15px;
            color: #FFFFFF;
        }

        .reg_user_y span:first-child {
            margin-left: -1px;
        }

        .reg_user_y span:first-child + span {
            margin-left: 57px;
        }

        .reg_user_y .jdt {
            display: inline-block;
            margin-left: 55px;
            width: 80px;
            height: 8px;
            background-color: #29263B;
        }

        .reg_user_y .jdt div {
            background-color: #00A1E9;
            margin-left: -0.5px;
            margin-top: -0.2px;
            height: 8.4px;
        }

        .time_turnover_y {
            position: absolute;
            top: 668px;
            left: 43px;
            height: 100px;
            width: 336px;
        }

        .real_time_data {
            position: absolute;
            top: 83px;
            left: 57px;
            width: 226px;
            height: 121px;
        }

        .real_time_data p {
            margin-top: 60px;
            color: #FFFFFF;
            font-family: "微软雅黑";
            font-size: 47.21px;
            text-align: center;
        }

        .turnover, .reg_user {
            position: absolute;
            top: 200px;
            right: 45px;
            width: 424px;
        }

        .reg_user {
            top: 585px;
            width: 411px;
        }

        .time_turnover {
            position: absolute;
            top: 833px;
            left: 455px;
            height: 118px;
            width: 880px;
            /*background-color: #00A1E9;*/
        }

        .time_turnover span {
            color: #FFFFFF;
            font-size: 110px;
            line-height: 118px;
        }

        .time_turnover div {
            float: left;
            width: 260px;
            height: 118px;
        }

        .time_turnover div:first-child + div,
        .time_turnover div:first-child + div + div {
            margin-left: 50px;
        }

        .time_turnover div span {
            margin-left: 8px;
        }

        .time_turnover div span:first-child + span,
        .time_turnover div span:first-child + span + span {
            margin-left: 19px;
        }

        #main1, #main2, #main4 {
            width: 495px;
            height: 400px;
            margin-top: -30px;
            margin-right: -45px;
        }

        #main4 {
            width: 405px;
            margin-top: -45px;
        }
    </style>
</head>
<body>
<div class="container w1920 h1080 bg0C002A">
    <div class="title h69 bg_title">
        <span id="shijian" data-time="{{$now}}"></span>
        <span><img src="{{asset('images/sjtj/title_text.jpg')}}"/></span>
    </div>
    <div class="body_box bg_html h1011">

        <!--2014-2018年注册用户数开始-->
        <div class="reg_user_y">
            <span>2018年</span>
            <span id="user2018">{{$sj43}}</span>
            <div class="jdt">
                <div id="jdt" style="width: 0;"></div>
            </div>
        </div>
        <!--2014-2018年注册用户数结束-->

        <!--2014-2018年度交易额开始-->
        <div class="time_turnover_y" id="main4" style="margin-left: -30px;"></div>
        <!--2014-2018年度交易额结束-->

        <!--实时数据开始-->
        <div class="real_time_data">
            <p id="user_count">0</p>
        </div>
        <!--实时数据结束-->

        <!--2018年月交易额开始-->
        <div class="turnover" id="main2"></div>
        <!--2018年月交易额结束-->

        <!--注册用户类别及数量开始-->
        <div class="reg_user" id="main1"></div>
        <!--注册用户类别及数量结束-->

        <!--2018年交易额实时交易额开始-->
        <div class="time_turnover">
            <div>
                <span id="s8">0</span>
                <span id="s7">0</span>
                <span id="s6">0</span>
            </div>

            <div>
                <span id="s5">0</span>
                <span id="s4">0</span>
                <span id="s3">0</span>
            </div>

            <div>
                <span id="s2">0</span>
                <span id="s1">0</span>
                <span id="s0">0</span>
            </div>
        </div>
        <!--2018年交易额实时交易额结束-->
    </div>
</div>
{{--<div class="left">--}}
{{--<div id="main3" style="width: 600px;height:400px;"></div>--}}
{{--<div id="main4" style="width: 600px;height:400px;"></div>--}}
{{--</div>--}}
{{--<div class="right">--}}
{{--<div id="main1" style="width: 600px;height:400px;"></div>--}}
{{--<div id="main2" style="width: 600px;height:400px;"></div>--}}
{{--</div>--}}
<script>
    var myChart1 = echarts.init(document.getElementById('main1'));
    var myChart2 = echarts.init(document.getElementById('main2'));
    var myChart4 = echarts.init(document.getElementById('main4'));

    {{--myChart1.setOption({--}}
    {{--// title: {--}}
    {{--//     text: '注册用户类别及数量',--}}
    {{--// },--}}
    {{--legend: {--}}
    {{--// orient: 'vertical',--}}
    {{--// top: 'middle',--}}
    {{--bottom: 10,--}}
    {{--left: 'center',--}}
    {{--data: ['{{$sj11[0]}}', '{{$sj11[1]}}', '{{$sj11[2]}}', '{{$sj11[3]}}']--}}
    {{--},--}}
    {{--series: {--}}
    {{--type: 'pie',--}}
    {{--data: [--}}
    {{--{name: '{{$sj11[0]}}', value: '{{$sj12[0]}}'},--}}
    {{--{name: '{{$sj11[1]}}', value: '{{$sj12[1]}}'},--}}
    {{--{name: '{{$sj11[2]}}', value: '{{$sj12[2]}}'},--}}
    {{--{name: '{{$sj11[3]}}', value: '{{$sj12[3]}}'}--}}
    {{--]--}}
    {{--}--}}
    {{--});--}}
    {{--myChart2.setOption({--}}
    {{--// title: {--}}
    {{--//     text: '2018年月交易额'--}}
    {{--// },--}}
    {{--xAxis: {--}}
    {{--type: 'category',--}}
    {{--data: [--}}
    {{--@foreach($sj21 as $k=>$v)--}}
    {{--@if($k>0), @endif--}}
    {{--'{{$v}}月'--}}
    {{--@endforeach--}}
    {{--],--}}
    {{--axisLine: {--}}
    {{--lineStyle: {--}}
    {{--color: '#eee'--}}
    {{--}--}}
    {{--}--}}
    {{--},--}}
    {{--yAxis: {--}}
    {{--type: 'value',--}}
    {{--axisLine: {--}}
    {{--lineStyle: {--}}
    {{--color: '#eee'--}}
    {{--}--}}
    {{--}--}}
    {{--},--}}
    {{--series: [{--}}
    {{--data: [--}}
    {{--@foreach($sj22 as $k=>$v)--}}
    {{--@if($k>0),@endif--}}
    {{--{{$v}}--}}
    {{--@endforeach--}}
    {{--],--}}
    {{--label: {--}}
    {{--normal: {--}}
    {{--show: true,--}}
    {{--position: 'left',--}}
    {{--color: '#eee'--}}
    {{--}--}}
    {{--},--}}
    {{--type: 'line'--}}
    {{--}]--}}
    {{--});--}}

    {{--myChart4.setOption({--}}
    {{--title: {--}}
    {{--text: '2014-2018年度交易额'--}}
    {{--},--}}
    {{--xAxis: {--}}
    {{--type: 'category',--}}
    {{--data: [--}}
    {{--@foreach($sj31 as $k=>$v)--}}
    {{--@if($k>0), @endif--}}
    {{--'{{$v}}年'--}}
    {{--@endforeach--}}
    {{--]--}}
    {{--},--}}
    {{--yAxis: {--}}
    {{--type: 'value'--}}
    {{--},--}}
    {{--series: [{--}}
    {{--data: [--}}
    {{--@foreach($sj32 as $k=>$v)--}}
    {{--@if($k>0),@endif--}}
    {{--{{$v}}--}}
    {{--@endforeach--}}
    {{--],--}}
    {{--type: 'line'--}}
    {{--}]--}}
    {{--});--}}

    function getData() {
        $.ajax({
            url: '/sjtj',
            type: 'get',
            dataType: 'json',
            success: function (data) {
                for (var i in data.sj41) {
                    $('#s' + i).text(data.sj41[i])
                }
                $('#user_count').text(data.sj42);
                $('#user2018').text(data.sj43);
                $('#jdt').css('width', (data.sj43 / 8000) * 100 + '%');
                myChart1.setOption({
                    // title: {
                    //     text: '注册用户类别及数量',
                    // },
                    // legend: {
                    //     // orient: 'vertical',
                    //     // top: 'middle',
                    //     bottom: 10,
                    //     left: 'center',
                    //     data: [data.sj11[0], data.sj11[1], data.sj11[2], data.sj11[3]]
                    // },
                    series: {
                        type: 'pie',
                        radius: [0, 135],
                        center: ['52%', '52%'],
                        data: [
                            {
                                name: data.sj11[0], value: data.sj12[0], itemStyle: {
                                    color: '#02edb5'
                                }
                            },
                            {
                                name: data.sj11[1], value: data.sj12[1], itemStyle: {
                                    color: '#fa9022'
                                }
                            },
                            {
                                name: data.sj11[2], value: data.sj12[2], itemStyle: {
                                    color: '#e9ed03'
                                }
                            },
                            {
                                name: data.sj11[3], value: data.sj12[3], itemStyle: {
                                    color: '#e60012'
                                }
                            }
                        ]
                    }
                });
                myChart2.setOption({
                    // title: {
                    //     text: '2018年月交易额'
                    // },
                    xAxis: {
                        type: 'category',
                        data: data.sj21,
                        axisLine: {
                            lineStyle: {
                                color: '#eee'
                            }
                        }
                    },
                    yAxis: {
                        type: 'value',
                        axisLine: {
                            lineStyle: {
                                color: '#eee'
                            }
                        }
                    },
                    series: [{
                        data: data.sj22,
                        label: {
                            normal: {
                                show: true,
                                position: 'right',
                                color: '#eee'
                            }
                        },
                        type: 'line'
                    }]
                });
                myChart4.setOption({
                    // title: {
                    //     text: '2018年月交易额'
                    // },
                    xAxis: {
                        type: 'category',
                        data: data.sj31,
                        axisLine: {
                            lineStyle: {
                                color: '#eee'
                            }
                        }
                    },
                    yAxis: {
                        type: 'value',
                        axisLine: {
                            lineStyle: {
                                color: '#eee'
                            }
                        }
                    },
                    series: [{
                        data: data.sj32,
                        label: {
                            normal: {
                                show: true,
                                position: 'right',
                                color: '#eee'
                            }
                        },
                        type: 'line'
                    }]
                });
            }
        })
    }

    function getDate() {
        var today = new Date();
        var date = today.getFullYear() + "-" + twoDigits(today.getMonth() + 1) + "-" + twoDigits(today.getDate()) + " ";
        var time = twoDigits(today.getHours()) + ":" + twoDigits(today.getMinutes()) + ":" + twoDigits(today.getSeconds());
        $("#shijian").html(date + " " + time);
    }

    function twoDigits(val) {
        if (val < 10) return "0" + val;
        return val;
    }

    $(function () {
        getData();
        setInterval(getDate, 1000);
        setInterval(getData, 1000 * 10);
    });
</script>
</body>
</html>
