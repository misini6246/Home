<div class="help_footer">
    <div class="footer_bottom">
        <div class="title">
            @foreach(nav_list('bottom') as $v)
                <a href="{{$v->url}}" @if($v->opennew==1) target="_blank" @endif>{{$v->name}}</a>
            @endforeach
        </div>
        <div class="title"><a href="{{path('images/zgz2.jpg')}}" target="_blank">互联网药品信息服务资格证：川20160010</a>
        </div>
        <div class="title"><a href="http://www.tiedsun.cn/" target="_blank">版权所有 {{date('Y')}} {{config('services.web.name')}}
                http://www.tiedsun.cn/ </a>ICP备案证书号:蜀ICP备18023478号-1
        </div>
        <div class="title">
            <a>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</a>
        </div>
        <ul class="papers fn_clear" style="width: 505px;padding-left: 20px;">
            <li>
                <a target="_blank" href="https://v.pinpaibao.com.cn/cert/site/?site=www.hezongyy.com&at=realname">
                    <img src="{{get_img_path('images/index/footer_link_1.png')}}"/>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <img src="{{get_img_path('images/index/footer_link_2.png')}}"/>
                </a>
            </li>
            <li>
                <a target="_blank" href="https://credit.cecdc.com/CX20150626010878010620.html">
                    <img src="{{get_img_path('images/index/footer_link_3.png')}}"/>
                </a>
            </li>
            <li>
                <a href="javascript:;">
                    <img src="{{get_img_path('images/index/footer_link_4.png')}}"/>
                </a>
            </li>
        </ul>
    </div>
</div>    