<div class="hot content">
    <div class="content_box">
        <div class="content_title">
            <div class="img_box">
                <img src="{{get_img_path('images/jf/hot_03.png')}}"/>
            </div>
            <span>热门兑换榜</span>
        </div>
        <ul>
            @foreach($top5 as $k=>$v)
                <li>
                    <div class="img_box">
                        <a target="_blank" href="{{route('jifen.goods.show',['id'=>$v->id])}}"><img
                                    src="http://jf.jyeyw.com/{{substr($v->goods_image,1)}}"/></a>
                        @if($k<3)
                            <div class="top">
                                TOP {{$k+1}}
                            </div>
                        @endif
                    </div>
                    <div class="text">
                        <p>{{$v->name}}</p>
                        <div class="jifen">
                            <span>{{$v->jf}}积分</span>
                            <img src="{{get_img_path('images/jf/jrgwc_03.png')}}"
                                 onclick="add_to_cart('{{$v->id}}',1)"/>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>