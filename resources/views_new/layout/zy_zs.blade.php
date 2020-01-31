<div class="zhongyyp-left-box">
    <div class="left-zyypzq">
        <h3>中药饮片专区</h3>
        <ul class="zyypzq-list">
            @foreach(cate_tree(445) as $v)
                <li><a href="{{route('category.zyyp',['pid'=>$v->cat_id])}}"> {{$v->cat_name}}  </a></li>
            @endforeach
        </ul>
    </div>
    <div class="left-tjcj">
        <h3>推荐厂家</h3>
        <ul class="tjcj-list">
            @foreach(ads(98) as $k=>$v)
                @if($k<2)
                    <li>
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}" alt=""/>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>

    </div>
    <div class="list_next">
        <h3>一周销量排行榜</h3>
        <ul>
            @foreach($top1 as $k=>$v)
                <li @if($k==0)class="first"@endif>
                    <a href="{{$v->goods_url}}" class="list">
                        <span class="com_num red">{{$k+1}}</span>
                        <span class="name" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>
                        <span class="norms" alt="" title="{{$v->spgg}}" >{{str_limit($v->spgg,6)}}</span>
                    </a>
                            <span class="span_hide">
                                <span class="com_num red">{{$k+1}}</span>
                                <a href="{{$v->goods_url}}"><img src="{{$v->goods_thumb}}" alt="{{$v->goods_name}}" title="{{$v->goods_name}}"/></a>
                                <span class="title" style="margin: 0;
                                                           padding: 0;
                                                           border: 0;
                                                           font-size: 12px;
                                                           font-family: '微软雅黑';
                                                           vertical-align: baseline;margin-top:11px;color:#5b5a5a;" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>
                                <span class="norms" alt="" title="{{$v->spgg}}" >{{str_limit($v->spgg,6)}}</span>
                            </span>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="list_next">
        <h3>一月销量排行榜</h3>
        <ul>
            @foreach($top2 as $k=>$v)
                <li @if($k==0)class="first"@endif>
                    <a href="{{$v->goods_url}}" class="list">
                        <span class="com_num red">{{$k+1}}</span>
                        <span class="name" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>
                        <span class="norms" alt="" title="{{$v->spgg}}" >{{str_limit($v->spgg,6)}}</span>
                    </a>
                            <span class="span_hide">
                                <span class="com_num red">{{$k+1}}</span>
                                <a href="{{$v->goods_url}}"><img src="{{$v->goods_thumb}}" alt="{{$v->goods_name}}" title="{{$v->goods_name}}"/></a>
                                <span class="title" style="margin: 0;
                                                           padding: 0;
                                                           border: 0;
                                                           font-size: 12px;
                                                           font-family: '微软雅黑';
                                                           vertical-align: baseline;margin-top:11px;color:#5b5a5a;" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>
                                <span class="norms" alt="" title="{{$v->spgg}}" >{{str_limit($v->spgg,6)}}</span>
                            </span>
                </li>
            @endforeach
        </ul>

    </div>

    <div class="zhongdiantuijian">
        <h3>重点推荐品类</h3>
        <ul class="zhongdiantj-list">
            @foreach($zdtj as $v)
                <li>
                    <div style="text-align:center">
                        <a href="{{$v->goods_url}}"><img src="{{$v->goods_thumb}}" alt=""/></a>
                        <p>  <a href="{{$v->goods_url}}">{{str_limit($v->goods_name,13)}}</a></p>
                        <p><a>{{$v->spgg}}</a></p>
                        <p class="price"><span class="linshoujia">
                            {{$v->real_price_format}}
                            </span>
                            {{--<span class="yuanjia">{{formated_price($v->market_price)}}</span>--}}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
        <p class="huanyipi"><a href="javascript:;"><img src="./images/zyyp/zhyp053.jpg" alt="" onclick="get_other()"/></a></p>
    </div>
</div>