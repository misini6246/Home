@if($type==0)
    <div class="dd_none">
        <img src="/user/img/search_none.jpg"/>
        <p>{{$emsg or '您还没有下过单，这里是空的'}}</p>
        <a target="_blank" href="{{route('category.index',['dis'=>1,'py'=>1])}}">去逛逛</a>
    </div>
@elseif($type==1)
    <div class="dd_none">
        <img src="/user/img/search_none.jpg"/>
        <p>您还没有收藏过商品，这里是空的</p>
        <a target="_blank" href="{{route('category.index',['dis'=>1,'py'=>1])}}">去逛逛</a>
    </div>
@elseif($type==2)
    <div class="dd_none">
        <img src="/user/img/search_none.jpg"/>
        <p>您还没有购买过商品，这里是空的</p>
        <a target="_blank" href="{{route('category.index',['dis'=>1,'py'=>1])}}">去逛逛</a>
    </div>
@elseif($type==3)
    <div class="dd_none">
        <img src="/user/img/search_none.jpg"/>
        <p>您还没有可用优惠券，这里是空的</p>
        {{--<a target="_blank" href="{{route('category.index',['dis'=>1,'py'=>1])}}">去逛逛</a>--}}
    </div>
@elseif($type==4)
    <div class="dd_none">
        <img src="/user/img/search_none.jpg"/>
        <p>{{$emsg or '记录为空'}}</p>
    </div>
@endif
