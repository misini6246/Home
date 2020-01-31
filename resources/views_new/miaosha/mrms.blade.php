@extends('miaosha.app')
@section('links')
    <link href="{{asset('css/new/mrms.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="big_container">
        <div class="top"></div>
        <div class="content_box">
            <div class="content" id="goods_box">
                <div class="btn_box">
                    @if(count($today)>0)
                        <span class="jrtj cur">今日特价</span>
                    @endif
                    @if(count($tomorrow)>0)
                        <span class="mryg @if(count($today)==0) cur @endif">明日预告</span>
                    @endif
                </div>
                @if(count($today)>0)
                    <div class="product_box product_cur" @if(count($today)>2) style="text-align: left;" @endif>
                        @foreach($today as $k=>$v)
                            <div class="product_{{$k%2 + 1}}">
                                <div class="img_box">
                                    <div class="qzsj">
                                        起止时间:
                                        {{date('Y-m-d',$v->promote_start_date)}}
                                        到
                                        {{date('Y-m-d',$v->promote_end_date-1)}}
                                    </div>
                                    <img width="260" height="260" src="{{$v->goods_thumb}}"/>
                                    <div id="{{$v->goods_id}}-bg">
                                        {{--@if($v->is_has==1)--}}
                                        {{--<div class="status status_2"></div>--}}
                                        {{--@elseif($v->goods_number<=0)--}}
                                        {{--<div class="status status_3"></div>--}}
                                        {{--@endif--}}
                                    </div>
                                </div>
                                <div class="text_box">
                                    <p class="name">{{str_limit($v->goods_name,20)}}</p>
                                    <p class="gx">规格：{{$v->spgg}}</p>
                                    <p class="cj">厂家：{{str_limit($v->sccj,30)}}</p>
                                    <div class="line" style="margin-top: 15px;"></div>
                                    <div class="num_box">
                                        <p class="xl" style="width: auto">限量：<span>{{$v->ls_ggg}}{{$v->dw}}</span></p>
                                        {{--<p class="zl">总量：<span><span--}}
                                        {{--id="{{$v->group_id}}-{{$v->goods_id}}-kc">{{$v->goods_number}}</span>{{$v->dw}}</span>--}}
                                        {{--</p>--}}
                                        <p class="zl" style="width: auto;float: right">效期：<span>{{$v->xq}}</span>
                                        </p>
                                    </div>
                                    <div class="price_box">
                                        <p class="xj">{{formated_price($v->promote_price)}}</p>
                                        <p class="yj">正价: <span>{{formated_price($v->shop_price)}}</span></p>
                                    </div>
                                    <div class="line" style="margin-top: 9px;"></div>
                                    <div id="{{$v->goods_id}}-btn">
                                        @if($v->is_has==1)
                                            <input type="button" name="btn" class="btn btn_sta_2" value="已抢购"/>
                                        @elseif($v->goods_number<=0)
                                            <input type="button" name="btn" class="btn btn_sta_3" value="已抢完"/>
                                        @else
                                            <input type="button" name="btn" class="btn btn_sta_1" value="立即抢购"
                                                   onclick="addCart('{{$v->goods_id}}','{{$v->ls_ggg}}')"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if(count($tomorrow)>0)
                    <div class="product_box @if(count($today)==0) product_cur @endif"
                         @if(count($today)>2) style="text-align: left;" @endif>
                        @foreach($tomorrow as $k=>$v)
                            <div class="product_{{$k%2 + 1}}">
                                <div class="img_box">
                                    <div class="qzsj">
                                        起止时间:
                                        {{date('Y-m-d',$v->promote_start_date)}}
                                        到
                                        {{date('Y-m-d',$v->promote_end_date-1)}}
                                    </div>
                                    <img width="260" height="260" src="{{$v->goods_thumb}}"/>
                                    <div id="{{$v->goods_id}}-bg">
                                        {{--@if($v->is_has==1)--}}
                                        {{--<div class="status status_2"></div>--}}
                                        {{--@elseif($v->goods_number<=0)--}}
                                        {{--<div class="status status_3"></div>--}}
                                        {{--@endif--}}
                                    </div>
                                </div>
                                <div class="text_box">
                                    <p class="name">{{str_limit($v->goods_name,20)}}</p>
                                    <p class="gx">规格：{{$v->spgg}}</p>
                                    <p class="cj">厂家：{{str_limit($v->sccj,30)}}</p>
                                    <div class="line" style="margin-top: 15px;"></div>
                                    <div class="num_box">
                                        <p class="xl" style="width: auto">限量：<span>{{$v->ls_ggg}}{{$v->dw}}</span></p>
                                        {{--<p class="zl">总量：<span><span--}}
                                        {{--id="{{$v->group_id}}-{{$v->goods_id}}-kc">{{$v->goods_number}}</span>{{$v->dw}}</span>--}}
                                        {{--</p>--}}
                                        <p class="zl" style="width: auto;float: right">效期：<span>{{$v->xq}}</span>
                                        </p>
                                    </div>
                                    <div class="price_box">
                                        <p class="xj">{{formated_price($v->promote_price)}}</p>
                                        <p class="yj">正价: <span>{{formated_price($v->shop_price)}}</span></p>
                                    </div>
                                    <div class="line" style="margin-top: 9px;"></div>
                                    <div id="{{$v->goods_id}}-btn">
                                        @if($v->is_has==1)
                                            <input type="button" name="btn" class="btn btn_sta_2" value="已抢购"/>
                                        @elseif($v->goods_number<=0)
                                            <input type="button" name="btn" class="btn btn_sta_3" value="已抢完"/>
                                        @else
                                            <input type="button" name="btn" class="btn btn_sta_1" value="敬请期待"/>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <div class="bottom"></div>
    </div>
    <script>
        $(function () {
            //切换
            $('.btn_box span').hover(function () {
                $(this).addClass('cur').siblings().removeClass('cur')
                $('.product_box').eq($(this).index()).addClass('product_cur').siblings().removeClass('product_cur')
            });
        });

        function addCart(id, num) {
            $.ajax({
                url: '/new_gwc',
                data: {id: id, num: num, product_id: 0},
                dataType: 'json',
                success: function (data) {
                    if (data.error == 0) {
                        if (data.type == 0) {
                            layer.msg('购物车已有该商品', {icon: 0})
                        } else {
                            layer.confirm(data.msg, {
                                btn: ['继续购物', '去结算'], //按钮
                                icon: 1
                            }, function (index) {
                                layer.close(index);
                            }, function () {
                                location.href = '/cart';
                                return false;
                            });
                        }
                    } else if (data.error == 2) {
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
                        if (data.msg.indexOf('血液制品采购委托书') > 0 || data.msg.indexOf('冷藏药品采购委托书') > 0) {
                            layer.alert(data.msg, {
                                btn: ['下载委托书', '确定'], //按钮
                                icon: 2
                            }, function (index) {
                                location.href = '/uploads/血液制品、冷藏药品采购委托书（二合一）.doc';
                            })
                        } else {
                            layer.alert(data.msg, {icon: 2})
                        }
                    }
                }
            })
        }
    </script>
@endsection