@foreach($result as $k=>$v)
    <li @if($k>=5) class="all_goods" style="display: none;" @endif>
        <div class="spqd_tbody_xx">
            <div class="spmc">
                <p class="img_box">
                    <img src="{{$v->goods->goods_thumb}}"/>
                </p>
                <p class="name">{{$v->goods->goods_name}}</p>
            </div>
            <div class="sccj">{{$v->goods->sccj}}</div>
            <div class="gg">{{$v->goods->spgg}}</div>
            <div class="xq"
                @if($v->goods->is_xq_red==1) style="color:#e70000;" @endif>{{$v->goods->xq}}</div>
            <div class="gyzz">{{$v->goods->gyzz}}</div>
            <div class="dj">{{formated_price($v->goods->real_price)}}</div>
            <div class="sl">{{$v->goods_number}}</div>
            <div class="xj">{{formated_price($v->goods->real_price*$v->goods_number)}}</div>
        </div>
        @if($v->goods->tsbz=='秒')
        <span class="jiesuan-span" style=" color:#ff2828;display: inline-block; font-size:10.5px;width: 170px;height: 30px;line-height: 30px;overflow: hidden">此商品不参与优惠券活动及返利活动</span>
        @endif
        @if($v->goods->is_yhq_status == 2)
            <span class="jiesuan-span" style=" color:#ff2828;display: inline-block;font-size:10.5px;width: 170px;height: 30px;line-height: 30px;overflow: hidden">此商品不参与优惠券活动及返利活动</span>
        @endif
        @if($v->goods->is_yhq_status == 1)
            @if($v->goods->is_promote == 1 && time() >= $v->goods->promote_start_date && time() < $v->goods->promote_end_date)
                <span class="jiesuan-span" style=" color:#ff2828;display: inline-block;width: 130px;height: 30px;line-height: 30px;overflow: hidden">此商品不参与优惠券活动及返利活动</span>
            @endif

            @if(time() >= $v->goods->preferential_start_date && time() < $v->goods->preferential_end_date && $v->goods->zyzk > 0.01)
                <span class="jiesuan-span" style=" color:#ff2828;display: inline-block;font-size:10.5px;width: 170px;height: 30px;line-height: 30px;overflow: hidden">此商品不参与优惠券活动及返利活动</span>
            @endif
        @endif
        @if($v->goods->is_zx==1&&count($v->child)>0)
            @foreach($v->child as $child)
                <div class="spqd_tbody_zp spqd_tbody_xx">
                    <div class="spmc">
                        <p class="img_box">
                            <span>赠品</span>
                        </p>
                        <p class="name">{{$child->zp_goods->goods_name}}</p>
                    </div>
                    <div class="sccj">{{$child->zp_goods->product_name}}</div>
                    <div class="gg"></div>
                    <div class="xq"></div>
                    <div class="gyzz"></div>
                    <div class="dj">{{formated_price($child->goods_price)}}</div>
                    <div class="sl">{{$child->goods_number}}</div>
                    <div class="xj">{{formated_price($child->goods_price*$child->goods_number)}}</div>
                </div>
            @endforeach
        @endif
    </li>
@endforeach