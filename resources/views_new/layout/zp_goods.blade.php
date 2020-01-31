<tr class="td-tip tr{{$v->rec_id}}" id="zp_goods{{$v->rec_id}}"
    @if((($v->goods->is_zx==1)&&!empty($v->goods->cxxx))||!empty($v->goods->bzxx)||!empty($v->goods->bzxx2)||$v->goods->tsbz=='预') style="display: table-row;"
    @else style="display: none;" @endif>
    <td colspan="12">
        @if(isset($v->child)&&count($v->child)>0)
            @foreach($v->child as $child)
                <div class="zengpin">
                    <span class="biaoshi">赠品</span>
                    <span class="name">{{$child->zp_goods->goods_name}}</span>
                    <span class="changjia">{{$child->zp_goods->product_name}}</span>
                    <span class="guige">{{$child->zp_goods->ypgg}}</span>
                    <span class="jianzhuang"></span>
                    <span class="xiaoqi"></span>
                    <span class="kucun"></span>
                    <span class="danjia">{{formated_price($child->goods_price)}}</span>
                    <span class="shuliang">{{$child->goods_number}}</span>
                    <span class="xiaoji">{{formated_price($child->goods_price*$child->goods_number)}}</span>
                    {{--<span class="caozuo">删除</span>--}}
                </div>
            @endforeach
        @endif
        <p>
            <span style="color:#444343;font-weight:bold;padding-left:10px;"> 注：</span>
            <span style="color:#ff6600">{{$v->goods->cxxx}}{{$v->goods->bzxx}}{{$v->goods->bzxx2}}@if($v->goods->tsbz=='预')
                    为保证抢购成功，预售商品请立即提交付款，商品随119订单一起配送。@endif</span>
        </p>
    </td>
</tr>