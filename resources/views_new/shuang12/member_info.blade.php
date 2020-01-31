@if($user)
    <div class="login_after">
        <span class="username" alt="{{$user->msn}}" title="{{$user->msn}}">{{str_limit($user->msn,15)}}</span>
        <span>,欢迎来到合纵医药网！</span>
        [<a href="/auth/logout" class="out">退出</a>]
        <span class="separate2">|</span>
        <a href="{{route('user.index')}}" class="my_name">我的药易购</a>
    </div>
@else
    <div class="login_before">
        <span>您好，欢迎来到合纵医药网！</span><span class="separate">|</span>
        <a href="/auth/login" class="login">登录</a> <span class="separate2"></span><a href="/auth/register" class="reg">注册</a>
    </div>
@endif