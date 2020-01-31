<div class="nav content">
    <div class="content_box">
        <div class="logo_box">
            <a href="{{route('index')}}"><img src="{{get_img_path('images/logo-new.png')}}"/></a>
        </div>
        <div class="nav_title">
            <a href="{{route('jf.index')}}"><img src="{{get_img_path('images/jf/nav_title.png')}}"/></a>
        </div>
        <ul class="nav_list">
            <li @if($action=='index')class="active"@endif>
                <a href="{{route('jf.index')}}">积分首页</a>
            </li>
            <li @if($action=='user')class="active"@endif>
                <a href="{{route('jf.user.index')}}">个人中心</a>
            </li>
            <li>
                <a href="{{route('index')}}">药品采购</a>
            </li>
        </ul>
        <div class="lp_cart">
            <a href="{{route('jf.cart.index')}}">
                <img src="{{get_img_path('images/jf/lipin_03.png')}}"/>
                <span class="txt">礼品车</span><span class="num">{{jf_cart_count()}}</span>
            </a>
        </div>
    </div>
</div>
