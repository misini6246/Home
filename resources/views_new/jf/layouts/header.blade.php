<div class="header content">
    <div class="content_box">
        @if(!$user)
            <div class="login_before fl">
                您好，欢迎来到合纵医药网积分商城!
                <a href="/auth/login" class="login">请登录</a>
                <a href="/auth/register" class="reg">注册</a>
            </div>
        @else
            <div class="login_after fl">
					<span class="user_name text_overflow">
						{{$user->msn}}
					</span><span>，欢迎来到合纵医药网！</span>
            </div>
        @endif
        <ul class="help fr">
            <li>
                <img src="{{get_img_path('images/jf/jifen_balck_03.png')}}"/>
                <a href="{{route('jf.user.index')}}">我的积分</a>
            </li>
            <li class="phone">
                <img src="{{get_img_path('images/jf/phone_03.png')}}"/>
                <span>400-6028-262</span>
            </li>
            <li>
                <a href="/article?id=3">帮助中心</a>
            </li>
        </ul>
    </div>
</div>