<div class="goods_prompt">
    <div class="get_address_title">礼品推荐</div>
    <div class="prompt">
        <button class="prompt_left reset_btn"></button>
        <ul class="clear_float">
            @foreach(getTj8() as $v)
                <li><a href="{{route('jf.goods',['id'=>$v->id])}}" target="_blank"><img src="{{get_img_path('jf')}}{{substr($v->goods_image,1)}}" width="134" height="134" alt=""/></a><p>{{$v->name}}</p></li>
            @endforeach
        </ul>
        <button class="prompt_right reset_btn"></button>
    </div>
</div>