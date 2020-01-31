@extends('miaosha.app')
@section('links')
    <link href="{{asset('css/new/mrms.css')}}" rel="stylesheet" type="text/css"/>
@endsection
@section('content')
    <div class="big_container">
        <div class="top"></div>
        <div class="content_box">
            <div class="content" id="goods_box">
                @forelse($collect as $k=>$v)
                    <div class="product_{{$k%2 + 1}}">
                        <div class="img_box">
                            <div class="qzsj">
                                起止时间:
                                {{date('Y-m-d',strtotime($v->miaoshaGroup->start_time))}}
                                到
                                {{date('Y-m-d',strtotime($v->miaoshaGroup->end_time)-1)}}
                            </div>
                            <img width="260" height="260" src="{{$v->goods->goods_thumb}}"/>
                            <div id="{{$v->group_id}}-{{$v->goods_id}}-bg">
                                @if($v->is_has==1)
                                    <div class="status status_2"></div>
                                @elseif($v->goods_number<=0)
                                    <div class="status status_3"></div>
                                @endif
                            </div>
                        </div>
                        <div class="text_box">
                            <p class="name">{{str_limit($v->goods->goods_name,20)}}</p>
                            <p class="gx">规格：{{$v->goods->spgg}}</p>
                            <p class="cj">厂家：{{str_limit($v->goods->sccj,30)}}</p>
                            <div class="line" style="margin-top: 15px;"></div>
                            <div class="num_box">
                                <p class="xl">限量：<span>{{$v->min_number}}{{$v->goods->dw}}</span></p>
                                {{--<p class="zl">总量：<span><span--}}
                                {{--id="{{$v->group_id}}-{{$v->goods_id}}-kc">{{$v->goods_number}}</span>{{$v->goods->dw}}</span>--}}
                                {{--</p>--}}
                                <p class="zl"><span>{{$v->description}}</span>
                                </p>
                            </div>
                            <div class="price_box">
                                <p class="xj">{{formated_price($v->goods_price)}}</p>
                                <p class="yj">正价: <span>{{formated_price($v->goods->shop_price)}}</span></p>
                            </div>
                            <div class="line" style="margin-top: 9px;"></div>
                            <div id="{{$v->group_id}}-{{$v->goods_id}}-btn">
                                @if($v->is_has==1)
                                    <input type="button" name="btn" class="btn btn_sta_2" value="已抢购"/>
                                @elseif($v->goods_number<=0)
                                    <input type="button" name="btn" class="btn btn_sta_3" value="已抢完"/>
                                @else
                                    <input type="button" name="btn" class="btn btn_sta_1" value="立即抢购"
                                           onclick="addCart('{{$v->group_id}}','{{$v->goods_id}}')"/>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="height: 320px;width: 100%"></div>
                @endforelse
            </div>
        </div>
        <div class="bottom"></div>
    </div>
    <script>
        $(function () {

        });

        function addCart(group_id, goods_id) {
            $.ajax({
                url: '/xin/miaosha/add_cart',
                type: 'get',
                data: {group_id: group_id, goods_id: goods_id},
                dataType: 'json',
                success: function (data) {
                    if (data.error >= 300) {
                        layer.msg(data.msg, {icon: 2});
                        return false;
                    }
                    var icon = data.error + 1;
                    if (data.error == 2) {
                        icon = 2;
                    }
                    layer.confirm(data.msg, {
                        btn: ['继续购物', '去结算'], //按钮
                        icon: icon
                    }, function (index) {
                        layer.close(index);
                    }, function () {
                        location.href = '/cart';
                        return false;
                    });
                    // $('#' + group_id + '-' + goods_id + '-kc').text(data.goods_number);
                    if (data.error == 2) {
                        $('#' + group_id + '-' + goods_id + '-btn').html('<input type="button" name="btn" class="btn btn_sta_3" value="已抢完"/>')
                        $('#' + group_id + '-' + goods_id + '-bg').html('<div class="status status_3"></div>')
                    } else {
                        $('#' + group_id + '-' + goods_id + '-btn').html('<input type="button" name="btn" class="btn btn_sta_2" value="已抢购"/>')
                        $('#' + group_id + '-' + goods_id + '-bg').html('<div class="status status_2"></div>')
                    }
                }
            });
        }
    </script>
@endsection