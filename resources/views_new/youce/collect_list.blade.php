@if($full_page==1)
    <div class="fix-title">
        <i class="wdsc"></i>我的收藏
        <i class="quxiao" onclick="quxiao()"></i>
    </div>
    @if(count($result)==0)
        <div class="cart-none">
            <img src="{{get_img_path('images/new/sc-none.jpg')}}"/>
        </div>
    @else
        <div class="examples">
            <div class="wdsc-scroll">
                <div id="wdscDiv">
                    <div class="fixhwc-chanpin">
                        <ul id="collect_list" page="1" last_page="{{$result->lastPage()}}">
                            @foreach($result as $v)
                                <li>
                                    <div class="img-box">
                                        <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                                                    src="{{$v->goods->goods_thumb}}"/></a>
                                    </div>
                                    <p class="biaot">{{str_limit($v->goods->goods_name,26)}}</p>
                                    <p class="fixgwc-company">{{str_limit($v->goods->sccj,30)}}</p>
                                    <p>{{$v->goods->spgg}}</p>
                                    <span class="jiage">
                                         <span class="shanchu"
                                               onclick="shanchu('从收藏夹删除商品{{$v->goods->goods_name}}','{{$v->rec_id}}','delete_collect',$(this))">删除</span>
                                        <span class="jrgwc"
                                              onclick="newtocart('{{$v->goods_id}}','{{$v->goods->zbz}}')">加入购物车</span>
                                        {{formated_price($v->goods->real_price)}}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="wdsc-bottom">
        <a href="/user/collectList" class="ckqbsc">
            查看全部收藏
        </a>
    </div>
@else
    @foreach($result as $v)
        <li>
            <div class="img-box">
                <a href="{{route('goods.index',['id'=>$v->goods_id])}}"><img
                            src="{{$v->goods->goods_thumb}}"/></a>
            </div>
            <p class="biaot">{{str_limit($v->goods->goods_name,26)}}</p>
            <p class="fixgwc-company">{{str_limit($v->goods->sccj,30)}}</p>
            <p>{{$v->goods->spgg}}</p>
            <span class="jiage">
                <span class="shanchu"
                      onclick="shanchu('从收藏夹删除商品{{$v->goods->goods_name}}','{{$v->rec_id}}','delete_collect',$(this))">删除</span>
                <span class="jrgwc" onclick="newtocart('{{$v->goods_id}}','{{$v->goods->zbz}}')">加入购物车</span>
                {{formated_price($v->goods->real_price)}}</span>
        </li>
    @endforeach
@endif