<div class="vip_left">
    <div class="vip_left_title">
        个人中心
    </div>
    <ul class="title_list">
        <li @if($user_menu=='index')class="active"@endif><a href="{{route('jifen.user.index')}}">我的积分</a></li>
        <li @if($user_menu=='order')class="active"@endif><a href="{{route('jifen.order.index')}}">积分订单</a></li>
        <li @if($user_menu=='address')class="active"@endif><a href="{{route('jifen.address.index')}}">我的地址</a></li>
    </ul>
</div>