@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/jifen/jfdhjb.css')}}1"/>
    <!--IE兼容-->
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="{{path('css/index/iehack.css')}}"/>
    <![endif]-->
    <!--IE兼容-->
    <!--[if lte IE 7]>
    <script src="{{path('js/index/IEhack.js')}}" type="text/javascript" charset="utf-8"></script>
    <![endif]-->
    <style>
        #footer {
            margin-top: 0;
        }
    </style>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    <div class="container top" style="height: 1110px">
        <div class="main">
            <div class="main_title">
                您目前的{{trans('common.pay_points')}}为：<span id="pay_points">{{$user->pay_points}}</span>
            </div>
            <ul class="jf">
                @foreach($rules as $k=>$v)
                    <li>
                        <div class="img_bg">
                            <p>{{$k}}个</p>
                            <p>{{trans('common.jf_money')}}</p>
                        </div>
                        <p class="jifen">{{$v}}积分兑换</p>
                        <p class="tj">(等价{{$k}}元{{trans('common.cz_money')}})</p>
                        <input type="button" value="点击兑换" onclick="lq_yhq('{{$k}}','{{$v}}')"/>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="sm" style="height: 280px;">
            <div class="sm_title"><img src="{{get_img_path('adimages1/201805/jifen/sm_title.png')}}"/></div>
            <ul class="sm_list">
                <li>1，会员可根据自身积分数量选择合适数量{{trans('common.jf_money')}}进行兑换，兑换成功后可在“我的药易购”中查看；</li>
                <li>2，下单时默认优先使用{{trans('common.jf_money')}}进行抵扣；</li>
                <li>3，{{trans('common.jf_money')}}可与优惠券重叠或累计使用；</li>
                <li>4、除含麻、血液制品、秒杀之外，全场通用；</li>
                <li>5、货到付款不可使用{{trans('common.jf_money')}}；</li>
                <li>6、每月底清零所有兑换的{{trans('common.jf_money')}}。</li>
            </ul>
        </div>
    </div>
    <input type="hidden" id="type" value="0">
    <script>
        function lq_yhq(id, points) {
            var pay_points = parseInt($('#pay_points').text());
            if (pay_points < parseInt(points)) {
                layer.msg('积分不足！', {icon: 2})
                return false;
            }
            layer.confirm('确定兑换' + id + '{{trans('common.jf_money')}}？<br/><span style="color:red">提示：每月底清零所有兑换未使用的积分金币</span>', function (e) {
                var type = parseInt($('#type').val());
                $('#type').val(1);
                layer.close(e);
                if (type == 0) {
                    $.ajax({
                        url: '/jifen/jf_money',
                        data: {id: id},
                        async: true,
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
                            }
                            layer.msg(data.msg, {icon: data.error + 1})
                            $('#pay_points').text(data.pay_points);
                            $('#type').val(0);
                        }
                    })
                }
            });
        }
    </script>
    @include('layouts.old_footer')
@endsection
