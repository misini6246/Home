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
<script>
    var djs_time = 0;
    $('.djs').each(function (index) {
        var this_djs_time = parseInt($(this).data('djs'));
        if (index == 0) {
            djs_time = this_djs_time;
        } else {
            if (this_djs_time < djs_time) {
                djs_time = this_djs_time;
            }
        }
    });
    var djs_fun = setInterval('djs()', 1000);

    function djs() {
        if (djs_time == 0) {
            clearInterval(djs_fun);
            getMrms();
        }
        djs_time--;
    }
</script>