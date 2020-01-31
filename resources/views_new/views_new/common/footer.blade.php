<style type="text/css">
    #footer1 ul li {
        float: left;
        list-style: none;
    }
    .firstul li:hover img{
        opacity: 0.8;
    }
    /*尾部开始*/
    #footer1{
        width: 100%;
        /*height: 100px;*/
    }
    .footer1-box{
        width: 1200px;
        margin: 0 auto;
    }
    .footerli2{
        margin-left:55px;
    }
    .secondul>li{
        float: left;
        margin-left: 20px;
        margin-top:50px;
    }
    .firstul li {
        margin-top: 10px;
    }
    .secondul li ul li{
        text-align: center;
        color: #777777;
        line-height: 30px;
    }

    .dibu{
        text-align: center;
        line-height: 30px;
        margin-top:20px;
    }
    .dibu ul{
        margin-left: 360px;
        margin-top: 20px;
    }
    .dibu ul li{
        float: left;
        padding-left: 10px;
    }
    .dibu p{
        color: #9a9a9a;
    }
    /*尾部开始*/
</style>
<!--尾部-->
<div style="margin-bottom: 20px;">
    <div id="footer1">
        <div class="footer1-box">
            <ul class="firstul">
                <li>
                    <a href="#">
                        <img src="{{path('new/images/footer01.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="#">
                        <img src="{{path('new/images/footer02.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="#">
                        <img src="{{path('new/images/footer03.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="#">
                        <img src="{{path('new/images/footer04.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="#">
                        <img src="{{path('new/images/footer05.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="#">
                        <img src="{{path('new/images/footer06.png')}}"/>
                    </a>
                </li>
            </ul>


        </div>

    </div>
    <ul class="secondul" style="width: 1200px;margin: 0 auto;">
        <li>

            <ul>
                <img src="{{path('new/images/xinshou.png')}}"/>
                <a href="{{route('articleInfo',['id'=>65])}}" target="_blank"><li>免费注册</li></a>
                <a href="{{route('articleInfo',['id'=>67])}}" target="_blank"><li>安全购药</li></a>
                <a href="{{route('articleInfo',['id'=>125])}}" target="_blank"><li>所需资质</li></a>
            </ul>
        </li>

        <li>

            <ul>
                <img src="{{path('new/images/peisong.png')}}"/>
                <a href="{{route('articleInfo',['id'=>47])}}" target="_blank"><li>物流配送</li></a>
                <a href="{{route('articleInfo',['id'=>49])}}" target="_blank"><li>支付订单</li></a>
                <a href="{{route('articleInfo',['id'=>54])}}" target="_blank"><li>药品配送</li></a>
                <a href="{{route('articleInfo',['id'=>91])}}" target="_blank"><li>在线支付</li></a>
            </ul>
        </li>
        <li>

            <ul>
                <img src="{{path('new/images/fuwu.png')}}"/>
                <a href="{{route('articleInfo',['id'=>48])}}" target="_blank"><li>质量保证</li></a>
                <a href="{{route('articleInfo',['id'=>55])}}" target="_blank"><li>服务保证</li></a>
                <a href="{{route('articleInfo',['id'=>73])}}" target="_blank"><li>用户协议</li></a>
            </ul>
        </li>
        <li>

            <ul>
                <img src="{{path('new/images/about.png')}}"/>
                <a href="/gsjj" target="_blank"><li>公司简介</li></a>
                <a href="{{route('articleInfo',['id'=>68])}}" target="_blank"><li>联系我们</li></a>

            </ul>

        </li>

    </ul>
    <div class="erweimabottom" style="margin-top: 65px;border-left: 1px solid #e5e5e5;display: inline-block;margin-left:50px;">
        <img src="{{path('new/images/erweima01.png')}}" style="padding:0 60px;"/>
    </div>
    <!--尾部-->
    <hr style="margin-top:40px;border: 1px solid #e5e5e5;"/>
    <div class="dibu" style="width: 1200px;margin: 0 auto;">
        <p>a互联网药品交易服务资格证：<a href="http://www.hezongyy.com/images/zgz1.jpg" target="_blank" style="color: #323333">川B20130002</a> | 互联网药品信息服务资格证：<a href="http://www.hezongyy.com/images/zgz2.jpg" target="_blank" style="color: #323333">川20150030</a></p>
        <p>&copy 2014-{{date('Y')}}<a href="http://www.hezongyy.com/" target="_blank" style="color: #323333">合纵医药网-药易购</a>版权所有 ICP备案证书号：<a href="#" style="color: #323333">蜀ICP备14007234号01</a></p>
        <p>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</p>
        <ul style="height: 41px;">
            <li>
                <a href="#">
                    <img src="{{path('new/images/shiming_11.png')}}"/>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{path('new/images/beian_11.png')}}"/>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{path('new/images/chengxin_11.png')}}"/>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{path('new/images/360_11.png')}}"/>
                </a>
            </li>
        </ul>
    </div>
