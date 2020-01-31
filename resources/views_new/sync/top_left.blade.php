@if($user)
    <div class="login_after" style="display:block;">

        <div class="username" alt="{{$user->msn}}" title="{{$user->msn}}">
            <div class="UserId">{{str_limit($user->msn,14)}}<span
                        style="color: #4c4b4b;">，欢迎来到合纵医药网！</span></div>

        </div>

        <a href="/auth/logout" class="out">[&nbsp;退出&nbsp;]</a>
        <span class="separate2"></span>
        <div class="my_name-box">
            <a href="http://www.hezongyy.com/user" class="my_name">
                我的药易购
            </a>
            <div class="gerenxinxi">
                <img src="{{path('new/images/gerenxinxi-top.png')}}"
                     style="position: absolute;top: -7px;left:30px;"/>
                <div class="touxiangimg">
                    <a href="#"><img src="{{path('new/images/gerentouxiang.png')}}"/></a>
                </div>
                <div class="weizhi" style="color: #767676;">
                    <a style="margin-left:15px;" href="/user">{{str_limit($user->msn,18)}}</a>
                </div>
                <div class="mingzi">
                    <a href="#"
                       style="color:#999999;margin-left:15px;">{{rank_name($user->user_rank)}}</a>

                </div>
                <ul class="userfunc">
                    <li><a href="/user/orderList" style="color: white;">我的订单</a></li>
                    <li><a target="_blank" href="/jf/member" style="color: white;">我的积分</a></li>
                    <li style="border: none;"><a href="/user/zncg" style="color: white;">智能采购</a></li>
                </ul>
            </div>
        </div>

    </div>
@else
    <div class="login_before">
        <span style="float: left;">您好，欢迎来到合纵医药网！</span><span style="float: left;"
                                                             class="separate">|</span>
        <div class="login_before1">
            <a href="/auth/login">
                <div class="loginbtn">登录</div>
            </a>
            <span class="separate2"></span>
            <a href="/auth/register" class="reg" style="color:#777777;">
                注册
            </a>
        </div>
    </div>
@endif
@if(isset($show_area_url))
    @if(auth()->check())
        {{--<div class="show_area1">--}}
        {{--<div class="show_area-box">--}}
        {{--<div id="moreAdd" style="line-height: 40px;text-align:left;">--}}
        {{--<p>@if($show_area==26)四川@else新疆@endif</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
    @else
        <div class="show_area" onmouseover="this.className='show_area mv_hover2'"
             onmouseout="this.className='show_area'">
            <div class="show_area-box">
                <div id="moreAdd" style="text-align:left;">
                    <p>@if($show_area==26)四川@else新疆@endif</p>
                    <span></span>
                </div>
            </div>
            <div class="show_areaselect">
                {!! $show_area_url !!}
            </div>
        </div>
    @endif
@endif