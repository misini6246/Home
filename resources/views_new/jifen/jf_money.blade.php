@extends('jifen.layouts.body')
@section('links')
    <link href="{{path('css/jifen/common.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{path('css/jifen/jfdhjb.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    @include('jifen.layouts.header')
    @include('jifen.layouts.nav')
    <div class="container top">
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
                        <input type="button" value="点击兑换" onclick="lq_yhq('{{$k}}','{{$k}}')"/>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="sm">
            <div class="sm_title"><img src="{{get_img_path('adimages1/201805/jifen/sm_title.png')}}"/></div>
            <ul class="sm_list">
                <li>1，会员可根据自身积分数量选择合适数量{{trans('common.jf_money')}}进行兑换，兑换成功后可在“我的药易购”中查看；</li>
                <li>2，下单时默认优先使用{{trans('common.jf_money')}}进行抵扣；</li>
                <li>3，{{trans('common.jf_money')}}可与优惠券重叠或累计使用；</li>
                <li>4、除含麻、血液制品之外，全场通用；</li>
                <li>5、每月底清零所有兑换的{{trans('common.jf_money')}}。</li>
            </ul>
        </div>
    </div>
    <script>
        function lq_yhq(id, je) {
            layer.confirm('确定兑换' + je + '{{trans('common.jf_money')}}？', function (e) {
                layer.closeAll();
                $.ajax({
                    url: '/jifen/jf_money',
                    data: {id: id},
                    async: false,
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
                    }
                })
            });
        }
    </script>
    @include('jifen.layouts.footer')
@endsection
