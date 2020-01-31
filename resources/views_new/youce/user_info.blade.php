<div class="fix-title">
    <i class="yyg"></i>我的太星医药网
    <i class="quxiao" onclick="quxiao()"></i>
</div>
<a href="/user">
    <div class="xinxi">
        <div class="img-box">
            <img src="@if($user->ls_file!=''){{get_img_path('data/feedbackimg/'.$user->ls_file)}}@else{{path('images/member_20.png')}}@endif"/>
        </div>
        <div class="name">
            {{$user->user_name}}
        </div>
        <div class="addr">
            {{$user->msn}}
        </div>
    </div>
</a>
<ul class="ziliao first-ul">
    <a href="javascript:;">
        <li>
            <p>余额</p>
            <p>{{formated_price($user->user_money)}}</p>
        </li>
    </a>
    <a href="javascript:;">
        <li>
            <p>待付款金额</p>
            <p>{{$wait_amount}}</p>
        </li>
    </a>
    <a href="/user/orderList">
        <li>
            <p style="margin-top: 10px;">
                <img src="{{get_img_path('images/new/my_dd.jpg')}}"/>
            </p>
            <p style="margin-top: 3px;color: #666666;font-family: '宋体';font-size: 12px;">订单管理</p>
        </li>
    </a>
</ul>
<ul class="ziliao">
    {{--<a href="/jifen/user">--}}
        {{--<li>--}}
            {{--<p>普药积分</p>--}}
            {{--<p>{{$user->pay_points}}</p>--}}
        {{--</li>--}}
    {{--</a>--}}
    {{--<a href="javascript:;">--}}
        {{--<li>--}}
            {{--<p>精品积分</p>--}}
            {{--<p>{{$user->jp_points}}</p>--}}
        {{--</li>--}}
    {{--</a>--}}
    <a href="/user/youhuiq">
        <li>
            <p>优惠劵</p>
            <p>{{$yhq_num or 0}}</p>
        </li>
    </a>
</ul>
<a href="/user" class="ddgl">
    <img src="{{get_img_path('images/new/my_yyg.jpg')}}" style="vertical-align: middle;margin-right: 5px;"/> <span
            style="vertical-align: middle;font-family: '宋体';font-size: 16px;color: #333;">我的太星医药网</span>
</a>