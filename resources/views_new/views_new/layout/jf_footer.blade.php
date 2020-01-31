<div class="footer">
    <div class="footer_help">
        <div class="footer_help_detail clear_float">
            <div class="logo2"><img src="{{path('jfen/images/logo2.jpg')}}" alt=""/></div>
            <ul class="footer_help_block">
                <li>
                    <ul>
                        <li class="footer_help_t"><img src="{{path('jfen/images/service.gif')}}" alt=""/><span>帮助中心</span></li>
                        @foreach(jf_helpList() as $v)
                        <li><a href="{{route('jf.help',['id'=>$v->id])}}" target="_blank">{{$v->name}}</a></li>
                        @endforeach
                    </ul>
                </li>
                <li class="width_small"><img src="{{path('jfen/images/footer_cut_line.png')}}" alt=""/></li>
                <li>
                    <ul>
                        <li class="footer_help_t"><img src="{{path('jfen/images/user_msg.gif')}}" alt=""/><span>用户信息</span></li>
                        <li><a href="{{route('jf.member')}}" target="_blank">我的积分</a></li>
                        <li><a href="{{route('jf.address')}}" target="_blank">收货地址</a></li>
                    </ul>
                </li>
                <li class="width_small"><img src="{{path('jfen/images/footer_cut_line.png')}}" alt=""/></li>
                <li>
                    <ul>
                        <li class="footer_help_t"><img src="{{path('jfen/images/call_us.gif')}}" alt=""/><span>联系我们</span></li>
                        <li>客服热线：4006-028-262</li>
                        <!--<li><a href="javascript:;" target="_blank">帮助中心</a></li>-->
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="copyright">
        <div class="footer_list">
            <ul class="clear_float">
                <li><a href="{{route('index')}}" target="_blank">药品采购</a></li>
                <li><a href="{{route('category.index',['dis'=>1,'py'=>1])}}" target="_blank">普药</a></li>
                <li><a href="{{route('category.index',['dis'=>3])}}" target="_blank">产品推介</a></li>
                <li><a href="{{route('activity.index')}}" target="_blank">促销专区</a></li>
                <li><a href="{{route('category.index',['dis'=>2])}}" target="_blank">精品专区</a></li>
                <li><a href="{{route('category.index',['dis'=>4])}}" target="_blank">中药饮片</a></li>
                <li><a href="{{route('category.index',['dis'=>5])}}" target="_blank">保健品</a></li>
                <li><a href="{{route('category.index',['dis'=>6])}}" target="_blank">医疗器械</a></li>
            </ul>
        </div>
        <div class="footer_footer">
            <p class="company_name">Copyright © 2014--{{date('Y')}} 合纵医药网—药易购 版权所有    蜀ICP备06000372号-1</p>
            <p>公司地址： <span class="company_address">成都市金牛区高科技园兴盛西路2号固特大厦1栋A座8楼801</span>    邮政编码： <span class="zip_code">646000</span>    服务热线： <span class="phone">4006028262</span></p>
            <p class="company_name">本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</p>
        </div>
    </div>
</div>
<div class="to_top">
    <ul>
        <li class="collect_web">
            <a href="javascript:;" onclick="collect()">
                <img src="{{path('jfen/images/my_collect.png')}}" alt=""/>
                <p>收藏网站</p>
            </a>
        </li>
        <li>
            <a href="{{route('jf.cart')}}" class="goods_car">
                <img src="{{path('jfen/images/my_goods_car.png')}}" alt=""/>
                <p>礼品车</p>
            </a>
        </li>
        <li>
            <a href="{{route('jf.member')}}">
                <img src="{{path('jfen/images/vip_center.png')}}" alt=""/>
                <p>会员中心</p>
            </a>
        </li>
        <li class="to_head"><img src="{{path('jfen/images/to_top.png')}}" alt=""/></li>
    </ul>
</div>