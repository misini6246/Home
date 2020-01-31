
<div class="main_left fn_clear">
    <div style="background-color: #f2ffd5;">
    <h2><p>{{str_limit($user->user_name,18)}}</p></h2>
    <div class="profile">
        <a href="{{route('user.index')}}"><span class="head_pic"><img src="@if($user->ls_file!=''){{get_img_path('data/feedbackimg/'.$user->ls_file)}}@else{{path('images/member_20.png')}}@endif" alt="{{$user->user_name}}" title="{{$user->user_name}}"></span></a>
        <div style="line-height:24px;text-align:center;" class="fn_clear">
            <div>         <span class="name" alt="{{$user->msn}}" title="{{$user->msn}}">{{str_limit($user->msn,18)}}</span></div>
        </div>

    </div>
        </div>
    <div class="list">
        <h3><span class="ico"></span> 交易管理</h3>
        <ul class="list_fist">
            <li @if($action=='orderList')class="li_checked"@endif ><a href="{{route('user.orderList')}}">我的订单 <span class="right_ico"></span></a></li>
            @if($user->is_zq==1||$user->is_zq==2)
                <li @if($action=='zq_order')class="li_checked"@endif ><a href="{{route('user.zq_order')}}">账期汇总订单 <span class="right_ico"></span></a></li>
            @endif
            <li @if($action=='zq_order_sy')class="li_checked"@endif ><a href="{{route('user.zq_order_sy')}}">尚医账期汇总订单 <span class="right_ico"></span></a></li>
            <li><a href="{{route('jf.order')}}">积分订单 <span class="right_ico"></span></a></li>
            <li @if($action=='collectList')class="li_checked"@endif ><a href="{{route('user.collectList')}}">我的收藏 <span class="right_ico"></span></a></li>
            <li @if($action=='zncg')class="li_checked"@endif ><a href="{{route('user.zncg')}}">智能采购 <span class="right_ico"></span></a></li>
            <!--<li><a href="online_user.php?act=online_order">团购订单 <span class="right_ico"></span></a></li>-->
        </ul>
        <h3><span class="ico2"></span> 我的账户</h3>
        <ul>
            <li @if($action=='youhuiq')class="li_checked"@endif><a href="{{route('user.youhuiq')}}">优惠券管理 <span class="right_ico"></span></a></li>

            <li @if($action=='account')class="li_checked"@endif ><a href="{{route('user.account')}}">余额管理 <span class="right_ico"></span></a></li>
            @if($user->is_zq==1||$user->is_zq==2)
                <li @if($action=='zq_log')class="li_checked"@endif ><a href="{{route('user.zq_log')}}">账期记录 <span class="right_ico"></span></a></li>
            @endif
            <li><a href="{{route('jf.member')}}">积分管理 <span class="right_ico"></span></a></li>
            <li @if($action=='profile')class="li_checked"@endif ><a href="{{route('user.profile')}}">基本信息 <span class="right_ico"></span></a></li>
            <li @if($action=='addressList')class="li_checked"@endif ><a href="{{route('user.addressList')}}">收货地址 <span class="right_ico"></span></a></li>
            <li @if($action=='pswl')class="li_checked"@endif ><a href="{{route('user.pswl')}}">配送物流 <span class="right_ico"></span></a></li>
            <li @if($action=='messageList')class="li_checked"@endif ><a href="{{route('user.messageList')}}">我的留言 <span class="right_ico"></span></a></li>
            <li @if($action=='buyList')class="li_checked"@endif ><a href="{{route('user.buyList')}}">我的求购 <span class="right_ico"></span></a></li>
        </ul>

    </div>
</div>