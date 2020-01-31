<div class="fixed-right">
    <div class="bg"></div>
    <div class="bar">
        <div class="kefu">
            <img src="/index/img/客服.png"/>
            <div class="hover">
                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1716462161&site=qq&menu=yes"><img border="0" src="/index/img/kefu-new.png" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>
            </div>
        </div>
        <div class="huiyuan">
            <a href="/member">
                <img src="/index/img/会员.png"/>
                <div class="hover">
                    <div class="jiantou"></div>
                    会员中心
                </div>
            </a>
        </div>
        <div class="message">
            <a href="/member/wodexiaoxi">
                <img src="/index/img/消息.png"/>
                <span>{{msg_count()}}</span>
                <div class="hover">
                    <div class="jiantou"></div>
                    我的消息
                </div>
            </a>

        </div>
        <div class="line"></div>
        <div class="cart">
            <a href="{{route('cart.index')}}">
            <img src="/index/img/购物车.png"/>
            <span class="text">购物车</span>
            <span class="num">{{cart_info(1,1)}}</span>
            </a>
        </div>
        <div class="line"></div>
        <div class="collect">
            <a href="{{route('member.collection.index')}}">
            <img src="/index/img/图层 4.png"/>
            <div class="hover">
                <div class="jiantou"></div>
                我的收藏
            </div>
            </a>
        </div>
        <div class="fankui">
            <a href="/feedback">
            <img src="/index/img/反馈.png"/>
            <div class="hover">
                <div class="jiantou"></div>
                我要反馈
            </div>
            </a>
        </div>
        <div class="btn-top">
            <img src="/index/img/首页-14.png"/>
            <div class="hover">
                <div class="jiantou"></div>
                返回顶部
            </div>
        </div>
    </div>
</div>