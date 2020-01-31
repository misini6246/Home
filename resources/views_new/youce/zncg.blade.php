@if($full_page==1)
    <div class="fix-title">
        <i class="icon-zncg"></i>智能采购
        <i class="quxiao" onclick="quxiao()"></i>
    </div>
    @if(count($result)==0)
        <div class="cart-none" style="text-align: center;position: absolute;top: 40%;width: 100%;">
            <img src="{{get_img_path('images/new/zn-none.jpg')}}"/>
        </div>
    @else
        <p class="text">
            下面商品为您的历史购买品种。
        </p>
        <div class="fixgwc-content">
            <div class="examples">
                <div class="zncg-scroll">
                    <div id="zncgDiv">
                        <div class="fixhwc-chanpin">
                            <ul id="zncgsp" page="1">
                                @foreach($result->goods as $v)
                                    <li>
                                        <div class="img-box">
                                            <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                        src="{{$v->goods_thumb}}"/></a>
                                        </div>
                                        <p class="biaot">{{str_limit($v->goods_name,26)}}</p>
                                        <p class="fixgwc-company">{{str_limit($v->sccj,30)}}</p>
                                        <p>{{$v->spgg}}</p>
                                        <span class="jiage">
                                            <span class="shanchu" onclick="newtocart('{{$v->goods_id}}','{{$v->zbz}}')">加入购物车</span>
                                            {{formated_price($v->real_price)}}</span>
                                        <div class="fixgwc-title">
                                            <p>提示</p>
                                            <p>本商品您已采购过<span>{{$v->goods_number}}</span>次</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@else
    @foreach($result->goods as $v)
        <li>
            <div class="img-box">
                <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                            src="{{$v->goods_thumb}}"/></a>
            </div>
            <p class="biaot">{{str_limit($v->goods_name,26)}}</p>
            <p class="fixgwc-company">{{str_limit($v->sccj,30)}}</p>
            <p>{{$v->spgg}}</p>
            <span class="jiage">
                <span class="shanchu" onclick="newtocart('{{$v->goods_id}}','{{$v->zbz}}')">加入购物车</span>
                {{formated_price($v->real_price)}}</span>
            <div class="fixgwc-title">
                <p>提示</p>
                <p>本商品您已采购过<span>{{$v->goods_number}}</span>次</p>
            </div>
        </li>
    @endforeach
@endif