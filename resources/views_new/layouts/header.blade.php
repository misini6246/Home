<!--头部-->
    <div class="header-box">
        <div class="box-container">
            <div class="left-box">
                @if(!$user)
                <span>您好，<a href="/auth/login" style="color: #FF2A3E;">请登录</a> <a href="/xin/register/old">免费注册</a></span>
                @else
                <span>您好，<span style="color: #FF2A3E;margin-left: 0;">{{str_limit($user->msn,40)}}</span>
						<a href="{{route('member.index')}}" class="hyzx" style="margin-top: 0px;">会员中心</a>
						<a href="/auth/logout">退出</a>
						</span>
                    @endif
            </div>
            <div class="right-box">
                <ul>
                    <li id="down" style=" border: 1px solid #bb8d2b !important;width: 92px;padding: 0 !important;text-align: center;margin-right: 10px;">
                        <a href="/今瑜e药网.url" class="color" style="color: #bb8d2b!important;">添加网站到桌面</a>
                    </li>
                    @if(!$user)
                    <li>
                        <a href="/auth/login">我的订单</a>
                    </li>
                    <li class="line"></li>
                    <li>
                        <i class="my-icon icon-2"></i>
                        <a href="/auth/login">我的收藏</a>
                    </li>
                    <li class="line"></li>
                    @else
                        <li>
                            <a href="{{route('member.order.index')}}">我的订单</a>
                        </li>
                        <li class="line"></li>
                        <li>
                            <i class="my-icon icon-2"></i>
                            <a href="{{route('member.collection.index')}}">我的收藏</a>
                        </li>
                        <li class="line"></li>
                    @endif
                    {{--<li>--}}
                        {{--<a href="#">客户服务</a>--}}
                    {{--</li>--}}
                    {{--<span class="line"></span>--}}
                    <li>
                        {{--<a href="/article?id=3">帮助中心</a>--}}
                        <a href="/articleInfo?id=27">帮助中心</a>
                    </li>
                    <li class="line"></li>
                    <li>
                        <a href="#" style="color: #FF2A3E;">咨询热线：400-993-7199</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>