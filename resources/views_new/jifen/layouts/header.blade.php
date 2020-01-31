<div class="header content">
    <div class="content_box">
        @if(auth()->guest())
            <div class="login_before fl">
                您好，欢迎来到今瑜e药网积分商城!
                <a href="/auth/login" class="login">请登录</a>
                <a href="/auth/register" class="reg">注册</a>
            </div>
        @else
            <div class="login_after fl">
					<span class="user_name text_overflow">
						{{auth()->user()->msn}}
					</span><span>，欢迎来到欢迎来到今瑜e药网积分商城!</span>
            </div>
        @endif
        <ul class="help fr">
            <li>
                <img src="http://images.hezongyy.com/images/jf/phone_03.png?1"/>
                <a href="{{route('jifen.user.index')}}">我的积分</a>
            </li>
            <li class="phone">
                <img src="http://images.hezongyy.com/images/jf/phone_03.png?1"/>
                <span>400-993-7199</span>
            </li>
            <li>
                <a href="/articleInfo?id=27">帮助中心</a>
            </li>
        </ul>
    </div>
</div>