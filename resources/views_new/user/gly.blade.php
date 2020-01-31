@if($gly)
    <p class="zhuanshu">
        专属客服：<span class="kefu" style="display: inline-block;width: 50px;margin-right: 0;">{{$gly->name}}</span>
        @if(!empty($gly->mobile)||!empty($gly->tel)||!empty($gly->qq))
            <span class="chakan">查看联系方式 ></span>
        @endif
    </p>
    <ul class="lxfs" style="left: 340px;">
        <img src="{{get_img_path('images/user/lxfs_sanjiao.png')}}"
             class="lxfs_sanjiao"/>
        @if(!empty($gly->mobile))
            <li>
                <span class="left_title">手机号：</span><span class="num">{{$gly->mobile}}</span>
            </li>
        @endif
        @if(!empty($gly->tel))
            <li>
                <span class="left_title">座机号：</span><span class="num">{{$gly->tel}}</span>
            </li>
        @endif
        @if(!empty($gly->qq))
            <li>
                <span class="left_title">QQ号：</span><span class="num">{{$gly->qq}}</span>
            </li>
        @endif
        @if(!empty($gly->weixin))
            <li>
                <span class="left_title">微信号：</span><span class="num">{{$gly->weixin}}</span>
            </li>
        @endif
    </ul>
@endif