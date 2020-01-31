<div class="vip_manage">
    <div class="accordion_list">
        <div class="accordion_list_out @if($action=='index') open @endif">
            <p>交易中心<i></i></p>
            <ul>
                <li><a href="{{route('jf.member')}}">我的首页</a></li>
                <li><a href="{{route('jf.order')}}">我的订单</a></li>
            </ul>
        </div>
        <div class="accordion_list_out @if($action=='payPoints') open @endif">
            <p>服务中心<i></i></p>
            <ul>
                <li><a href="{{route('jf.payPoints')}}">积分查询</a></li>
            </ul>
        </div>
        <div class="accordion_list_out @if($action=='address') open @endif" >
            <p>个人设置<i></i></p>
            <ul>
                <li><a href="{{route('jf.address')}}">收货地址</a></li>
            </ul>
        </div>
    </div>
</div>