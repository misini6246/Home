@if(!isset($hide_yc))
    @include('layouts.youce')
@endif
<input id="check_auth" type="hidden" value="@if(auth()->check()) 1 @else 0 @endif">
<div id="footer" class="container">
    <div class="container_box">
        <div class="footer_top">
            <ul class="help_list">
                <li>
                    <p>
                        <span class="icon_box">
                            <i class="myicon footer_1"></i>
                        </span><span>新人指南</span>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>65])}}">免费注册</a>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>67])}}">安全购药</a>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>125])}}">所需资质</a>
                    </p>
                    {{--<p>--}}
                    {{--<a href="#">积分说明</a>--}}
                    {{--</p>--}}
                    {{--<p>--}}
                    {{--<a href="#">找回密码</a>--}}
                    {{--</p>--}}
                </li>
                <li>
                    <p>
                        <span class="icon_box">
                            <i class="myicon footer_2"></i>
                        </span><span>配送方式</span>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>47])}}">物流配送</a>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>49])}}">包装流程</a>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>54])}}">药品退换</a>
                    </p>
                </li>
                <li>
                    <p>
                        <span class="icon_box">
                            <i class="myicon footer_3"></i>
                        </span><span>支付方式</span>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>91])}}">在线支付</a>
                    </p>
                    {{--<p>--}}
                    {{--<a href="#">银行转账</a>--}}
                    {{--</p>--}}
                    {{--<p>--}}
                    {{--<a href="#">开具发票</a>--}}
                    {{--</p>--}}
                </li>
                {{--<li>--}}
                {{--<p>--}}
                {{--<span class="icon_box">--}}
                {{--<i class="myicon footer_4"></i>--}}
                {{--</span><span>售后服务</span>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<a href="#">退换货流程</a>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<a href="#">退换货政策</a>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<a href="#">投诉与建议</a>--}}
                {{--</p>--}}
                {{--<p>--}}
                {{--<a href="#">退款说明</a>--}}
                {{--</p>--}}
                {{--</li>--}}
                <li>
                    <p>
                        <span class="icon_box">
                            <i class="myicon footer_5"></i>
                        </span><span>关于我们</span>
                    </p>
                    <p>
                        <a target="_blank" href="/gsjj">公司简介</a>
                    </p>
                    <p>
                        <a href="#">业界荣誉</a>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>68])}}">联系我们</a>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>73])}}">用户协议</a>
                    </p>
                    <p>
                        <a target="_blank" href="{{route('articleInfo',['id'=>48])}}">质量担保</a>
                    </p>
                </li>
                <li>
                    <p>
                        <span class="icon_box">
                            <i class="myicon footer_6"></i>
                        </span><span>商务合作</span>
                    </p>
                    <p>
                        <a href="#">广告合作</a>
                    </p>
                </li>
            </ul>
            <ul class="erweima">
                <li>
                    <div class="img_box">
                        <img src="{{get_img_path('images/index/wx_erweima.jpg')}}"/>
                    </div>
                    <div class="text">
                        <p class="title">药易购官方微信</p>
                        <p class="ct">扫描二维码，及时关注我们，不 错过每一次优惠活动！</p>
                    </div>
                </li>
                <li>
                    <div class="img_box">
                        <img src="{{get_img_path('images/index/app_erweima.jpg')}}"/>
                    </div>
                    <div class="text">
                        <p class="title">手机药易购</p>
                        <p class="ct">轻松采购，迅速到货！</p>
                        <p>
                            <a href="javascript:;" class="ios"></a>
                            <a href="javascript:;" class="md"></a>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
        <div class="footer_bottom">
            <p class="p1">
                互联网药品交易服务资格证编号：
                <a target="_blank" href="/images/zgz1.jpg">川B20130002</a> 互联网药品信息服务资格证编号：
                <a target="_blank" href="/images/zgz2.jpg">川20150030</a> ICP备案证书号：
                <a href="javascript:;">蜀ICP备14007234号-1</a> 增值电信业务经营许可证：
                <a href="#">川B2-20140119</a>
            </p>
            <p class="p2">
                © 2014-{{date('Y')}}
                <a href="{{route('index')}}">{{config('services.web.name')}}</a>版权所有
                {{--<a href="#">四川合纵医药股份有限公司 </a>--}}
            </p>
            <ul class="footer_bottom_link">
                <li>
                    <a target="_blank" href="#">
                        <img src="{{get_img_path('images/index/footer_link_1.png')}}"/>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <img src="{{get_img_path('images/index/footer_link_2.png')}}"/>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="#">
                        <img src="{{get_img_path('images/index/footer_link_3.png')}}"/>
                    </a>
                </li>
                <li>
                    <a href="javascript:;">
                        <img src="{{get_img_path('images/index/footer_link_4.png')}}"/>
                    </a>
                </li>
            </ul>
            <p>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</p>
        </div>
    </div>
</div>