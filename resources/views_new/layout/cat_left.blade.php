<div class="left_list">
    <div class="list_top">
        <h3>推荐厂家</h3>
        <ul>
            @if($ad34)
                @foreach($ad34 as $v)
                    <li>
                        <a href="{{$v->ad_link}}" target="_blank">
                            <img src="{{$v->ad_code}}" alt=""/>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>

    </div>
    <div class="list_next">
        <h3>一周销量排行榜</h3>
        <ul>
            @foreach($weekSales as $k=>$v)
                <li @if($k==0)class="first"@endif>
                    <a href="{{$v->goods_url}}" class="list">
                        <span class="com_num red">{{$k+1}}</span>
                        <span class="name" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>

                        <span class="norms" alt="" title="{{$v->spgg or ''}}" >{{str_limit($v->spgg,12)}}</span>

                    </a>
					<span class="span_hide">
						<span class="com_num red">{{$k+1}}</span>
						<a href="{{$v->goods_url}}"><img src="{{empty($v->goods_thumb)? 'no_picture.gif':$v->goods_thumb}}" alt="{{$v->goods_name}}" title="{{$v->goods_name}}"/></a>
						<span class="title" alt="{{$v->goods_name}}" title="{{$v->goods_name}}">{{str_limit($v->goods_name,12)}}</span>

						<span class="norms" alt="{{$v->spgg}}" title="{{$v->spgg}}" >{{str_limit($v->spgg,12)}}</span>

					</span>
                </li>
            @endforeach
        </ul>
    </div>


</div>