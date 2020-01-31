<div class="left">
    <a href="{{route('member.index')}}">
        <div class="myyyg">
            <span>我的今瑜e药网</span>
        </div>
    </a>
    <ul class="f_ul">
        <p class="biaoti">
            <img src="/user/img/交易管理图标.png"/>
            <span>交易管理</span>
        </p>
        @include('user.menu',['name'=>'order','text'=>'我的订单','url'=>route('member.order.index')])
        @if($zq_order>0)
            @include('user.menu',['name'=>'zq_order','text'=>'账期汇总订单','url'=>route('member.zq_order.index')])
        @endif
        {{--@include('user.menu',['name'=>'cz_order','text'=>'充值记录','url'=>route('user.cz_order')])--}}
        {{--@include('user.menu',['name'=>'','text'=>'积分订单','url'=>route('jifen.order.index')])--}}
    </ul>
    <ul class="f_ul">
        <p class="biaoti">
            <img src="/user/img/资产管理图标.png"/>
            <span>资产管理</span>
        </p>
        @include('user.menu',['name'=>'money','text'=>'余额管理','url'=>route('member.money')])
        @include('user.menu',['name'=>'youhuiq','text'=>'优惠劵管理','url'=>route('member.youhuiq')])
        {{--@include('user.menu',['name'=>'','text'=>'积分管理','url'=>route('jifen.user.index')])--}}
        {{--@include('user.menu',['name'=>'jf_money','text'=>'积分金币管理','url'=>route('member.jf_money_log')])--}}
    </ul>
    <ul class="f_ul last_ul">
        <p class="biaoti">
            <img src="/user/img/个人中心图标.png"/>
            <span>个人中心</span>
        </p>
        @include('user.menu',['name'=>'profile','text'=>'基本信息','url'=>route('member.info')])
        @include('user.menu',['name'=>'collection','text'=>'我的收藏','url'=>route('member.collection.index')])
        @include('user.menu',['name'=>'zncg','text'=>'智能采购','url'=>route('member.zncg')])
        @include('user.menu',['name'=>'qhhy','text'=>'多会员管理','url'=>route('member.duohuiyuan.index')])
        @include('user.menu',['name'=>'znx','text'=>'我的消息','url'=>route('member.wodexiaoxi.index')])
        {{--@include('user.menu',['name'=>'message','text'=>'我的留言','url'=>route('user.messageList')])--}}
        {{--@include('user.menu',['name'=>'buy','text'=>'我的求购','url'=>route('member.buy')])--}}
        {{--@include('user.menu',['name'=>'fankui','text'=>'我的反馈','url'=>route('member.fankui')])--}}
        @include('user.menu',['name'=>'address','text'=>'收货地址','url'=>route('member.address.index')])
        @include('user.menu',['name'=>'pswl','text'=>'配送物流','url'=>route('member.pswl')])
    </ul>
</div>