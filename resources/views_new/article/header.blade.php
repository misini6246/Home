<div id="header" class="container">
    <div class="container_box">
        @if(!$user)
            <div class="login_before">
                <span>您好，欢迎来到{{config('services.web.name')}}网！</span>
                <a href="/auth/login" class="login">登录</a>
                <a href="/auth/register" class="reg">注册</a>
            </div>
        @else
            <div class="login_after">
					<span class="userid">
						{{$user->msn}}
					</span>，欢迎来到{{config('services.web.name')}}网
                <a href="/auth/logout" class="out">[退出]</a>
            </div>
        @endif
        <ul class="right_list">
            <li>
                <a href="#">加入收藏</a>
            </li>
            <li>
                <img src="{{get_img_path('images/new/help_header_phone.png')}}"/>
            </li>
            <li>
                <a href="{{route('index')}}">返回首页</a>
            </li>
        </ul>
    </div>
</div>