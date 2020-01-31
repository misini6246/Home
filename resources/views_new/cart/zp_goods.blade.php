@if(isset($v->child)&&count($v->child)>0)
    @foreach($v->child as $child)
        <p class="zp" id="zp_goods{{$v->rec_id}}">
            <span class="zp_box">
                赠品
            </span>
            <span class="name">{{$child->zp_goods->goods_name}}</span>
            <span class="gg">规格：{{$child->zp_goods->ypgg}}</span>
            <span class="company">{{$child->zp_goods->product_name}}</span>
            <span class="money">{{formated_price($child->goods_price)}}</span>
            <span class="sl">{{$child->goods_number}}</span>
            <span class="xj">{{formated_price($child->goods_price*$child->goods_number)}}</span>
        </p>
    @endforeach
@endif