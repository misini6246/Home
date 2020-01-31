@extends('layouts.app')
@section('links')
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>物流配送</title>
    <link rel="stylesheet" type="text/css" href="/index/common/css/com-css.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuancommon.css" />
    <link rel="stylesheet" type="text/css" href="/user/huiyuanzhongxin.css" />
    <link rel="stylesheet" type="text/css" href="/user/wuliu.css"/>
    <!--layer-->
    <link rel="stylesheet" type="text/css" href="common/layer/layer.css" />

    <script src="/index/common/js/jQuery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="/index/common/js/com-js.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/common_hyzx.js" type="text/javascript" charset="utf-8"></script>
    <script src="/user/huiyuancommon.js" type="text/javascript" charset="utf-8"></script>
@endsection
@section('content')
    @include('layouts.header')
    @include('layouts.search')
    @include('layouts.nav')
    @include('layouts.youce')

    <div class="container" id="user_center">
        <div class="container_box">
            <div class="top_title">
                <img src="/user/img/详情页_01.png"/><span>当前位置：</span>
                <a href="{{route('index')}}">首页</a><img src="/user/img/right_03.png"
                                                        class="right_icon"/><a
                        href="{{route('member.index')}}">我的今瑜e药网</a><img
                        src="/user/img/right_03.png" class="right_icon"/><span>配送物流</span>
            </div>
            @include('user.left')
            <div class="right">
                <div class="right_title">
                    <img src="/new_gwc/jiesuan_img/椭圆.png"/>
                    <span>配送物流</span>
                </div>
                @if(isset($shipping)&&$user->shipping_id==0)
                    <form action="{{route('member.set_wl')}}" method="post" onsubmit="return check_sub()">
                        <div class="choose_before">
                            <div class="choose_title">
                                请选择适合您的物流配送方式
                            </div>
                            {!! csrf_field() !!}
                            <input type="hidden" name="shipping_id" value="0">
                            <ul class="wl">
                                @foreach($shipping as $v)
                                    @if($v->shipping_id==9)
                                        @include('user.hzzp')
                                    @elseif($v->shipping_id==13)
                                        @include('user.ziti')
                                    @elseif($v->shipping_id==10)
                                        @include('user.ysdf')
                                    @elseif($v->shipping_id==17)
                                        @include('user.zjs')
                                    @else
                                        <li id="shipping{{$v->shipping_id}}"
                                            onclick="choose_shipping('{{$v->shipping_id}}')">
                                            <p class="name">{{$v->shipping_name}}</p>
                                            <div class="choose_box"><img class="select_wl"
                                                                         src="/user/img/select.png" style="display: none">
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                                {{--<li id="shipping-1" class="other_wl" onclick="choose_shipping('-1')">--}}
                                    {{--<p class="name">其他物流</p>--}}
                                    {{--<div class="xx">--}}
                                        {{--<p id="shipping_name">填写物流名称及电话</p>--}}
                                        {{--<p id="wl_dh"></p>--}}
                                    {{--</div>--}}
                                    {{--<div class="choose_box"><img class="select_wl"--}}
                                                                 {{--src="/user/img/select.png" style="display: none;"></div>--}}
                                {{--</li>--}}
                                {{--<li id="alert_box">--}}
                                    {{--<div class="alert_box_title">--}}
                                        {{--其他物流--}}
                                    {{--</div>--}}
                                    {{--<div>--}}
                                        {{--物流名称：<input name="shipping_name" style="border: 1px solid #ccc"--}}
                                                    {{--type="text"/><span>*</span>--}}
                                    {{--</div>--}}
                                    {{--<div>--}}
                                        {{--联系电话：<input name="wl_dh" style="border: 1px solid #ccc"--}}
                                                    {{--type="text"/><span>*</span>--}}
                                    {{--</div>--}}
                                    {{--<div>--}}
                                        {{--<input onclick="set_wl()" type="button" name="" id="qr" value="确认"/><input--}}
                                                {{--type="button" name=""--}}
                                                {{--id="qx" value="取消"/>--}}
                                    {{--</div>--}}
                                {{--</li>--}}
                            </ul>
                            <div class="tijiao">
                                <input type="submit" name="" id="tj_btn" value="确定"/>
                                <p>*请谨慎选择或填写，配送方式确定后如需更改需联系客服。</p>
                            </div>
                        </div>
                    </form>
                @elseif($user->shipping_id!=0)
                    <div class="choose_after">
                        <div class="choose_title">
                            您的物流配送方式
                        </div>
                        <div class="choose_wl">
                            <p class="wl_name">
                                物流名称：<span>{{$user->shipping_name}}</span>
                            </p>
                            <p class="wl_num">
                                物流电话：<span>{{$user->wl_dh}}</span>
                            </p>
                        </div>
                        <p style="color: #ff2929;
    font-size: 14px;
    margin: 15px 0 0 20px;">*配送方式如需更改请联系客服。</p>
                    </div>
                @else
                    <div class="choose_after">
                        <div class="choose_title">
                            填写收货地址后才能选择物流。
                        </div>
                    </div>
                @endif
            </div>
            <div style="clear: both"></div>
        </div>

    </div>
    <script type="text/javascript">
        $(function () {
            $('.other_wl').click(function (e) {
                $('#alert_box').show();
                $('#qr,#qx').click(function () {
                    $('#alert_box').hide();
                })
            })

        })
        function choose_shipping(id) {
            $('input[name=shipping_id]').val(id);
            $('.select_wl').hide();
            $('#shipping' + id).find('.select_wl').show();
        }
        function check_sub() {
            var id = $('input[name=shipping_id]').val();
            if (id == 0) {
                layer.msg('请选择物流', {icon: 2});
                return false;
            }
            if (id == 9) {
                var area = $('select[name=area_name]').val();
                if (area == '') {
                    layer.msg('请选择直配区域', {icon: 2});
                    return false;
                }
            }
            if (id == 13) {
                var kf = $('select[name=kf_name]').val();
                if (kf == '') {
                    layer.msg('请选择自提库房', {icon: 2});
                    return false;
                }
            }
            if (id == -1) {
                var shipping_name = $('input[name=shipping_name]').val();
                if (shipping_name == '') {
                    layer.msg('请填写物流名称', {icon: 2});
                    return false;
                }
            }
            return true;
        }
        function set_wl() {
            var shipping_name = $('input[name=shipping_name]').val();
            var wl_dh = $('input[name=wl_dh]').val();
            if (shipping_name != '') {
                $('#shipping_name').text(shipping_name);
            }
            $('#wl_dh').text(wl_dh);
        }
        //返回顶部
        $('.btn-top').click(function() {
            $('html,body').animate({
                'scrollTop': 0
            })
        });
    </script>
    @include('layouts.new_footer')
@endsection
