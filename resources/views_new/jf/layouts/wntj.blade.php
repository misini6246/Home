@if(count($wntj)>3)
    <div id="wntj">
        <div class="wntj_title">
            <img src="{{get_img_path('images/jf/dian_03.png')}}"/><span>礼品推荐</span>
        </div>
        <div id="ban2">
            <div class="banner">
                <ul class="img">
                    <li>
                        @foreach($wntj as $k=>$v)
                            @if($k<4)
                                <div class="wntj-cp">
                                    <div class="wntj-img-box">
                                        <a href="{{route('jf.goods.show',['id'=>$v->id])}}">
                                            <img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}"/>
                                        </a>
                                    </div>
                                    <p class="mingzi">{{$v->name}}</p>
                                    <p class="jiage">积分：{{$v->jf}}</p>
                                </div>
                            @endif
                        @endforeach
                    </li>
                    @if(count($wntj)>6)
                        <li>
                            @foreach($wntj as $k=>$v)
                                @if($k>=4&&$k<8)
                                    <div class="wntj-cp">
                                        <div class="wntj-img-box">
                                            <a href="{{route('jf.goods.show',['id'=>$v->id])}}">
                                                <img src="{{get_img_path('jf/'.substr($v->goods_image,1))}}"/>
                                            </a>
                                        </div>
                                        <p class="mingzi">{{$v->name}}</p>
                                        <p class="jiage">积分：{{$v->jf}}</p>
                                    </div>
                                @endif
                            @endforeach
                        </li>
                    @endif
                </ul>
                <div class="btn btn_l">
                    <img src="{{get_img_path('images/jf/tj_prev_03.png')}}"/>
                </div>
                <div class="btn btn_r">
                    <img src="{{get_img_path('images/jf/tj_next_03.png')}}"/>
                </div>
            </div>
        </div>
    </div>
@endif