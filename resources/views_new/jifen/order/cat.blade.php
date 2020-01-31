<ul class="common_ul">
    @foreach($cat as $k=>$v)
        @if($k<5)
            <li>
                <div class="img_box">
                    <a target="_blank" href="{{route('jifen.goods.show',['id'=>$v->id])}}"><img
                                src="http://jf.jyeyw.com.{{substr($goods->goods_image,1)}}"/></a>
                </div>
                <div class="xx">
                    <p class="text_overflow">
                        {{$v->name}}
                    </p>
                    <p class="jiage">
                        参考价：<span>{{formated_price($v->market_price)}}</span>
                    </p>
                    <p class="jf">
                        <img src="/jfen/jrgwc_03.png" class="fr"
                             onclick="add_to_cart('{{$v->id}}',1)"/>
                        <span>{{$v->jf}}积分</span>
                    </p>
                </div>
            </li>
        @endif
    @endforeach
</ul>