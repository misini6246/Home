<link href="{{path('new/css/fix-box.css')}}" rel="stylesheet" type="text/css"/>
<style type="text/css">
    #footer1 ul li {
        float: left;
        list-style: none;
    }

    .firstul li:hover img {
        opacity: 0.8;
    }

    /*尾部开始*/
    #footer1 {
        width: 100%;
        /*height: 100px;*/
    }

    .footer1-box {
        width: 1200px;
        margin: 0 auto;
    }

    .secondul > li {
        float: left;
        margin-left: 20px;
        margin-top: 20px;
    }

    .firstul li {
        margin-top: 10px;
    }

    .secondul li ul li {
        text-align: center;
        color: #777777;
        line-height: 30px;
    }

    .dibu {
        text-align: center;
        line-height: 30px;
        margin-top: 20px;
    }

    .dibu ul {
        margin-left: 360px;
        margin-top: 20px;
    }

    .dibu ul li {
        float: left;
        padding-left: 10px;
    }

    .dibu p {
        color: #9a9a9a;
    }

    .cart-none {
        text-align: center;
        margin-top: 10px;
    }

    .tishi {
        width: 120px;
        height: 40px;
        line-height: 40px;
        text-align: center;
        position: absolute;
        bottom: 5px;
        *bottom: 0px;
        left: -120px;
        background: #42bb36;
        font-weight: bold;
    }

    .tishi span {
        color: #fff536;
        margin: 0 5px;
    }

    .tishi div {
        width: 0;
        height: 0;
        border-top: 5px solid transparent;
        border-left: 8px solid #42bb36;
        border-bottom: 5px solid transparent;
        position: absolute;
        top: 15px;
        right: -8px;
    }

    /*尾部开始*/
