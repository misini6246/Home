<div class="title">
    <a href="{{route('user.collectList')}}" class="readmore">查看全部收藏</a>
    <img src="/new_gwc/jiesuan_img/椭圆.png"/>
    <span class="bt">我的收藏</span>
</div>
@if(count($result)>0)
    <table>
        <tr>
            <th class="mc">商品名称</th>
            <th class="cj">生产厂家</th>
            <th class="gg">规格</th>
            <th class="jg">价格</th>
            <th class="kc">库存</th>
            <th class="cz">操作</th>
        </tr>

        @foreach($result as $v)
            <tr>
                <td>
                    <a target="_blank" href="{{$v->goods_url}}">
                        <div class="mc">
                            {{$v->goods_name}}
                        </div>
                    </a>
                </td>
                <td>
                    <div class="cj" title="{{$v->sccj}}">{{str_limit($v->sccj,30)}}</div>
                </td>
                <td>
                    <div class="gg">
                        {{$v->ypgg}}
                    </div>
                </td>
                <td>
                    <div class="jg">
                        {{formated_price($v->real_price)}}
                    </div>
                </td>
                <td>
                    <div class="kc">
                        @if($v->goods_number>=800)
                            充裕
                        @elseif($v->goods_number==0)
                            缺货
                        @else
                            {{$v->goods_number}}
                        @endif
                    </div>
                </td>
                <td class="cz">
                    <img style="display: none;" class="fly_img{{$v->goods_id}}"
                         src="{{$v->goods_thumb}}"
                         alt="{{$v->goods_name}}"/>
                    <span class="jrgwc fly_to_cart{{$v->goods_id}}" onclick="tocart({{$v->goods_id}})">加入购物车</span>
                    <span class="qxsc" onclick="del($(this))"
                          data-config='{"url":"{{route('member.collection.destroy',['id'=>$v->goods_id])}}","msg":"确定从收藏夹删除该商品?",
                          "method":"delete","dataType":"json","box":"sc"}'
                    >取消收藏</span>
                </td>
            </tr>
        @endforeach
    </table>
@else
    @include('user.empty',['type'=>1])
@endif