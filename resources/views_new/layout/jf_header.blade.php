<div class="header">
    <div class="header_top">
        <div class="header_content clear_float">
            @include('layout.jf_member_info')
            <li class="cart">
                <a href="{{route('jf.cart')}}">
                    <img src="{{path('jfen/images/cart.png')}}" alt="礼品车"/>
                    <span>礼品车共计<i>{{jf_cart_info()}}</i>件</span>
                </a>
            </li>
            </ul>
        </div>
    </div>
</div>
<div class="header_bottom">
    <div class="header_search clear_float">
        <div class="float_right clear_float">
            <div class="integral_search">
                <div class="select integral_search_select">
                    <div class="select_choose"><span>请选择积分范围</span><i></i></div>
                    <ul class="select_options">
                        <li data-id="1" style="border: 0">5000积分以下</li>
                        <li data-id="2">5000-15000</li>
                        <li data-id="3">15000-30000</li>
                        <li data-id="4">30000积分以上</li>
                    </ul>
                </div>
                <label class="search_btn"><input class="button" type="button" value="搜索"/></label>
            </div>
        </div>
        <div class="header_search_logo">
            <a href="{{route('jf.index')}}"><img src="{{path('jfen/images/logo_big.png')}}" alt="首页"/></a>
            <img class="head_cut_line" src="{{path('jfen/images/head_cut_line.png')}}"/>
            <a href="{{route('jf.index')}}"><img src="{{path('jfen/images/logo_integral.png')}}" alt="积分商城"/></a>
        </div>
    </div>
</div>
</div>
<div class="content">
    <div class="content_nav clear_float">
        <div class="content_nav_detail">
            <ul class="cnd_list clear_float">
                <li><a href="{{route('jf.index')}}">首页</a></li>
                <li><a href="{{route('index')}}" target='_blank'>药品采购</a></li>
                <!--<li><a href="lottery.php">积分抽奖</a></li>-->
                <!--<li><a href="javascript:;">促销专区</a></li>-->
            </ul>
            <div class="cnd_goodsCar" title="礼品车"><a href="{{route('jf.cart')}}">礼品车<span>(<span>{{jf_cart_info()}}</span>)</span></a></div>
        </div>
    </div>

