@extends('common.index')
@section('links')
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            font-family: "微软雅黑";
            list-style: none;
        }

        .container {
            width: 100%;
            height: 1000px;
            background: url('{{get_img_path('images/yhq/jifenPC_bg.jpg')}}') no-repeat scroll top center;
            min-width: 1200px;
            overflow: hidden;
        }

        .center {
            width: 1200px;
            margin: 457px auto;
        }

        .jifen {
            font-size: 36px;
            color: #e14538;
            width: 55px;
            margin: 0 auto;
        }

        .juan {
            overflow: hidden;
            margin-top: 160px;
        }

        .juan li {
            width: 220px;
            height: 302px;
            float: left;
            margin-left: 25px;
            box-sizing: border-box;
            position: relative;
        }

        .juan li:first-child {
            margin-left: 0;
        }

        .juan li a {
            display: inline-block;
            width: 100%;
            height: 56px;
            position: absolute;
            bottom: 0;
            left: 0;
        }

        #alert_box {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 2;
            display: none;
        }

        #alert_box .tcc {
            text-align: center;
            position: relative;
            width: 702px;
            height: 699px;
            margin: 95px auto;
            background: url('{{get_img_path('images/yhq/jifentcc.png')}}');
            overflow: hidden;
        }

        .money {
            height: 45px;
            margin-top: 265px;
            color: #f63c3c;
            font-size: 48px;
        }

        #alert_box .tcc a {
            display: inline-block;
            width: 175px;
            height: 46px;
            margin-top: 129px;
        }

        #alert_box .tcc a#qr {
            margin-left: 10px;
        }

        #alert_box .tcc a#read {
            margin-left: 35px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="center">
            <p class="jifen">{{$user->pay_points}}</p>
            <ul class="juan">
                @foreach($rules as $k=>$v)
                    <li style="background: url('{{get_img_path('images/yhq/jifen_'.$k.'.png')}}') no-repeat;">
                        <a href="javascript:;" data-je="10" onclick="lq_yhq('{{$k}}','{{intval($k)}}')"></a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div id="alert_box">
            <div class="tcc">
                <p class="money"></p>
                <a href="javascript:;" id="qr" onclick="$('#alert_box').hide();$('#type').val(0);"></a>
                <a href="/jf_money/log" id="read" target="_blank"></a>
            </div>
        </div>
    </div>
    <input type="hidden" id="type" value="0">
    <script>
        function lq_yhq(id, je) {
            var type = $('#type').val();
            layer.confirm('确定兑换' + je + '积分金币？', function (e) {
                layer.closeAll();
                if (type == 0) {
                    $('#type').val(1);
                    $.ajax({
                        url: '/jf_money',
                        data: {id: id},
                        async: false,
                        dataType: 'json',
                        success: function (data) {
                            if (data.error == 2) {
                                $('#type').val(1);
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
                                $('.money').text(je);
                                $('#alert_box').show();
                                if (data.error == 3) {
                                    data.error = 1;
                                }
                            } else {
                                layer.msg(data.msg, {icon: data.error + 1})
                                $('#type').val(0);
                            }
                            $('.jifen').text(data.pay_points);
                        }
                    })
                }
            });
        }
    </script>
@endsection
