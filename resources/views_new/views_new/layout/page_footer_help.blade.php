<div class="help_footer">
    <div class="footer_bottom">
        <div class="title">
            @foreach(nav_list('bottom') as $v)
                <a href="{{$v->url}}" @if($v->opennew==1) target="_blank" @endif>{{$v->name}}</a>
            @endforeach
        </div>
        <div class="title">
            <a href="{{path('images/zgz1.jpg')}}" target="_blank">互联网药品交易服务资格证：川B20130002 </a>|<a href="{{path('images/zgz2.jpg')}}" target="_blank">互联网药品信息服务资格证：川20150030</a>
        </div>
        <div class="title"><a href="http://www.hezongyy.com/" target="_blank">版权所有 {{date('Y')}} 合纵医药网—药易购 www.hezongyy.com </a>ICP备案证书号:蜀ICP备14007234号-1</div>
        <div class="title">
            <a>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</a>
        </div>
        {{--<ul class="papers fn_clear">--}}

            {{--<li>--}}
                {{--<a key="55b87665efbfb03c90330bde" logo_size="124x47" logo_type="business" href="http://www.anquan.org/authenticate/cert/?site=www.hezongyy.com&amp;at=business" target="_blank">--}}
                    {{--<script src="http://static.anquan.org/static/outer/js/aq_auth.js"></script>--}}
                    {{--<span style="display:none;" class="LOGO_aq_jsonp_wrap_" id="AQ_logo_span_init_1">--}}
                        {{--<script src="http://outer.anquan.org/query_auth_status/?callback=AQ_fn_aq_auth_callback&amp;url=http://www.hezongyy.com/&amp;logo_type=business" type="text/javascript" async="true"></script>--}}
                    {{--</span>--}}
                    {{--<img src="http://static.anquan.org/static/outer/image/hy_124x47.png" alt="安全联盟认证" width="124" height="47" style="border: none;">--}}
                {{--</a>--}}
            {{--</li>--}}
            {{--<li><a href="javascript:;"><img border="0" src="http://img.webscan.360.cn/status/pai/hash/73cfbd5da0efa9f632172da914817fed"></a></li>--}}
            {{--<li><a href="javascript:;"><img src="./images/bottom3.png"></a></li>--}}
            {{--<li><a href="https://search.szfw.org/cert/l/CX20150626010878010620" target="_blank"><img src="{{path('images/bottom8.png')}}" width="127" height="47"></a></li>--}}
        {{--</ul>--}}
        <ul class="papers fn_clear">
            <!--<li><img src="./themes/yiyao/images/bottom4.png"/></li>
            <li><img src="./themes/yiyao/images/bottom5.png"/></li>
            <li><img src="./themes/yiyao/images/bottom6.png"/></li>-->
            <li><a key="55b87665efbfb03c90330bde" logo_size="124x47" logo_type="realname" href="http://www.anquan.org"><script src="http://static.anquan.org/static/outer/js/aq_auth.js"></script></a></li>
            <li><a href="javascript:;"><img border="0" src="http://img.webscan.360.cn/status/pai/hash/73cfbd5da0efa9f632172da914817fed"/></a></li>
            <li><a href="javascript:;"><img src="{{path('images/bottom3.png')}}"/></a></li>
            <li><a href="https://search.szfw.org/cert/l/CX20150626010878010620" target="_blank"><img src="{{path('images/bottom8.png')}}" width="127" height="47"/></a></li>
        </ul>
    </div>
</div>    