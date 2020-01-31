<div class="goods-box-left">
    {{--<ul class="goods-box-left-title">--}}
        {{--<li class="active qczhg">--}}
            {{--<a href="#">换购</a>--}}
        {{--</li>--}}
        {{--<li class="qjpmz">--}}
            {{--<a href="#">买赠</a>--}}
        {{--</li>--}}
    {{--</ul>--}}
    <ul class="goods-box-left-list zpczhg">
        @if(isset($mzhg[8]))
            @foreach($mzhg[8] as $k=>$v)
                @if($k<6)
                    <li>
                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                            <div class="bs layer_tips" id="czhg{{$v->rec_id}}" data-msg="{{$v->cxxx}}">活动内容<i
                                        class="jiantou result_xia"></i></div>
                            <div class="money">{{$v->format_price}}</div>
                            <img src="{{$v->goods_thumb}}"/>
                            <p class="name">{{$v->goods_name}}</p>
                            <p class="gg">{{$v->ypgg}}</p>
                            <p class="company">{{str_limit($v->sccj,30)}}</p>
                        </a>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
    <ul class="goods-box-left-list zpjpmz" style="display: none;">
        @if(isset($mzhg[10]))
            @foreach($mzhg[10] as $k=>$v)
                @if($k<6)
                    <li>
                        <a target="_blank" href="{{route('goods.index',['id'=>$v->goods_id])}}">
                            <div class="bs layer_tips" id="jpmz{{$v->rec_id}}" data-msg="{{$v->cxxx}}">活动内容<i
                                        class="jiantou result_xia"></i></div>
                            <div class="money">{{$v->format_price}}</div>
                            <img src="{{$v->goods_thumb}}"/>
                            <p class="name">{{$v->goods_name}}</p>
                            <p class="gg">{{$v->ypgg}}</p>
                            <p class="company">{{str_limit($v->sccj,30)}}</p>
                        </a>
                    </li>
                @endif
            @endforeach
        @endif
    </ul>
</div>
<script>
    $('.qczhg').hover(function () {
        $('.zpczhg').show();
        $('.zpjpmz').hide();
        $(this).addClass('active').siblings().removeClass('active')
    });
    $('.qjpmz').hover(function () {
        $('.zpjpmz').show();
        $('.zpczhg').hide();
        $(this).addClass('active').siblings().removeClass('active')
    })
</script>