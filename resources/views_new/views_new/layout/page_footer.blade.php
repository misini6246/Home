<!-- 底部开始 -->
<!--右侧边栏开始-->
<div class="mui-mbar-tabs">
    <div class="quick_link_mian">
        <div class="quick_links_panel">
            <div id="quick_links" class="quick_links">
                <li>
                    <a href="#" class="my_qlinks"><i class="setting2"></i></a>
                    <div class="ibar_login_box status_login">
                        <div class="online_service">
                            <a target="_blank" href="http://wpa.b.qq.com/cgi/wpa.php?ln=2&uin=4006028262&site=qq&menu=yes"></a>
                            <img src="{{get_img_path('images/kefu01.png')}}" alt="" />
                        </div>
                        <i class="ico"></i>
                    </div>
                </li>

                <li style="margin-top:10px;">
                    <em class="i-sidebarcom-cart"></em>
                    <a href="{{route('user.index')}}" class="mpbtn_wdsc3" ><i class="wdsc3"></i></a>
                    <em class="i-sidebarcom-cart"></em>
                    <!--   <div class="mp_tooltip"><a href="#" class="tip_txt"><img src="./images/bar_1.png"></a><i class="icon_arrow_right_black"></i></div>   -->
                </li>

                <li>
                    <a href="{{route('user.collectList')}}" class="mpbtn_wdsc" style="margin:15px 0;*margin-left:-16px;"><i class="wdsc"></i></a>
                    <div class="mp_tooltip"><a href="{{route('user.collectList')}}" class="tip_txt"><img src="{{get_img_path('images/bar_2.png')}}"></a><i class="icon_arrow_right_black"></i></div>
                </li>


                <li  id="shopCart">
                    <em class="i-sidebarcom-cart"></em>
                    <a href="{{route('cart.index')}}" class="mpbtn_wdsc2"><i class="wdsc2"></i></a>
                    <em class="i-sidebarcom-cart"></em>
                    <!--   <div class="mp_tooltip"><a href="#" class="tip_txt"><img src="./images/bar_3.png"></a><i class="icon_arrow_right_black"></i></div> -->
                </li>




            </div>
            <div class="quick_toggle">
                <li>
                    <a href="#" class="mpbtn_wdsc"><i class="wdsc6"></i></a>

                    <div class="ibar_login_box status_login">
                        <div class="shoujiapp">

                            <img src="{{get_img_path('images/dibu05.png')}}" alt="" />
                        </div>
                        <i class="ico"></i>
                    </div>
                </li>
                {{--<li>--}}
                {{--<a href="javascript:;" class="mpbtn_wdsc" ><i class="wdsc4"></i></a>--}}
                {{--<div class="mp_tooltip"><a href="javascript:;" class="tip_txt"><img src="{{get_img_path('images/bar_4.png')}}"></a><i class="icon_arrow_right_black"></i></div>--}}
                {{--</li>--}}
                <li>
                    <a href="javascript:;" class="mpbtn_wdsc" ><i class="wdsc5" id="totop"></i></a>
                    <div class="mp_tooltip"><a href="javascript:;" class="tip_txt"><img src="{{get_img_path('images/bar_5.png')}}"></a><i class="icon_arrow_right_black"></i></div>
                </li>


            </div>
        </div>
        <div id="quick_links_pop" class="quick_links_pop hide"></div>
    </div>
</div>

<!--右侧边栏结束-->
<!-- 楼层提示开始 -->

<div  id="fixedNavBar">
    <ul>

        <li id="demo1Btn" href="#demo1">
            <a class="num" href="javascript:;" ><div class="mui-lift-nav-name">新品上架</div></a>
            <a class="word"   style="display:block"><div class="mui-lift-nav-name">新品上架</div></a>

        </li>
        <li  id="demo2Btn" href="#demo2">
            <a class="num" href="javascript:;" ><div class="mui-lift-nav-name">产品推荐</div></a>
            <a class="word"><div class="mui-lift-nav-name">产品推荐</div></a>
        </li>
        <li  id="demo3Btn" href="#demo3">
            <a class="num" href="javascript:;" ><div class="mui-lift-nav-name">当季热销</div></a>
            <a class="word"><div class="mui-lift-nav-name">当季热销</div></a>
        </li>
        <li  id="demo4Btn" href="#demo4">
            <a class="num" href="javascript:;" ><div class="mui-lift-nav-name">家用保健</div></a>
            <a class="word" ><div class="mui-lift-nav-name">家用保健</div></a>
        </li>
        <li id="demo5Btn" href="#demo5">
            <a class="num" href="javascript:;" ><div class="mui-lift-nav-name">中药饮片</div></a>
            <a class="word"  ><div class="mui-lift-nav-name">中药饮片</div></a>
        </li>


    </ul>