</style>
<!--尾部-->
<div class="site-footer" style="margin-bottom: 20px;border-top: 1px solid #ebebeb;position: relative;">
    <div id="footer1" style="height: 90px;padding-top: 20px;">
        <div class="footer1-box">
            <ul class="firstul">
                <li>
                    <a href="http://www.sda.gov.cn/WS01/CL0001/" target="_blank" title="国家食品药品监督局">
                        <img src="{{path('new/images/footer01.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="http://www.chinamsr.com/" target="_blank" title="中国医药联盟">
                        <img src="{{path('new/images/footer02.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="http://www.ydzz.com/" target="_blank" title="中国药店">
                        <img src="{{path('new/images/footer03.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="http://www.39.net/" target="_blank" title="39健康网">
                        <img src="{{path('new/images/footer04.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="http://www.100yiyao.com/" target="_blank" title="100医药">
                        <img src="{{path('new/images/footer05.png')}}"/>
                    </a>
                </li>
                <li class="footerli2">
                    <a href="http://www.menet.com.cn/" target="_blank" title="米内">
                        <img src="{{path('new/images/footer06.png')}}"/>
                    </a>
                </li>
            </ul>


        </div>

    </div>
    <ul class="secondul" style="width: 1200px;margin: 0 auto;position: relative;">
        <li>

            <ul>
                <img src="{{path('new/images/xinshou.png')}}"/>
                <a href="{{route('articleInfo',['id'=>65])}}" target="_blank">
                    <li>免费注册</li>
                </a>
                <a href="{{route('articleInfo',['id'=>67])}}" target="_blank">
                    <li>安全购药</li>
                </a>
                <a href="{{route('articleInfo',['id'=>125])}}" target="_blank">
                    <li>所需资质</li>
                </a>
            </ul>
        </li>

        <li>

            <ul>
                <img src="{{path('new/images/peisong.png')}}"/>
                <a href="{{route('articleInfo',['id'=>47])}}" target="_blank">
                    <li>物流配送</li>
                </a>
                <a href="{{route('articleInfo',['id'=>49])}}" target="_blank">
                    <li>支付订单</li>
                </a>
                <a href="{{route('articleInfo',['id'=>54])}}" target="_blank">
                    <li>药品配送</li>
                </a>
                <a href="{{route('articleInfo',['id'=>91])}}" target="_blank">
                    <li>在线支付</li>
                </a>
            </ul>
        </li>
        <li>

            <ul>
                <img src="{{path('new/images/fuwu.png')}}"/>
                <a href="{{route('articleInfo',['id'=>48])}}" target="_blank">
                    <li>质量保证</li>
                </a>
                <a href="{{route('articleInfo',['id'=>55])}}" target="_blank">
                    <li>服务保证</li>
                </a>
                <a href="{{route('articleInfo',['id'=>73])}}" target="_blank">
                    <li>用户协议</li>
                </a>
            </ul>
        </li>
        <li>

            <ul>
                <img src="{{path('new/images/about.png')}}"/>
                <a href="/gsjj" target="_blank">
                    <li>公司简介</li>
                </a>
                <a href="{{route('articleInfo',['id'=>68])}}" target="_blank">
                    <li>联系我们</li>
                </a>

            </ul>

        </li>
        <div class="erweimabottom"
             style="margin-top: 30px;border-left: 1px solid #e5e5e5;display: inline-block;margin-left:50px;">
            <img src="{{path('new/images/erweima01.png')}}" style="padding:0 60px;"/>
        </div>
    </ul>

    <!--尾部-->
    <div class="dibu" style="width: 1200px;margin:10px auto;*margin-top: 50px;">
        <p>互联网药品交易服务资格证：<a href="http://www.hezongyy.com/images/zgz1.jpg" target="_blank" style="color: #323333">川B20130002</a>
            | 互联网药品信息服务资格证：<a href="http://www.hezongyy.com/images/zgz2.jpg" target="_blank" style="color: #323333">川20150030</a>
        </p>
        <p>&copy 2014-{{date('Y')}}<a href="http://www.hezongyy.com/" target="_blank"
                                      style="color: #323333">{{config('services.web.name')}}</a>版权所有 ICP备案证书号：<a href="#"
                                                                                           style="color: #323333">蜀ICP备14007234号01</a>
        </p>
        <p>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</p>
        <ul style="height: 41px;">
            <li>
                <a target="_blank" href="https://v.pinpaibao.com.cn/cert/site/?site=www.hezongyy.com&at=realname">
                    <img src="{{path('new/images/shiming_11.png')}}"/>
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="{{path('new/images/beian_11.png')}}"/>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://credit.cecdc.com/CX20150626010878010620.html">
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
<!--右侧边栏开始-->
@if(!isset($hide_yc))
    <div id="fixright"></div>
    <style type="text/css">
        .fly_item {
            border: 1px solid #000;
            width: 50px;
            height: 50px;
            overflow: hidden;
            position: absolute;
            visibility: hidden;
            top: 0
        }

    </style>
    <div id="flyItem" class="fly_item">
        <img src="http://images.hezongyy.com/data/afficheimg/1483064251055739082.png" style="width: 100%;">
    </div>
@endif
<!--右侧边栏结束-->
<input id="check_auth" type="hidden" value="@if(auth()->check()) 1 @else 0 @endif">
<script type="text/javascript" src="{{path('/js/keywordsSearch.js')}}"></script>
<script type="text/javascript" src="{{path('js/animate.js')}}"></script>
<script type="text/javascript" src="{{path('js/footer.js')}}"></script>
<script type="text/javascript" src="{{path('new/js/jquery.slimscroll.min.js')}}"></script>
<script type="text/javascript" src="{{path('new/js/prettify.min.js')}}"></script>
<!--[if lte IE 8]>
<script src="{{path('new/js/ieBetter.js')}}"></script>
<![endif]-->
<script type="text/javascript" src="{{path('js/parabola.js')}}"></script>
<script type="text/javascript">
    var rem = 10;
    var flag = setInterval(remain, 1000);

    function remain() {
        return false;
        rem--;
        if (rem == 0) {
            $('.tishi').hide('slow');
        }
        if (rem <= -10) {
            $('.tishi').show('slow');
        }
        if (rem < -20) {
            $('.tishi').hide('slow');
            clearInterval(flag);
        }
    }
</script>
