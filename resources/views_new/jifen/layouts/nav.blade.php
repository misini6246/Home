<div class="nav content">
    <div class="content_box">
        
        <div class="logo_box" style="width: 250px;text-align: left;">
            <a href="{{route('index')}}"><img style="width: 226px;height: 60px;vertical-align: middle;"
                                              src="/index/img/logo.jpg"/></a>
        </div>
        <div class="nav_title">
            <a href="{{route('jifen.index')}}"><img src="http://images.hezongyy.com/images/jf/nav_title.png?1"/></a>
        </div>
        <ul class="nav_list">
            <li @if(isset($action)&&$action=='index')class="active"@endif>
                <a href="{{route('jifen.index')}}">积分首页</a>
            </li>
            <li @if(isset($action)&&$action=='user')class="active"@endif>
                <a href="{{route('jifen.user.index')}}">个人中心</a>
            </li>
            <li @if(isset($action)&&$action=='qiandao')class="active"@endif>
                <a href="{{route('jifen.qiandao.index')}}">签到</a>
            </li>
            <li>
                <a href="{{route('index')}}">返回今瑜e药网</a>
            </li>
        </ul>
        <div class="lp_cart">
            <a href="{{route('jifen.cart.index')}}">
                <img src="http://images.hezongyy.com/images/jf/lipin_03.png?1"/>
                <span class="txt">礼品车</span><span class="num">{{jf_cart_count()}}</span>
            </a>
        </div>
    </div>
</div>
