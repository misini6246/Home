<div id="append_parent"></div>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
@if($user)
<span class="login_after" >
    <span class="username" alt="{{$user->msn}}" title="{{$user->msn}}">{{$user->msn}}</span>

    [<a href="/auth/logout" class="out">退出</a>]
    <span class="separate2">|</span>
    <a href="{{route('user.index')}}" class="my_name">会员中心</a>
 </span>
@else
<span class="login_before">
    <a href="{{url('auth/login')}}" class="login">{{trans('common.login')}}</a><span class="separate">|</span><a href="{{url('auth/register')}}" class="reg">{{trans('common.register')}}</a>
 </span>
@endif
