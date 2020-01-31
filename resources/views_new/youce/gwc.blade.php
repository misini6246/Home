@if($full_page==1)
    <div class="fix-title">
        <i class="gwc"></i>购物车
        <i class="quxiao" onclick="quxiao()"></i>
    </div>
    @if(count($result)==0)
        <div class="cart-none">
            <img src="{{get_img_path('images/new/cart-none.jpg')}}"/>
        </div>
    @else
        <div class="fixgwc-content">
            <div class="examples">
                <div class="gwc-scroll">
                    <div id="GwcDiv">
                        <div class="fixhwc-chanpin">
                            <ul id="gwc" page="1">
                                @foreach($result as $v)
                                    <li class="fixgwc-mz">
                                        @if(strpos($v->goods->tsbz,'z')!==false)
                                            <div class="fixgwc-title">
                                                <span>换购</span>
                                                <span>{{$v->goods->cxxx}}</span>
                                            </div>
                                        @endif
                                        <div class="img-box">
                                            <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                        src="{{$v->goods->goods_thumb}}"/></a>
                                        </div>
                                        <p class="biaot">{{str_limit($v->goods->goods_name,26)}}</p>
                                        <p class="fixgwc-company">{{str_limit($v->goods->sccj,30)}}</p>
                                        <p>{{$v->goods->spgg}}</p>
                                        <span class="jiage">
                                            <span class="shanchu"
                                                  onclick="shanchu('从购物车删除商品{{$v->goods->goods_name}}','{{$v->rec_id}}','delete_gwc',$(this))">删除</span>
                                            {{formated_price($v->goods_price)}}
                                            <span>x{{$v->goods_number}}</span></span>

                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixgwc-jiesuan">
            <p>
                <span class="cart_number">{{cart_info()}}</span>件商品
            </p>
            <p>
                共计：<span id="gwc_total">{{formated_price($total)}}</span>
            </p>
            <a href="/cart">
                去购物车结算
            </a>
        </div>
    @endif
@else
    @foreach($result as $v)
        <li class="fixgwc-mz">
            @if(strpos($v->goods->tsbz,'z')!==false)
                <div class="fixgwc-title">
                    <span>换购</span>
                    <span>{{$v->goods->cxxx}}</span>
                </div>
            @endif
            <div class="img-box">
                <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                            src="{{$v->goods->goods_thumb}}"/></a>
            </div>
            <p class="biaot">{{str_limit($v->goods->goods_name,26)}}</p>
            <p class="fixgwc-company">{{str_limit($v->goods->sccj,30)}}</p>
            <p>{{$v->goods->spgg}}</p>
            <span class="jiage">
                <span class="shanchu"
                      onclick="shanchu('从购物车删除商品{{$v->goods->goods_name}}','{{$v->rec_id}}','delete_gwc',$(this))">删除</span>
                {{formated_price($v->goods_price)}}
                <span>x{{$v->goods_number}}</span></span>

        </li>
    @endforeach
@endif