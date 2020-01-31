@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_gy.css')}}"/>
@endsection
@section('content')
    @include('article.header')
    @include('article.help_nav')
    <div id="help_title" class="container">
        <div class="container_box">
            <ul class="help_title_list">
                @foreach($articles as $k=>$v)
                    <li @if($k==$article_id)class="active"@endif><a
                                href="{{route('xin.help',['cat_id'=>$cat_id,'article_id'=>$k])}}">{{$v}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div id="content" class="container">
        <div class="container_box">
            <div class="help_title">安全购药</div>
            <div class="step">
                <div class="content_step">
                    1，合法的售药平台
                </div>
                <div class="gy_content">
                    <p>只有经国家食品药品监督管理局或各省市食品药品监督管理局批准能在网上提供药品交易的医药电子商务网站才能进行网上药品交易服务。取得的证书为<span
                                style="font-size:18px;font-weight: 800;">《互联网药品交易服务资格证》</span>，有效期为五年。</p>
                    <p style="padding-bottom: 6px;">提供交易服务的网站按批准的服务范围分为A、B、C三类：</p>
                    <p style="font-size: 16px; font-weight: 600; padding-bottom: 0px;">第一类：第三方交易服务平台。</p>
                    <p style="font-size: 14px; padding-left: 64px;line-height:20px;padding-bottom: 0px;">
                        证书编号样本：国A20060001</br>“国”表示是国家食品药品监督管理局审批的。</br>“A”表示为服务范围为“第三方交易服务平台”。</br>
                        “20060001”其中“2006”为年号，“0001”为序号</p>
                    <p style="font-size: 14px; padding-left: 64px;line-height:20px;">
                        此类证书的特征为“第三方交易”，俗称B2B2C，指为网上药品交易提供第三方交易平台的技术支持与维护的网站，网站上交易的药品必须由入住网站的药品生产或经营企业提供且必须在网站上实名制公示，交易的主体必须是药品生产或经营企业。作为提供第三方交易服务平台的网站必须有专职资质审核人员对入住的药品生产或经营企业进行资质审核，通过审核会在网站上显示入住企业的营业执照号码、药品生产或经营许可证号等企业资质信息。</p>
                    <p style="font-size: 16px; font-weight: 600; padding-bottom: 0px;">第二类：与其他企业进行药品交易。</p>
                    <p style="font-size: 14px; padding-left: 64px;line-height:20px;padding-bottom: 0px;">
                        证书编号样本；蜀B20080001</br>“蜀” 表示是安徽省食品药品监督管理局审批的。</br>“B”表示为服务范围为“与其他企业进行药品交易”。</br>
                        “20080001”其中“2008”为年号，“0001”为序号。</p>
                    <p style="font-size: 14px; padding-left: 64px;line-height:20px;">
                        此类证书的特征为“网上批发”，俗称B2B，指药品生产或经营企业之间的网上药品交易，不得针对个人用户提供交易，申请此类证书的网站必须是药品生产或经营企业且只能网上交易企业自主生产或经营的药品，不得以批准之外的其他企业名义网上销售药品。网站首页必须悬挂营业执照、药品生产或经营许可证、《互联网药品交易服务资格证书》等。</p>
                    <p style="font-size: 16px; font-weight: 600; padding-bottom: 0px;">第三类：向个人消费者提供药品。</p>
                    <p style="font-size: 14px; padding-left: 64px;line-height:20px;padding-bottom: 0px;">
                        证书编号样本；蜀C20080002</br>“蜀”表示是上海市食品药品监督管理局审批的。</br>“C”表示为服务范围为“向个人消费者提供药品”。</br>
                        “20080002”其中“2008”为年号，“0002”为序号。</p>
                    <p style="font-size: 14px; padding-left: 64px;line-height:20px;">
                        此类证书的特征为“网上零售”，俗称B2C，指连锁药店与个人用户之间的网上交易且只能是非处方药、保健品、医疗器械等。只能为个人用户提供交易服务，不得与其他企业进行网上交易，申请此类证书的网站必须是药品经营连锁企业且只能网上交易企业自主经营的药品，不得以批准之外的其他企业名义网上销售药品。网站首页必须悬挂营业执照、药品经营许可证、《互联网药品交易服务资格证书》等。</p>

                </div>
            </div>
            <div class="step">
                <div class="content_step">
                    2，如何判断是否正规合法
                </div>
                <div class="gy_content">
                    <p style="padding-bottom: 6px;font-weight: 600;">判断是否正规合法的网站主要看如下几点：</p>
                    <p style="font-size: 16px;padding-bottom: 20px;">第一、在网站首页醒目位置是否显示《互联网药品交易服务资格证书》字样及编号。</br>
                        第二、打开《互联网药品交易服务资格证书》看网站域名、企业名称及地址等信息是否与访问的网站域名一致。</br>第三、访问国家食品药品监督管理局官网<a
                                href="http://www.sfda.gov.cn/" style="font-size: 16px;color: blue;">http://www.sfda.gov.cn/</a>，点击导航栏的“数据查询”，在导航页面底部的“其他”栏，选择点击中部的“互联网药品
                        &#12288&#12288&#12288交易服务”即可对网站提供的《互联网药品交易服务资格证书》进行核实。</br>第四、提供网上药品交易的企业是否实名制公示且有企业资质证号公示。</p>
                    <p style="font-size: 16px; font-weight: 600;padding-bottom: 0px;">
                        综合国家其他法律法规，结合药品互联网交易的特殊性，合法网上药店需具备以下资格证书：</p>
                    <p style="font-size: 16px; color:#ff1919;">
                        《互联网药品交易服务机构资格证书》&#12288&#12288&#12288&#12288&#12288&#12288《互联网药品信息服务资格证书》</br>
                        《电信与信息服务业务经营许可证》&#12288&#12288&#12288&#12288&#12288&#12288&#12288《医疗器械经营企业许可证》</br>
                        《药品经营质量管理规范认证证书》&#12288&#12288&#12288&#12288&#12288&#12288&#12288《药品经营许可证》</br>
                        《食品经营许可证》&#12288&#12288&#12288&#12288&#12288&#12288&#12288&#12288&#12288&#12288&#12288&#12288&#12288&#12288《营业执照》</p>
                </div>
            </div>
            <div class="step">
                <div class="content_step">
                    3、药易购网站具备的证书查看
                </div>
                <div class="gy_content">
                    <ul class="gy_title_list">
                        <li class="ml0 active">《互联网药品交易服务机构资格证书》</li>
                        <li>《互联网药品信息服务资格证书》</li>
                        <li>《电信与信息服务业务经营许可证》</li>
                        <li>《药品经营许可证》</li>
                        <li class="ml0">《医疗器械经营企业许可证》</li>
                        <li>《药品经营质量管理规范认证证书》</li>
                        <li class="w175">《食品经营许可证》</li>
                        <li class="w175">《营业执照》</li>
                    </ul>
                    <ul class="gy_content_list">
                        <li class="active"><img src="{{get_img_path('adimages1/201807/erji/help_anquan_06.jpg')}}">
                            <p style="font-size: 14px; color: #666666; padding-top: 10px;padding-bottom: 0px;">
                                《互联网药品交易服务机构资格证书》</p></li>
                        <li><img src="{{get_img_path('adimages1/201807/erji/help_anquan_05.jpg')}}">
                            <p style="font-size: 14px; color: #666666; padding-top: 10px;padding-bottom: 0px;">
                                《互联网药品信息服务资格证书》</p></li>
                        <li><img src="{{get_img_path('adimages1/201807/erji/help_anquan_14.jpg')}}">
                            <p style="font-size: 14px; color: #666666; padding-top: 10px;padding-bottom: 0px;">
                                《电信与信息服务业务经营许可证》</p></li>
                        <li><img src="{{get_img_path('adimages1/201807/erji/help_anquan_07.jpg')}}">
                            <p style="font-size: 14px; color: #666666; padding-top: 10px;padding-bottom: 0px;">
                                《药品经营许可证》</p></li>
                        <li><img src="{{get_img_path('adimages1/201807/erji/help_anquan_09.jpg')}}" width="100%">
                            <p style="font-size: 14px; color: #666666; padding-top: 10px;padding-bottom: 0px;">
                                《医疗器械经营企业许可证》</p></li>
                        <li><img src="{{get_img_path('adimages1/201807/erji/help_anquan_08.jpg')}}">
                            <p style="font-size: 14px; color: #666666; padding-top: 10px;padding-bottom: 0px;">
                                《药品经营质量管理规范认证证书》</p></li>
                        <li><img src="{{get_img_path('adimages1/201807/erji/help_anquan_11.jpg')}}">
                            <p style="font-size: 14px; color: #666666; padding-top: 10px;padding-bottom: 0px;">
                                《食品经营许可证》</p></li>
                        <li><img src="{{get_img_path('adimages1/201807/erji/help_anquan_10.jpg')}}">
                            <p style="font-size: 14px; color: #666666; padding-top: 10px;padding-bottom: 0px;">
                                《营业执照》</p></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('article.footer')
    <script type="text/javascript">
        $(function () {
            $('.gy_title_list li').click(function () {

                var index = $(this).index();

                $(this).addClass('active').siblings('li').removeClass('active');

                $('.gy_content_list li').eq(index).addClass('active').siblings('li').removeClass('active');

            })
        })
    </script>
@endsection
