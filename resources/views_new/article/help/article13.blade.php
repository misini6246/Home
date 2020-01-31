@extends('layouts.body')
@section('links')
    <link rel="stylesheet" type="text/css" href="{{path('css/index/new_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_common.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{path('css/new/help_zz.css')}}"/>
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
            <div class="help_title">所需资质</div>
            <div class="step">
                <div class="text_content">
                    <ul class="step_3">
                        <li>
                            <div class="step_3_box">
                                <div class="step_3_box_title">诊所</div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        《医疗机构执业许可证》
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        营业执照复印件（营利性）
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        <span>法人身份证复印件</span>或<span>采购、提货委托书加身份证复印件</span>
                                    </div>
                                </div>
                            </div>
                            <p class="step_3_p">*以上资料在有效期之内并通过新版GSP，且均需加盖 公章鲜章（包含法人身份证复印件）</p>
                        </li>
                        <li>
                            <div class="step_3_box">
                                <div class="step_3_box_title">药店（含连锁药房）</div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        《药品经营许可证》
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        营业执照复印件，连锁药房需上一年的 年度报告
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        《药品经营质量管理规范认证证书》 （GSP证书）
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        <span>法人身份证复印件（仅限连锁药房）</span>或<span>采购、提货委托书加身份证复印件</span>
                                    </div>
                                </div>
                            </div>
                            <p class="step_3_p">*以上资料在有效期之内并通过新版GSP，且均需加盖公章鲜章（包含法人身份证复印件）拷贝</p>
                        </li>
                        <li>
                            <div class="step_3_box">
                                <div class="step_3_box_title">医药企业</div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        《营业执照》
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        《药品经营企业许可证》
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        《GSP认证证书》
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        税务登记证
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        法人授权委托书
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        组织机构代码证
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        联系人身份证复印件（正反面）
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        质量保证协议书
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        指定账户公函
                                    </div>
                                </div>
                                <div class="step_3_list">
                                    <div class="icon">
                                        <img src="{{get_img_path('images/help/help_dian.png')}}"/>
                                    </div>
                                    <div class="step_3_text">
                                        开票信息
                                    </div>
                                </div>
                            </div>
                            <p class="step_3_p">*以上资质材料必须加盖企业红章</p>
                        </li>
                    </ul>
                    <div class="help_address">
                        <p class="help_address_title">
                            邮寄地址：
                        </p>
                        <div class="help_address_box">
                            <div class="help_addres_imgbox">
                                <img src="{{get_img_path('images/help/help_reg_add.png')}}"/>
                            </div>
                            <div class="help_address_text">
                                <p>
                                    <span class="img_span"><img
                                                src="{{get_img_path('images/help/help_user_icon.png')}}"/></span>
                                    <span class="help_left_span">收件人：</span>
                                    <span>兰秋菊</span>
                                </p>
                                <p>
                                    <span class="img_span"><img
                                                src="{{get_img_path('images/help/help_phone_icon.png')}}"/></span>
                                    <span class="help_left_span">联系电话：</span>
                                    <span>028-69932957</span>
                                </p>
                                <p>
                                    <span class="img_span"><img
                                                src="{{get_img_path('images/help/help_address_icon.png')}}"/></span>
                                    <span class="help_left_span">收件地址：</span>
                                    <span>成都市金牛区友联一街18号（量力医药健康城8号楼）13-14层</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="content_step">
                        下载示例模板
                    </div>
                    <ul class="down">
                        <li>采购委托书模板<a href="#">点击下载</a></li>
                        <li>购买特殊管理药品委托书格式<a href="#">点击下载</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @include('article.footer')
@endsection
