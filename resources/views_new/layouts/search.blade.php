<div class="search-nav">
    <div class="box-container">
        <div class="logo-box">
            <a href="/">
                <img src="/index/img/logo.jpg" />
            </a>
        </div>
        <div class="search-box">
            <div class="search">
                <input type="text" class="search-input" placeholder="请输入搜索内容" />
                <ul class="search-list">
                </ul>
            </div>
            <div class="search-btn">搜 索</div>
            <div class="search_hot">
                <span>热门搜索：</span>
                <ul>
                    @foreach($ad159 as $v)
                        <li>
                            <a target="_blank" href="{{$v->ad_link}}">{{$v->ad_name}}</a>
                        </li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="right-box">
            <a href="{{route('member.order.index')}}" class="dd"><i class="my-icon icon-3"></i>订单查询</a><a href="{{route('cart.index')}}" class="gwc" ><i class="my-icon icon-1"></i>购物车<span id="only_gwc">{{cart_info()}}</span></a>
            <a href="http://www.jyeyw.com/articleInfo?id=28" class="zz">互联网药品信息服务资格证书:<span style="color: #FF2A3E">(渝)-经营性-2018-0018</span></a>
        </div>
    </div>
</div>