</div>
<!-- 楼层提示结束 -->


{{--<!-- WPA Button Begin -->--}}
{{--<script charset="utf-8" type="text/javascript" src="http://wpa.b.qq.com/cgi/wpa.php?key=XzkzODE2NjI1Ml80MDk2MDhfNDAwNjAyODI2Ml8"></script>--}}
{{--<!-- WPA Button END -->--}}


<!-- 收藏弹出层部分begin -->
<div class="comfirm_buy" style="display:none;" id="collect_box">
    <div class="content_buy" ><a href="#" class="success"></a>
        <h4>&nbsp;</h4>
        <p class="collect_p">
            <span class="collect_text"> 共收藏 <span class="num">0</span>  件商品</span>
            <a href="{{route('user.collectList')}}" class="click_me">查看我的收藏 &gt;</a>
        </p>

        <p class="login_p login_p2" style="display:none;">
            <a href="/auth/login" class="login_a" >登录</a> <a href="/auth/register">注册</a>
        </p>
        <span class="close2"></span>
    </div>
</div>
<!-- 弹出层部分end -->

<!-- 加入购物车弹出层begin -->
<div class="comfirm_buy" style="display:none;" id="shopping_box">
    <div class="content_buy" ><a href="#" class="success"></a>
        <h4>&nbsp;</h4>
        <p class="tip_txt" alt="" title="">&nbsp;</p>

        <p class="login_p tab_p1" style="display: none;">
            <a class="login_a again" >继续购物</a> <a href="/cart">去结算 ></a>
        </p>

        <p class="login_p tab_p2" style="display: none;">
            <a href="/auth/login" class="login_a" >登录</a> <a href="/auth/register">注册</a>
        </p>

        <p class="login_p tab_p3" style="display: none;">
            <a href="requirement.php" class="login_a" >去登记</a> <a class="login_a again">取消</a>
        </p>

        <p class="login_p tab_p4" style="display: none;">
            <a class="login_a confirm again">确认</a>
        </p>

        <p class="login_p tab_p5" style="display: none;">
            <a href="#" class="login_a confirm">确认</a>
        </p>

        <span class="close2"></span>
    </div>
</div>
<!-- 加入购物车弹出层end -->


<!-- 购物删除弹出层begin -->
<div class="comfirm_buy" id="shopping_box4">
    <div class="content_buy" ><a href="#" class="question"></a>

        <h3>删除商品？</h3>
        <p class="txt_tip">您可以选择移到收藏，或删除商品。</p>


        <p class="del_p">
            <a href="" class="del2">删 除</a>
            <a href="" class="remove_col">移到我的收藏</a>
        </p>

        <span class="close2"></span>
    </div>
</div>
<!-- 购物删除弹出层end -->

<!-- 购物移到收藏弹出层begin -->
<div class="comfirm_buy" id="shopping_box5">
    <div class="content_buy" ><a href="#" class="question"></a>
        <h3>移到收藏？</h3>
        <p class="txt_tip">移动后该商品将不在购物车中显示。</p>
        <p class="del_p">
            <a href="" class="confirm_cc">确定</a>
            <a href="javascript:void(0); " class="cancel">取消</a>
        </p>
        <span class="close2"></span>
    </div>
</div>
<!-- 购物移到收藏弹出层end -->
<div class="alert_mark" style="display:none;">
    <div class="content_l" >
        <div class="mark_box">
            <span class="close"> </span>
            <p class="feed_back">支付反馈</p>
            <div class="info_m">
                <p>请您在新打开的网上银行页面进行支付，支付完成后选择：</p>
                <p class="text"> <span class="suc_ico ico"></span> 支付成功： <a href="{{route('user.orderList')}}">查看订单</a> <a href="{{route('index')}}">继续购物</a> </p>
                <p class="text"> <span class="fail_ico ico"></span> 支付失败： <a href="{{route('articleInfo',['id'=>49])}}">查看支付帮助</a>  </p>
            </div>


        </div>
    </div>
