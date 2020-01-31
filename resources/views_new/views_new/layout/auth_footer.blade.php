<div class="footer_box">
    <div class="footer_bottom">
        <div class="title">
            @foreach(nav_list('bottom') as $v)
                <a href="{{$v->url}}" @if($v->opennew==1) target="_blank" @endif>{{$v->name}}</a>
            @endforeach
        </div>
        <div class="title">
            <a href="{{path('images/zgz1.jpg')}}" target='_blank'>互联网药品交易服务资格证：川B20130002 </a>|<a href="{{path('images/zgz2.jpg')}}" target='_blank'>互联网药品信息服务资格证：川20150030</a>
        </div>
        <div class="title">
            <a href="http://www.hezongyy.com/" target="_blank">版权所有 {{date('Y')}} 合纵医药网—药易购 www.hezongyy.com </a><a href="http://www.miibeian.gov.cn/" target="_blank">ICP备案证书号:{{shopConfig('icp_number')}}</a>
        </div>
        <div class="title">
            <a>本网站未发布毒性药品、麻醉药品、精神药品、放射性药品、戒毒药品和医疗机构制剂的产品信息</a>
        </div>
    </div>

</div>