</div>
<div class="mui-mbar-tabs">

    <div class="quick_link_mian" style="z-index: 9999;">
        <div class="quick_links_panel">
            <div id="quick_links" class="quick_links">
                <li>
                    <a href="#" class="my_qlinks"><i class="setting2"></i></a>
                    <div class="ibar_login_box status_login">
                        <div class="online_service">
                            <a target="_blank"
                               href="http://wpa.b.qq.com/cgi/wpa.php?ln=2&uin=4006028262&site=qq&menu=yes"></a>
                            <img src="http://images.hezongyy.com/images/kefu01.png" alt=""/>
                        </div>
                        <i class="ico"></i>
                    </div>
                </li>

                <li style="margin-top:10px;border-bottom: 1px solid #7d6b50;">
                    <em class="i-sidebarcom-cart"></em>
                    <a href="http://www.hezongyy.com/user" class="mpbtn_wdsc3"><i class="wdsc3"></i></a>
                    <em class="i-sidebarcom-cart"></em>
                    <!--<div class="mp_tooltip"><a href="#" class="tip_txt"><img src="./images/bar_1.png"></a><i class="icon_arrow_right_black"></i></div>-->
                </li>


                <li id="shopCart" style="border-bottom: 1px solid #7d6b50;">
                    <em class="i-sidebarcom-cart"></em>
                    <a href="http://www.hezongyy.com/cart" class="mpbtn_wdsc2"><i class="wdsc2"></i></a>
                    <em class="i-sidebarcom-cart"></em>
                    <!--   <div class="mp_tooltip"><a href="#" class="tip_txt"><img src="./images/bar_3.png"></a><i class="icon_arrow_right_black"></i></div> -->
                </li>
                <li>
                    <a href="http://www.hezongyy.com/user/collectList" class="mpbtn_wdsc"
                       style="margin:15px 0;*margin-left:-16px;display: inline;"><i class="wdsc"></i></a>
                    <div class="mp_tooltip"><a href="http://www.hezongyy.com/user/collectList"
                                               class="tip_txt"><img
                                    src="http://images.hezongyy.com/images/bar_2.png"></a><i
                                class="icon_arrow_right_black"></i></div>
                </li>
                <li>
                    <a href="#" class="mpbtn_wdsc"><i class="wdsc6"></i></a>

                    <div class="ibar_login_box status_login">
                        <div class="shoujiapp">
                            <img src="{{path('images/right-erweima.png')}}" alt="">
                        </div>

                    </div>
                </li>


            </div>
            <li style="position: absolute;left: 0;bottom:60px;list-style: none;">
                <a href="#" style="height: 40px;">
                    <img src="{{path('new/images/write.png')}}"/>
                </a>
                <div class="mp_tooltip"><a href="#" style="height: 40px;"><img
                                src="{{path('new/images/fankui01.png')}}"/></a></div>
            </li>
            <div class="quick_toggle">

                <li>
                    <a href="#header" class="mpbtn_wdsc">
                        <i class="wdsc5" id="totop"></i>
                    </a>
                    <div class="mp_tooltip"><a href="#header" class="tip_txt"><img
                                    src="{{path('new/images/bar_5.png')}}"></a><i class="icon_arrow_right_black"></i></div>
                </li>


            </div>
        </div>
        <div id="quick_links_pop" class="quick_links_pop hide"></div>
    </div>
    <div id="right-bgcolor">

    </div>
</div>
<script type="text/javascript" src="{{path('js/index2.js')}}"></script>
<script type="text/javascript" src="{{path('/js/keywordsSearch.js')}}"></script>
<script type="text/javascript" src="{{path('js/animate.js')}}"></script>
