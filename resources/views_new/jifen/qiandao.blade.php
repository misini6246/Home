@extends('jifen.layouts.body')
@section('links')
    <link href="{{path('css/jifen/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jifen/qiandao.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('jifen.layouts.header')
    @include('jifen.layouts.nav')
    <div class="container content">
        <div class="content_box">
            <div class="qiandao_top">
                <div class="fl">
                    <div class="qiandao_top_user">
                        <p class="qd_user">
                            {{$user->msn}}
                        </p>
                        @if($today)
                            <p class="qd_c">
                                已连续签到<span id="days">{{$today->days}}</span>天，累计签到<span
                                        id="count">{{count($days)}}</span>天
                            </p>
                        @elseif($yesterday)
                            <p class="qd_c">
                                已连续签到<span id="days">{{$yesterday->days}}</span>天，累计签到<span
                                        id="count">{{count($days)}}</span>天
                            </p>
                        @else
                            <p class="qd_c">
                                已连续签到<span id="days">0</span>天，累计签到<span
                                        id="count">{{count($days)}}</span>天
                            </p>
                        @endif
                        <p class="qd_btn">
                            @if($today)
                                <input id="qiandao" type="button" value="已签到" style="background: #ccc !important;"/>
                            @else
                                <input id="qiandao" type="button" value="点击签到" onclick="qiandao()"/>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="fr">
                    <div class="qd_y">
                        {{--<div class="btn">--}}
                        {{--<input type="button" name="prev" id="prev" value="<" class="disabled"/>--}}
                        {{--<input type="button" name="prev" id="next" value=">" class="disabled"/>--}}
                        {{--</div>--}}
                        <img src="{{get_img_path('jifen/images/qiandao_cal.png')}}"/>
                        <span id="date_title" data-date="{{$date['year']}}-{{$date['month']}}">
                            {{$date['year']}}年{{$date['month']}}月签到日历
                        </span>
                    </div>
                    <ul class="data_list">
                        @foreach($date['days'] as $v)
                            @if(in_array($v,$days))
                                <li class="yqd">
                                    {{$v}}
                                </li>
                            @elseif(date('d')==$v)
                                <li class="today">
                                    {{$v}}
                                    <span class="qdjf">+{{$jf}}</span>
                                </li>
                            @else
                                <li>
                                    {{$v}}
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="qiandao_bottom">
                <div class="qiandao_bottom_title">
                    活动规则：
                </div>
                <ul class="qiandao_bottom_list">
                    <li>
                        <img src="{{get_img_path('jifen/images/qiandao_li.png')}}"/>
                        <span>每天每客户可签到<span>1</span>次，获得积分奖励；连续签到累计次数当月有效，断签后重新累计，跨月重新累计。</span>
                    </li>
                    <li>
                        <img src="{{get_img_path('jifen/images/qiandao_li.png')}}"/>
                        <span>连续签到<span>第1天</span>至<span>第7天</span>，每次签到可获得<span>50积分</span>奖励； </span>
                    </li>
                    <li>
                        <img src="{{get_img_path('jifen/images/qiandao_li.png')}}"/>
                        <span>连续签到<span>第8天</span>至<span>第14天</span>，每次签到可获得<span>150积分</span>奖励； </span>
                    </li>
                    <li>
                        <img src="{{get_img_path('jifen/images/qiandao_li.png')}}"/>
                        <span>连续签到<span>第15天</span>至<span>第21天</span>，每次签到可获得<span>300积分</span>奖励； </span>
                    </li>
                    <li>
                        <img src="{{get_img_path('jifen/images/qiandao_li.png')}}"/>
                        <span>连续签到<span>第22天</span>至<span>第31天</span>，每次签到可获得<span>500积分</span>奖励； </span>
                    </li>
                    {{-- 刘磊 2019年6月12日14点15分 --}}
                    {{-- <li>
                        <img src="{{get_img_path('jifen/images/qiandao_li.png')}}"/>
                        <span>签到奖励积分自动存入积分账户，请在积分记录中查看；活动解释权在法律范围内由药易购所有，如有疑问请拨打400-993-7199咨询。</span>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            change_date(0);
        });

        function qiandao() {
            var loading=layer.load(1,{
                shade: [0.3,'#000'] 
            });
            $.ajax({
                url: '/jifen/qiandao',
                async: true,
                dataType: 'json',
                success: function (data) {
                    console.log(data);
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
                    }
                    else if (data.error == 0) {
                        $('#days').text(data.info.days);
                        $('#count').text(parseInt($('#count').text()) + 1);
                        $('#qiandao').val('已签到');
                        $('#qiandao').unbind('click');
                        $('#qiandao').css('background', '#ccc');
                        change_date(0);
                        
                    }
                    layer.alert(data.msg, {
                        icon: data.error + 1
                    });
                    layer.close(loading);
                }
            });
        }

        function change_date(next) {
            $.ajax({
                url: '/jifen/qiandao/change_date',
                data: {date: $('#date_title').data('date'), next: next},
                dataType: 'json',
                async: false,
                success: function (data) {
                    if (data['error'] == 0) {
                        var date = '{{date('Y-m-d')}}';
                        $('#date_title').text(data['date']['year'] + '年' + data['date']['month'] + '月签到日历')
                        $('#date_title').data('date', data['date']['year'] + '-' + data['date']['month']);
                        var days = '';
                        console.log(data);
                        for (k in data['date']['days']) {
                            if (data['days'].toString().indexOf(data['date']['days'][k].toString())!=-1){
                                days += '<li class="yqd">' + data['date']['days'][k] + '</li>';                
                            }
                            else if (date == format_time(data['date']['year'],data['date']['month'],data['date']['days'][k]))
                                days += '<li class="today">' + data['date']['days'][k] + '<span class="qdjf">+' + data['jf'] + '</span></li>';
                            else
                                days += '<li>' + data['date']['days'][k] + '</li>';
                        }
                        $('.data_list').html(days);
                        if (data['prev'] == true) {
                            $('#prev').unbind('click');
                            $('#prev').removeClass('disabled').addClass('enabled');
                            $('#prev').bind('click', function () {
                                change_date(-1);
                            });
                        } else {
                            $('#prev').removeClass('enabled').addClass('disabled');
                            $('#prev').unbind('click');
                        }
                        if (data['next'] == true) {
                            $('#next').unbind('click');
                            $('#next').removeClass('disabled').addClass('enabled');
                            $('#next').bind('click', function () {
                                change_date(1);
                            });
                        } else {
                            $('#next').removeClass('enabled').addClass('disabled');
                            $('#next').unbind('click');
                        }
                    } else {
                        layer.msg(data['msg'], {icon: data['error'] + 1});
                    }
                }
            })
        }
        //处理时间，日期小于10添加0
        function format_time(year,month,day){
            if(day<10){
                day='0'+day;
            }
            return year+'-'+month+'-'+day;
        }
    </script>
    @include('jifen.layouts.footer')
@endsection