</div>
<div class="content_mark_div"></div>
<script type="text/javascript" src="{{path('js/index2.js')}}"></script>
<script type="text/javascript" src="{{path('/js/keywordsSearch.js')}}"></script>
<script type="text/javascript" src="{{path('js/animate.js')}}"></script>
<script type="text/javascript">

    $(".phone-app").hover(function () {

        $(this).addClass("a_tab2");

        $(".app-ewm").show();

        $(this).css({

            "color":"#6c6c6c"

        });

    }, function () {

        $(".app-ewm").hide();

        $(this).removeClass("a_tab2");

    });

</script>

<script type="text/javascript">
    $(function () {
        $(".saoma-box span").click(function () {
            $(".saoma").hide();
        })
    })

</script>
<div class="site-footer" style="margin-top: 10px;">
    <div class="footer-box fn_clear">
        <ul class="unit fn_clear">


                <li><a href="http://www.sda.gov.cn/WS01/CL0001/" target="_blank" title="国家食品药品监督局"><img src="{{get_img_path('images/new-index45.jpg')}}" alt="国家食品药品监督局"/></a></li>
                <li><a href="http://www.chinamsr.com/" target="_blank" title="中国医药联盟"><img src="{{get_img_path('images/new-index46.jpg')}}" alt="中国医药联盟"/></a></li>
                <li><a href="http://www.ydzz.com/" target="_blank" title="中国药店"><img src="{{get_img_path('images/new-index47.jpg')}}" alt="中国药店"/></a></li>
                <li><a href="http://www.39.net/" target="_blank" title="39健康网"><img src="{{get_img_path('images/new-index48.jpg')}}" alt="39健康网"/></a></li>
                <li><a href="http://www.100yiyao.com/" target="_blank" title="100医药"><img src="{{get_img_path('images/new-index49.jpg')}}" alt="100医药"/></a></li>
                <li  class="end" ><a href="http://www.menet.com.cn/" target="_blank" title="米内"><img src="{{get_img_path('images/minei.jpg')}}" alt="米内"/></a></li>


        </ul>

        <div class="footer-msg">
            <ul class="msg-list fn_clear">
                <li class="msg-li">
                    <h4><img src="{{get_img_path('images/new-index53.jpg')}}" alt="" /></h4>
                    <ul>
                        <li><a href="{{route('articleInfo',['id'=>65])}}" target="_blank">免费注册</a></li>
                        <li><a href="{{route('articleInfo',['id'=>67])}}" target="_blank">安全购药</a></li>
                        <li><a href="{{route('articleInfo',['id'=>125])}}" target="_blank">所需资质</a></li>
                    </ul>

                </li>
                <li class="msg-li">
                    <h4><img src="{{get_img_path('images/new-index54.jpg')}}" alt="" /></h4>
                    <ul>
                        <li><a href="{{route('articleInfo',['id'=>47])}}" target="_blank">物流配送</a></li>
                        <li><a href="{{route('articleInfo',['id'=>49])}}" target="_blank">订单支付</a></li>
                        <li><a href="{{route('articleInfo',['id'=>54])}}" target="_blank">药品退换</a></li>
                        <li><a href="{{route('articleInfo',['id'=>91])}}" target="_blank">在线支付</a></li>
                    </ul>

                </li>
                <li class="msg-li">
                    <h4><img src="{{get_img_path('images/new-index55.jpg')}}" alt="" /></h4>
                    <ul>
                        <li><a href="{{route('articleInfo',['id'=>48])}}" target="_blank">质量担保</a></li>
                        <li><a href="{{route('articleInfo',['id'=>55])}}" target="_blank">服务担保</a></li>
                        <li><a href="{{route('articleInfo',['id'=>73])}}" target="_blank">用户协议</a></li>
                    </ul>

                </li>
                <li class="msg-li">
                    <h4><img src="{{get_img_path('images/new-index56.jpg')}}" alt="" /></h4>
                    <ul>
                        <li><a href="/gsjj" target="_blank">公司简介</a></li>
                        <li><a href="{{route('articleInfo',['id'=>68])}}" target="_blank">联系我们</a></li>
                        <li><a href="{{route('articleInfo',['id'=>241])}}" target="_blank">广告服务</a></li>

                    </ul>

                </li>

            </ul>
            <div class="erweima">
                <img src="{{get_img_path('images/dibu01.jpg')}}" alt="" />
            </div>
        </div>


        {{--<div class="footer-bottom">--}}
            {{--<div class="title">--}}
                {{--<a href="{{route('articleInfo',['id'=>68])}}">联系我们</a>--}}
                {{--<a href="{{route('articleInfo',['id'=>57])}}">公司简介</a>--}}
                {{--<a href="{{route('articleInfo',['id'=>47])}}">配送方式</a>--}}
            {{--</div>--}}
            {{--<div class="title">--}}
                {{--<a href="http://www.hezongyy.com/images/zgz1.jpg" target="_blank">互联网药品交易服务资格证：{{env('jyfw','川B20130002')}} </a>|--}}
                {{--<a href="http://www.hezongyy.com/images/zgz2.jpg" target="_blank">互联网药品信息服务资格证：{{env('xxfw','川20100019')}}</a>--}}
            {{--</div>--}}
            {{--<div class="title">--}}
                {{--<a href="http://www.hezongyy.com/" target="_blank">版权所有 {{date('Y')}} 合纵医药网—药易购 www.hezongyy.com </a>ICP备案证书号:{{env('icp','蜀ICP备14007234号-1')}}--}}
            {{--</div>--}}
            {{--<div class="title">--}}
                {{--<a>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</a>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--<div class="safe-part">--}}
            {{--<ul class="papers fn_clear">--}}

                {{--<li><a key="55b87665efbfb03c90330bde" logo_size="124x47" logo_type="business" href="http://v.pinpaibao.com.cn/authenticate/cert/?site=www.hezongyy.com&amp;at=business" target="_blank">--}}
                        {{--<b id="aqLogoDJWQQ" style="display: none;"></b><img src="{{path('images//hy_124x47.png')}}" alt="安全联盟认证" >--}}
                    {{--</a></li>--}}
                {{--<li><a href="javascript:;"><img border="0" src="http://img.webscan.360.cn/status/pai/hash/73cfbd5da0efa9f632172da914817fed"></a></li>--}}
                {{--<li><a href="javascript:;"><img src="http://www.hezongyy.com/images/bottom3.png"></a></li>--}}
                {{--<li><a href="https://search.szfw.org/cert/l/CX20150626010878010620" target="_blank"><img src="{{path('images/bottom8.png')}}" ></a></li>--}}
            {{--</ul>--}}

        {{--</div>--}}
    </div>
    <div class="bottom-bg"></div>
    <div class="bottom-bg2">
        <ul class="bg2-list">
            <li><a href="{{route('articleInfo',['id'=>68])}}" target="_blank">联系我们</a></li>
            <li><a href="/gsjj" target="_blank">公司简介</a></li>
            <li><a href="{{route('articleInfo',['id'=>47])}}" target="_blank">配送方式</a></li>

        </ul>

    </div>
    <div class="bottom-bg3">

        <div class="footer-bottom">

            <div class="title">
                {{--<a href="http://www.hezongyy.com/images/zgz1.jpg" target="_blank">互联网药品交易服务资格证：川B20130002 </a>|--}}
                <a href="http://www.hezongyy.com/images/zgz2.jpg" target="_blank">互联网药品信息服务资格证：川20160010</a>
            </div>
            <div class="title">
                <a href="http://www.hezongyy.com/" target="_blank">版权所有 {{date('Y')}} 合纵医药网—药易购 www.hezongyy.com </a><a>ICP备案证书号:蜀ICP备18023478号-1</a>
            </div>
            <div class="title">
                <a>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</a>
            </div>

        </div>


        <div class="safe-part" style="position: relative;">
            <ul class="papers fn_clear">

                <li>
                    <a key="55b87665efbfb03c90330bde" logo_size="124x47" logo_type="business" href="http://v.pinpaibao.com.cn/authenticate/cert/?site=www.hezongyy.com&amp;at=business" target="_blank"></a>
                        <a  key ="57c7e441efbfb00e0ee18d90"  logo_size="124x47"  logo_type="realname"  href="http://www.anquan.org" ><script src="//static.anquan.org/static/outer/js/aq_auth.js"></script></a>
                </li>
                {{--<li><a href="javascript:;"><img border="0" src="http://img.webscan.360.cn/status/pai/hash/73cfbd5da0efa9f632172da914817fed"></a></li>--}}
                <li><a href="javascript:;"><img src="http://www.hezongyy.com/images/bottom3.png"></a></li>
                <li><a href="https://search.szfw.org/cert/l/CX20150626010878010620" target="_blank"><img src="{{get_img_path('images/bottom8.png')}}" ></a></li>
            </ul>
        </div>


    </div>
</div>
<!-- 底部结束 -->
